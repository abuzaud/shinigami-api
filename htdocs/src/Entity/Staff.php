<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * A staff user
 *
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\StaffRepository")
 * @ORM\AssociationOverrides({
 *     @ORM\AssociationOverride(name="userRoles",
 *          joinTable=@ORM\JoinTable(
 *              name="staff_role",
 *              joinColumns=@ORM\JoinColumn(name="user_id", onDelete="CASCADE"),
 *              inverseJoinColumns=@ORM\JoinColumn(name="role_id", onDelete="CASCADE")
 *          )
 *      )
 * })
 */
class Staff extends User
{
    /**
     * @var Collection|Establishment[] $establishments The list of establishments
     *
     * @Assert\NotNull()
     * @ORM\ManyToMany(targetEntity="App\Entity\Establishment", inversedBy="staff")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read", "write"})
     */
    private $establishments;

    /**
     * Staff constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->establishments = new ArrayCollection();
    }

    /**
     * @var string $username
     * @return Staff
     */
    public function setUsername(string $username): self
    {
        $this->setEmail($username);
        
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getEmail();
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
     * @return Staff
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
     * @return Staff
     */
    public function removeEstablishment(Establishment $establishment): self
    {
        if ($this->establishments->contains($establishment)) {
            $this->establishments->removeElement($establishment);
        }

        return $this;
    }
}
