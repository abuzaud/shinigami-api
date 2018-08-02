<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ClientFixtures
 * @package App\DataFixtures
 */
class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    public const CLIENT_FIXTURES = 'client-';

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

            $client = new Client();
            $client->setFirstName('Firstname ' . $i);
            $client->setLastName('Lastname ' . $i);
            $client->setUsername('username' . $i);
            $client->setEmail('client' . $i . '@domain.com');
            //$password = $this->encoder->encodePassword($client, 'client_password');
            //$client->setPassword($password);
            $client->setPassword('client_password');
            $client->addAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[1]));
            $client->setPhoneNumber($phoneNumber);
            $client->setBirthday(new \DateTime('now'));
            $client->setRegistrationDate(new \DateTime('now'));
            $client->setIsActive(true);
            $client->setToken('123');
            $client->addRole($this->getReference(RoleFixtures::ROLE_REFERENCE . 'client'));
            $client->addEstablishment($this->getReference(EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[1]));
            $manager->persist($client);
            $this->addReference(self::CLIENT_FIXTURES . $i, $client);
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