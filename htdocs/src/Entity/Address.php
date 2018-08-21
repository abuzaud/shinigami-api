<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * An address
 *
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 *  * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 */
class Address
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer $streetNumber The street number
     *
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"read", "write"})
     */
    private $streetNumber;

    /**
     * @var string $streetName The name of the street
     *
     * @ORM\Column(type="string", length=150)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     */
    private $streetName;

    /**
     * @var string $complement The complement of the address
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Groups({"read", "write"})
     */
    private $complement;

    /**
     * @var string $zipCode The zip code
     *
     * @ORM\Column(type="string", length=15)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     */
    private $zipCode;

    /**
     * @var string $city The city
     *
     * @ORM\Column(type="string", length=50)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     */
    private $city;

    /**
     * @var string $country The country
     *
     * @ORM\Column(type="string", length=50, options={"default":"France"})
     * @Groups({"read", "write"})
     */
    private $country;

    /**
     * @var float $latitude The latitude
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"read", "write"})
     */
    private $latitude;

    /**
     * @var float $longitude The longitude
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"read", "write"})
     */
    private $longitude;

    public function getId()
    {
        return $this->id;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(?int $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function setComplement(?string $complement): self
    {
        $this->complement = $complement;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
