<?php

namespace App\DataFixtures;

use App\Entity\Customer;
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
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
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

            $customer = new Customer();
            $customer->setFirstName('Firstname ' . $i);
            $customer->setLastName('Lastname ' . $i);
            $customer->setUsername('username' . $i);
            $customer->setEmail('customer' . $i . '@domain.com');
            $password = $this->encoder->encodePassword($customer, 'customer_password');
            $customer->setPassword($password);
            $customer->addAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[1]));
            $customer->setPhoneNumber($phoneNumber);
            $customer->setBirthday(new \DateTime('now'));
            $customer->setRegistrationDate(new \DateTime('now'));
            $customer->setIsActive(true);
            $customer->setToken('123');
            $customer->addUserRole($this->getReference(RoleFixtures::ROLE_REFERENCE . 'customer'));
            $customer->addEstablishment($this->getReference(EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[1]));
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