<?php

namespace App\DataFixtures;

use App\Card\CardFactory;
use App\Entity\Establishment;
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
    private $cf;

    public function __construct(CardFactory $cf){
        $this->cf = $cf;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $customers = range(1, 100);
        $establishmentsId = range(1, 3);
        $establishmentCode = range(100,200, 5);

        for ($i = 1; $i <= 50; $i++) {
            shuffle($customers);
            shuffle($establishmentsId);
            shuffle($establishmentCode);

            $establishment = (new Establishment())->setId(intval($establishmentsId[0]));
            $establishment->setCodeEstablishment(intval($establishmentCode[0]));

            $card = $this->cf->createFixtureCardFromEstablishment($establishment);
            $card->setCustomer($this->getReference(CustomerFixtures::CUSTOMER_FIXTURES . $customers[1]));

            $manager->persist($establishment);
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