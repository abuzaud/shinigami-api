<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 04/08/2018
 * Time: 18:23
 */

namespace App\Tests\Entity;


use App\Entity\Establishment;
use App\Entity\Staff;
use PHPUnit\Framework\TestCase;

class StaffTest extends TestCase
{
    public function testStaffAddUsername(){
        $staff = new Staff();
        $username = "test@test.com";
        $staff->setUsername($username);

        $this->assertSame('test@test.com', $staff->getUsername());
    }

    /**
     * Test d'ajout et suppression d'établissements d'un staff
     */
    public function testStaffAddRemoveEstablishment(){
        $staff = new Staff();
        $establishment1 = new Establishment();
        $establishment2 = new Establishment();

        $staff->addEstablishment($establishment1);

        $this->assertSame(1, count($staff->getEstablishments()));
        $this->assertContainsOnlyInstancesOf(Establishment::class, $staff->getEstablishments());

        $staff->addEstablishment($establishment2);
        $this->assertSame(2, count($staff->getEstablishments()));

        $staff->removeEstablishment($establishment1);
        $this->assertSame(1, count($staff->getEstablishments()));
    }
}