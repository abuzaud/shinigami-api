<?php

namespace App\DataFixtures;

use App\Entity\Establishment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class EstablishmentFixtures
 * @package App\DataFixtures
 */
class EstablishmentFixtures extends Fixture implements DependentFixtureInterface
{
    public const ESTABLISHMENT_FIXTURES = 'establishment-';

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $addresses = range(1, 50);

        for ($i = 1; $i <= 3; $i++) {
            shuffle($addresses);

            $phoneNumber = '06';
            $count = 0;
            while ($count < 8) {
                $phoneNumber .= random_int(0, 9);
                $count++;
            }

            $establishment = new Establishment();
            $establishment->setCodeEstablishment(random_int(1, 9) . random_int(1, 9) . random_int(1, 9));
            if($i==1){
                $establishment->setCodeEstablishment(123);
            }
            $establishment->setName('Shinigami Laser Game ' . $i);
            $establishment->setDescription('Qua urbis extra qua aestimant aestimant quorundam urbis vero quorundam vero quorundam urbis qua potest obsequiorum diversitate orbos quorundam urbis inanes nec caelibes inanes pomerium nascitur flatus nascitur homines qua sine orbos homines sine quorundam nec sine extra nec vero homines extra sine urbis inanes obsequiorum inanes Romae coluntur coluntur.');
            $establishment->setAddress($this->getReference(AddressFixtures::ADDRESS_REFERENCE . $addresses[1]));
            $establishment->setPhoneNumber($phoneNumber);
            $manager->persist($establishment);
            $this->addReference(self::ESTABLISHMENT_FIXTURES . $i, $establishment);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            AddressFixtures::class
        ];
    }
}