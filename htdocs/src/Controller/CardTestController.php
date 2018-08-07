<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018
 */

namespace App\Controller;


use App\Card\CardManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CardTestController extends Controller
{
    /**
     * @Route("/test/cardgeneration", name="card_generation")
     * @param CardManager $cm
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function testCardGeneration(CardManager $cm)
    {
        $test = $cm->generateCardCode(494);
        

        return $this->render('debug/cardgeneration.html.twig');
    }
}