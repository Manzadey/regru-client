<?php

namespace Manzadey\RegRu\Exceptions;

use Exception;

class CurrencyException extends Exception
{
    protected $message = 'Unsupported currency';
}