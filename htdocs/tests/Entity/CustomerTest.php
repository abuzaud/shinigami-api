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
use PHPUnit\Framework\TestCase;

/**
 * Class CustomerTest
 * @package App\Tests\Entity
 */
class CustomerTest extends TestCase
{
    /**
     * Test d'instanciation d'un Customer
     */
    public function testInstanciationCustomer()
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
    public function testCustomerAddRemoveAddress()
    {
        $customer = new Customer();
        $address1 = new Address();
        $address2 = new Address();

        $customer->addAddress($address1);

        $this->assertSame(1, count($customer->getAddresses()));
        $this->assertContainsOnlyInstancesOf(Address::class, $customer->getAddresses());

        $customer->addAddress($address2);
        $this->assertSame(2, count($customer->getAddresses()));

        $customer->removeAddress($address2);
        $this->assertSame(1, count($customer->getAddresses()));
    }
}