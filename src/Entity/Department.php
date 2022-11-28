<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DepartmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'department:list'
            ]
        ]
    ],
    itemOperations: ['get'],
)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('department:list')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('department:list')]
    private ?string $name = null;

    #[ORM\Column(length: 3)]
    private ?string $code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
