<?php

namespace App\Entity;

use App\Repository\StoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoriesRepository::class)]
class Stories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $story_title = null;

    #[ORM\Column(length: 255)]
    private ?string $preview_link = null;

    #[ORM\Column(length: 255)]
    private ?string $story_link = null;



    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'stories')]
    private Collection $users;

    public function __construct()
    {
    
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStoryTitle(): ?string
    {
        return $this->story_title;
    }

    public function setStoryTitle(string $story_title): self
    {
        $this->story_title = $story_title;

        return $this;
    }

    public function getPreviewLink(): ?string
    {
        return $this->preview_link;
    }

    public function setPreviewLink(string $preview_link): self
    {
        $this->preview_link = $preview_link;

        return $this;
    }

    public function getStoryLink(): ?string
    {
        return $this->story_link;
    }

    public function setStoryLink(string $story_link): self
    {
        $this->story_link = $story_link;

        return $this;
    }



    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addStory($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeStory($this);
        }

        return $this;
    }
}
