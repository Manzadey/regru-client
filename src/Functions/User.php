<?php

namespace Manzadey\RegRu\Functions;

use Manzadey\RegRu\Functions\User\UserCreate;
use Manzadey\RegRu\Response;

class User extends BaseFunction
{
    protected $prefix = 'user';

    /**
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#user_nop
     */
    public function getNop() : Response
    {
        return $this->getClient()->function('nop');
    }

    /**
     * @param string $email
     *
     * @return \Manzadey\RegRu\Functions\User\UserCreate
     * @link https://www.reg.ru/support/help/api2#user_create
     */
    public function create(string $email) : UserCreate
    {
        return (new UserCreate($this->getClient(), $email));
    }

    /**
     * @param string $date_from
     * @param string $date_till
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#user_get_statistics
     */
    public function getStatistic(string $date_from = '', string $date_till = '') : Response
    {
        return $this
            ->getClient()
            ->function('get_statistics', compact('date_from', 'date_till'));
    }

    /**
     * @param string $currency
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#user_get_balance
     */
    public function getBalance(string $currency = 'RUR') : Response
    {
        return $this->getClient()->function('get_balance', compact('currency'));
    }

    /**
     * @param string $servType
     * @param string $urlType
     * @param string $url
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#user_set_reseller_url
     */
    public function setResellerUrl(string $servType, string $urlType, string $url) : Response
    {
        return $this->getClient()->function('set_reseller_url', [
            'servtype' => $servType,
            'url_type' => $urlType,
            'url'      => $url,
        ]);
    }

    /**
     * @param string $servType
     * @param string $urlType
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#user_get_reseller_url
     */
    public function getResellerUrl(string $servType, string $urlType) : Response
    {
        return $this->getClient()->function('get_reseller_url', [
            'servtype' => $servType,
            'url_type' => $urlType,
        ]);
    }
}