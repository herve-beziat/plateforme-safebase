<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\BackupScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BackupScheduleRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Delete()
    ]
)]
class BackupSchedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'backupSchedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DatabaseConnection $databaseConnection = null;

    #[ORM\Column(length: 20)]
    private ?string $frequency = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(nullable: true)]
    private ?int $dayOfWeek = null;

    #[ORM\Column(nullable: true)]
    private ?int $dayOfMonth = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastRun = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $nextRun = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatabaseConnection(): ?DatabaseConnection
    {
        return $this->databaseConnection;
    }

    public function setDatabaseConnection(?DatabaseConnection $databaseConnection): static
    {
        $this->databaseConnection = $databaseConnection;

        return $this;
    }

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(string $frequency): static
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getDayOfWeek(): ?int
    {
        return $this->dayOfWeek;
    }

    public function setDayOfWeek(?int $dayOfWeek): static
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    public function getDayOfMonth(): ?int
    {
        return $this->dayOfMonth;
    }

    public function setDayOfMonth(?int $dayOfMonth): static
    {
        $this->dayOfMonth = $dayOfMonth;

        return $this;
    }

    public function getLastRun(): ?\DateTimeImmutable
    {
        return $this->lastRun;
    }

    public function setLastRun(?\DateTimeImmutable $lastRun): static
    {
        $this->lastRun = $lastRun;

        return $this;
    }

    public function getNextRun(): ?\DateTimeImmutable
    {
        return $this->nextRun;
    }

    public function setNextRun(\DateTimeImmutable $nextRun): static
    {
        $this->nextRun = $nextRun;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
