<?php

namespace App\Customer;

use ApiPlatform\Core\Exception\ItemNotFoundException;
use App\Entity\Customer;
use App\Entity\Role;
use App\Service\UtilsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class CustomerManager
 * @package App\Customer
 * @codeCoverageIgnore
 */
class CustomerManager
{
    private const NOT_FOUND = 'Not found';

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
        $token = $this->utils->generateRandomString(16);
        $role = $this->manager->getRepository(Role::class)
            ->findOneByRole('ROLE_CUSTOMER');

        $customer->setRegistrationDate(new \DateTime('now'));
        $customer->setIsActive(false);
        $customer->setToken($token);
        $customer->addUserRole($role);

        $this->dispatcher->dispatch(CustomerEvents::CUSTOMER_ACCOUNT_TO_ENABLE, new CustomerEvent($customer));

        return $customer;
    }

    /**
     * @param $email
     * @param $token
     * @return Customer|null
     * @throws \Exception
     */
    public function enableAccount($email, $token): ?Customer
    {
        $customer = $this->repository->findOneBy([
            'email' => $email,
            'token' => $token
        ]);

        if (!$customer) {
            throw new ItemNotFoundException(self::NOT_FOUND);
        }

        if ($customer->getIsActive() === true) {
            throw new \Exception('Already enabled');
        }

        $customer->setIsActive(true);
        $this->manager->persist($customer);
        $this->manager->flush();

        $this->dispatcher->dispatch(CustomerEvents::CUSTOMER_ACCOUNT_ENABLED, new CustomerEvent($customer));

        return $customer;
    }

    /**
     * @param $email
     * @return Customer|null
     * @throws \Exception
     */
    public function forgotPassword($email): ?Customer
    {
        $customer = $this->repository->findOneBy([
            'email' => $email
        ]);

        if (!$customer) {
            throw new ItemNotFoundException(self::NOT_FOUND);
        }

        $token = $this->utils->generateRandomString(16);

        $customer->setToken($token);
        $this->manager->persist($customer);
        $this->manager->flush();

        $this->dispatcher->dispatch(CustomerEvents::CUSTOMER_PASSWORD_TO_RESET, new CustomerEvent($customer));

        return $customer;
    }

    /**
     * @param $id
     * @param $email
     * @param $token
     * @param $password
     * @return Customer|null
     */
    public function resetPassword($id, $email, $token, $password): ?Customer
    {
        $customer = $this->repository->findOneBy([
            'id' => $id,
            'email' => $email,
            'token' => $token
        ]);

        if (!$customer) {
            throw new ItemNotFoundException(self::NOT_FOUND);
        }

        $customer->setPassword($password);
        $this->manager->persist($customer);
        $this->manager->flush();

        $this->dispatcher->dispatch(CustomerEvents::CUSTOMER_PASSWORD_RESET, new CustomerEvent($customer));

        return $customer;
    }
}
