<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018
 */

namespace App\Controller;


use App\Card\CardFactory;
use App\Card\CardManager;
use App\Entity\Card;
use App\Entity\Customer;
use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CardTestController
 * @package App\Controller
 * Page de test de l'API
 * @codeCoverageIgnore
 */
class CardTestController extends Controller
{

    /**
     * @Route("/test/cardpdf", name="card_pdf")
     * @param CardFactory $cardFactory
     * @param CardManager $cardManager
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function testCardPdf(CardFactory $cardFactory, CardManager $cardManager, EntityManagerInterface $em)
    {
        $customer = $em->getRepository(Customer::class)->find(3);
        $establishment = $em->getRepository(Establishment::class)->find(1);

        $card = $cardFactory->createCardFromEstablishment($establishment);
        $card->setCodeCard($cardManager->generateCardCode($card->getEstablishmentCode()));
        $card->setCustomer($customer);

        # Génération de la carte
        $cardManager->generateCardPdf($card);

        $datas = [];

        return $this->render('pdf/cardgeneration.html.twig', [
            'title' => 'Test Génération PDF carte',
            'card' => $card,
            'datas' => $datas
        ]);
    }

    /**
     * @Route("/test/cardgeneration", name="card_generation")
     * @param CardManager $cm
     * @param CardFactory $cardFactory
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function testCardGeneration(CardManager $cm, CardFactory $cardFactory, EntityManagerInterface $em)
    {
        $establishment = new Establishment();
        $establishment->setCodeEstablishment(123);
        $establishment->setName('Lycée Buffon');
        $establishment->setDescription('Prout');

        //$card = $cardFactory->createCardFromEstablishment($establishment);
        $card = $em->getRepository(Card::class)->find(1);

        # Sérializer pour les entités
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $customer = $em->getRepository(Customer::class)->find(1);

        dump($card);
        $cm->deactivateCard($card);
        dump($card);

        $datas = [];

        return $this->render('debug/cardgeneration.html.twig', [
            'title' => 'Test Génération de carte',
            'datas' => $datas
        ]);
    }
}