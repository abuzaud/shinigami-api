<?php
/**
 * Created by Antoine Buzaud.
 * Date: 20/08/2018
 */

namespace App\Tests\Card;


use App\Card\CardFactory;
use App\Card\CardManager;
use App\Card\CardPdf;
use App\Entity\Card;
use App\Entity\Customer;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class CardFactoryTest extends TestCase
{
    /**
     * Test la création d'une carte
     */
    public function testCreateCard()
    {
        $card = new Card();
        $card->setCodeCard('1230456789');
        $customer = new Customer();
        $customer->setFirstName('Antoine');

        #Mock du repository
        $repository = $this->createMock(ObjectRepository::class);
        $repository->expects($this->any())
            ->method('findby')
            ->willReturn(null);

        # Mock du EntityManager
        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->any())
            ->method('getRepository')
            ->willReturn($repository);
        # On mock le cardPDF et UrlGeneratorInterface
        $cardPDF = $this->createMock(CardPdf::class);
        $urlGeneratorInterface = $this->createMock(UrlGeneratorInterface::class);

        # On mock le workflow
        $workflow = $this->createMock(WorkflowInterface::class);
        $workflow->expects($this->any())
            ->method('can')
            ->willReturn(true);

        $cm = new CardManager($em, $cardPDF, $urlGeneratorInterface, $workflow);
        $cf = new CardFactory($cm, $em);

        $newCard = $cf->createCard();
        $this->assertInstanceOf(Card::class, $newCard);
    }
}