<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Exception\CardException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * A card
 *
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $codeCustomer The customer loyalty code
     *
     * @ORM\Column(type="string", length=6, unique=true)
     */
    private $codeCustomer;

    /**
     * @var string $codeCard The establishment code, the customer loyalty code and the checksum
     *
     * @ORM\Column(type="string", length=12)
     */
    private $codeCard;

    /**
     * @var Customer $customer The customer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="cards")
     */
    private $customer;

    /**
     * @var Visit $visits The use of the loyalty card
     * @ORM\OneToMany(targetEntity="Visit", mappedBy="card", cascade={"persist"})
     */
    private $visits;

    /**
     * @var integer $points Points accumulated on the loyalty card
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points;

    /**
     * @var Establishment $establishment The establishment code
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Establishment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $establishment;

    /**
     * @var string $state State of the current card
     *
     * @ORM\Column(type="array", nullable=false)
     */
    public $state;

    /**
     * @var boolean $activate Card activated property
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $activate;
    
    public function __construct()
    {
        $this->visits = new ArrayCollection();
        $this->state = ['blank' => 1];
        $this->activate = false;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Establishment|null
     */
    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    /**
     * @param Establishment $establishment
     * @return Card
     */
    public function setEstablishment(Establishment $establishment): self
    {
        $this->establishment = $establishment;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCodeCustomer(): ?string
    {
        return $this->codeCustomer;
    }

    /**
     * @param int $codeCustomer
     * @return Card
     */
    public function setCodeCustomer(string $codeCustomer): self
    {
        $this->codeCustomer = $codeCustomer;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCodeCard(): ?string
    {
        return $this->codeCard;
    }

    /**
     * @param string $codeCard
     * @return Card
     */
    public function setCodeCard(string $codeCard): self
    {
        $this->codeCard = $codeCard;
        $this->codeCustomer = substr($this->getCodeCard(), 3, 6);

        return $this;
    }

    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return Card|false
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        $this->setActivated(true);

        return $this;
    }

    public function removeCustomer()
    {
        $this->customer = null;
        $this->setActivated(false);
    }

    /**
     * @return Collection|Visit[]
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    /**
     * @param Visit $visit
     * @return Card
     */
    public function addVisit(Visit $visit): self
    {
        if (!$this->visits->contains($visit)) {
            $this->visits[] = $visit;
            $visit->setCard($this);
        }

        return $this;
    }

    /**
     * @param Visit $visit
     * @return Card
     */
    public function removeVisit(Visit $visit): self
    {
        if ($this->visits->contains($visit)) {
            $this->visits->removeElement($visit);
            // set the owning side to null (unless already changed)
            if ($visit->getCard() === $this) {
                $visit->setCard(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPoints(): ?int
    {
        return $this->points;
    }

    /**
     * @param int|null $points
     * @return Card
     */
    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Ajoute des points à la carte
     * @param int $points
     */
    public function addPoints(int $points)
    {
        $this->points += $points;
    }

    /**
     * @return int|null
     */
    public function getEstablishmentCode()
    {
        return $this->establishment->getCodeEstablishment();
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param array $state
     * @return Card
     */
    public function setState(array $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getActivated()
    {
        return $this->activate;
    }

    private function setActivated(bool $bool): self
    {
        $this->activate = $bool;

        return $this;
    }

    public function desactivateCard(): self
    {
        $this->setActivated(false);

        return $this;
    }
}
