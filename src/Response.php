<?php

namespace Manzadey\RegRu;

class Response
{
    /**
     * @var array
     */
    private $response;

    /**
     * @var array
     */
    private $requestData;

    /**
     * @var string
     */
    private $function;

    public function __construct(string $function, array $response, array $requestData)
    {
        $this->function    = $function;
        $this->response    = $response;
        $this->requestData = $requestData;
    }

    /**
     * @return array
     */
    public function getResponse() : array
    {
        return $this->response;
    }

    public function isSuccess() : bool
    {
        return $this->getResult() === 'success';
    }

    public function isFailed() : bool
    {
        return $this->getResult() === 'error';
    }

    public function getAnswer() : array
    {
        return $this->response['answer'] ?? [];
    }

    public function getCharset() : string
    {
        return $this->response['charset'] ?? '';
    }

    public function getErrorCode() : string
    {
        return $this->response['error_code'] ?? '';
    }

    public function getErrorParams() : array
    {
        return $this->response['error_params'] ?? [];
    }

    public function getErrorText() : string
    {
        return $this->response['error_text'] ?? '';
    }

    public function getResult() : string
    {
        return $this->response['result'] ?? '';
    }

    public function getValue(string $key) : ?string
    {
        return $this->getAnswer()[$key] ?? '';
    }

    /**
     * @return array
     */
    public function getRequestData() : array
    {
        return $this->requestData;
    }

    /**
     * @param array $requestData
     */
    public function setRequestData(array $requestData) : void
    {
        $this->requestData = $requestData;
    }

    /**
     * @return string
     */
    public function getFunction() : string
    {
        return $this->function;
    }
}