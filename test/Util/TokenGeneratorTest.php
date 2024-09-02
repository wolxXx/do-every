<?php

declare(strict_types=1);

namespace MyDMSTest\Util;

class TokenGeneratorTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSpaceAccessValidUntil()
    {
        \Carbon\Carbon::setTestNow(new \DateTime('2024-01-01 12:34:56'));
        $validUntil = \MyDMS\Util\TokenGenerator::getSpaceAccessValidUntil()->format('Y-m-d H:i:s');
        $this->assertEquals('2024-01-31 23:59:59', $validUntil);
        $validUntil = \MyDMS\Util\TokenGenerator::getSpaceAccessValidUntil(5)->format('Y-m-d H:i:s');
        $this->assertEquals('2024-01-06 23:59:59', $validUntil);
        $validUntil = \MyDMS\Util\TokenGenerator::getSpaceAccessValidUntil(55)->format('Y-m-d H:i:s');
        $this->assertEquals('2024-02-25 23:59:59', $validUntil);
    }
    public function testGetSpaceAccess()
    {
        $token = \MyDMS\Util\TokenGenerator::getSpaceAccess();
        $this->assertSame(36, \strlen($token));
    }
    public function testGetSpaceToken()
    {
        $token = \MyDMS\Util\TokenGenerator::getSpaceToken();
        $this->assertSame(44, \strlen($token));
    }
    public function testGetUserPasswordReset()
    {
        $token = \MyDMS\Util\TokenGenerator::getUserPasswordReset();
        $this->assertSame(36, \strlen($token));
    }
    
    
    public function testGetUserPasswordResetValidUntil()
    {
        \Carbon\Carbon::setTestNow(new \DateTime('2024-01-01 12:34:56'));
        $validUntil = \MyDMS\Util\TokenGenerator::getUserPasswordResetValidUntil()->format('Y-m-d H:i:s');
        $this->assertEquals('2024-01-31 23:59:59', $validUntil);
    }
    
    
    public function testGetUserActivation()
    {
        $token = \MyDMS\Util\TokenGenerator::getUserActivation();
        $this->assertSame(36, \strlen($token));
    }
}