<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Service\UtilsService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CustomerFixtures
 * @package App\DataFixtures
 */
class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    public const CUSTOMER_FIXTURES = 'customer-';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var UtilsService
     */
    private $utils;

    /**
     * CustomerFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     * @param UtilsService $utils
     */
    public function __construct(UserPasswordEncoderInterface $encoder, UtilsService $utils)
    {
        $this->encoder = $encoder;
        $this->utils = $utils;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $addresses = range(1, 50);
        $establishments = range(1, 3);

        for ($i = 1; $i <= 100; $i++) {
            shuffle($addresses);
            $phoneNumber = '06';
            $count = 0;
            while ($count < 8) {
                $phoneNumber .= random_int(0, 9);
                $count++;
            }
            shuffle($establishments);
            $token = $this->utils->generateSecureRandomString(16);
            $address = $this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[1]);
            $establishment = $this->getReference(EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[1]);
            $role = $this->getReference(RoleFixtures::ROLE_REFERENCE . 'customer');

            $customer = new Customer();
            $password = $this->encoder->encodePassword($customer, 'customer_password');
            $customer->setFirstName('Firstname ' . $i);
            $customer->setLastName('Lastname ' . $i);
            $customer->setUsername('username' . $i);
            $customer->setEmail('customer' . $i . '@domain.com');
            $customer->setPassword($password);
            $customer->addAddress($address);
            $customer->setPhoneNumber($phoneNumber);
            $customer->setBirthday(new \DateTime('now'));
            $customer->setRegistrationDate(new \DateTime('now'));
            $customer->setIsActive(true);
            $customer->setToken($token);
            $customer->addUserRole($role);
            $customer->addEstablishment($establishment);

            $manager->persist($customer);

            $this->addReference(self::CUSTOMER_FIXTURES . $i, $customer);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            AddressFixtures::class,
            EstablishmentFixtures::class,
            RoleFixtures::class
        ];
    }
}