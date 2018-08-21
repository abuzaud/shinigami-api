<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A role
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $name The displayed name
     *
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=30)
     * @Groups({"read", "write"})
     */
    private $name;

    /**
     * @var string $role The role type
     *
     * @Assert\NotBlank()
     * @Assert\Regex("/^\w+/")
     * @ORM\Column(type="string", length=20, unique=true)
     * @Groups({"read", "write"})
     */
    private $role;

    /**
     * Role constructor.
     * @param string $role
     */
    public function __construct(string $role)
    {
        $this->setRole($role);
    }


    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return Role
     */
    public function setRole(string $role): self
    {
        $role = strtoupper($role);
        if (strrpos($role, 'ROLE_') !== 0) {
            $role = 'ROLE_' . $role;
        }
        $this->role = $role;

        return $this;
    }
}
