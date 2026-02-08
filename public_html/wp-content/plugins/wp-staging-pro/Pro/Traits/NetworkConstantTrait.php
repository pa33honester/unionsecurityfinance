<?php

namespace WPStaging\Pro\Traits;

use WPStaging\Framework\Adapter\Database\InterfaceDatabaseClient;

trait NetworkConstantTrait
{
    /** @var string */
    protected $prefix = '';

    /** @var InterfaceDatabaseClient */
    protected $client;

    /**
     * @param InterfaceDatabaseClient $client
     * @return void
     */
    public function setDatabaseClient(InterfaceDatabaseClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $prefix
     * @return void
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    protected function getCurrentNetworkPath(): string
    {
        if (defined('PATH_CURRENT_SITE')) {
            return constant('PATH_CURRENT_SITE');
        }

        return $this->getFromSiteTable('path');
    }

    /**
     * @return string
     */
    protected function getCurrentNetworkDomain(): string
    {
        if (defined('DOMAIN_CURRENT_SITE')) {
            return constant('DOMAIN_CURRENT_SITE');
        }

        return $this->getFromSiteTable('domain');
    }

    private function getFromSiteTable(string $field): string
    {
        $siteTable = $this->prefix . 'site';
        $result    = $this->client->query("SELECT {$field} FROM {$siteTable}");
        $value     = $this->client->fetchAssoc($result)[0][$field];

        $this->client->freeResult($result);

        return $value;
    }
}
