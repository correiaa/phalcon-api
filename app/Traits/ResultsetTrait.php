<?php

namespace App\Traits;

trait ResultsetTrait
{
    /**
     * Get success resultset.
     *
     * @param array  $data
     * @param string $msg
     * @param string $code
     *
     * @return array
     */
    public function getOKResultset(array $data, $msg = 'OK', $code = 'API_1001')
    {
        return $this->getResultset(true, $data, $msg, $code);
    }

    /**
     * Get failed resultset.
     *
     * @param array  $data
     * @param string $msg
     * @param string $code
     *
     * @return array
     */
    public function getNOResultset(array $data, $msg = 'NO', $code = 'API_1002')
    {
        return $this->getResultset(false, $data, $msg, $code);
    }

    /**
     * Get resultset.
     *
     * @param bool   $status
     * @param array  $data
     * @param string $msg
     * @param string $code
     *
     * @return array
     */
    private function getResultset($status, array $data, $msg, $code = '')
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
