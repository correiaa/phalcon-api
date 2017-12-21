<?php

namespace App\Controller;

use App\Traits\ResultsetTrait;
use Phalcon\Mvc\Controller;

/**
 * Abstract Controller.
 *
 * @package App\Controller
 */
abstract class AbstractController extends Controller
{
    use ResultsetTrait;

    /**
     * Successful notification.
     *
     * @param array  $data
     * @param string $msg
     * @param string $code
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function successResponse(
        array $data,
        $msg = 'OK',
        $code = 'API_1001'
    ) {
        return $this->createJsonResponse(true, $data, $msg, $code);
    }

    /**
     * Warning notification.
     *
     * @param array  $data
     * @param string $msg
     * @param string $code
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function warningResponse(
        array $data,
        $msg = 'NO',
        $code = 'API_1002'
    ) {
        return $this->createJsonResponse(false, $data, $msg, $code);
    }

    /**
     * Create JSON response.
     *
     * @param bool   $status
     * @param array  $data
     * @param string $msg
     * @param string $code
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    private function createJsonResponse($status, array $data, $msg, $code)
    {
        if ($status) {
            $content = $this->getOKResultset($data, $msg, $code);
        } else {
            $content = $this->getNOResultset($data, $msg, $code);
        }
        $this->response
            ->setStatusCode(200, $status ? 'OK' : 'NO')
            ->sendHeaders()
            ->setJsonContent($content);

        return $this->response;
    }
}
