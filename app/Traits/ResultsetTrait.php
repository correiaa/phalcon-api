<?php

namespace App\Traits;

trait ResultsetTrait
{
    /**
     * Get success resultset.
     *
     * @param array  $data
     * @param string $message
     * @param int    $code
     *
     * @return array
     */
    public function getOkResultset(
        array $data,
        string $message = 'OK',
        int $code = 200200
    ) : array {
        return $this->getResultset($data, $message, $code);
    }

    /**
     * Get failed resultset.
     *
     * @param array  $data
     * @param string $message
     * @param int    $code
     *
     * @return array
     */
    public function getNoResultset(
        array $data,
        string $message = 'NO',
        int $code = 400400
    ) : array {
        return $this->getResultset($data, $message, $code);
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
        array $data,
        string $message,
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
