<?php
/**
 * Created by Antoine Buzaud.
 * Date: 20/08/2018
 */

namespace App\Tests\Entity;


use App\Entity\Establishment;
use PHPUnit\Framework\TestCase;

class EstablishmentTest extends TestCase
{
    /**
     * Test d'instanciation d'un établissement
     */
    public function testInstanciationEstablishment(){
        $establishment = new Establishment();
        $this->assertInstanceOf(Establishment::class, $establishment);
    }
}