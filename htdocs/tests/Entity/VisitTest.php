<?php
/**
 * Created by Antoine Buzaud.
 * Date: 20/08/2018
 */

namespace App\Tests\Entity;


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
}