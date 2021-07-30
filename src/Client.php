<?php

namespace Manzadey\RegRu;

use Manzadey\RegRu\Functions\Bill;
use Manzadey\RegRu\Functions\Common;
use Manzadey\RegRu\Functions\Domain;
use Manzadey\RegRu\Functions\Service;
use Manzadey\RegRu\Functions\User;
use Manzadey\RegRu\Helpers\Currency;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * @var string
     * @link https://www.reg.ru/support/help/api2#common_query_format
     */
    private $apiUrl = 'https://api.reg.ru/api/regru2/';

    /**
     * @var array
     * @link https://www.reg.ru/support/help/api2#common_service_identification_params
     */
    private $serviceParameters = [
        'service_id',
        'user_servid',
        'domain_name',
        'servtype',
        'uplink_service_id',
        'subtype',
    ];

    private $query = [];

    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var array
     */
    private $container = [];

    /**
     * @var \Manzadey\RegRu\Helpers\Currency
     */
    protected $currencyService;

    /**
     * Client constructor.
     *
     * @param string $username
     * @param string $password
     * @param array  $parameters
     *
     * @link https://www.reg.ru/support/help/api2#common_auth
     */
    public function __construct(string $username, string $password, array $parameters = [])
    {
        $this->query['username'] = $username;
        $this->query['password'] = $password;
        $this->client            = new \GuzzleHttp\Client;
        $this->currencyService   = new Currency;
    }

    public function common() : Common
    {
        return $this->getFromContainer(new Common($this));
    }

    public function user() : User
    {
        return $this->getFromContainer(new User($this));
    }

    public function bill() : Bill
    {
        return $this->getFromContainer(new Bill($this));
    }

    public function service() : Service
    {
        return $this->getFromContainer(new Service($this));
    }

    public function domain() : Domain
    {
        return $this->getFromContainer(new Domain($this));
    }

    /**
     * @param string $url
     * @param array  $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $url, array $data = []) : ResponseInterface
    {
        return $this->client->post($url, [
            'query' => array_merge($this->query, $data),
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function function(string $function, array $requestData = []) : Response
    {
        if(isset($requestData['input_data']) && is_array($requestData['input_data'])) {
            $requestData['input_data'] = json_encode($requestData['input_data']);
            $this->setInputFormat('json')->setOutputContentType('plain');
        }

        $response = $this->request($this->getApiUrl($function), $requestData)->getBody();
        $data     = json_decode($response, true);

        return new Response($this->getApiUrl($function), $data, array_merge($this->query, $requestData));
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    public function getApiUrl(string $prefix = '') : string
    {
        return $this->apiUrl . $prefix;
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl(string $apiUrl) : void
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return array
     */
    public function getServiceParameters() : array
    {
        return $this->serviceParameters;
    }

    /**
     * @param array $serviceParameters
     */
    public function setServiceParameters(array $serviceParameters) : void
    {
        $this->serviceParameters = $serviceParameters;
    }

    public function getFromContainer($object)
    {
        if(is_object($object)) {
            return $this->container[get_class($object)] ?? $this->container[get_class($object)] = $object;
        }

        return $object;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     * @link https://www.reg.ru/support/help/api2#common_api_management_params
     */
    public function setQueryParameter(string $key, $value) : self
    {
        $this->query[$key] = $value;

        return $this;
    }

    public function setEncoding(string $value) : self
    {
        return $this->setQueryParameter('io_encoding', $value);
    }

    public function setInputFormat(string $value) : self
    {
        return $this->setQueryParameter('input_format', $value);
    }

    public function setInputData(string $value) : self
    {
        return $this->setQueryParameter('input_data', $value);
    }

    public function setOutputFormat(string $value) : self
    {
        return $this->setQueryParameter('output_format', $value);
    }

    public function setOutputContentType(string $value) : self
    {
        return $this->setQueryParameter('output_content_type', $value);
    }

    public function setLang(string $value) : self
    {
        return $this->setQueryParameter('lang', $value);
    }

    public function setShowInputParams(string $value) : self
    {
        return $this->setQueryParameter('show_input_params', $value);
    }

    /**
     * @return \Manzadey\RegRu\Helpers\Currency
     */
    public function getCurrencyService() : Currency
    {
        return $this->currencyService;
    }
}