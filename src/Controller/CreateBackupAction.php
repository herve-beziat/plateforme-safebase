<?php

namespace App\Controller;

use App\Entity\DatabaseConnection;
use App\Entity\Backup;
use App\Service\DatabaseBackupService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateBackupAction extends AbstractController
{
    private $backupService;

    public function __construct(DatabaseBackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    public function __invoke(DatabaseConnection $data): Backup
    {
        return $this->backupService->createBackup($data);
    }
}