<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class RoleFixtures
 * @package App\DataFixtures
 */
class RoleFixtures extends Fixture
{
    public const ROLE_REFERENCE = 'role-';

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $role = new Role();
        $role->setName('Client');
        $role->setRole('ROLE_CUSTOMER');
        $manager->persist($role);
        $this->addReference(self::ROLE_REFERENCE . 'customer', $role);

        $role = new Role();
        $role->setName('Staff');
        $role->setRole('ROLE_STAFF');
        $manager->persist($role);
        $this->addReference(self::ROLE_REFERENCE . 'staff', $role);

        $role = new Role();
        $role->setName('Admin');
        $role->setRole('ROLE_ADMIN');
        $manager->persist($role);
        $this->addReference(self::ROLE_REFERENCE . 'admin', $role);

        $manager->flush();
    }
}