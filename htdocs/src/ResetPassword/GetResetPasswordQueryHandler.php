<?php

namespace App\ResetPassword;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

/**
 * Class GetResetPasswordQueryHandler
 * @package App\ResetPasswordRequest
 */
class GetResetPasswordQueryHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * GetResetPasswordQueryHandler constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param GetResetPasswordQuery $query
     * @return mixed
     * @throws EntityNotFoundException
     * TODO: changer Customer en User + test
     */
    public function handle(GetResetPasswordQuery $query)
    {
        $customer = $this->manager->getRepository(Customer::class)
            ->findOneByEmail($query->getEmail());

        if (!$customer) {
            throw new EntityNotFoundException('Not found');
        }

        return $customer;
    }
}
