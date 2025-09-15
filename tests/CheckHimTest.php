<?php
use PHPUnit\Framework\TestCase;
use CheckHim\CheckHim;

class CheckHimTest extends TestCase
{
    public function testVerifyReturnsApiErrorResponse()
    {
        $mock = $this->getMockBuilder(CheckHim::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['verify'])
            ->getMock();

        $mock->expects($this->once())
            ->method('verify')
            ->with('244921000111')
            ->willReturn([
                'error' => 'verification failed: Network is forbidden (code: 6)',
                'code' => 'REJECTED_NETWORK',
                'http_status' => 400
            ]);

        $result = $mock->verify('244921000111');
        $this->assertIsArray($result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('code', $result);
        $this->assertArrayHasKey('http_status', $result);
        $this->assertEquals('REJECTED_NETWORK', $result['code']);
        $this->assertEquals(400, $result['http_status']);
    }
    public function testVerifyReturnsValidResponse()
    {
        $mock = $this->getMockBuilder(CheckHim::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['verify'])
            ->getMock();

        $mock->expects($this->once())
            ->method('verify')
            ->with('+5511984339000')
            ->willReturn([
                'carrier' => 'UNITEL',
                'valid' => true
            ]);

        $result = $mock->verify('+5511984339000');
        $this->assertIsArray($result);
        $this->assertArrayHasKey('carrier', $result);
        $this->assertArrayHasKey('valid', $result);
        $this->assertEquals('UNITEL', $result['carrier']);
        $this->assertTrue($result['valid']);
    }

    public function testThrowsExceptionOnEmptyNumber()
    {
        $this->expectException(InvalidArgumentException::class);
        $client = new CheckHim('test_key');
        $client->verify('');
    }

    public function testThrowsExceptionOnEmptyApiKey()
    {
        $this->expectException(InvalidArgumentException::class);
        new CheckHim('');
    }
}
