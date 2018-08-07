<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A client
 *
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @ORM\AssociationOverrides({
 *      @ORM\AssociationOverride(name="addresses",
 *          joinTable=@ORM\JoinTable(
 *              name="client_address",
 *              joinColumns=@ORM\JoinColumn(name="client_id"),
 *              inverseJoinColumns=@ORM\JoinColumn(name="address_id")
 *          )
 *      ),
 *     @ORM\AssociationOverride(name="roles",
 *          joinTable=@ORM\JoinTable(
 *              name="client_role",
 *              joinColumns=@ORM\JoinColumn(name="client_id"),
 *              inverseJoinColumns=@ORM\JoinColumn(name="role_id")
 *          )
 *      )
 * })
 */
class Client extends User
{
    /**
     * @var string $username The username
     *
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @var Card $cards The list of cards
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="client")
     */
    private $cards;

    /**
     * @var Collection $establishments The list of establishments
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Establishment")
     */
    private $establishments;

    public function __construct()
    {
        parent::__construct();
        $this->cards = new ArrayCollection();
        $this->establishments = new ArrayCollection();
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
        }

        return $this;
    }

    /**
     * @return Collection|Establishment[]
     */
    public function getEstablishments(): Collection
    {
        return $this->establishments;
    }

    public function addEstablishment(Establishment $establishment): self
    {
        if (!$this->establishments->contains($establishment)) {
            $this->establishments[] = $establishment;
        }

        return $this;
    }

    public function removeEstablishment(Establishment $establishment): self
    {
        if ($this->establishments->contains($establishment)) {
            $this->establishments->removeElement($establishment);
        }

        return $this;
    }
}
