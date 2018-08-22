<?php

namespace App\Customer;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Customer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CustomerDataPersister
 * @package App\Customer
 */
class CustomerDataPersister implements DataPersisterInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * CustomerDataPersister constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function supports($data): bool
    {
        return $data instanceof Customer;
    }

    /**
     * @param mixed $data
     * @return Customer
     */
    public function persist($data): Customer
    {
        $password = $this->encoder->encodePassword($data, $data->getPassword());
        $data->setPassword($password);

        return $data;
    }

    /**
     * @param mixed $data
     */
    public function remove($data)
    {
        // call your persistence layer to delete $data
    }
}