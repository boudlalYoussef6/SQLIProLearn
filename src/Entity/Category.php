<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
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
        // unset the owning side of the relation if necessary
        if (null === $category && null !== $this->category) {
            $this->category->setParentId(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $category && $category->getParentId() !== $this) {
            $category->setParentId($this);
        }

        $this->category = $category;

        return $this;
    }
}
