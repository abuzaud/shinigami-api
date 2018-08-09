<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018
 */

namespace App\Controller;


use App\Card\CardFactory;
use App\Card\CardManager;
use App\Card\CardPdf;
use App\Entity\Customer;
use App\Entity\Establishment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

class CardTestController extends Controller
{

    /**
     * @Route("/test/cardpdf", name="card_pdf")
     * @param CardFactory $cardFactory
     * @param CardManager $cardManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function testCardPdf(CardFactory $cardFactory, CardManager $cardManager, CardPdf $pdf)
    {
        $customer = new Customer();
        $customer->setFirstName('Antoine')->setLastName('Buzaud');
        $customer->setEmail('antoine.buzaud@gmail.com');

        $card = $cardFactory->createCardFromEstablishmentId(1);
        $card->setCodeCustomer(456);
        $card->setCustomer($customer);
        $card->setCodeCard($cardManager->generateCardCode($card->getEstablishmentCode()));

        $card->setCodeCard('1233977872');
        # Génération de la carte
        $pdf = $pdf->generateLoyaltyCardFromEntity($card);

        dump($pdf);

        #return $this->render('debug/cardpdf.html.twig', [
        return $this->render('pdf/card.html.twig', [
            'title' => 'Test Génération PDF carte',
            'card' => $card
        ]);
    }

    /**
     * @Route("/test/cardgeneration", name="card_generation")
     * @param CardManager $cm
     * @param CardFactory $cardFactory
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function testCardGeneration(CardManager $cm, CardFactory $cardFactory)
    {
        $establishment = new Establishment();
        $establishment->setCodeEstablishment(123);
        $establishment->setName('Lycée Buffon');
        $establishment->setDescription('Prout');

        $card = $cardFactory->createCardFromEstablishmentCode(123);
        $card->setEstablishment($establishment);


        dump($card);
        dump($establishment);

        # Sérializer pour les entités
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $jsonEstablishment = $serializer->serialize($establishment, 'json');
        $jsonCard = $serializer->serialize($card, 'json');

        $datas = [];
        $datas[] = $jsonEstablishment;
        $datas[] = $jsonCard;

        return $this->render('debug/cardgeneration.html.twig', [
            'title' => 'Test Génération de carte',
            'datas' => $datas
        ]);
    }
}