<?php

namespace Manzadey\RegRu\Functions;

use Manzadey\RegRu\Response;
use Manzadey\RegRu\Exceptions\UnknownParameterServiceIdentificationException;

class Common extends BaseFunction
{
    /**
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#common_nop
     */
    public function getNop() : Response
    {
        return $this->getClient()->function('nop');
    }

    /**
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#common_reseller_nop
     */
    public function getResellerTest() : Response
    {
        return $this->getClient()->function('reseller_nop');
    }

    /**
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#common_get_user_id
     */
    public function getUserId() : Response
    {
        return $this->getClient()->function('get_user_id');
    }

    /**
     * @param string $serviceParameter
     * @param string $value
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     * @link https://www.reg.ru/support/help/api2#common_get_service_id
     */
    public function getServiceId(string $serviceParameter, string $value) : Response
    {
        if(!in_array($serviceParameter, $this->getClient()->getServiceParameters(), true)) {
            throw new UnknownParameterServiceIdentificationException;
        }

        return $this->getClient()->function('get_service_id', [
            $serviceParameter => $value,
        ]);
    }
}