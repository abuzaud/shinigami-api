<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var Establishment $establishment The establishment code
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Establishment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $establishment;

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

    public function __construct()
    {
        $this->visits = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEstablishment(): ?Establishment
    {
        return $this->establishment;
    }

    public function setEstablishment(Establishment $establishment): self
    {
        $this->establishment = $establishment;

        return $this;
    }

    public function getCodeCustomer(): ?int
    {
        return $this->codeCustomer;
    }

    public function setCodeCustomer(int $codeCustomer): self
    {
        $this->codeCustomer = $codeCustomer;

        return $this;
    }

    public function getCodeCard(): ?string
    {
        return $this->codeCard;
    }

    public function setCodeCard(string $codeCard): self
    {
        $this->codeCard = $codeCard;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection|Visit[]
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): self
    {
        if (!$this->visits->contains($visit)) {
            $this->visits[] = $visit;
            $visit->setCard($this);
        }

        return $this;
    }

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

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }
}
