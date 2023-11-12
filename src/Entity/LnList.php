<?php

namespace App\Entity;

use App\Repository\LnListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LnListRepository::class)]
class LnList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'lnLists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $isOwned = null;

    #[ORM\OneToMany(mappedBy: 'isInList', targetEntity: LightNovel::class)]
    private Collection $lightNovels;

    public function __construct()
    {
        $this->lightNovels = new ArrayCollection();
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
    public function __toString()
    {
        return $this->title;
    }

    public function getIsOwned(): ?User
    {
        return $this->isOwned;
    }

    public function setIsOwned(?User $isOwned): static
    {
        $this->isOwned = $isOwned;

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
            $lightNovel->setIsInList($this);
        }

        return $this;
    }

    public function removeLightNovel(LightNovel $lightNovel): static
    {
        if ($this->lightNovels->removeElement($lightNovel)) {
            // set the owning side to null (unless already changed)
            if ($lightNovel->getIsInList() === $this) {
                $lightNovel->setIsInList(null);
            }
        }

        return $this;
    }


}
