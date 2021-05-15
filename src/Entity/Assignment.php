<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssignmentRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\Api\AssignmentNearController;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=AssignmentRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"read:assignment"}},
 *     collectionOperations={
 *      "post",
 *      "put",
 *      "get",
 *      "near"={
 *          "method"="GET",
 *          "path"="/assignments/near",
 *          "controller"=AssignmentNearController::class
 *        }
 *     }
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
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:assignment", "read:course", "read:user"})
     */
    private ?string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Course::class, inversedBy="assignments")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Groups({"read:assignment"})
     */
    private ?Course $course;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read:assignment", "read:course", "read:user"})
     */
    private ?bool $allowNotifications = false;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:assignment", "read:course", "read:user"})
     */
    private ?DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="string")
     * @Groups({"read:assignment", "read:course", "read:user", "read:calendar"})
     */
    private ?string $finishAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="assignments")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read:course"})
     */
    private ?User $user;

    public function __construct ()
    {
        $this->createdAt = new DateTime();
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

    public function getFinishAt (): ?string
    {
        return $this->finishAt;
    }

    public function setFinishAt (string $finishAt): self
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
