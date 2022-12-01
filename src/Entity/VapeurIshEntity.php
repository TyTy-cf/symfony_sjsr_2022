<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

trait VapeurIshEntity
{

    #[Assert\NotBlank(message: 'Le nom doit être renseigné')]
    #[Assert\Length(min: 3, minMessage: 'Le nom ne peut pas faire moins de {{ limit }} caractères')]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['account:list', 'account:post', 'country:read', 'country:post', 'account:show', 'game:read', 'publisher:read', 'publisher:form'])]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Groups(['country:read', 'account:list', 'account:show', 'game:read', 'publisher:read'])]
    private string $slug = '';

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

}
