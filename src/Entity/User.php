<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: LightNovel::class)]
    private Collection $Library;

    #[ORM\ManyToMany(targetEntity: LightNovel::class, inversedBy: 'users')]
    private Collection $follow;

    #[ORM\OneToMany(mappedBy: 'isOwned', targetEntity: LnList::class)]
    private Collection $lnLists;

    public function __construct()
    {
        $this->Library = new ArrayCollection();
        $this->follow = new ArrayCollection();
        $this->lnLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, LightNovel>
     */
    public function getLibrary(): Collection
    {
        return $this->Library;
    }

    public function addLibrary(LightNovel $library): static
    {
        if (!$this->Library->contains($library)) {
            $this->Library->add($library);
            $library->setUser($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->username;
    }
    public function removeLibrary(LightNovel $library): static
    {
        if ($this->Library->removeElement($library)) {
            // set the owning side to null (unless already changed)
            if ($library->getUser() === $this) {
                $library->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LightNovel>
     */
    public function getFollow(): Collection
    {
        return $this->follow;
    }

    public function addFollow(LightNovel $follow): static
    {
        if (!$this->follow->contains($follow)) {
            $this->follow->add($follow);
        }

        return $this;
    }

    public function removeFollow(LightNovel $follow): static
    {
        $this->follow->removeElement($follow);

        return $this;
    }

    /**
     * @return Collection<int, LnList>
     */
    public function getLnLists(): Collection
    {
        return $this->lnLists;
    }

    public function addLnList(LnList $lnList): static
    {
        if (!$this->lnLists->contains($lnList)) {
            $this->lnLists->add($lnList);
            $lnList->setIsOwned($this);
        }

        return $this;
    }

    public function removeLnList(LnList $lnList): static
    {
        if ($this->lnLists->removeElement($lnList)) {
            // set the owning side to null (unless already changed)
            if ($lnList->getIsOwned() === $this) {
                $lnList->setIsOwned(null);
            }
        }

        return $this;
    }



}
