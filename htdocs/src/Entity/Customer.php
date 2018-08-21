<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A customer
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\AssociationOverrides({
 *     @ORM\AssociationOverride(name="userRoles",
 *          joinTable=@ORM\JoinTable(
 *              name="customer_role",
 *              joinColumns=@ORM\JoinColumn(name="customer_id", onDelete="CASCADE"),
 *              inverseJoinColumns=@ORM\JoinColumn(name="role_id", onDelete="CASCADE")
 *          )
 *      )
 * })
 */
class Customer extends User
{
    /**
     * @var string $username The username
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50, unique=true)
     * @Groups({"read", "write"})
     */
    private $username;

    /**
     * @var Collection|Establishment[] $establishments The list of establishments
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Establishment")
     * @Groups({"read", "write"})
     */
    private $establishments;

    /**
     * @var Collection|Card[] $cards The list of cards
     *
     * @ORM\OneToMany(targetEntity=Card::class, mappedBy="customer", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"read", "write"})
     */
    private $cards;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->establishments = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Customer
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Establishment[]
     */
    public function getEstablishments(): Collection
    {
        return $this->establishments;
    }

    /**
     * @param Establishment $establishment
     * @return Customer
     */
    public function addEstablishment(Establishment $establishment): self
    {
        if (!$this->establishments->contains($establishment)) {
            $this->establishments[] = $establishment;
        }

        return $this;
    }

    /**
     * @param Establishment $establishment
     * @return Customer
     */
    public function removeEstablishment(Establishment $establishment): self
    {
        if ($this->establishments->contains($establishment)) {
            $this->establishments->removeElement($establishment);
        }

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    /**
     * @param Card $card
     * @return Customer
     */
    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
        }

        return $this;
    }

    /**
     * @param Card $card
     * @return Customer
     */
    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
        }

        return $this;
    }
}
