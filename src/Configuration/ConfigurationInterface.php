<?php

namespace Hammock\LaravelERPNext\Configuration;

/**
 * @package Hammock\ERPnext\Configuration
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
