<?php

namespace Montexto;

class ErrorMessage
{
    /**
     * @var array
     */
    const MESSAGE = [
        8401 => 'API account does not exist',
        8402 => 'Error with Key API and/or Token API',
        8403 => 'Check your message or the number entered',
        8404 => 'You do not have enough SMS credit',
        8406 => 'You rights to send your message to a single recipient',
        8407 => 'SenderName does not exist or Not actived',
        8408 => 'You will need to send to at least 2 recipients with this method'
    ];

    /**
     * Get error message by code.
     *
     * @param $code
     * @return string
     */
    public function get($code)
    {
        if (!isset(static::MESSAGE[$code])) {
            return false;
        }

        return static::MESSAGE[$code];
    }
}