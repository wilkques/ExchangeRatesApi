<?php

namespace Wilkques\ExchangeRates;

use Wilkques\ExchangeRates\Exceptions\RequestException;
use Wilkques\Http\Response as HttpClientResponse;

/**
 * @method static int status()
 * @method static string body()
 * @method static array json()
 * @method static array headers()
 * @method static string|null header()
 * @method static boolean ok()
 * @method static boolean redirect()
 * @method static boolean successful()
 * @method static boolean failed()
 * @method static boolean clientError()
 * @method static boolean serverError()
 * @method static throws throw(callable $callback = null)
 */
class Response implements \JsonSerializable, \ArrayAccess
{
    /** @var HttpClientResponse */
    protected $response;

    /** @var integer */
    protected $errorCode;

    /** @var string */
    protected $errorMessage;

    /** @var string */
    protected $mappingMessage = null;

    /** @var array */
    protected $errorCodeDescription = [
        404 => "The requested resource does not exist.",
        101 => "No API Key was specified or an invalid API Key was specified.",
        103 => "The requested API endpoint does not exist.",
        104 => "The maximum allowed API amount of monthly API requests has been reached.",
        105 => "The current subscription plan does not support this API endpoint.",
        106 => "The current request did not return any results.",
        102 => "The account this API request is coming from is inactive.",
        201 => "An invalid base currency has been entered.",
        202 => "One or more invalid symbols have been specified.",
        301 => "No date has been specified. [historical]",
        302 => "An invalid date has been specified. [historical, convert]",
        403 => "No or an invalid amount has been specified. [convert]",
        501 => "No or an invalid timeframe has been specified. [timeseries]",
        502 => "No or an invalid 'start_date' has been specified. [timeseries, fluctuation]",
        503 => "No or an invalid 'end_date' has been specified. [timeseries, fluctuation]",
        504 => "An invalid timeframe has been specified. [timeseries, fluctuation]",
        505 => "The specified timeframe is too long, exceeding 365 days. [timeseries, fluctuation]",
    ];

    /**
     * @param HttpClientResponse $response
     */
    public function __construct(HttpClientResponse $response)
    {
        $this->setResponse($response);
    }

    /**
     * @param HttpClientResponse $response
     * 
     * @return static
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return HttpClientResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param integer $code
     * 
     * @return static
     */
    public function setErrorCode(int $code)
    {
        $this->errorCode = $code;

        return $this;
    }

    /**
     * @return integer
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param string $message
     * 
     * @return static
     */
    public function setErrorMessage(string $message)
    {
        $this->errorMessage = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @return array
     */
    public function getErrorCodeDescription()
    {
        return $this->errorCodeDescription;
    }

    /**
     * @param string $code
     * 
     * @return string
     */
    public function getErrorCodeDescriptionByCode(string $code)
    {
        return $this->getErrorCodeDescription()[$code] ?? null;
    }

    /**
     * @return static
     */
    public function setMappingMessage()
    {
        $this->mappingMessage = $this->getErrorCodeDescriptionByCode($this->getErrorCode());

        return $this;
    }

    /**
     * @return string
     */
    public function getMappingMessage()
    {
        return $this->mappingMessage;
    }

    /**
     * @return RequestException
     */
    public function getThrows()
    {
        return new RequestException($this);
    }

    /**
     * @param callable|null $callback
     * 
     * @throws \Wilkques\HttpClient\Exception\RequestException|RequestException
     * 
     * @return static
     */
    public function throw(callable $callback = null)
    {
        $response = $this->getResponse()->throw(function (
            HttpClientResponse $response,
            \Wilkques\Http\Exceptions\RequestException $exception
        ) use ($callback) {
            if ($response->failed()) {
                $this->setErrorCode($exception->getCode())->setErrorMessage($exception->getMessage());

                if ($callback) throw $this->callableReturnCheck($callback($this, $this->getThrows()));

                throw $this->getThrows();
            }
        })->json();

        if (!$response['success'] && array_key_exists('error', $response)) {
            $this->setErrorCode($response['error']['code'])->setErrorMessage($response['error']['info']);

            if ($callback) throw $this->callableReturnCheck($callback($this, $this->getThrows()));

            throw $this->getThrows();
        }

        return $this;
    }

    /**
     * @param mixed $callable
     * 
     * @throws UnexpectedValueException
     * 
     * @return mixed
     */
    protected function callableReturnCheck($callable = null)
    {
        if (is_null($callable)) return $this->getThrows();
        else if (!is_object($callable)) return new \UnexpectedValueException("throw function return must be Exception Object");

        return $callable;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->json();
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->json()[$offset];
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->json()[$offset] = $value;
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return !array_key_exists($offset, $this->json()) && !is_null($this->json()[$offset]);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->json()[$offset]);
    }

    /**
     * Determine if an attribute or relation exists on the model.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * @param string $key
     * 
     * @return mixed
     */
    public function __get(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }

        return $this->json()[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function __set(string $key, $value)
    {
        if (property_exists($this, $key)) {
            $this->{$key} = $value;
        } else {
            $this->json()[$key] = $value;
        }
    }

    /**
     * @param string $method
     * @param array $arguments
     * 
     * @return HttpClientResponse
     */
    public function __call(string $method, array $arguments)
    {
        return $this->getResponse()->{$method}(...$arguments);
    }
}
