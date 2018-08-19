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
     * Response constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;

        $this->error = new ErrorMessage;
    }

    /**
     * Check if is
     *
     * @return bool
     */
    public function fails()
    {
        return !$this->data['status'] || isset($this->data['error']);
    }

    /**
     * Get error message
     *
     * @return null|string
     */
    public function getMessage()
    {
        if ($this->fails()) {
            return $this->error->get($this->get('error'));
        }

        return null;
    }

    /**
     * Get error code
     *
     * @return int|mixed|null
     */
    public function getCode()
    {
        if ($this->fails()) {
            return $this->get('error');
        }

        return 0;
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
        throw new \ErrorException('The action is not allows');
    }

    /**
     * @param mixed $offset
     * @throws \ErrorException
     */
    public function offsetUnset($offset)
    {
        throw new \ErrorException('The action is not allows');
    }
}