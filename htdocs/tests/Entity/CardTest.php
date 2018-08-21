<?php
/**
 * Created by Antoine Buzaud.
 * Date: 20/08/2018
 */

namespace App\Tests\Entity;


use App\Entity\Card;
use App\Entity\Customer;
use App\Entity\Establishment;
use App\Entity\Visit;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

/**
 * Class CardTest
 * @package App\Tests\Entity
 */
class CardTest extends TestCase
{
    /**
     * Test d'instanciation d'une carte
     */
    public function testInstanciationCard()
    {
        $card = new Card();
        $this->assertInstanceOf(Card::class, $card);
    }


    /**
     * Test de l'ID
     */
    public function testId()
    {
        $card = new Card;
        $this->assertNull($card->getId());
    }


    /**
     * Test de l'état initial du workflow
     */
    public function testInitialWorkflowState()
    {
        $card = new Card();
        $this->assertSame(['blank' => 1], $card->getState());
        $this->assertFalse($card->getActivated());
    }

    /**
     * Test d'ajout des établissements
     */
    public function testEstablishement()
    {
        $card = new Card();
        $establishment = new Establishment();
        $card->setEstablishment($establishment);
        $this->assertInstanceOf(Establishment::class, $card->getEstablishment());
    }

    /**
     * Test d'akpit d'un code customer
     */
    public function testCodeCustomer()
    {
        $card = new Card();
        $card->setCodeCustomer('542638');
        $this->assertSame('542638', $card->getCodeCustomer());
    }

    /**
     * Test d'ajout d'un code card
     */
    public function testCodeCard()
    {
        $card = new Card();
        $card->setCodeCard('1230456789');
        $this->assertSame('1230456789', $card->getCodeCard());
    }

    /**
     * Test d'ajout d'un customer
     */
    public function testCustomer()
    {
        $card = new Card();
        $customer = new Customer();
        $card->setCustomer($customer);
        $this->assertInstanceOf(Customer::class, $card->getCustomer());
    }

    /**
     * Test de la suppression d'un client
     */
    public function testRemoveCustomer()
    {
        $card = new Card();
        $customer = new Customer();
        $card->setCustomer($customer);
        $this->assertInstanceOf(Customer::class, $card->getCustomer());

        $card->removeCustomer();
        $this->assertNull($card->getCustomer());
    }

    /**
     * Test d'ajout d'une visite
     */
    public function testVisits()
    {
        $card = new Card();
        $visit1 = new Visit();
        $visit2 = new Visit();

        $card->addVisit($visit1);
        $this->assertInstanceOf(Collection::class, $card->getVisits());

        $card->addVisit($visit2);
        foreach ($card->getVisits() as $visit) {
            $this->assertInstanceOf(Visit::class, $visit);
        }
    }

    /**
     * Test d'ajout de points
     */
    public function testPoints()
    {
        $card = new Card();
        $card->setPoints('100');
        $this->assertSame(100, $card->getPoints());

        $card->addPoints('50');
        $this->assertSame(150, $card->getPoints());
    }

    /**
     * Test de désactivation de carte
     */
    public function testDeactivateCard()
    {
        $card = new Card();
        $customer = new Customer();
        # La carte est lors de la création
        $this->assertFalse($card->getActivated());

        # Une carte est activé lorsqu'on lui ajoute un customer
        $card->setCustomer($customer);
        $this->assertTrue($card->getActivated());

        # On désactive la carte
        $card->desactivateCard();
        $this->assertFalse($card->getActivated());
    }

    /**
     * Test d'activation de carte
     */
    public function testActivateCard()
    {
        $card = new Card();
        $customer = new Customer();

        # Une carte est activé lorsqu'on lui ajoute un customer
        $card->setCustomer($customer);
        $this->assertTrue($card->getActivated());

        # On désactive la carte
        $card->desactivateCard();
        $this->assertFalse($card->getActivated());

        # On active la carte
        $card->activateCard();
        $this->assertTrue($card->getActivated());
    }

    /**
     * Test de suppression d'une visite
     */
    public function testRemoveVisit()
    {
        $card = new Card();
        $visit = new Visit();

        $card->addVisit($visit);
        $this->assertCount(1, $card->getVisits());

        $card->removeVisit($visit);
        $this->assertCount(0, $card->getVisits());
    }

    /**
     * Test d'ajout de code à l'établissement
     */
    public function testEstablishmentCode()
    {
        $card = new Card();
        $establishment = new Establishment();
        $establishment->setCodeEstablishment(123);

        $card->setEstablishment($establishment);

        $this->assertSame(123, $card->getEstablishmentCode());
    }
}
