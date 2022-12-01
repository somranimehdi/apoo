<?php

namespace App\Entity;

use App\Repository\SuggestionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuggestionsRepository::class)]
class Suggestions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sugg = null;

    
    #[ORM\ManyToOne(inversedBy: 'suggestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSugg(): ?string
    {
        return $this->sugg;
    }

    public function setSugg(string $sugg): self
    {
        $this->sugg = $sugg;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

}
