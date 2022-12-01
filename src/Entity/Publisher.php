<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Api\Publisher\FormAction;
use App\Repository\PublisherRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[UniqueEntity(fields: 'name')]
#[ORM\Entity(repositoryClass: PublisherRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [ // passer de l'objet au Json
                'groups' => 'publisher:read'
            ]
        ],
        'post' => [
            'denormalization_context' => [ // désérialisation json vers objet
                'groups' => 'publisher:form'
            ],
            'controller' => [
                FormAction::class, 'handleForm'
            ]
        ]
    ],
    itemOperations:  [
        'get' => [
            'normalization_context' => [ // passer de l'objet au Json
                'groups' => [
                    'publisher:read',
                    'publisher:read:show'
                ]
            ]
        ],
        'put' => [
            'denormalization_context' => [ // désérialisation json vers objet
                'groups' => 'publisher:form'
            ],
            'controller' => [
                FormAction::class, 'handleForm'
            ]
        ]
    ],
)]
class Publisher
{

    use VapeurIshEntity;

    #[ORM\Id, ORM\GeneratedValue('AUTO'), ORM\Column(type: 'integer')]
    #[Groups(['publisher:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: '180')]
    #[Groups(['publisher:read', 'publisher:form'])]
    private string $website;

    #[ORM\ManyToOne(targetEntity: Country::class)]
    #[Groups(['publisher:read', 'publisher:form'])]
    private Country $country;

    #[ORM\OneToMany(mappedBy: 'publisher', targetEntity: Game::class)]
    #[Groups(['publisher:read:show'])]
    private Collection $games;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['publisher:read:show', 'publisher:form'])]
    protected DateTime $createdAt;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @param string $website
     */
    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getCountry(): Country
    {
        return $this->country;
    }

    public function setCountry(Country $country): self
    {
        $this->country = $country;

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
            $game->setPublisher($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getPublisher() === $this) {
                $game->setPublisher(null);
            }
        }

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
     * @return Publisher
     */
    public function setCreatedAt(DateTime $createdAt): Publisher
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}
