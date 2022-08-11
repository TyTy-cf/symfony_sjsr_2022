<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields: 'email'), UniqueEntity(fields: 'name')]
#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{

    use VapeurIshEntity;

    #[ORM\Id, ORM\GeneratedValue('AUTO'), ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private string $email;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private ?string $nickname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $pathImage;

    #[ORM\Column(type: 'float')]
    private float $wallet;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Library::class)]
    private Collection $libraries;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column(type: 'datetime')]
    protected DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: Country::class)]
    private ?Country $country;

    public function __construct()
    {
        $this->libraries = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->wallet = 0.0;
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPathImage(): ?string
    {
        return $this->pathImage;
    }

    public function setPathImage(?string $pathImage): Account
    {
        $this->pathImage = $pathImage;
        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getWallet(): ?float
    {
        return $this->wallet;
    }

    public function setWallet(float $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getLibraries(): Collection
    {
        return $this->libraries;
    }

    public function addLibrary(Library $library): self
    {
        if (!$this->libraries->contains($library)) {
            $this->libraries[] = $library;
        }

        return $this;
    }

    public function removeLibrary(Library $library): self
    {
        if ($this->libraries->contains($library)) {
            $this->libraries->removeElement($library);
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
 * @return DateTime
 */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return Account
     */
    public function setCreatedAt(DateTime $createdAt): Account
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getTotalGameTime(): int {
        $totalGameTime = 0;
        foreach ($this->libraries as $library) {
            /** @var Library $library */
            $totalGameTime += $library->getGameTime();
        }
        return $totalGameTime;
    }

    public function getTotalLibraryPrice(): int {
        $totalLibraryPrice = 0;
        foreach ($this->libraries as $library) {
            /** @var Library $library */
            $totalLibraryPrice += $library->getGame()->getPrice();
        }
        return $totalLibraryPrice;
    }

}
