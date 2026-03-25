<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{

    public function __construct()
    {
        $this->blogPosts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name;

    #[ORM\ManyToMany(targetEntity: BlogPost::class, mappedBy: 'tags')]
    private Collection $blogPosts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    public function addBlogPosts(BlogPost $blogPosts): void
    {
        if (!$this->blogPosts->contains($blogPosts)) {
            $this->blogPosts->add($blogPosts);
        }
    }
    public function removeBlogPosts(BlogPost $blogPosts): void
    {
        $this->blogPosts->removeElement($blogPosts);
    }
}
