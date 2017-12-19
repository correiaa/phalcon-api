<?php

namespace App\Controller;

use Phalcon\Mvc\Controller;

/**
 * Abstract Controller.
 *
 * @package App\Controller
 */
abstract class AbstractController extends Controller
{
    /**
     * Successful notification.
     *
     * @param string $msg
     * @param string $code
     * @param array  $data
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function success($msg = 'OK', $code = 'API_1001', array $data = [])
    {
        return $this->createJsonResponse(true, $msg, $code, $data);
    }

    /**
     * Warning notification.
     *
     * @param string $msg
     * @param string $code
     * @param array  $data
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function warning($msg = 'NO', $code = 'API_1002', array $data = [])
    {
        return $this->createJsonResponse(false, $msg, $code, $data);
    }

    /**
     * Create JSON response.
     *
     * @param bool   $status
     * @param string $msg
     * @param string $code
     * @param array  $data
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    private function createJsonResponse($status, $msg, $code, array $data = [])
    {
        $content = $this->getResultset($status, $msg, $code, $data);
        $this->response
            ->setStatusCode(200, $status ? 'OK' : 'NO')
            ->sendHeaders()
            ->setJsonContent($content);

        return $this->response;
    }

    /**
     * Get resultset.
     *
     * @param bool   $status
     * @param string $msg
     * @param string $code
     * @param array  $data
     *
     * @return array
     */
    public function getResultset($status, $msg, $code, array $data = [])
    {
        $result = [
            'status' => $status,
            'msg'    => $msg,
            'code'   => $code,
            'data'   => $data,
        ];

        return $result;
    }
}
