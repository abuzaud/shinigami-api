<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleHierarchy;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A role
 *
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role implements RoleHierarchyInterface
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
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string $role The role type
     *
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\NotBlank()
     */
    private $role;

    /**
     * @return mixed
     */
    public function getId()
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

    /**
     * Returns an array of all reachable roles by the given ones.
     * Reachable roles are the roles directly assigned but also all roles that
     * are transitively reachable from them in the role hierarchy.
     *
     * @param Role[] $roles An array of directly assigned roles
     * @return Role[] An array of all reachable roles
     */
    public function getReachableRoles(array $roles)
    {

    }
}
