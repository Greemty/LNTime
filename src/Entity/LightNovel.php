<?php

namespace App\Entity;

use App\Repository\LightNovelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LightNovelRepository::class)]
class LightNovel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'Library')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'lightNovels')]
    private Collection $inGenre;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'follow')]
    private Collection $users;

    public function __construct()
    {
        $this->inGenre = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): static
    {
        $this->author = $author;

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

    /**
     * @return Collection<int, Genre>
     */
    public function getInGenre(): Collection
    {
        return $this->inGenre;
    }

    public function addInGenre(Genre $inGenre): static
    {
        if (!$this->inGenre->contains($inGenre)) {
            $this->inGenre->add($inGenre);
            $inGenre->setLightNovel($this);
        }

        return $this;
    }

    public function removeInGenre(Genre $inGenre): static
    {
        if ($this->inGenre->removeElement($inGenre)) {
            // set the owning side to null (unless already changed)
            if ($inGenre->getLightNovel() === $this) {
                $inGenre->setLightNovel(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFollow($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeFollow($this);
        }

        return $this;
    }
}
