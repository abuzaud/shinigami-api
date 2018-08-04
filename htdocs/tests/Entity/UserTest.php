<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 04/08/2018
 * Time: 18:48
 */

namespace App\Tests\Entity;


use App\Entity\Client;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    /**
     * Test que la class user ne peut pas être instancié
     */
    public function testUserInstanciation()
    {
        $this->expectException(\Error::class);
        $user = new User();
    }
}