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
        $clients = range(1, 100);

        for ($i = 1; $i <= 50; $i++) {
            shuffle($establishments);
            $codeClient = '';
            $count = 0;
            while ($count < 6) {
                $codeClient .= random_int(0, 9);
                $count++;
            }
            shuffle($clients);

            $card = new Card();
            $card->setEstablishment($this->getReference(EstablishmentFixtures::ESTABLISHMENT_FIXTURES . $establishments[1]));
            $card->setCodeClient($codeClient);
            $card->setChecksum(random_int(1, 9));
            $card->setClient($this->getReference(ClientFixtures::CLIENT_FIXTURES . $clients[1]));
            $card->setCodeCard('');
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
            ClientFixtures::class
        ];
    }
}