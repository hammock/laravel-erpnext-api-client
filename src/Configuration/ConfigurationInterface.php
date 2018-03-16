<?php

namespace Hammock\LaravelERPNext\Configuration;

/**
 * Interface ConfigurationInterface
 *
 * @package Hammock\LaravelERPNext\Configuration
 */
interface ConfigurationInterface
{
    /**
     * @return string
     */
    public function getDomain(): string;

    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @return string
     */
    public function getPassword(): string;
}
