<?php

namespace App\Traits;

use Phalcon\Http\Response;

/**
 * Resultset Trait.
 *
 * @package App\Traits
 */
trait ResultsetTrait
{
    public function getResultset(Response $response)
    {
        $result = [
            'status' => false,
            'msg'    => 'API_1001',
            'tip'    => '',
        ];
        $response->setStatusCode(200, 'OK')
            ->setJsonContent($result);

        return $response;
    }
}
