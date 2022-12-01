<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: [],
    itemOperations: []
)]
#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{

    #[ORM\Id, ORM\GeneratedValue('AUTO'), ORM\Column(type: 'integer')]
    #[Groups(['game:show'])]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    #[Groups(['game:show'])]
    private string $content;

    #[ORM\Column(type: 'integer')]
    #[Groups(['game:show'])]
    private int $upVotes;

    #[ORM\Column(type: 'integer')]
    #[Groups(['game:show'])]
    private int $downVotes;

    #[ORM\Column(type: 'float')]
    #[Groups(['game:show'])]
    private float $rank;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['game:show'])]
    protected DateTime $createdAt;

    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['game:show'])]
    private Account $account;

    #[ORM\ManyToOne(targetEntity: Game::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private Game $game;

    public function __construct()
    {
        $this->downVotes = 0;
        $this->upVotes = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Comment
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpVotes(): int
    {
        return $this->upVotes;
    }

    public function setUpVotes(int $upVotes): self
    {
        $this->upVotes = $upVotes;

        return $this;
    }

    public function getDownVotes(): int
    {
        return $this->downVotes;
    }

    public function setDownVotes(int $downVotes): self
    {
        $this->downVotes = $downVotes;

        return $this;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return float
     */
    public function getRank(): float
    {
        return $this->rank;
    }

    /**
     * @param float $rank
     * @return Comment
     */
    public function setRank(float $rank): Comment
    {
        $this->rank = $rank;
        return $this;
    }

    public function getArrayStar(): array {
        if ($this->rank <= 0.5 && $this->rank > 0) {
            return [
                'fa-solid fa-star-half-stroke',
                'fa-regular fa-star',
                'fa-regular fa-star',
                'fa-regular fa-star',
                'fa-regular fa-star',
            ];
        }
        return [
            'fa-regular fa-star',
            'fa-regular fa-star',
            'fa-regular fa-star',
            'fa-regular fa-star',
            'fa-regular fa-star',
        ];
    }

}
