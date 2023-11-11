<?php

namespace App\Entity;

use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $categoryName = null;

    #[ORM\ManyToMany(targetEntity: LightNovel::class, mappedBy: 'inGenre')]
    private Collection $lightNovels;

    public function __construct()
    {
        $this->lightNovels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->categoryName;
    }
    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }


    /**
     * @return Collection<int, LightNovel>
     */
    public function getLightNovels(): Collection
    {
        return $this->lightNovels;
    }

    public function addLightNovel(LightNovel $lightNovel): static
    {
        if (!$this->lightNovels->contains($lightNovel)) {
            $this->lightNovels->add($lightNovel);
            $lightNovel->addInGenre($this);
        }

        return $this;
    }

    public function removeLightNovel(LightNovel $lightNovel): static
    {
        if ($this->lightNovels->removeElement($lightNovel)) {
            $lightNovel->removeInGenre($this);
        }

        return $this;
    }
}
