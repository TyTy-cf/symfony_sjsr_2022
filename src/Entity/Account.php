<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Api\Acount\PostAction;
use App\Repository\AccountRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: 'email'), UniqueEntity(fields: 'name', message: 'Ce nom de compte est déjà utilisé')]
#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'account:list'
            ]
        ],
        'post' => [
            'denormalization_context' => [
                'groups' => 'account:post'
            ],
            'path' => '/register', // change le nom qui apparaît dans le swagger d'API Platform
            'controller' => [ // redéfinit l'action du post sur la méthode "register" du controller PostAction
                PostAction::class, 'register'
            ]
        ]
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'account:show'
            ]
        ],
    ],
)]
#[ApiFilter(
    SearchFilter::class, properties: [
        'slug' => 'exact',
    ]
)]
class Account
{

    use VapeurIshEntity;

    #[ORM\Id, ORM\GeneratedValue('AUTO'), ORM\Column(type: 'integer')]
    #[Groups(['account:list', 'account:show'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank(message: 'L\'email ne peut pas être vide')]
    #[Groups(['account:list', 'account:post', 'account:show'])]
    private string $email;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    #[Assert\NotBlank(message: 'Le pseudo ne peut pas être vide')]
    #[Groups(['account:list', 'account:post', 'account:show'])]
    private ?string $nickname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['account:show'])]
    private ?string $pathImage;

    #[ORM\Column(type: 'float')]
    #[Groups(['account:list', 'account:show'])]
    private float $wallet;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Library::class)]
    #[Groups(['account:show'])]
    private Collection $libraries;

    #[ORM\OneToMany(mappedBy: 'account', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['account:list', 'account:show'])]
    protected DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: Country::class)]
    private ?Country $country;

    #[ORM\ManyToMany(targetEntity: Game::class)]
    private Collection $favorites;

    public function __construct()
    {
        $this->libraries = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->wallet = 0.0;
        $this->createdAt = new DateTime();
        $this->favorites = new ArrayCollection();
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

    #[Groups('account:show')]
    public function getTotalGameTime(): int {
        $totalGameTime = 0;
        foreach ($this->libraries as $library) {
            /** @var Library $library */
            $totalGameTime += $library->getGameTime();
        }
        return $totalGameTime;
    }

    #[Groups('account:show')]
    public function getTotalLibraryPrice(): int {
        $totalLibraryPrice = 0;
        foreach ($this->libraries as $library) {
            /** @var Library $library */
            $totalLibraryPrice += $library->getGame()->getPrice();
        }
        return $totalLibraryPrice;
    }

    #[Groups('account:list')]
    public function getTotalGamesLibrary(): int {
        return count($this->libraries);
    }

    /**
     * @return Collection<int, Game>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Game $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
        }

        return $this;
    }

    public function addToFavorite(Game $game): bool {
        if (!$this->favorites->contains($game)) {
            $this->favorites->add($game);
            return true;
        }
        $this->favorites->removeElement($game);
        return false;
    }

    public function removeFavorite(Game $favorite): self
    {
        $this->favorites->removeElement($favorite);

        return $this;
    }

}
