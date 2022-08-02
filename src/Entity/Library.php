<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{

    #[ORM\Id, ORM\GeneratedValue('AUTO'), ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'boolean', options: ['default' => 0])]
    private bool $installed;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    private int $gameTime;

    #[ORM\Column(type: 'datetime')]
    private DateTime $lastUsedAt;

    #[ORM\Column(type: 'datetime')]
    protected ?DateTime $createdAt;

    /**
     * Dans une relation (ManyToOne OU ManyToMany) s'il n'y a pas d'inversedBy, alors :
     * On est dans une relation dites "Unilatérale", c'est-à-dire que l'entité courante
     * connaît l'autre entité, mais l'autre entité ne connait pas la classe courante
     */
    #[ORM\ManyToOne(targetEntity: Game::class)]
    private Game $game;

    /**
     * Dans une relation (ManyToOne OU ManyToMany) s'il y a un inversedBy, alors :
     * On est dans une relation dites "Bilatérale", c'est-à-dire que l'entité courante
     * connaît l'autre entité, l'autre entité connait la classe courante
     */
    #[ORM\ManyToOne(targetEntity: Account::class, inversedBy: 'libraries')]
    private Account $account;

    public function __construct()
    {
        $this->gameTime = 0.0;
        $this->installed = false;
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): Library
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    public function getInstalled(): bool
    {
        return $this->installed;
    }

    public function setInstalled(bool $installed): self
    {
        $this->installed = $installed;

        return $this;
    }

    public function getGameTime(): int
    {
        return $this->gameTime;
    }

    public function setGameTime(int $gameTime): self
    {
        $this->gameTime = $gameTime;

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

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastUsedAt(): DateTime
    {
        return $this->lastUsedAt;
    }

    /**
     * @param DateTime $lastUsedAt
     * @return Library
     */
    public function setLastUsedAt(DateTime $lastUsedAt): Library
    {
        $this->lastUsedAt = $lastUsedAt;
        return $this;
    }

    /**
     * Converti l'attribut gameTime (qui est en seconde)
     *
     * @return string
     */
    public function getTimeConverter(): string {
        $hours = floor($this->gameTime / 3600);
        $minutes = ($this->gameTime % 60);
        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }
        return $hours. 'h' . $minutes;
    }
}
