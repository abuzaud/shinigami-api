<?php

namespace App\DataFixtures;

use App\Entity\Card;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CardFixtures
 * @package App\DataFixtures
 */
class CardFixtures extends Fixture implements DependentFixtureInterface
{
    public const CARD_REFERENCE = 'card-';

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $establishments = range(1, 3);
        $customers = range(1, 100);

        for ($i = 1; $i <= 50; $i++) {
            shuffle($establishments);
            $codeCustomer = '';
            $count = 0;
            while ($count < 6) {
                $codeCustomer .= random_int(0, 9);
                $count++;
            }
            shuffle($customers);

            $card = new Card();
            $card->setEstablishment($this->getReference(EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[1]));
            $codeEstablishment = $card->getEstablishment()->getCodeEstablishment();
            $checksum = (intval($codeEstablishment) + intval($codeCustomer)) % 9;
            $card->setCodeCard(substr(strval($codeEstablishment . $codeCustomer . $checksum), 0, 10));
            $card->setCustomer($this->getReference(CustomerFixtures::CUSTOMER_FIXTURES . $customers[1]));
            $card->setState(['activated']);
            $manager->persist($card);
            $this->addReference(self::CARD_REFERENCE . $i, $card);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            EstablishmentFixtures::class,
            CustomerFixtures::class
        ];
    }
}