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
use App\Entity\Client;
use App\Entity\Establishment;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 * @package App\Tests\Entity
 */
class ClientTest extends TestCase
{
    /**
     * Test du username des clients
     */
    public function testClientUsername()
    {
        $client = new Client();
        $client->setUsername('testusername');

        $name = 'testusername';
        $this->assertSame($client->getUsername(), $name);
    }

    /**
     * Test d'ajout et de récupération de carte du client
     */
    public function testClientAddCard()
    {
        $client = new Client();
        $card = new Card();

        $client->addCard($card);

        $this->assertContainsOnlyInstancesOf(Card::class, $client->getCards());
    }


    /**
     * Test de suppression de cartes du client
     */
    public function testClientRemoveCard(){
        $client = new Client();
        $card1 = new Card();
        $card2 = new Card();
        $card3 = new Card();

        # Test d'ajout de deux cartes
        $client->addCard($card1);
        $client->addCard($card2);
        $client->addCard($card3);

        $this->assertSame(3, count($client->getCards()));

        $client->removeCard($card3);
        $this->assertSame(2, count($client->getCards()));
    }

    /**
     * Test d'ajout et suppression d'établissements d'un client
     */
    public function testClientAddRemoveEstablishment(){
        $client = new Client();
        $establishment1 = new Establishment();
        $establishment2 = new Establishment();

        $client->addEstablishment($establishment1);

        $this->assertSame(1, count($client->getEstablishments()));
        $this->assertContainsOnlyInstancesOf(Establishment::class, $client->getEstablishments());

        $client->addEstablishment($establishment2);
        $this->assertSame(2, count($client->getEstablishments()));

        $client->removeEstablishment($establishment1);
        $this->assertSame(1, count($client->getEstablishments()));
    }

    /**
     * Test d'ajout et suppression des adresses
     */
    public function test(){
        $client = new Client();
        $address1 = new Address();
        $address2 = new Address();

        $client->addAddress($address1);

        $this->assertSame(1, count($client->getAddresses()));
        $this->assertContainsOnlyInstancesOf(Address::class, $client->getAddresses());

        $client->addAddress($address2);
        $this->assertSame(2, count($client->getAddresses()));

        $client->removeAddress($address2);
        $this->assertSame(1, count($client->getAddresses()));
    }
}