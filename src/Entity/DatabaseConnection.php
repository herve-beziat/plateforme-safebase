<?php

namespace App\Entity;

use App\Repository\DatabaseConnectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DatabaseConnectionRepository::class)]
class DatabaseConnection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $host = null;

    #[ORM\Column]
    private ?int $port = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $databaseName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Backup>
     */
    #[ORM\OneToMany(targetEntity: Backup::class, mappedBy: 'databaseConnection', orphanRemoval: true)]
    private Collection $backups;

    /**
     * @var Collection<int, BackupSchedule>
     */
    #[ORM\OneToMany(targetEntity: BackupSchedule::class, mappedBy: 'databaseConnection', orphanRemoval: true)]
    private Collection $backupSchedules;

    public function __construct()
    {
        $this->backups = new ArrayCollection();
        $this->backupSchedules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(string $host): static
    {
        $this->host = $host;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(int $port): static
    {
        $this->port = $port;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getDatabaseName(): ?string
    {
        return $this->databaseName;
    }

    public function setDatabaseName(string $databaseName): static
    {
        $this->databaseName = $databaseName;

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

    /**
     * @return Collection<int, Backup>
     */
    public function getBackups(): Collection
    {
        return $this->backups;
    }

    public function addBackup(Backup $backup): static
    {
        if (!$this->backups->contains($backup)) {
            $this->backups->add($backup);
            $backup->setDatabaseConnection($this);
        }

        return $this;
    }

    public function removeBackup(Backup $backup): static
    {
        if ($this->backups->removeElement($backup)) {
            // set the owning side to null (unless already changed)
            if ($backup->getDatabaseConnection() === $this) {
                $backup->setDatabaseConnection(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BackupSchedule>
     */
    public function getBackupSchedules(): Collection
    {
        return $this->backupSchedules;
    }

    public function addBackupSchedule(BackupSchedule $backupSchedule): static
    {
        if (!$this->backupSchedules->contains($backupSchedule)) {
            $this->backupSchedules->add($backupSchedule);
            $backupSchedule->setDatabaseConnection($this);
        }

        return $this;
    }

    public function removeBackupSchedule(BackupSchedule $backupSchedule): static
    {
        if ($this->backupSchedules->removeElement($backupSchedule)) {
            // set the owning side to null (unless already changed)
            if ($backupSchedule->getDatabaseConnection() === $this) {
                $backupSchedule->setDatabaseConnection(null);
            }
        }

        return $this;
    }
}
