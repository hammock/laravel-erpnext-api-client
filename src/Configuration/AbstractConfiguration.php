<?php

namespace Hammock\LaravelERPNext\Configuration;

abstract class AbstractConfiguration implements ConfigurationInterface
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

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
