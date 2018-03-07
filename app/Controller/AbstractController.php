<?php

namespace App\Controller;

use App\Traits\ResultsetTrait;
use Nilnice\Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
 * @property \Nilnice\Phalcon\Http\Request  $request
 * @property \Nilnice\Phalcon\Http\Response $response
 */
abstract class AbstractController extends Controller
{
    use ResultsetTrait;

    /**
     * Successful notification.
     *
     * @param array  $data
     * @param string $message
     * @param int    $code
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function successResponse(
        array $data,
        string $message = 'OK',
        int $code = 200200
    ) : Response {
        return $this->createJsonResponse(true, $data, $message, $code);
    }

    /**
     * Warning notification.
     *
     * @param array  $data
     * @param string $message
     * @param int    $code
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function warningResponse(
        array $data,
        string $message = 'NO',
        int $code = 400400
    ) : Response {
        return $this->createJsonResponse(false, $data, $message, $code);
    }

    /**
     * Create JSON response.
     *
     * @param bool   $status
     * @param array  $data
     * @param string $message
     * @param int    $code
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    private function createJsonResponse(
        bool $status,
        array $data,
        string $message,
        int $code
    ) : Response {
        if ($status) {
            $content = $this->getOkResultset($data, $message, $code);
        } else {
            $content = $this->getNoResultset($data, $message, $code);
        }
        $this->response
            ->setStatusCode(200, $status ? 'OK' : 'NO')
            ->sendHeaders()
            ->setJsonContent($content);

        return $this->response;
    }
}
