<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 04/08/2018
 * Time: 17:04
 */

namespace App\Tests\Entity;


use App\Entity\Address;
use App\Entity\Card;
use App\Entity\Customer;
use App\Entity\Establishment;
use App\Entity\Role;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerTest
 * @package App\Tests\Entity
 */
class CustomerTest extends TestCase
{
    /**
     * Test de l'ID
     */
    public function testId(){
        $customer = new Customer();
        $this->assertNull($customer->getId());
    }

    /**
     * Test du firstName
     */
    public function testFirstName()
    {
        $customer = new Customer();
        $customer->setFirstName('Antoine');
        $this->assertSame('Antoine', $customer->getFirstName());
    }

    /**
     * Test du lastName
     */
    public function testLastName()
    {
        $customer = new Customer();
        $customer->setLastName('Buzaud');
        $this->assertSame('Buzaud', $customer->getLastName());
    }

    /**
     * Test de l'email
     */
    public function testEmail()
    {
        $customer = new Customer();
        $customer->setEmail('test@test.com');
        $this->assertSame('test@test.com', $customer->getEmail());
    }

    /**
     * Test du password
     */
    public function testPassword()
    {
        $customer = new Customer();
        $customer->setPassword('azerty123');
        $this->assertSame('azerty123', $customer->getPassword());
    }

    /**
     * Test des adresses
     */
    public function testAddresses()
    {
        $customer = new Customer();
        $address = new Address();
        $customer->setAddress($address);
        $this->assertInstanceOf(Address::class, $customer->getAddress());
    }

    /**
     * Test du numéro de téléphone
     */
    public function testPhoneNumber()
    {
        $customer = new Customer();
        $customer->setPhoneNumber('0123456789');
        $this->assertSame('0123456789', $customer->getPhoneNumber());
    }

    /**
     * Test de la date d'anniversaire
     */
    public function testBirthday()
    {
        $customer = new Customer();
        $customer->setBirthday(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $customer->getBirthday());
    }

    /**
     * Test de la date registrationDate
     */
    public function testRegistrationDate()
    {
        $customer = new Customer();
        $customer->setRegistrationDate(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $customer->getRegistrationDate());
    }

    /**
     * Test de la date lastConnectionDate
     */
    public function testLastConnectionDate()
    {
        $customer = new Customer();
        $customer->setLastConnectionDate(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $customer->getLastConnectionDate());
    }

    /**
     * Test d'ajout d'un token
     */
    public function testToken()
    {
        $customer = new Customer();
        $customer->setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1MzQ3NTExMTAsImV4cCI6MTUzNDkyMzkxMCwicm9sZXMiOlsiUk9MRV9DVVNUT01FUiIsIlJPTEVfVVNFUiJdLCJlbWFpbCI6ImN1c3RvbWVyMTAwQGRvbWFpbi5jb20ifQ.sKDa3iuOOl4f9y8kLSlI3Wg043ByPKJbdmzgkKgL6YjGhmAjtS-BM_lNwPd__s0lEks5yj-A8ulcTNGl1PNrA4vUy2qgfnMwe5t4VrL_fuTFeLBkfFmmdPYkA051dRFlQRNX3Zivl8K0mo4J8EuhWq3MlaxkprPN-jz-nmgU58Rb0C1aj6tc7oKlh54B8IvIjaOL3hECxJluHy4Ya98zc2lM1-ZhmSPdqTcdm7Nrb-c2Gksl4tEcHJMJBG0rycNS0k0cEMT-tz2mV85bLr1K5H95Ha3InvVXJ0vFSCIybFDB61E_sYP5en1e81sa64uBg2QeRQ0w9X4CevXruFLhOzibJBv-2O91oapsqz1o4TfWbm5HoyePha9aAT7Hj4rSDx6JT2SbDjgfK6HH56wQjdrv6TpUp6k1paxm0_Q7rwvDuwWJED_SDhG8fb5hyNU_C4Sn-r2seVa31ww3teS2MdWIgIftGuKgqD4mV4CWpVHk3Pn-2uIcbGfZHu_jAltseA-FyUSHHEJlrpGp7wBvPh6Aic-pAomtDg1MOqeWyJU6xOOFAmXdk6mvt0Ja4E6qzbQg4ss0qJvNWqBJOYAuj3utQEtLgPawh2ZlYVCSZgXjzGPWksgtlDPbkTGv4P4cav6flObKensU1mv0epuMBTR1yDKp1PKawhnCqwyXt7s');

        $this->assertSame('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1MzQ3NTExMTAsImV4cCI6MTUzNDkyMzkxMCwicm9sZXMiOlsiUk9MRV9DVVNUT01FUiIsIlJPTEVfVVNFUiJdLCJlbWFpbCI6ImN1c3RvbWVyMTAwQGRvbWFpbi5jb20ifQ.sKDa3iuOOl4f9y8kLSlI3Wg043ByPKJbdmzgkKgL6YjGhmAjtS-BM_lNwPd__s0lEks5yj-A8ulcTNGl1PNrA4vUy2qgfnMwe5t4VrL_fuTFeLBkfFmmdPYkA051dRFlQRNX3Zivl8K0mo4J8EuhWq3MlaxkprPN-jz-nmgU58Rb0C1aj6tc7oKlh54B8IvIjaOL3hECxJluHy4Ya98zc2lM1-ZhmSPdqTcdm7Nrb-c2Gksl4tEcHJMJBG0rycNS0k0cEMT-tz2mV85bLr1K5H95Ha3InvVXJ0vFSCIybFDB61E_sYP5en1e81sa64uBg2QeRQ0w9X4CevXruFLhOzibJBv-2O91oapsqz1o4TfWbm5HoyePha9aAT7Hj4rSDx6JT2SbDjgfK6HH56wQjdrv6TpUp6k1paxm0_Q7rwvDuwWJED_SDhG8fb5hyNU_C4Sn-r2seVa31ww3teS2MdWIgIftGuKgqD4mV4CWpVHk3Pn-2uIcbGfZHu_jAltseA-FyUSHHEJlrpGp7wBvPh6Aic-pAomtDg1MOqeWyJU6xOOFAmXdk6mvt0Ja4E6qzbQg4ss0qJvNWqBJOYAuj3utQEtLgPawh2ZlYVCSZgXjzGPWksgtlDPbkTGv4P4cav6flObKensU1mv0epuMBTR1yDKp1PKawhnCqwyXt7s', $customer->getToken());
    }

    /**
     * Test des roles
     */
    public function testRoles()
    {
        $customer1 = new Customer();
        $customer2 = new Customer();
        $role1 = new Role('ROLE_USER');
        $role2 = new Role('ROLE_ADMIN');

        $customer1->addUserRole($role1);

        $this->assertCount(1, $customer1->getUserRoles());
        $this->assertInstanceOf(Collection::class, $customer1->getUserRoles());

        foreach ($customer1->getUserRoles() as $role1) {
            $this->assertInstanceOf(Role::class, $role1);
        }

        $this->assertSame('array', gettype($customer1->getRoles()));

        foreach ($customer1->getRoles() as $role1) {
            $this->assertSame('ROLE_USER', $role1);
        }

        $this->assertContainsOnly('string', $customer1->getRoles());

        $customer2->addUserRole($role2);
        $this->assertCount(1, $customer2->getUserRoles());
        $this->assertTrue(in_array('ROLE_USER', $customer2->getRoles()));

        $customer2->removeUserRole($role2);
        $this->assertCount(0, $customer2->getUserRoles());
    }

    /**
     * Test d'instanciation d'un Customer
     */
    public function testInstantiationCustomer()
    {
        $customer = new Customer();
        $this->assertInstanceOf(Customer::class, $customer);
    }

    /**
     * Test du username des customers
     */
    public function testCustomerUsername()
    {
        $customer = new Customer();
        $customer->setUsername('testusername');

        $name = 'testusername';
        $this->assertSame($customer->getUsername(), $name);
    }

    /**
     * Test d'ajout et de récupération de carte du customer
     */
    public function testCustomerAddCard()
    {
        $customer = new Customer();
        $card = new Card();

        $customer->addCard($card);

        $this->assertContainsOnlyInstancesOf(Card::class, $customer->getCards());
    }


    /**
     * Test de suppression de cartes du customer
     */
    public function testCustomerRemoveCard()
    {
        $customer = new Customer();
        $card1 = new Card();
        $card2 = new Card();
        $card3 = new Card();

        # Test d'ajout de deux cartes
        $customer->addCard($card1);
        $customer->addCard($card2);
        $customer->addCard($card3);

        $this->assertSame(3, count($customer->getCards()));

        $customer->removeCard($card3);
        $this->assertSame(2, count($customer->getCards()));
    }

    /**
     * Test d'ajout et suppression d'établissements d'un customer
     */
    public function testCustomerAddRemoveEstablishment()
    {
        $customer = new Customer();
        $establishment1 = new Establishment();
        $establishment2 = new Establishment();

        $customer->addEstablishment($establishment1);

        $this->assertSame(1, count($customer->getEstablishments()));
        $this->assertContainsOnlyInstancesOf(Establishment::class, $customer->getEstablishments());

        $customer->addEstablishment($establishment2);
        $this->assertSame(2, count($customer->getEstablishments()));

        $customer->removeEstablishment($establishment1);
        $this->assertSame(1, count($customer->getEstablishments()));
    }

    /**
     * Test d'ajout et suppression des adresses
     */
    public function testCustomerAddress()
    {
        $customer = new Customer();
        $address = new Address();

        $customer->setAddress($address);
        $this->assertInstanceOf(Address::class, $customer->getAddress());
    }

    /**
     * Test isActive
     */
    public function testIsActive()
    {
        $customer = new Customer();
        $customer->setIsActive(true);
        $this->assertTrue($customer->getIsActive());
    }

    /**
     * Test Salt
     */
    public function testSalt()
    {
        $customer = new Customer();
        $this->assertNull($customer->getSalt());
    }

    /**
     * Test eraseCredential
     */
    public function testEraseCredential()
    {
        $customer = new Customer();

        $customer->setPassword('0123456789AZerty');
        $customer->setToken('01234d5d6g4zfze8fez84fr6z4g6zgseg56468D5fvez');
        $this->assertSame('0123456789AZerty', $customer->getPassword());

        $customer->eraseCredentials();
        $this->assertSame('', $customer->getPassword());
        $this->assertSame('', $customer->getToken());
    }
}