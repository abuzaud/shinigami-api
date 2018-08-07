<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018
 */

namespace App\Controller;


use App\Card\CardFactory;
use App\Card\CardManager;
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
     * @Route("/test/cardgeneration", name="card_generation")
     * @param CardManager $cm
     * @param CardFactory $cardFactory
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function testCardGeneration(CardManager $cm, CardFactory $cardFactory)
    {
        $establishment = new Establishment();
        $establishment->setCodeEstablishment(835);
        $establishment->setName('Lycée Buffon');
        $establishment->setDescription('Prout');

        $card = $cardFactory->createCard(835);
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
        #$datas[] = $jsonEstablishment;
        $datas[] = $jsonCard;

        return $this->render('debug/cardgeneration.html.twig', [
            'datas' => $datas
        ]);
    }
}