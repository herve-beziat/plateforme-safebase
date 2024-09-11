<?php

namespace App\Service;

use App\Entity\DatabaseConnection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DatabaseConnectionManagerService
{
    private $entityManager;
    private $connectionService;
    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        DatabaseConnectionService $connectionService,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->connectionService = $connectionService;
        $this->validator = $validator;
    }

    public function saveConnection(DatabaseConnection $connection): array
    {
        // Valider l'entité
        $errors = $this->validator->validate($connection);
        if (count($errors) > 0) {
            return [
                'success' => false,
                'message' => (string) $errors
            ];
        }

        // Tester la connexion avant de sauvegarder
        $testResult = $this->connectionService->testConnection($connection);
        
        if (!$testResult['status']) {
            return [
                'success' => false,
                'message' => 'Impossible de sauvegarder : ' . $testResult['message']
            ];
        }

        // Si la connexion est réussie, sauvegarder dans la base de données
        try {
            $this->entityManager->persist($connection);
            $this->entityManager->flush();

            return [
                'success' => true,
                'message' => 'Connexion sauvegardée avec succès',
                'connection' => [
                    'id' => $connection->getId(),
                    'name' => $connection->getName(),
                    'host' => $connection->getHost(),
                    'databaseName' => $connection->getDatabaseName()
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la sauvegarde : ' . $e->getMessage()
            ];
        }
    }

    public function getConnection(int $id): ?DatabaseConnection
    {
        return $this->entityManager->getRepository(DatabaseConnection::class)->find($id);
    }

    public function getAllConnections(): array
    {
        return $this->entityManager->getRepository(DatabaseConnection::class)->findAll();
    }

    public function updateConnection(DatabaseConnection $connection): array
    {
        // Similaire à saveConnection, mais sans créer une nouvelle entrée
        $errors = $this->validator->validate($connection);
        if (count($errors) > 0) {
            return [
                'success' => false,
                'message' => (string) $errors
            ];
        }

        $testResult = $this->connectionService->testConnection($connection);
        
        if (!$testResult['status']) {
            return [
                'success' => false,
                'message' => 'Impossible de mettre à jour : ' . $testResult['message']
            ];
        }

        try {
            $this->entityManager->flush();
            return [
                'success' => true,
                'message' => 'Connexion mise à jour avec succès'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la mise à jour : ' . $e->getMessage()
            ];
        }
    }

    public function deleteConnection(DatabaseConnection $connection): array
    {
        try {
            $this->entityManager->remove($connection);
            $this->entityManager->flush();
            return [
                'success' => true,
                'message' => 'Connexion supprimée avec succès'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur lors de la suppression : ' . $e->getMessage()
            ];
        }
    }
}