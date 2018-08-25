<?php

namespace Montexto;

class Response implements \ArrayAccess
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var ErrorMessage
     */
    private $error;

    /**
     * @var array
     */
    const MESSAGE = [
        8000 => "Request success",
        8401 => 'API account does not exist',
        8402 => 'Error with Key API and/or Token API',
        8403 => 'Check your message or the number entered',
        8404 => 'You do not have enough SMS credit',
        8406 => 'You rights to send your message to a single recipient',
        8407 => 'SenderName does not exist or Not actived',
        8408 => 'You will need to send to at least 2 recipients with this method'
    ];

    /**
     * Response constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Check if request fails
     *
     * @return bool
     */
    public function fails()
    {
        return isset($this->data['error']) || !$this->data['status'];
    }

    /**
     * Get error message
     *
     * @return null|string
     */
    public function getMessage()
    {
        return static::MESSAGE[$this->getCode()];
    }

    /**
     * Get error code
     *
     * @return int|mixed|null
     */
    public function getCode()
    {
        return $this->fails() ? $this->get('error') : 8000;
    }

    /**
     * Get response content
     *
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * To json
     *
     * @return string
     */
    public function toJson()
    {
        return (string) $this;
    }

    /**
     * To json
     *
     * @return array
     */
    public function toArray()
    {
        return (array) $this->data;
    }

    /**
     * Get response to strong
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->data);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }

        return null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws \ErrorException
     */
    public function offsetSet($offset, $value)
    {
        throw new \BadMethodCallException('The action is not allows');
    }

    /**
     * @param mixed $offset
     * @throws \ErrorException
     */
    public function offsetUnset($offset)
    {
        throw new \BadMethodCallException('The action is not allows');
    }
}