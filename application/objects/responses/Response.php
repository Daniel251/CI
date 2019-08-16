<?php

namespace app\objects\responses;

abstract class Response
{

    const STATUS_ERROR = 0;
    const STATUS_OK    = 1;

    const STATUS_CODE_OK                    = 200;
    const STATUS_CODE_BAD_REQUEST           = 400;
    const STATUS_CODE_UNAUTHORIZED          = 401;
    const STATUS_CODE_FORBIDDEN             = 403;
    const STATUS_CODE_CONFLICT              = 409;
    const STATUS_CODE_INTERNAL_SERVER_ERROR = 500;
    const STAUTS_CODE_NOT_IMPLEMENTED       = 501;

    const DATA_CHANGE_SUCCESS_MESSAGE = 'Zmiany zostały zapisane';
    const DATA_CHANGE_ERROR_MESSAGE   = 'Wystąpił bład, zmiany nie zostały zapisane';

    protected $code = 0;
    protected $status = 0;
    protected $message = '';
    protected $data;

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = (int)$status;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
