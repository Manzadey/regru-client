<?php

namespace Manzadey\RegRu\Helpers\ParameterPayTypes;

use Manzadey\RegRu\Contracts\ParameterTypeContract;

class PayType implements ParameterTypeContract
{
    protected $parameter = 'paytype';

    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toArray() : array
    {
        return [$this->parameter => $this->value];
    }

    public function getParameter() : string
    {
        return $this->parameter;
    }

    public function getValue() : string
    {
        return $this->value;
    }
}