<?php

namespace Manzadey\RegRu\Functions;

use Manzadey\RegRu\Exceptions\PayTypeException;
use Manzadey\RegRu\Response;

class Bill extends BaseFunction
{
    protected $prefix = 'bill';

    /**
     * @var string[]
     */
    protected $paymentTypes = [
        'prepay',
        'bank',
        'pbank',
        'yamoney',
        'robox',
        'alfacard',
        'chronopay',
        'handybank',
        'paypal',
    ];

    /**
     * @param int $bill_id
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#bill_nop
     */
    public function getNopFromBillId(int $bill_id) : Response
    {
        return $this->getClient()
            ->function('nop', compact('bill_id'));
    }

    /**
     * @param array $ids
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#bill_nop
     */
    public function getNopFromBillIds(array $ids) : Response
    {
        return (clone $this->getClient())->setInputFormat('json')
            ->function('nop', [
                'input_data' => [
                    'bills'               => $ids,
                    'output_content_type' => 'plain',
                ],
            ]);
    }

    /**
     * @param int      $limit
     * @param int|null $offset
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#bill_get_not_payed`
     */
    public function getNotPayed(int $limit = 100, ?int $offset = null) : Response
    {
        return $this->getClient()
            ->function('get_not_payed', compact('limit', 'offset'));
    }

    /**
     * @param string      $startDate
     * @param string      $endDate
     * @param string|null $payType
     * @param int|null    $limit
     * @param int|null    $offset
     * @param bool        $all
     *
     * @return \Manzadey\RegRu\Response
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Manzadey\RegRu\Exceptions\PayTypeException
     * @link https://www.reg.ru/support/help/api2#bill_get_for_period
     */
    public function getForPeriod(string $startDate, string $endDate, ?string $payType = null, ?int $limit = null, ?int $offset = null, ?bool $all = null) : Response
    {
        $this->checkPaymentType($payType);

        return $this->getClient()
            ->function('get_for_period', [
                'start_date' => $startDate,
                'end_date'   => $endDate,
                'pay_type'   => $payType,
                'limit'      => $limit,
                'offset'     => $offset,
                'all'        => (int) $all,
            ]);
    }

    /**
     * @param int|array $bills
     *
     * @throws \Manzadey\RegRu\Exceptions\CurrencyException
     * @throws \Manzadey\RegRu\Exceptions\PayTypeException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     * @link https://www.reg.ru/support/help/api2#bill_change_pay_type
     */
    public function changePayType($bills, string $payType, string $currency = 'RUR') : Response
    {
        $this->checkPaymentType($payType);
        $this->getClient()->getCurrencyService()->checkCurrency($currency);

        if(!is_int($bills) && !is_array($bills)) {
            throw new \Exception('Bill parameter must be an array or a number, at the moment - ' . gettype($bills));
        }

        $data = [
            'pay_type' => $payType,
            'currency' => $currency,
        ];

        if(is_int($bills)) {
            $data = array_merge($data, [
                'bill_id' => $bills,
            ]);
        } else {
            $data = [
                'input_data' => array_merge([
                    'bills'               => $bills,
                    'output_content_type' => 'plain',
                ], $data),
            ];
        }

        $this->getClient()->setInputFormat('json');

        return $this->getClient()->function('change_pay_type', $data);
    }

    /**
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @link https://www.reg.ru/support/help/api2#bill_delete
     */
    public function delete($bills) : Response
    {
        if(!is_int($bills) && !is_array($bills)) {
            throw new \Exception('Bill parameter must be an array or a number, at the moment - ' . gettype($bills));
        }

        if(is_int($bills)) {
            $data = [
                'bill_id' => $bills,
            ];
        } else {
            $data = [
                'input_data' => [
                    'bills'               => $bills,
                    'output_content_type' => 'plain',
                ],
            ];
        }

        $this->getClient()->setInputFormat('json');

        return $this->getClient()->function('delete', $data);
    }

    /**
     * @return string[]
     */
    public function getPaymentTypes() : array
    {
        return $this->paymentTypes;
    }

    /**
     * @param string[] $paymentTypes
     */
    public function setPaymentTypes(array $paymentTypes) : void
    {
        $this->paymentTypes = $paymentTypes;
    }

    /**
     * @param string|null $payType
     *
     * @throws \Manzadey\RegRu\Exceptions\PayTypeException
     */
    private function checkPaymentType(?string $payType) : void
    {
        if($payType !== null && !in_array($payType, $this->getPaymentTypes(), true)) {
            throw new PayTypeException;
        }
    }
}