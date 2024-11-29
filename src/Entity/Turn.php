<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TurnRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TurnRepository::class)]
class Turn
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(nullable: true)]
    private ?array $field = null;

    #[ORM\Column]
    private bool $isRedo = false;

    #[ORM\ManyToOne(inversedBy: 'turns')]
    #[ORM\JoinColumn(nullable: false)]
    private Game $game;

    public function getId(): int
    {
        return $this->id;
    }

    public function getField(): ?array
    {
        return $this->field;
    }

    public function setField(?array $field): static
    {
        $this->field = $field;

        return $this;
    }

    public function isRedo(): bool
    {
        return $this->isRedo;
    }

    public function setRedo(bool $isRedo): static
    {
        $this->isRedo = $isRedo;

        return $this;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): static
    {
        $this->game = $game;

        return $this;
    }
}
