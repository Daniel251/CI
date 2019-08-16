<?php

namespace application\objects\responses;

final class JsonResponse extends Response
{
    public function sendResponse()
    {
        $data = [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];

        exit(json_encode($data));
    }

    public static function sendSuccess(string $message = '', array $data = [])
    {
        http_response_code(Response::STATUS_CODE_OK);

        $response = new static();

        $response
            ->setStatus(Response::STATUS_OK)
            ->setMessage($message);

        if (!empty($data)) {
            $response->setData($data);
        }

        $response->sendResponse();
    }

    /**
     * @param $message
     * @param int $responseCode
     */
    public static function sendError($message, $responseCode = Response::STATUS_CODE_BAD_REQUEST)
    {
        http_response_code($responseCode);

        $response = new static();

        $response
            ->setStatus(self::STATUS_ERROR)
            ->setMessage($message)
            ->sendResponse();
    }

    public static function sendErrorWithData(string $message, $data)
    {
        $response = new self();

        $response->setStatus(Response::STATUS_ERROR)
            ->setMessage($message)
            ->setData($data)
            ->sendResponse();
    }
}