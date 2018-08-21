<?php
/**
 * Created by Antoine Buzaud.
 * Date: 21/08/2018
 */

namespace App\Controller\Establishment;

use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

class GetStaff
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function __invoke(int $id)
    {
        $establishment = $this->em->getRepository(Establishment::class)->find($id);
        $staff = $establishment->getStaff();

        $data = $staff;
        return $data;
    }
}