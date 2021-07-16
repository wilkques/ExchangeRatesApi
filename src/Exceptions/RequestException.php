<?php

namespace Wilkques\ExchangeRate\Exceptions;

use Wilkques\ExchangeRate\Factories\Response;

class RequestException extends \Exception
{
    /** @var string */
    protected $mappingMessage = null;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        parent::__construct($response->getErrorMessage(), $response->getErrorCode());

        $this->setMappingMessage($response);
    }

    /**
     * @param Response $response
     * 
     * @return static
     */
    public function setMappingMessage(Response $response)
    {
        $this->mappingMessage = $response->getMappingMessage();

        return $this;
    }

    /**
     * @return string
     */
    public function getMappingMessage()
    {
        return $this->mappingMessage;
    }
}