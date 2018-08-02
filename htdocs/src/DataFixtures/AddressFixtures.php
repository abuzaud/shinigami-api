<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AddressFixtures
 * @package App\DataFixtures
 */
class AddressFixtures extends Fixture
{
    public const ADDRESS_REFERENCE = 'address-';

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $typesStreet = [
            'allée',
            'avenue',
            'boulevard',
            'chaussée',
            'chemin',
            'impasse',
            'passage',
            'place',
            'route',
            'rue'
        ];
        $namesStreet = [
            'Charles de Gaulle',
            'Général Leclerc',
            'Georges Clémenceau',
            'Jean Jaurès',
            'Jean Moulin',
            'Jules Ferry',
            'Léon Gambetta',
            'Louis Pasteur',
            'Maréchal Foch',
            'Victor Hugo'
        ];
        $citys = [
            ['33000', 'Bordeaux'],
            ['59000', 'Lille'],
            ['69007', 'Lyon'],
            ['13001', 'Marseille'],
            ['34000', 'Montpellier'],
            ['44000', 'Nantes'],
            ['06000', 'Nice'],
            ['75009', 'Paris'],
            ['67000', 'Strasbourg'],
            ['31000', 'Toulouse']
        ];

        for ($i = 1; $i <= 50; $i++) {
            shuffle($typesStreet);
            shuffle($namesStreet);
            shuffle($citys);

            $address = new Address();
            $address->setStreetNumber(random_int(1, 200));
            $address->setStreetName($typesStreet[0] . ' ' . $namesStreet[0]);
            $address->setZipCode($citys[0][0]);
            $address->setCity($citys[0][1]);
            $address->setCountry('France');
            $manager->persist($address);
            $this->addReference(self::ADDRESS_REFERENCE . $i, $address);
        }

        $manager->flush();
    }
}