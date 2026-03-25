<?php

namespace App\Entity;

use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: BlogPostRepository::class)]
class BlogPost
{
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'blogPosts')]
    private Collection $tags;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'blogPosts')]
    private ?User $author = null;

    #[ORM\Column(length: 255)]
    private ?string $title;

    #[ORM\Column(type: 'text')]
    private ?string $description;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $slug = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

    }
    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }
}
