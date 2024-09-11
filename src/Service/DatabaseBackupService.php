<?php

namespace App\Service;

use App\Entity\DatabaseConnection;
use App\Entity\Backup; // Assurez-vous d'avoir cette entité
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Doctrine\ORM\EntityManagerInterface;

class DatabaseBackupService
{
    private $backupDir;
    private $entityManager;

    public function __construct(string $backupDir, EntityManagerInterface $entityManager)
    {
        $this->backupDir = $backupDir;
        $this->entityManager = $entityManager;
    }

    public function createBackup(DatabaseConnection $connection): Backup
    {
        $backup = new Backup();
        $backup->setDatabaseConnection($connection);
        $backup->setStatus('pending');
        
        $filename = sprintf(
            '%s_%s.sql',
            $connection->getDatabaseName(),
            $backup->getCreatedAt()->format('Y-m-d_H-i-s')
        );
        $filePath = $this->backupDir . '/' . $filename;

        $command = sprintf(
            'mysqldump -h %s -P %s -u %s -p%s %s > %s',
            $connection->getHost(),
            $connection->getPort(),
            $connection->getUsername(),
            $connection->getPassword(),
            $connection->getDatabaseName(),
            $filePath
        );

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(3600); // 1 hour timeout
        
        try {
            $process->mustRun();

            $backup->setFilename($filename);
            $backup->setFilePath($filePath);
            $backup->setSize(filesize($filePath));
            $backup->setStatus('completed');

            $this->entityManager->persist($backup);
            $this->entityManager->flush();

            return $backup;
        } catch (ProcessFailedException $exception) {
            $backup->setStatus('failed');
            $this->entityManager->persist($backup);
            $this->entityManager->flush();

            throw $exception;
        }
    }
}