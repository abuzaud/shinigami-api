<?php
/**
 * Created by Antoine Buzaud.
 * Date: 20/08/2018
 */

namespace App\Tests\Entity;


use App\Entity\Establishment;
use App\Entity\Visit;
use PHPUnit\Framework\TestCase;

class VisitTest extends TestCase
{
    /**
     * Test d'instanciation d'une visite
     */
    public function testInstanciationVisit(){
        $visit = new Visit();
        $this->assertInstanceOf(Visit::class, $visit);
    }

    /**
     * Test Id
     */
    public function testId(){
        $visit = new Visit();
        $this->assertNull($visit->getId());
    }

    /**
     * Test Establishment
     */
    public function testEstablishment(){
        $visit = new Visit();
        $establishment = new Establishment();
        $establishment->setName('Etablissement 1');

        $visit->setEstablishement($establishment);

        $this->assertSame('Etablissement 1', $visit->getEstablishement()->getName());
    }

    /**
     * Test UseDate
     */
    public function testUseDate(){
        $visit = new Visit();
        $visit->setUseDate(new \DateTime());

        $this->assertInstanceOf(\DateTime::class, $visit->getUseDate());
    }
}