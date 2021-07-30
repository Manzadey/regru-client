<?php

namespace Manzadey\RegRu\Helpers\ParameterPayTypes;

use Manzadey\RegRu\Contracts\ParameterTypeContract;

class NoMoney implements ParameterTypeContract
{
    protected $parameter = 'ok_if_no_money';

    /**
     * @var \Manzadey\RegRu\Helpers\ParameterPayTypes\PayType
     */
    private $payType;

    public function __construct(PayType $payType)
    {
        $this->payType = $payType;
    }

    public function toArray() : array
    {
        return [
            $this->parameter               => 1,
            $this->payType->getParameter() => $this->payType->getValue(),
        ];
    }
}