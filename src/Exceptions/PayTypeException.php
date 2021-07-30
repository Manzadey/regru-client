<?php

namespace Manzadey\RegRu\Exceptions;

use Exception;

class PayTypeException extends Exception
{
    protected $message = 'Unknown payment method, payment options. You can see the available methods at the link: https://www.reg.ru/support/help/api2#common_response_parameters';
}