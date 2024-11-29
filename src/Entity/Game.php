<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: Types::GUID)]
    private string $userUuid;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $startTime;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endTime = null;

    /**
     * @var Collection<int, Turn>
     */
    #[Ignore]
    #[ORM\OneToMany(targetEntity: Turn::class, mappedBy: 'game')]
    private Collection $turns;

    public function __construct()
    {
        $this->turns = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserUuid(): string
    {
        return $this->userUuid;
    }

    public function setUserUuid(string $userUuid): static
    {
        $this->userUuid = $userUuid;

        return $this;
    }

    public function getStartTime(): \DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * @return Collection<int, Turn>
     */
    public function getTurns(): Collection
    {
        return $this->turns;
    }

    public function addTurn(Turn $turn): static
    {
        if (!$this->turns->contains($turn)) {
            $this->turns->add($turn);
            $turn->setGame($this);
        }

        return $this;
    }

    public function removeTurn(Turn $turn): static
    {
        if ($this->turns->removeElement($turn)) {
            // set the owning side to null (unless already changed)
            if ($turn->getGame() === $this) {
                $turn->setGame(null);
            }
        }

        return $this;
    }
}
