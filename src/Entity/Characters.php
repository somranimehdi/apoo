<?php

namespace App\Entity;

use App\Repository\CharactersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharactersRepository::class)]
class Characters
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $character_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $about = null;

    #[ORM\Column(length: 255)]
    private ?string $picture_link = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacterName(): ?string
    {
        return $this->character_name;
    }

    public function setCharacterName(string $character_name): self
    {
        $this->character_name = $character_name;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getPictureLink(): ?string
    {
        return $this->picture_link;
    }

    public function setPictureLink(string $picture_link): self
    {
        $this->picture_link = $picture_link;

        return $this;
    }
}
