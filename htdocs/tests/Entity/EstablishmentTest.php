<?php
/**
 * Created by Antoine Buzaud.
 * Date: 20/08/2018
 */

namespace App\Tests\Entity;


use App\Entity\Address;
use App\Entity\Establishment;
use App\Entity\Staff;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class EstablishmentTest extends TestCase
{
    /**
     * Test d'instanciation d'un établissement
     */
    public function testInstanciationEstablishment()
    {
        $establishment = new Establishment();
        $this->assertInstanceOf(Establishment::class, $establishment);
    }

    /**
     * Test de l'id
     */
    public function testId()
    {
        $establishment = new Establishment();

        $this->assertNull($establishment->getId());

        $establishment->setId(5);
        $this->assertSame(5, $establishment->getId());
    }

    /**
     * Test du Name
     */
    public function testName()
    {
        $establishment = new Establishment();
        $establishment->setName('Lorem Ipsum');
        $this->assertSame('Lorem Ipsum', $establishment->getName());
    }

    /**
     * Test de Description
     */
    public function testDescription()
    {
        $establishment = new Establishment();
        $establishment->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet sagittis rutrum.');

        $this->assertSame('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec imperdiet sagittis rutrum.', $establishment->getDescription());
    }

    /**
     * Test d'Address
     */
    public function testAddress()
    {
        $establishment = new Establishment();
        $address = new Address();

        $establishment->setAddress($address);
        $this->assertInstanceOf(Address::class, $establishment->getAddress());
    }

    /**
     * Test de PhoneNumber
     */
    public function testPhoneNumber()
    {
        $establishment = new Establishment();
        $establishment->setPhoneNumber('0123456789');
        $this->assertSame('0123456789', $establishment->getPhoneNumber());
    }

    /**
     * Test de Staff
     */
    public function testStaff()
    {
        $establishment = new Establishment();
        $staff1 = new Staff();
        $staff2 = new Staff();
        $establishment->addStaff($staff1)->addStaff($staff2);

        $this->assertInstanceOf(Collection::class, $establishment->getStaff());

        foreach ($establishment->getStaff() as $staff) {
            $this->assertInstanceOf(Staff::class, $staff);
        }

        $this->assertCount(2, $establishment->getStaff());

        $establishment->removeStaff($staff2);
        $this->assertCount(1, $establishment->getStaff());
    }

}