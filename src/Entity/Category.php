<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $label = null;

    #[ORM\OneToOne(targetEntity: self::class, inversedBy: 'category', cascade: ['persist', 'remove'])]
    private ?self $parentId = null;

    
    #[ORM\OneToOne(targetEntity: self::class, mappedBy: 'parentId', cascade: ['persist', 'remove'])]
    private ?self $category = null;

    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $courses;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getParentId(): ?self
    {
        return $this->parentId;
    }

    public function setParentId(?self $parentId): static
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function getCategory(): ?self
    {
        return $this->category;
    }

    public function setCategory(?self $category): static
    {
        
        if (null === $category && null !== $this->category) {
            $this->category->setParentId(null);
        }

        if (null !== $category && $category->getParentId() !== $this) {
            $category->setParentId($this);
        }

        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setCategory($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            if ($course->getCategory() === $this) {
                $course->setCategory(null);
            }
        }

        return $this;
    }
}
