<?php

namespace App\DataFixtures;

use App\Entity\Staff;
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

        for ($i = 1; $i <= 30; $i++) {
            shuffle($addresses);
            $phoneNumber = '06';
            $count = 0;
            while ($count < 8) {
                $phoneNumber .= random_int(0, 9);
                $count++;
            }
            shuffle($establishments);

            $staff = new Staff();
            $staff->setFirstName('Firstname ' . $i);
            $staff->setLastName('Lastname ' . $i);
            $staff->setEmail('staff' . $i . '@shinigami.com');
            $password = $this->encoder->encodePassword($staff, 'staff_password');
            $staff->setPassword($password);
            $staff->addAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[1]));
            $staff->setPhoneNumber($phoneNumber);
            $staff->setBirthday(new \DateTime('now'));
            $staff->setRegistrationDate(new \DateTime('now'));
            $staff->setIsActive(true);
            $staff->setToken('123');
            $staff->addUserRole($this->getReference(RoleFixtures::ROLE_REFERENCE . 'staff'));
            $staff->addEstablishment($this->getReference(EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[1]));
            $manager->persist($staff);
        }


        shuffle($addresses);
        $phoneNumber = '06';
        $count = 0;
        while ($count < 8) {
            $phoneNumber .= random_int(0, 9);
            $count++;
        }
        shuffle($establishments);

        $staff = new Staff();
        $staff->setFirstName('Admin');
        $staff->setLastName('Shinigami');
        $staff->setEmail('admin@shinigami.com');
        $password = $this->encoder->encodePassword($staff, 'admin_password');
        $staff->setPassword($password);
        $staff->addAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[1]));
        $staff->setPhoneNumber($phoneNumber);
        $staff->setBirthday(new \DateTime('now'));
        $staff->setRegistrationDate(new \DateTime('now'));
        $staff->setIsActive(true);
        $staff->setToken('123');
        $staff->addUserRole($this->getReference(RoleFixtures::ROLE_REFERENCE . 'staff'));
        $staff->addEstablishment($this->getReference(EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[1]));
        $manager->persist($staff);

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