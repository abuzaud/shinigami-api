<?php
/**
 * Created by Antoine Buzaud.
 * Date: 20/08/2018
 */

namespace App\Tests\Entity;


use App\Entity\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    /**
     * Test d'instanciation d'une adresse
     */
    public function testInstanciationAddress()
    {
        $address = new Address();
        $this->assertInstanceOf(Address::class, $address);
    }

    /**
     * Test du streetNumber
     */
    public function testStreetNumber()
    {
        $address = new Address();
        $address->setStreetNumber(8);
        $this->assertSame(8, $address->getStreetNumber());
    }

    /**
     * Test du streetName
     */
    public function testStreetName()
    {
        $address = new Address();
        $address->setStreetName('avenue du président john kennedy');
        $this->assertSame('avenue du président john kennedy', $address->getStreetName());
    }

    /**
     * Test du complément
     */
    public function testComplement()
    {
        $address = new Address();
        $address->setComplement('numéro 8bis');
        $this->assertSame('numéro 8bis', $address->getComplement());
    }

    /**
     * Test du code postal
     */
    public function testZipCode()
    {
        $address = new Address();
        $address->setZipCode('75015');
        $this->assertSame('75015', $address->getZipCode());
    }

    /**
     * Test de la ville
     */
    public function testCity()
    {
        $address = new Address();
        $address->setCity('Aix-en-provence');
        $this->assertSame('Aix-en-provence', $address->getCity());
    }

    /**
     * Test du pays
     */
    public function testCountry()
    {
        $address = new Address();
        $address->setCountry('France');
        $this->assertSame('France', $address->getCountry());
    }

    /**
     * Test de la longitude
     */
    public function testLongitude()
    {
        $address = new Address();
        $address->setLongitude('2.556178');
        $this->assertSame(2.556178, $address->getLongitude());
    }

    /**
     * Test de la latitude
     */
    public function testLatitude(){
        $address = new Address();
        $address->setLatitude(47.700982);
        $this->assertSame(47.700982, $address->getLatitude());
    }
}