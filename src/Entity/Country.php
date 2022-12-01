<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\Api\Country\PostAction;
use App\Controller\Api\Country\PutAction;
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: 'name', message: 'Un pays de ce nom existe déjà'), UniqueEntity(fields: 'code')]
#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'country:read'
            ]
        ],
        'post' => [
            'denormalization_context' => [
                'groups' => 'country:post'
            ],
            'controller' => [
                PostAction::class, 'handle'
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'country:read'
            ]
        ],
        'put' => [
            'denormalization_context' => [
                'groups' => 'country:post'
            ],
            'controller' => [
                PutAction::class, 'edit'
            ]
        ],
    ],
)]
#[ApiFilter(
    SearchFilter::class, properties: [
        'name' => 'partial', // équivalent d'un LIKE %_%
        'code' => 'exact', // équivalent d'un =
    ]
)]
class Country
{

    use VapeurIshEntity;

    #[ORM\Id, ORM\GeneratedValue('AUTO'), ORM\Column(type: 'integer')]
    #[Groups(['game:show', 'country:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: '128')]
    #[Groups(['country:read', 'country:post', 'game:show'])]
    #[Assert\NotBlank(message: 'La nationalité doit être renseignée')]
    private string $nationality;

    #[ORM\Column(type: 'string', length: '255', nullable: true)]
    #[Groups(['game:show', 'country:read'])]
    private ?string $urlFlag;

    #[ORM\Column(type: 'string', length: '2')]
    #[Groups(['country:read', 'country:post'])]
    #[Assert\NotBlank(message: 'Le code doit être renseigné')]
    private string $code;

    #[ORM\ManyToMany(targetEntity: Game::class, mappedBy: 'countries')]
    private Collection $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlFlag(): ?string
    {
        return $this->urlFlag;
    }

    public function setUrlFlag(?string $urlFlag): self
    {
        $this->urlFlag = $urlFlag;

        return $this;
    }

    /**
     * @return string
     */
    public function getNationality(): string
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     */
    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->addCountry($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            $game->removeCountry($this);
        }

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
