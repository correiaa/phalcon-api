<?php

namespace App\Traits;

trait ResultsetTrait
{
    /**
     * Get success resultset.
     *
     * @param string $message
     * @param array  $data
     * @param int    $code
     *
     * @return array
     */
    public function getOkResultset(
        string $message = 'OK',
        array $data = [],
        int $code = 200200
    ) : array {
        return $this->getResultset($message, $data, $code);
    }

    /**
     * Get failed resultset.
     *
     * @param string $message
     * @param array  $data
     * @param int    $code
     *
     * @return array
     */
    public function getNoResultset(
        string $message = 'NO',
        array $data = [],
        int $code = 400400
    ) : array {
        return $this->getResultset($message, $data, $code);
    }

    /**
     * Get resultset.
     *
     * @param array  $data
     * @param string $message
     * @param int    $code
     *
     * @return array
     */
    private function getResultset(
        string $message,
        array $data,
        int $code = 200200
    ) : array {
        $result = [
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ];

        return $result;
    }
}
