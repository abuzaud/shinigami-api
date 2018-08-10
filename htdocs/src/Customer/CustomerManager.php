<?php

namespace App\Customer;

use App\Entity\Customer;
use App\Entity\Role;
use App\Service\UtilsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CustomerManager
 * @package App\Customer
 */
class CustomerManager
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $repository;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var UtilsService
     */
    private $utils;

    /**
     * CustomerManager constructor.
     * @param EntityManagerInterface $manager
     * @param EventDispatcherInterface $dispatcher
     * @param UtilsService $utils
     */
    public function __construct(
        EntityManagerInterface $manager,
        EventDispatcherInterface $dispatcher,
        UtilsService $utils
    ) {
        $this->manager = $manager;
        $this->repository = $this->manager->getRepository(Customer::class);
        $this->dispatcher = $dispatcher;
        $this->utils = $utils;
    }

    /**
     * @param Customer $customer
     * @return Customer
     * @throws \Exception
     */
    public function register(Customer $customer): Customer
    {
        $token = $this->utils->generateSecureRandomString(16);
        $role = $this->manager->getRepository(Role::class)
            ->findOneByRole('ROLE_CUSTOMER');

        $customer->setRegistrationDate(new \DateTime('now'));
        $customer->setIsActive(false);
        $customer->setToken($token);
        $customer->addUserRole($role);

        return $customer;
    }

    /**
     * @param $token
     * @param $email
     */
    public function enableAccount($email, $token): void
    {
        $customer = $this->findCustomerByEmailAndToken($email, $token);

        if ($customer && $customer->getIsActive() === false) {
            $customer->setIsActive(true);
            $this->manager->persist($customer);
            $this->manager->flush();

            $this->dispatcher->dispatch(CustomerEvents::CUSTOMER_ACCOUNT_ENABLED, new CustomerEvent($customer));
        }
    }

    /**
     * @param $email
     * @throws \Exception
     */
    public function forgotPassword($email): void
    {
        $customer = $this->findCustomerByEmail($email);

        if ($customer) {
            $token = $this->utils->generateSecureRandomString(16);
            $customer->setToken($token);
            $this->manager->persist($customer);
            $this->manager->flush();
        }
    }

    /**
     * @param $email
     * @return Customer|null
     */
    public function findCustomerByEmail($email): ?Customer
    {
        return $this->repository->findOneByEmail($email);
    }

    /**
     * @param $email
     * @param $token
     * @return Customer|null
     */
    public function findCustomerByEmailAndToken($email, $token): ?Customer
    {
        return $this->repository->findOneBy([
            'email' => $email,
            'token' => $token
        ]);
    }
}
