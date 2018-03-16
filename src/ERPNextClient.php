<?php

namespace Hammock\LaravelERPNext;

use Curl\Curl;
use Hammock\LaravelERPNext\Configuration\ConfigurationInterface;
use Hammock\LaravelERPNext\Exception\AuthorizationException;

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
     * @var array
     */
    protected $cookies = [];

    /**
     * @param ConfigurationInterface $config
     * @throws \ErrorException
     */
    public function __construct(ConfigurationInterface $config)
    {
        $this->curl = new Curl(rtrim($config->getDomain(), '/\\ '));
        $this->curl->setJsonDecoder(function ($response) {
            return json_decode($response, true, 512, JSON_ERROR_NONE);
        });
        $this->user = $config->getUser();
        $this->password = $config->getPassword();
    }

    /**
     * @return array|null
     * @throws AuthorizationException
     */
    public function authenticate()
    {
        $query = [
            'usr' => $this->user,
            'pwd' => $this->password
        ];

        $this->curl->post('/api/method/login', $query);

        if ($this->curl->error) {
            throw new AuthorizationException('Failed to authenticate with credentials provided.');
        }

        $this->cookies = $this->curl->getResponseCookies();
        $this->curl->setCookies($this->cookies);

        return $this->curl->response;
    }

    /**
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
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
            'limit_start' => $limitStart,
            'limit_page_length' => $limitLength
        ];

        if (!empty($fields)) {
            $query['fields'] = json_encode($fields);
        }

        if (!empty($filters)) {
            $query['filters'] = json_encode($filters);
        }

        $this->curl->get('/api/resource/' . $resourceName, $query);

        if ($this->curl->error) {
            return [];
        }

        return $this->curl->response['data'] ?? [];
    }
}
