<?php

namespace Kampyeri\Ci;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetHttpCode()
    {
        $exception = new Exception('test', -1, 500);
        $this->assertEquals(500, $exception->getHttpCode());
        $exception = new Exception('test', -1, 400);
        $this->assertEquals(400, $exception->getHttpCode());
    }

    public function testToString()
    {
        $exception = new Exception('test', -1000);
        $this->assertEquals('[-1000] test', $exception);
    }
}
