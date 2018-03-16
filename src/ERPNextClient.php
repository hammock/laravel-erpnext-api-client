<?php

namespace Hammock\LaravelERPNext;

use Hammock\LaravelERPNext\Configuration\ConfigurationInterface;
use Hammock\LaravelERPNext\Exception\AuthorizationException;
use Curl\Curl;

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
    protected $user;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var Curl
     */
    protected $curl;

    /**
     * @param ConfigurationInterface $config
     * @throws \ErrorException
     */
    public function __construct(ConfigurationInterface $config)
    {
        $this->curl = new Curl(rtrim($config->getDomain(), '/\\ '));
        $this->user = $config->getUser();
        $this->password = $config->getPassword();
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

        $this->curl->post('/api/method/login', $query);

        return $this->curl->error;
    }

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        $this->curl->get('/api/method/frappe.auth.get_logged_user');
        return $this->curl->httpStatusCode === 200;
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
        $query = [
            'filters' => $filters,
            'fields' => $fields,
            'limit_start' => $limitStart,
            'limit_page_length' => $limitLength
        ];

        $this->curl->get('/api/resource/' . $resourceName, $query);

        if ($this->curl->httpStatusCode !== 200 || array_key_exists('data', $this->curl->response)) {
            return [];
        }

        return $this->curl->response['data'];
    }
}
