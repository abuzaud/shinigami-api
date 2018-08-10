<?php

namespace App\ResetPassword;

use App\Customer\CustomerEvent;
use App\Customer\CustomerEvents;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UpdateResetPasswordHandler
 * @package App\ResetPasswordRequest
 */
class UpdateResetPasswordHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UpdateResetPasswordHandler constructor.
     * @param EntityManagerInterface $manager
     * @param EventDispatcherInterface $dispatcher
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(
        EntityManagerInterface $manager,
        EventDispatcherInterface $dispatcher,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->manager = $manager;
        $this->dispatcher = $dispatcher;
        $this->encoder = $encoder;
    }

    /**
     * @param UpdateResetPassword $command
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function handle(UpdateResetPassword $command)
    {
        /** @var Customer $customer */
        $customer = $this->manager->getRepository(Customer::class)
            ->findOneByEmail($command->getEmail());

        if (!$customer) {
            throw new EntityNotFoundException('Not found');
        }

        $password = $this->encoder->encodePassword($customer, $command->getPassword());
        $customer->setPassword($password);

        $this->manager->persist($customer);
        $this->manager->flush();

        $this->dispatcher->dispatch(CustomerEvents::CUSTOMER_RESET_PASSWORD, new CustomerEvent($customer));

        return $customer;
    }
}
