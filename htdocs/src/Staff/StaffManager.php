<?php

namespace App\Staff;

use App\Entity\Role;
use App\Entity\Staff;
use App\Service\UtilsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class StaffManager
 * @package App\Staff
 */
class StaffManager
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
     * StaffManager constructor.
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
        $this->repository = $this->manager->getRepository(Staff::class);
        $this->dispatcher = $dispatcher;
        $this->utils = $utils;
    }

    /**
     * @param Staff $staff
     * @return Staff
     * @throws \Exception
     */
    public function register(Staff $staff): Staff
    {
        $password = $this->utils->generateRandomString(4);
        $token = $this->utils->generateRandomString(16);
        $role = $this->manager->getRepository(Role::class)
            ->findOneByRole('ROLE_STAFF');

        $staff->setPassword($password);
        $staff->setRegistrationDate(new \DateTime('now'));
        $staff->setIsActive(true);
        $staff->setToken($token);
        $staff->addUserRole($role);

        $this->dispatcher->dispatch(StaffEvents::STAFF_PASSWORD_TO_UPDATE, new StaffEvent($staff));

        return $staff;
    }
}
