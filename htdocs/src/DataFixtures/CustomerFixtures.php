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
        $addresses = range(1, 135);
        $establishments = range(1, 3);

        $id = 1;

        for ($i = 1; $i <= 3; $i++) {

            for ($j = 1; $j <= 34; $j++) {
                $phoneNumber = $this->generatePhoneNumber();
                $token = $this->utils->generateRandomString(16);
                $address = $this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[$id + 32]);
                $establishment = $this->getReference(
                    EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[$i - 1]
                );
                $role = $this->getReference(RoleFixtures::ROLE_REFERENCE . 'customer');

                $customer = new Customer();
                $password = $this->encoder->encodePassword($customer, 'customer_password');
                $customer->setFirstName('Firstname ' . $id);
                $customer->setLastName('Lastname ' . $id);
                $customer->setUsername('username' . $id);
                $customer->setEmail('customer' . $id . '@domain.com');
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

                $this->addReference(self::CUSTOMER_FIXTURES . $id, $customer);

                $id++;
            }

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

    /**
     * @return string
     * @throws \Exception
     */
    private function generatePhoneNumber(): string
    {
        $phoneNumber = '06';
        $count = 0;
        while ($count < 8) {
            $phoneNumber .= random_int(0, 9);
            $count++;
        }

        return $phoneNumber;
    }
}
