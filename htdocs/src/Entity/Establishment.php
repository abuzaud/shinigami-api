<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * An establishment
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EstablishmentRepository")
 */
class Establishment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The establishment code
     *
     * @ORM\Column(type="string", length=3, unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d+/")
     * @Groups({"read", "write"})
     */
    private $codeEstablishment;

    /**
     * @var string The name of the establishment
     *
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @var string The description of the establishment
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Groups({"read", "write"})
     */
    private $description;

    /**
     * @var Address $address The address of the establishment
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Address")
     * @Groups({"read", "write"})
     */
    private $address;

    /**
     * @var string $phoneNumber The phone number
     *
     * @ORM\Column(type="string", length=20)
     * @Assert\Regex("/^\d+/")
     * @Groups({"read", "write"})
     */
    private $phoneNumber;

    /**
     * @var Collection $staff The list of staff
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff", mappedBy="establishments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $staff;

    public function __construct()
    {
        $this->staff = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getCodeEstablishment(): ?int
    {
        return $this->codeEstablishment;
    }

    public function setCodeEstablishment(int $codeEstablishment): self
    {
        $this->codeEstablishment = $codeEstablishment;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Staff[]
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Staff $staff): self
    {
        if (!$this->staff->contains($staff)) {
            $this->staff[] = $staff;
            $staff->addEstablishment($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staff->contains($staff)) {
            $this->staff->removeElement($staff);
            $staff->removeEstablishment($this);
        }

        return $this;
    }
}
