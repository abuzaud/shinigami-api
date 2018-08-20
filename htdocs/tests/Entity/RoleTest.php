<?php

namespace App\Tests\Entity;

use App\Entity\Role;
use PHPUnit\Framework\TestCase;

/**
 * Class RoleTest
 * @package App\Tests\Entity
 */
class RoleTest extends TestCase
{
    /**
     * Test d'instanciation d'un Role
     */
    public function testInstanciationRole(){
        $role = new Role('ROLE_USER');
        $this->assertInstanceOf(Role::class, $role);
    }

    /**
     * Test Set Roles
     */
    public function testSetRoleSemanticValue(): void
    {
        $value = 'customer';
        $role = new Role('ROLE_USER');
        $role->setRole($value);
        $this->assertNotSame($value, $role->getRole());
        $this->assertSame(strtoupper('role_' . $value), $role->getRole());

        $value = 'role_customer';
        $role = new Role('ROLE_USER');
        $role->setRole($value);
        $this->assertNotSame($value, $role->getRole());
        $this->assertSame(strtoupper($value), $role->getRole());

        $value = 'ROLE_CUSTOMER';
        $role = new Role('ROLE_USER');
        $role->setRole($value);
        $this->assertSame($value, $role->getRole());
    }

    /**
     * Test ID
     */
    public function testId(){
        $role = new Role('ROLE_USER');
        $this->assertNull($role->getId());
    }

    /**
     * Test Name
     */
    public function testName(){
        $role = new Role('ROLE_USER');
        $role->setName('User');
        $this->assertSame('User', $role->getName());
    }
}
