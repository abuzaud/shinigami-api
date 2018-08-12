<?php

namespace App\Tests\Service;

use App\Service\UtilsService;
use PHPUnit\Framework\TestCase;

/**
 * Class UtilsServiceTest
 * @package App\Tests\Service
 */
class UtilsServiceTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testGenerateRandomString(): void
    {
        $length = 16;
        $utilsService = new UtilsService();
        $secureRandomString = $utilsService->generateRandomString($length);

        $this->assertEquals($length * 2, \strlen($secureRandomString));
        $this->assertRegExp('/[a-zA-Z0-9]/', $secureRandomString);
    }
}
