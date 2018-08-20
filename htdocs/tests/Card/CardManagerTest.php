<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018
 */

namespace App\Tests\Card;


use App\Card\CardFactory;
use App\Card\CardManager;
use App\Card\CardPdf;
use App\Entity\Card;
use App\Entity\Customer;
use App\Entity\Establishment;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Workflow\WorkflowInterface;

class CardManagerTest extends TestCase
{
    /**
     * On test la vérification du code client en base de données
     */
    public function testCheckCustomerCodeExist()
    {
        # On créé une fausse carte
        $code = '985698';
        $card = new Card();
        $card->setCodeCustomer($code);

        # On créé le mock du repository pour qu'il retourne le mock de la carte
        $cardRepository1 = $this->createMock(ObjectRepository::class);
        $cardRepository2 = $this->createMock(ObjectRepository::class);

        # On simule que le repository nous retourne notre carte de test
        $cardRepository1->expects($this->any())
            ->method('findBy')
            ->willReturn($card);

        # On créé un autre repository, qui lui nous retournera null
        $cardRepository2->expects($this->any())
            ->method('findBy')
            ->willReturn(null);

        # On mock que l'entitymanager va nous retourner notre repository de test
        $em1 = $this->createMock(EntityManagerInterface::class);
        $em1->expects($this->any())
            ->method('getRepository')
            ->willReturn($cardRepository1);

        # On mock le cardPDF
        $cardPDF = $this->createMock(CardPdf::class);

        # On mock UrlGeneratorInterface
        $urlGeneratorInterface = $this->createMock(UrlGeneratorInterface::class);

        # On mock le workflow
        $workflow = $this->createMock(WorkflowInterface::class);
        $workflow->expects($this->any())
            ->method('can')
            ->willReturn(true);

        # On créé une nouvelle instance de notre classe à tester
        $cm1 = new CardManager($em1, $cardPDF, $urlGeneratorInterface, $workflow);

        # On test que le service nous renvoie bien true, car le code existe
        $codeCheck1 = $cm1->checkIfCustomerCodeExist($code);
        $this->assertSame(true, $codeCheck1);


        # On créé un nouveau
        $cardRepository2->expects($this->any())
            ->method('findBy')
            ->willReturn(null);

        # On recréé l'entity manager avec le nouveau repository
        $em2 = $this->createMock(EntityManagerInterface::class);
        $em2->expects($this->any())
            ->method('getRepository')
            ->willReturn($cardRepository2);

        $cm2 = new CardManager($em2, $cardPDF, $urlGeneratorInterface, $workflow);

        # On vérifie que la fonction ne trouve effectivement aucun code client
        $codeCheck2 = $cm2->checkIfCustomerCodeExist('985698');
        $this->assertSame(false, $codeCheck2);
    }

    /**
     * On test la génération du code client
     * @throws \Exception
     */
    public function testGenerateCustomerCode()
    {
        # Mock du repository
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

        # On génére le code et on le test
        for ($i = 0; $i < 20; $i++) {
            $this->assertSame(6, strlen($cm->generateCustomerCode()));
        }
    }

    /**
     * Test de recherche d'établissement
     */
    public function testCheckIfEstablishmentExist()
    {
        $establishment = new Establishment();
        $establishment->setCodeEstablishment(123);

        $repository = $this->createMock(ObjectRepository::class);
        $repository->expects($this->any())
            ->method('findby')
            ->willReturn($establishment);

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

        # On recherche l'établissmenet
        $cm = new CardManager($em, $cardPDF, $urlGeneratorInterface, $workflow);
        $findEstablishment = $cm->checkIfEstablishmentCodeExist(123);
        $this->assertSame(true, $findEstablishment);
    }

    /**
     * On test la génération du code client
     * @throws \Exception
     */
    public function testGenerateEstablishmentCode()
    {
        # Mock du repository
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

        # On génére le code et on le test
        for ($i = 0; $i < 20; $i++) {
            $code = $cm->generateEstablishmentCode();
            $this->assertSame(3, strlen($code));
        }
    }

    /**
     * On test la génération des codes de carte (10 chiffres)
     * @throws \Exception
     */
    public function testGenerateCardCode()
    {
        # Mock du repository
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

        # On génére la carte et on vérifie sa structure
        for ($i = 0; $i < 50; $i++) {
            $code = $cm->generateCardCode(123);

            # Elle doit avoir 10 charactère
            $this->assertSame(10, strlen($code));

            # On vérifie le checksum
            $codeEstablishment = substr($code, 0, 3);
            $codeCustomer = substr($code, 3, 6);

            # On calcul le modulo de la carte et on vérifie avec celui déjà généré
            $this->assertSame(intval(substr($code, -1)), (intval($codeEstablishment) + intval($codeCustomer)) % 9);
        }
    }

    public function testSetCardCode()
    {
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

        $code = $cm->generateCardCode(123);
        $establishment = new Establishment();
        $establishment->setCodeEstablishment(123)->setId(1);
        $card = $cf->createFixtureCardFromEstablishment($establishment);

        $this->assertEmpty($card->getCustomer());
        $cm->setCardCode($card, $establishment);
    }


    public function testDeactivateCard()
    {
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

        $workflow->expects($this->any())
            ->method('apply')
            ->willReturn(true);

        $cm = new CardManager($em, $cardPDF, $urlGeneratorInterface, $workflow);

        $card = new Card;
        $card->setState(['activated', 'code_created']);
        $this->assertSame(['activated', 'code_created'], $card->getState());
        $this->assertInstanceOf(Card::class, $cm->deactivateCard($card));

        # Si on ne peut pas changer le workflow de la carte
        $workflow = $this->createMock(WorkflowInterface::class);
        $workflow->expects($this->any())
            ->method('can')
            ->willReturn(false);

        $cm = new CardManager($em, $cardPDF, $urlGeneratorInterface, $workflow);

        $this->assertFalse($cm->deactivateCard($card));

    }

    /**
     *  Test de l'ajout d'un client sur une carte
     */
    public function testCardCustomer()
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

        $cm->setCardCustomer($card, $customer);
        $this->assertSame('Antoine', $card->getCustomer()->getFirstName());
    }
}