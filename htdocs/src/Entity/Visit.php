<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The use of the loyalty card
 *
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 */
class Visit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Establishment $establishement The establishment where the card is used
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Establishment")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $establishement;

    /**
     * @var Card $card The card used
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="visits")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $card;

    /**
     * @var \datetime $useDate The date of use
     *
     * @ORM\Column(type="datetime")
     */
    private $useDate;

    public function getId()
    {
        return $this->id;
    }

    public function getEstablishement(): ?Establishment
    {
        return $this->establishement;
    }

    public function setEstablishement(?Establishment $establishement): self
    {
        $this->establishement = $establishement;

        return $this;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getUseDate(): ?\DateTimeInterface
    {
        return $this->useDate;
    }

    public function setUseDate(\DateTimeInterface $useDate): self
    {
        $this->useDate = $useDate;

        return $this;
    }
}
