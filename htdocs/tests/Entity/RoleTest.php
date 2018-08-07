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
    public function testRoleSetRoleSemanticValue()
    {
        $value = 'customer';
        $role = new Role();
        $role->setRole($value);
        $this->assertNotSame($value, $role->getRole());
        $this->assertSame(strtoupper('role_' . $value), $role->getRole());

        $value = 'role_customer';
        $role = new Role();
        $role->setRole($value);
        $this->assertNotSame($value, $role->getRole());
        $this->assertSame(strtoupper($value), $role->getRole());

        $value = 'ROLE_CUSTOMER';
        $role = new Role();
        $role->setRole($value);
        $this->assertSame($value, $role->getRole());
    }
}