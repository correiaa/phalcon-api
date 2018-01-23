<?php

namespace Test;

use Phalcon\Test\UnitTestCase;

class UnitTest extends UnitTestCase
{
    public function testConfig()
    {
        $config = $this->getConfig();
        self::assertEquals(null, $config);
    }
}
