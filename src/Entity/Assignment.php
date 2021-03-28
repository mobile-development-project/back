<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssignmentRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=AssignmentRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"read:assignment"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"course", "exact"})
 */
class Assignment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:assignment", "read:course", "read:user"})
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:assignment", "read:course", "read:user"})
     */
    private ?string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="assignments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:assignment"})
     */
    private ?Course $course;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read:assignment", "read:course"})
     */
    private ?bool $allowNotifications = false;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:assignment", "read:course", "read:user"})
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:assignment", "read:course", "read:user"})
     */
    private ?DateTimeInterface $finishAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="assignments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read:course"})
     */
    private ?User $user;

    public function __construct ()
    {
        $this->createdAt = new DateTime();
        $this->finishAt = new DateTime();
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

    public function getCourse (): ?Course
    {
        return $this->course;
    }

    public function setCourse (?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getAllowNotifications (): ?bool
    {
        return $this->allowNotifications;
    }

    public function setAllowNotifications (bool $allowNotifications): self
    {
        $this->allowNotifications = $allowNotifications;

        return $this;
    }

    public function getCreatedAt (): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt (DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFinishAt (): ?DateTimeInterface
    {
        return $this->finishAt;
    }

    public function setFinishAt (DateTimeInterface $finishAt): self
    {
        $this->finishAt = $finishAt;

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
}
