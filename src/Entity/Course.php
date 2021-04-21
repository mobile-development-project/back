<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CourseRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"read:course"}}
 * )
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:course", "read:assignment", "read:user"})
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:course", "read:assignment", "read:user"})
     */
    private ?string $name;

    /**
     * @ORM\OneToMany(targetEntity=Assignment::class, mappedBy="course")
     * @Groups({"read:course"})
     */
    private $assignments;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="courses")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct ()
    {
        $this->assignments = new ArrayCollection();
    }

    public function getId (): ?int
    {
        return $this->id;
    }

    public function getName (): ?string
    {
        return $this->name;
    }

    public function setName (string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Assignment[]
     */
    public function getAssignments (): Collection
    {
        return $this->assignments;
    }

    public function addAssignment (Assignment $assignment): self
    {
        if (!$this->assignments->contains($assignment))
        {
            $this->assignments[] = $assignment;
            $assignment->setCourse($this);
        }

        return $this;
    }

    public function removeAssignment (Assignment $assignment): self
    {
        if ($this->assignments->removeElement($assignment))
        {
            // set the owning side to null (unless already changed)
            if ($assignment->getCourse() === $this)
            {
                $assignment->setCourse(null);
            }
        }

        return $this;
    }

    public function getUser (): ?User
    {
        return $this->user;
    }

    public function setUser (?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __toString ()
    {
        return $this->name;
    }
}
