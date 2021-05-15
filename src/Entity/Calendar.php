<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CalendarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CalendarRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"read:calendar"}},
 *     collectionOperations={
 *          "get",
 *          "post"={
 *              "controller"=App\Controller\Api\AgendaController::class,
 *              "denormalization_context"={"groups"={"create:calendar"}}
 *          }
 *      },
 *     itemOperations={
 *          "get",
 *          "removeCategory"={
 *              "method"="PUT",
 *              "path"="/calendar/{id}/category",
 *              "controller"=App\Controller\Api\AgendaDeleteCategoryController::class
 *          }
 *        }
 *     )
 * @ApiFilter(SearchFilter::class, properties={"date", "exact"})
 */
class Calendar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:calendar"})
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"read:calendar", "create:calendar"})
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read:calendar", "create:calendar"})
     */
    private $categories = null;

    /**
     * @ORM\ManyToMany(targetEntity=Course::class)
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"read:calendar", "create:calendar"})
     */
    private $courses = null;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="calendars")
     */
    private $user;

    public function __construct ()
    {
        $this->categories = new ArrayCollection();
        $this->courses = new ArrayCollection();
    }

    public function getId (): ?int
    {
        return $this->id;
    }

    public function getDate (): ?string
    {
        return $this->date;
    }

    public function setDate (string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories (): Collection
    {
        return $this->categories;
    }

    public function addCategory (Category $category): self
    {
        if (!$this->categories->contains($category))
        {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory (Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Course[]
     */
    public function getCourses (): Collection
    {
        return $this->courses;
    }

    public function addCourse (Course $course): self
    {
        if (!$this->courses->contains($course))
        {
            $this->courses[] = $course;
        }

        return $this;
    }

    public function removeCourse (Course $course): self
    {
        $this->courses->removeElement($course);

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
