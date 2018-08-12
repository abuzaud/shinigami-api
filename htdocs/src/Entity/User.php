<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
abstract class User implements UserInterface, \Serializable
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
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50)
     * @Groups({"read", "write"})
     */
    private $firstName;

    /**
     * @var string $lastName The last name
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50)
     * @Groups({"read", "write"})
     */
    private $lastName;

    /**
     * @var string $email The email
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(type="string", length=80, unique=true)
     * @Groups({"read", "write"})
     */
    private $email;

    /**
     * @var string $password The password
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=128)
     * @Groups({"read", "write"})
     */
    private $password;

    /**
     * @var Collection|Address[] $addresses The addresses
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Address")
     * @Groups({"read", "write"})
     */
    private $addresses;

    /**
     * @var string $phoneNumber The phone number
     *
     * @Assert\Regex("/^\d+/")
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"read", "write"})
     */
    private $phoneNumber;

    /**
     * @var \datetime $birthday The birthday
     *
     * @Assert\Date()
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"read", "write"})
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
     * @var Collection|Role $userRoles The list of roles
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Role")
     */
    private $userRoles;

    /**
     * @var array $roles The list of roles for the UserInterface
     */
    private $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->userRoles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
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

    /**
     * @param Address $address
     * @return User
     */
    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
        }

        return $this;
    }

    /**
     * @param Address $address
     * @return User
     */
    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return User
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * @param \DateTimeInterface $birthday
     * @return User
     */
    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    /**
     * @param \DateTimeInterface $registrationDate
     * @return User
     */
    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getLastConnectionDate(): ?\DateTimeInterface
    {
        return $this->lastConnectionDate;
    }

    /**
     * @param \DateTimeInterface|null $lastConnectionDate
     * @return User
     */
    public function setLastConnectionDate(?\DateTimeInterface $lastConnectionDate): self
    {
        $this->lastConnectionDate = $lastConnectionDate;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return User
     */
    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return User
     */
    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        $this->roles = [];
        foreach ($this->userRoles->toArray() as $role) {
            if (!\in_array($role, $this->roles, true)) {
                $this->roles[] = $role->getRole();
            }
        }
        if (!\in_array('ROLE_USER', $this->roles, true)) {
            $this->roles[] = 'ROLE_USER';
        }

        return $this->roles;
    }

    /**
     * @return Collection|Role[]
     */
    public function getUserRoles(): Collection
    {
        return $this->userRoles;
    }

    /**
     * @param Role $role
     * @return User
     */
    public function addUserRole(Role $role): self
    {
        if (!$this->userRoles->contains($role)) {
            $this->userRoles[] = $role;
        }

        return $this;
    }

    /**
     * @param Role $role
     * @return User
     */
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
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
            $this->isActive
        ]);
    }

    public function unserialize($serialized): void
    {
        [
            $this->id,
            $this->email,
            $this->password,
            $this->isActive
        ] = unserialize($serialized, ['allowed_classes' => false]);
    }
}
