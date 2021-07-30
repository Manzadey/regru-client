<?php

namespace Manzadey\RegRu\Functions;

use Manzadey\RegRu\Contracts\ParameterTypeContract;
use Manzadey\RegRu\Functions\Service\ServiceCreate;
use Manzadey\RegRu\Helpers\IdentificationService;
use Manzadey\RegRu\Response;

class Service extends BaseFunction
{
    protected $prefix = 'service';

    /**
     * @param string $parameter
     * @param string $value
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_nop
     */
    public function getNop(string $parameter, string $value) : Response
    {
        return $this->getClient()->function('nop', [
            $parameter => $value,
        ]);
    }

    /**
     * @param bool   $showRenewData
     * @param string $currency
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Manzadey\RegRu\Exceptions\CurrencyException
     * @link https://www.reg.ru/support/help/api2#service_get_prices
     */
    public function getPrices(?bool $showRenewData = null, string $currency = 'RUR') : Response
    {
        $this->getClient()->getCurrencyService()->checkCurrency($currency);

        return $this->getClient()->function('get_prices', [
            'show_renew_data' => $showRenewData,
            'currency'        => $currency,
        ]);
    }

    /**
     * @param string $servType
     * @param string $subType
     * @param bool   $unrollPrices
     * @param bool   $onlyActual
     * @param bool   $showHidden
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_servtype_details
     */
    public function getServTypeDetails(string $servType, string $subType, bool $unrollPrices = false, bool $onlyActual = false, bool $showHidden = false) : Response
    {
        return $this->getClient()->function('get_servtype_details', [
            'servtype'      => $servType,
            'subtype'       => $subType,
            'unroll_prices' => (int) $unrollPrices,
            'only_actual'   => (int) $onlyActual,
            'show_hidden'   => (int) $showHidden,
        ]);
    }

    /**
     * @param string   $domainName
     * @param string   $servType
     * @param int      $period
     * @param int|null $userServId
     *
     * @return \Manzadey\RegRu\Functions\Service\ServiceCreate
     * @link https://www.reg.ru/support/help/api2#service_create
     */
    public function create(string $domainName, string $servType, int $period, ?int $userServId = null) : ServiceCreate
    {
        $serviceCreate = (new ServiceCreate($this->getClient()))
            ->setDomainName($domainName)
            ->setServType($servType)
            ->setPeriod($period);

        if($userServId !== null) {
            $serviceCreate->setUserServId($userServId);
        }

        return $serviceCreate;
    }

    /**
     * @param string      $domainName
     * @param string|null $servType
     * @param string|null $subType
     * @param int|null    $period
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_check_create
     */
    public function checkCreate(string $domainName, ?string $servType = null, ?string $subType = null, ?int $period = null) : Response
    {
        return $this->getClient()->function('check_create', [
            'domain_name' => $domainName,
            'servtype'    => $servType,
            'subtype'     => $subType,
            'period'      => $period,
        ]);
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     * @param string|null                                   $serviceType
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_delete
     */
    public function delete(IdentificationService $identificationService, ?string $serviceType = null) : Response
    {
        return $this->getClient()->function('delete', [
            $identificationService->getName() => $identificationService->getValue(),
            'servtype'                        => $serviceType,
        ]);
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     * @param bool                                          $showFolders
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_info
     */
    public function getInfo(IdentificationService $identificationService, bool $showFolders = false) : Response
    {
        return $this->getClient()->function('get_info', [
            $identificationService->getName() => $identificationService->getValue(),
            'show_folders'                    => (int) $showFolders,
        ]);
    }

    /**
     * @param string|null $serviceType
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_list
     */
    public function getList(?string $serviceType = null) : Response
    {
        return $this->getClient()->function('get_list', [
            'servType' => $serviceType,
        ]);
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_folders
     */
    public function getFolders(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('get_folders', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     * @param bool                                          $separateGroups
     * @param bool                                          $showContactsOnly
     * @param bool                                          $splittedContacts
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_details
     */
    public function getDetails(IdentificationService $identificationService, bool $separateGroups = false, bool $showContactsOnly = false, bool $splittedContacts = false) : Response
    {
        return $this->getClient()->function('get_details', array_merge($identificationService->toArray(), [
            'separate_groups'    => (int) $separateGroups,
            'show_contacts_only' => (int) $showContactsOnly,
            'splitted_contacts'  => (int) $splittedContacts,
        ]));
    }

    /**
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_dedicated_server_list
     */
    public function getDedicatedServerList() : Response
    {
        return $this->getClient()->function('get_dedicated_server_list');
    }

    /**
     * @link https://www.reg.ru/support/help/api2#service_update
     */
    public function update()
    {

    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService   $identificationService
     * @param \Manzadey\RegRu\Contracts\ParameterTypeContract $parameterTypeContract
     * @param int                                             $period
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_renew
     */
    public function reNew(IdentificationService $identificationService, ParameterTypeContract $parameterTypeContract, int $period) : Response
    {
        return $this->getClient()
            ->function('renew', array_merge($identificationService->toArray(), $parameterTypeContract->toArray(), compact('period')));
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_bills
     */
    public function getBills(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('get_bills', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     * @param bool                                          $flagValue
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_set_autorenew_flag
     */
    public function setAutoReNewFlat(IdentificationService $identificationService, bool $flagValue) : Response
    {
        return $this->getClient()->function('set_autorenew_flag', array_merge($identificationService->toArray(), [
            'flag_value' => (int) $flagValue,
        ]));
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_suspend
     */
    public function suspend(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('suspend', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_resume
     */
    public function resume(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('resume', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_depreciated_period
     */
    public function getDepreciatedPeriod(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('get_depreciated_period', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     * @param string                                        $serviceType
     * @param int                                           $period
     * @param string|null                                   $subType
     * @param int|null                                      $diskSize
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_depreciated_period
     */
    public function upgrade(IdentificationService $identificationService, string $serviceType, int $period, ?string $subType = null, ?int $diskSize = null) : Response
    {
        return $this->getClient()->function('upgrade', array_merge($identificationService->toArray(), [
            'servtype'  => $serviceType,
            'period'    => $period,
            'subtype'   => $subType,
            'disk_size' => $diskSize,
        ]));
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     * @param string                                        $login
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_partcontrol_grant
     */
    public function partControlGrant(IdentificationService $identificationService, string $login) : Response
    {
        return $this->getClient()->function('partcontrol_grant', array_merge($identificationService->toArray(), compact('login')));
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_partcontrol_revoke
     */
    public function partControlRevoke(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('partcontrol_revoke', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     * @param string|null                                   $mailType
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_resend_mail
     */
    public function resendMail(IdentificationService $identificationService, ?string $mailType = null) : Response
    {
        return $this->getClient()->function('resend_mail', array_merge($identificationService->toArray(), [
            'mailtype' => $mailType,
        ]));
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_refill
     */
    public function refill(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('refill', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_refund
     */
    public function refund(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('refund', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_refund
     */
    public function getBalance(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('get_balance', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_seowizard_manage_link
     */
    public function getServiceSEOWizardManageLink(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('seowizard_manage_link', $identificationService->toArray());
    }

    /**
     * @param \Manzadey\RegRu\Helpers\IdentificationService $identificationService
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#service_get_websitebuilder_link
     */
    public function getWebSiteBuilderLink(IdentificationService $identificationService) : Response
    {
        return $this->getClient()->function('get_websitebuilder_link', $identificationService->toArray());
    }
}