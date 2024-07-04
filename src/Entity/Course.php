<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['course:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 200, type: Types::TEXT)]
    #[SerializedName('title')]
    #[Groups(['course:read', 'course:write'])]
    #[Assert\NotBlank, Assert\NotNull, Assert\Length(max: 200)]
    private ?string $label = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('description')]
    #[Groups(['course:read'])]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'courses', fetch: 'EAGER')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    #[Groups(['course:read'])]
    #[Assert\NotNull]
    private ?Category $category = null;

    #[ORM\Column(nullable: true)]
    #[SerializedName('id')]
    #[Groups(['course:read', 'course:write'])]
    private ?int $idReference = null;

    #[ORM\OneToMany(targetEntity: Section::class, mappedBy: 'course', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['course:read'])]
    private Collection $sections;

    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'cours', cascade: ['persist'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['course:read'])]
    private ?Author $author = null;

    private ?File $videoPath = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['course:read'])]
    private ?string $videoPathName = null;

    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'course', cascade: ['persist', 'remove'])]
    #[Groups(['course:read'])]
    private Collection $medias;

    #[Groups(['course:read'])]
    public Collection $attachments;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $addedAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(0)]
    private ?int $views = null;

    #[ORM\OneToMany(targetEntity: ViewHistory::class, mappedBy: 'course', cascade: ['remove'])]
    private Collection $viewHistories;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('image_480x270')]
    #[Groups(['course:read', 'course:write'])]
    #[Assert\Url]
    private ?string $cover = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[SerializedName('url')]
    #[Groups(['course:read', 'course:write'])]
    #[Assert\Url]
    private ?string $url = null;

    #[ORM\OneToMany(targetEntity: Favory::class, mappedBy: 'course', orphanRemoval: true)]
    private Collection $favories;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['course:read'])]
    private ?string $tags = null;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->viewHistories = new ArrayCollection();
        $this->favories = new ArrayCollection();
    }

    #[Groups(['course:read'])]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getIdReference(): ?int
    {
        return $this->idReference;
    }

    public function setIdReference(?int $idReference): static
    {
        $this->idReference = $idReference;

        return $this;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): static
    {
        if (!$this->sections->contains($section)) {
            $this->sections->add($section);
            $section->setCourse($this);
        }

        return $this;
    }

    public function removeSection(Section $section): static
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getCourse() === $this) {
                $section->setCourse(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getVideoPath(): ?File
    {
        return $this->videoPath;
    }

    public function setVideoPath(?File $videoPath): self
    {
        $this->videoPath = $videoPath;

        return $this;
    }

    public function getVideoPathName(): ?string
    {
        return $this->videoPathName;
    }

    public function setVideoPathName(?string $videoPathName): self
    {
        $this->videoPathName = $videoPathName;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): static
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setCourse($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): static
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getCourse() === $this) {
                $media->setCourse(null);
            }
        }

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): static
    {
        $this->views = $views;

        return $this;
    }

    public function incrementViews(): self
    {
        ++$this->views;

        return $this;
    }

    /**
     * @return Collection<int, ViewHistory>
     */
    public function getViewHistories(): Collection
    {
        return $this->viewHistories;
    }

    public function addViewHistory(ViewHistory $viewHistory): static
    {
        if (!$this->viewHistories->contains($viewHistory)) {
            $this->viewHistories->add($viewHistory);
            $viewHistory->setCourse($this);
        }

        return $this;
    }

    public function removeViewHistory(ViewHistory $viewHistory): static
    {
        if ($this->viewHistories->removeElement($viewHistory)) {
            // set the owning side to null (unless already changed)
            if ($viewHistory->getCourse() === $this) {
                $viewHistory->setCourse(null);
            }
        }

        return $this;
    }

    public function getAddedAt(): ?\DateTimeInterface
    {
        return $this->addedAt;
    }

    #[ORM\PrePersist]
    public function updateAddedAt(): void
    {
        $this->addedAt = new \DateTime();
    }

    public function setAddedAt(?\DateTimeInterface $addedAt): self
    {
        $this->addedAt = $addedAt;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Favory>
     */
    public function getFavories(): Collection
    {
        return $this->favories;
    }

    public function addFavory(Favory $favory): static
    {
        if (!$this->favories->contains($favory)) {
            $this->favories->add($favory);
            $favory->setCourse($this);
        }

        return $this;
    }

    public function removeFavory(Favory $favory): static
    {
        if ($this->favories->removeElement($favory)) {
            // set the owning side to null (unless already changed)
            if ($favory->getCourse() === $this) {
                $favory->setCourse(null);
            }
        }

        return $this;
    }

    #[Groups(['course:read'])]
    #[SerializedName('id')]
    public function getIdentifier(): ?int
    {
        return $this->id;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): static
    {
        $this->tags = $tags;

        return $this;
    }
}
