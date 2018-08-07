<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018
 */

namespace App\Tests\Card;


use App\Card\CardManager;
use App\Entity\Card;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

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


        # On créé une nouvelle instance de notre classe à tester
        $cm1 = new CardManager($em1);

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
        $cm2 = new CardManager($em2);

        # On vérifie que la fonction ne trouve effectivement aucun code client
        $codeCheck2 = $cm2->checkIfCustomerCodeExist('985698');
        $this->assertSame(false, $codeCheck2);
    }

    /**
     * On test la génération du code client
     */
    public function testGenerateCustomerCode(){
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

        $cm = new CardManager($em);

        # On génére le code et on le test
        for($i = 0 ; $i < 20 ; $i++){
            $code = $cm->generateCustomerCode();
            $this->assertSame(6, strlen($code));
        }
    }
}