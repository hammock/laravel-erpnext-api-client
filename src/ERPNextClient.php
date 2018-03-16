<?php

namespace Hammock\LaravelERPNext;

use Hammock\LaravelERPNext\Configuration\ConfigurationInterface;
use Hammock\LaravelERPNext\Exception\AuthorizationException;
use Unirest\Request;

/**
 * Class ERPNextClient
 *
 * @package Hammock\LaravelERPNext
 */
class ERPNextClient
{
    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $password;

    public function __construct(ConfigurationInterface $config)
    {
        $this->domain = rtrim($config->getDomain(), '/\\ ');
        $this->user = $config->getUser();
        $this->password = $config->getPassword();

        Request::defaultHeader('Accept', 'application/json');
    }

    /**
     * @param string $path
     * @return string
     */
    protected function api(string $path): string
    {
        return $this->domain . '/api/' . $path;
    }

    /**
     * @return bool
     */
    public function authenticate(): bool
    {
        $query = [
            'usr' => $this->user,
            'pwd' => $this->password
        ];

        $response = Request::post($this->api('method/login'), [], $query);

        return $response->code === 200;
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        $response = Request::get($this->api('method/frappe.auth.get_logged_user'));
        return $response->code === 200 && array_key_exists('message', $response->body);
    }

    /**
     * @param string $resourceName
     * @param array $fields
     * @param array $filters
     * @param int $limitStart
     * @param int $limitLength
     * @return array
     */
    public function getResource(string $resourceName, array $fields = [], array $filters = [], int $limitStart = 0, int $limitLength = 20): array
    {
        $this->authenticate();

        $query = [
            'filters' => $filters,
            'fields' => $fields,
            'limit_start' => $limitStart,
            'limit_page_length' => $limitLength
        ];

        $response = Request::get($this->api('resource/' . $resourceName), [], $query);

        if ($response->code !== 200 || array_key_exists('data', $response->body)) {
            return [];
        }

        return $response->body['data'];
    }
}
