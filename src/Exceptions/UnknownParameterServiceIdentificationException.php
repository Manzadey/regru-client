<?php

namespace Manzadey\RegRu\Exceptions;

use Exception;

class UnknownParameterServiceIdentificationException extends Exception
{
    protected $message = 'Unknown parameter for service identification';
}