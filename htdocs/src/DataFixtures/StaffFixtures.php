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
        $addresses = range(1, 135);
        $establishments = range(1, 3);

        $id = 1;

        for ($i = 1; $i <= 3; $i++) {
            $phoneNumber = $this->generatePhoneNumber();
            $token = $this->utils->generateRandomString(16);
            $address = $this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[$i - 1]);
            $establishment = $this->getReference(
                EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[$i - 1]
            );
            $role = $this->getReference(RoleFixtures::ROLE_REFERENCE . 'admin');

            $staff = new Staff();
            $password = $this->encoder->encodePassword($staff, 'admin_password');
            $staff->setFirstName('Admin' . $i);
            $staff->setLastName('Shinigami' . $i);
            $staff->setEmail('admin' . $i . '@shinigami.com');
            $staff->setPassword($password);
            $staff->setAddress($address);
            $staff->setPhoneNumber($phoneNumber);
            $staff->setBirthday(new \DateTime('now'));
            $staff->setRegistrationDate(new \DateTime('now'));
            $staff->setIsActive(true);
            $staff->setToken($token);
            $staff->addUserRole($role);
            $staff->addEstablishment($establishment);

            $manager->persist($staff);

            for ($j = 1; $j <= 10; $j++) {
                $phoneNumber = $this->generatePhoneNumber();
                $token = $this->utils->generateRandomString(16);
                $address = $this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[$id + 2]);
                $establishment = $this->getReference(
                    EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[$i - 1]
                );
                $role = $this->getReference(RoleFixtures::ROLE_REFERENCE . 'staff');

                $staff = new Staff();
                $password = $this->encoder->encodePassword($staff, 'staff_password');
                $staff->setFirstName('Firstname ' . $id);
                $staff->setLastName('Lastname ' . $id);
                $staff->setEmail('staff' . $id . '@shinigami.com');
                $staff->setPassword($password);
                $staff->setAddress($address);
                $staff->setPhoneNumber($phoneNumber);
                $staff->setBirthday(new \DateTime('now'));
                $staff->setRegistrationDate(new \DateTime('now'));
                $staff->setIsActive(true);
                $staff->setToken($token);
                $staff->addUserRole($role);
                $staff->addEstablishment($establishment);

                $manager->persist($staff);

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
