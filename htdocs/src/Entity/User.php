<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $firstName The first name
     *
     * @ORM\Column(type="string", length=50)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @var string $lastName The last name
     *
     * @ORM\Column(type="string", length=50)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @var string $email The email
     *
     * @ORM\Column(type="string", length=80, unique=true)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string $password The password
     *
     * @ORM\Column(type="string", length=128)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     * @Assert\Length(min="8", max="20")
     */
    private $password;

    /**
     * @var Collection $addresses The addresses
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Address")
     * @ApiSubresource()
     */
    private $addresses;

    /**
     * @var string $phoneNumber The phone number
     *
     * @ORM\Column(type="string", length=20)
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d+/")
     */
    private $phoneNumber;

    /**
     * @var \datetime $birthday The birthday
     *
     * @ORM\Column(type="date")
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $birthday;

    /**
     * @var \datetime $registrationDate The registration date
     *
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @var \datetime $lastConnectionDate The last connection date
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnectionDate;

    /**
     * @var boolean $isActive Defined if account is active
     *
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @var string $token Key allowing actions including account activation
     *
     * @ORM\Column(type="string", length=255)
     */
    private $token;

    /**
     * @var Collection $userRoles The list of roles
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", cascade={"persist"})
     * @Groups({"read", "write"})
     */
    private $userRoles;

    private $roles;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getLastConnectionDate(): ?\DateTimeInterface
    {
        return $this->lastConnectionDate;
    }

    public function setLastConnectionDate(?\DateTimeInterface $lastConnectionDate): self
    {
        $this->lastConnectionDate = $lastConnectionDate;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getRoles(): array
    {
        $this->roles = [];
        /*if (!\in_array('ROLE_USER', $this->roles, true)) {
            $this->roles[] = 'ROLE_USER';
        }*/
        foreach ($this->userRoles->toArray() as $role) {
            if (!\in_array($role, $this->roles, true)) {
                $this->roles[] = $role->getRole();
            }
        }
        return $this->roles;

        /*return [
            'ROLE_USER'
        ];*/
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    public function addUserRole(Role $role): self
    {
        if (!$this->userRoles->contains($role)) {
            $this->userRoles[] = $role;
        }

        return $this;
    }

    public function removeUserRole(Role $role): self
    {
        if ($this->userRoles->contains($role)) {
            $this->userRoles->removeElement($role);
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function eraseCredentials()
    {
    }
}
