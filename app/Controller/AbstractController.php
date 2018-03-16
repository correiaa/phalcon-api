<?php

namespace App\Controller;

use App\Traits\ResultsetTrait;
use Nilnice\Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Phalcon\Validation;

/**
 * @property \Nilnice\Phalcon\Http\Request  $request
 * @property \Nilnice\Phalcon\Http\Response $response
 */
abstract class AbstractController extends Controller
{
    use ResultsetTrait;

    // Successful code.
    public const SUCCESS = 200200;

    // Warning code.
    public const WARNING = 400400;

    /**
     * Successful notification.
     *
     * @param string $message
     * @param array  $data
     * @param int    $code
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function successResponse(
        string $message = 'OK',
        array $data = [],
        int $code = self::SUCCESS
    ) : Response {
        return $this->createJsonResponse(true, $message, $data, $code);
    }

    /**
     * Warning notification.
     *
     * @param string $message
     * @param array  $data
     * @param int    $code
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function warningResponse(
        string $message = 'NO',
        array $data = [],
        int $code = self::WARNING
    ) : Response {
        return $this->createJsonResponse(false, $message, $data, $code);
    }

    /**
     * Validate submission data.
     *
     * @param \Phalcon\Validation $validation
     * @param array               $data
     *
     * @return array
     */
    public function validator(Validation $validation, array $data) : array
    {
        $result = ['code' => '', 'type' => '', 'field' => '', 'message' => '',];
        $messages = $validation->validate($data);

        if (\count($messages)) {
            foreach ($messages as $message) {
                $result['code'] = $message->getCode();
                $result['type'] = $message->getType();
                $result['field'] = $message->getField();
                $result['message'] = $message->getMessage();

                return $result;
            }
        }

        return $result;
    }

    /**
     * @param bool $assoc
     *
     * @return array|bool|mixed|null|\stdClass
     */
    public function getRaw($assoc = true)
    {
        $result = null;

        if ($assoc) {
            $json = $this->request->getRawBody();
            $result = json_decode($json, true);
        } else {
            $result = $this->request->getJsonRawBody();
        }

        return $result;
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
        string $message,
        array $data,
        int $code
    ) : Response {
        if ($status) {
            $content = $this->getOkResultset($message, $data, $code);
        } else {
            $content = $this->getNoResultset($message, $data, $code);
        }
        $this->response
            ->setStatusCode(200, $status ? 'OK' : 'NO')
            ->sendHeaders()
            ->setJsonContent($content);

        return $this->response;
    }
}
