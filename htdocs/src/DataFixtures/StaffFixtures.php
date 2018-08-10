<?php

namespace App\DataFixtures;

use App\Entity\Staff;
use App\Service\UtilsService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class StaffFixtures
 * @package App\DataFixtures
 */
class StaffFixtures extends Fixture implements DependentFixtureInterface
{
    public const STAFF_FIXTURES = 'staff-';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var UtilsService
     */
    private $utils;

    /**
     * UserFixtures constructor.
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

        $phoneNumber = '06';
        $count = 0;
        while ($count < 8) {
            $phoneNumber .= random_int(0, 9);
            $count++;
        }
        $token = $this->utils->generateSecureRandomString(16);
        $address = $this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[1]);
        $establishment = $this->getReference(EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[1]);
        $role = $this->getReference(RoleFixtures::ROLE_REFERENCE . 'admin');

        $staff = new Staff();
        $password = $this->encoder->encodePassword($staff, 'admin_password');
        $staff->setFirstName('Admin');
        $staff->setLastName('Shinigami');
        $staff->setEmail('admin@shinigami.com');
        $staff->setPassword($password);
        $staff->addAddress($address);
        $staff->setPhoneNumber($phoneNumber);
        $staff->setBirthday(new \DateTime('now'));
        $staff->setRegistrationDate(new \DateTime('now'));
        $staff->setIsActive(true);
        $staff->setToken($token);
        $staff->addUserRole($role);
        $staff->addEstablishment($establishment);

        $manager->persist($staff);

        for ($i = 1; $i <= 30; $i++) {
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
            $role = $this->getReference(RoleFixtures::ROLE_REFERENCE . 'staff');

            $staff = new Staff();
            $password = $this->encoder->encodePassword($staff, 'staff_password');
            $staff->setFirstName('Firstname ' . $i);
            $staff->setLastName('Lastname ' . $i);
            $staff->setEmail('staff' . $i . '@shinigami.com');
            $staff->setPassword($password);
            $staff->addAddress($address);
            $staff->setPhoneNumber($phoneNumber);
            $staff->setBirthday(new \DateTime('now'));
            $staff->setRegistrationDate(new \DateTime('now'));
            $staff->setIsActive(true);
            $staff->setToken($token);
            $staff->addUserRole($role);
            $staff->addEstablishment($establishment);

            $manager->persist($staff);
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