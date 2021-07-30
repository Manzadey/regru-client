<?php

namespace Manzadey\RegRu\Functions;

use Manzadey\RegRu\Client;

abstract class BaseFunction
{
    protected $prefix = '';
    /**
     * @var \Manzadey\RegRu\Client
     */
    private $client;

    public function __construct(Client $client)
    {
        if($this->prefix !== '') {
            $client = (clone $client);
            $client->setApiUrl($client->getApiUrl($this->prefix . '/'));
        }

        $this->client = $client;
    }

    /**
     * @return \Manzadey\RegRu\Client
     */
    protected function getClient() : Client
    {
        return $this->client;
    }

    /**
     * @param \Manzadey\RegRu\Client $client
     */
    protected function setClient(Client $client) : void
    {
        $this->client = $client;
    }
}