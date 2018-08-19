<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018
 */

namespace App\Tests\Card;


use App\Card\CardManager;
use App\Card\CardPdf;
use App\Entity\Card;
use App\Entity\Establishment;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Workflow\Registry;

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
        $workflow = $this->createMock(Registry::class);
        $workflow->expects($this->any())
            ->method('get')
            ->willReturn(Registry::class);

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
        $workflow = $this->createMock(Registry::class);
        $workflow->expects($this->any())
            ->method('get')
            ->willReturn(Registry::class);

        $cm = new CardManager($em, $cardPDF, $urlGeneratorInterface, $workflow);

        # On génére le code et on le test
        for ($i = 0; $i < 20; $i++) {
            $code = $cm->generateCustomerCode();
            $this->assertSame(6, strlen($code));
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
        $workflow = $this->createMock(Registry::class);
        $workflow->expects($this->any())
            ->method('get')
            ->willReturn(Registry::class);

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
        $workflow = $this->createMock(Registry::class);
        $workflow->expects($this->any())
            ->method('get')
            ->willReturn(Registry::class);

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
        $workflow = $this->createMock(Registry::class);
        $workflow->expects($this->any())
            ->method('get')
            ->willReturn(Registry::class);

        $cm = new CardManager($em, $cardPDF, $urlGeneratorInterface, $workflow);

        # On génére la carte et on vérifie sa structure
        for ($i = 0; $i < 50; $i++) {
            $code = $cm->generateCardCode(123);

            # Elle doit avoir 10 charactère
            $this->assertSame(10, strlen($code));

            # On vérifie le checksum
            $codeEstablishment = substr($code, 0, 3);
            $codeCustomer = substr($code, 3, 6);
            $supposeChecksum = intval(substr($code, -1));
            $checksum = (intval($codeEstablishment) + intval($codeCustomer)) % 9;

            # On calcul le modulo de la carte et on vérifie avec celui déjà généré
            $this->assertSame($supposeChecksum, $checksum);
        }
    }
}