<?php

namespace Manzadey\RegRu\Functions\User;

use Manzadey\RegRu\Client;
use Manzadey\RegRu\Response;

class UserCreate
{
    protected $data = [];

    /**
     * @var \Manzadey\RegRu\Client
     */
    private $client;

    public function __construct(Client $client, string $email)
    {
        $this->client             = $client;
        $this->data['user_email'] = $email;
    }

    public function setPassword(string $value) : self
    {
        return $this->setQueryData('user_password', $value);
    }

    public function setLogin(string $value) : self
    {
        return $this->setQueryData('user_login', $value);
    }

    public function setCountryCode(string $value) : self
    {
        return $this->setQueryData('user_country_code', $value);
    }

    public function setDefaultCountryCode(string $value) : self
    {
        return $this->setQueryData('default_country_code', $value);
    }

    public function setUserIp(string $value) : self
    {
        return $this->setQueryData('user_ip', $value);
    }

    public function setFirstName(string $value) : self
    {
        return $this->setQueryData('user_first_name', $value);
    }

    public function setLastName(string $value) : self
    {
        return $this->setQueryData('user_last_name', $value);
    }

    public function setCompany(string $value) : self
    {
        return $this->setQueryData('user_company', $value);
    }

    public function setJabber(string $value) : self
    {
        return $this->setQueryData('user_jabber_id', $value);
    }

    public function setICQ(string $value) : self
    {
        return $this->setQueryData('user_icq', $value);
    }

    public function setPhone(string $value) : self
    {
        return $this->setQueryData('user_phone', $value);
    }

    public function setFax(string $value) : self
    {
        return $this->setQueryData('user_fax', $value);
    }

    public function setAddress(string $value) : self
    {
        return $this->setQueryData('user_addr', $value);
    }

    public function setCity(string $value) : self
    {
        return $this->setQueryData('user_city', $value);
    }

    public function setState(string $value) : self
    {
        return $this->setQueryData('user_state', $value);
    }

    public function setPostCode(string $value) : self
    {
        return $this->setQueryData('user_postcode', $value);
    }

    public function setWebMoneyId(string $value) : self
    {
        return $this->setQueryData('user_wmid', $value);
    }

    public function setWebSite(string $value) : self
    {
        return $this->setQueryData('user_website', $value);
    }

    public function setLanguage(string $value) : self
    {
        return $this->setQueryData('user_language', $value);
    }

    public function setSubscribe(bool $value) : self
    {
        return $this->setQueryData('user_subsribe', (int) $value);
    }

    public function setMailNotify(bool $value) : self
    {
        return $this->setQueryData('user_mailnotify', (int) $value);
    }

    public function setCheckOnly(bool $value) : self
    {
        return $this->setQueryData('check_only', (int) $value);
    }

    public function setWhiteListIps(array $value) : self
    {
        return $this->setQueryData('white_list_ips', $value);
    }

    public function setReferrer(bool $value) : self
    {
        return $this->setQueryData('set_me_as_referrer', (int) $value);
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setQueryData($key, $value) : self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get() : Response
    {
        return $this->client->function('user/create', $this->data);
    }
}