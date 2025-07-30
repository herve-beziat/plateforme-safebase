<?php

namespace App\Controller;

use App\Entity\DatabaseConnection;
use App\Service\DatabaseConnectionService;
use App\Service\DatabaseConnectionManagerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DatabaseConnectionController extends AbstractController
{
    private $connectionService;
    private $managerService;

    public function __construct(
        DatabaseConnectionService $connectionService,
        DatabaseConnectionManagerService $managerService
    ) {
        $this->connectionService = $connectionService;
        $this->managerService = $managerService;
    }

    #[Route('/api/test-connection', name: 'test_connection', methods: ['POST'])]
    public function testConnection(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $connection = new DatabaseConnection();
        $connection->setName($data['name'] ?? '');
        $connection->setHost($data['host'] ?? '');
        $connection->setPort($data['port'] ?? 3306);
        $connection->setUsername($data['username'] ?? '');
        $connection->setPassword($data['password'] ?? '');
        $connection->setDatabaseName($data['databaseName'] ?? '');

        try {
            $testResult = $this->connectionService->testConnection($connection);

            if (!$testResult['status']) {
                return $this->json($testResult, 400);
            }

            $saveResult = $this->managerService->saveConnection($connection);
            return $this->json($saveResult, $saveResult['success'] ? 200 : 400);
        } catch (\Throwable $e) {
            return $this->json([
                'status' => false,
                'message' => 'Erreur interne : ' . $e->getMessage(),
            ], 500);
        }
    }
    #[Route('/api/connections', name: 'list_connections', methods: ['GET'])]
    public function listConnections(): JsonResponse
    {
        try {
            $connections = $this->managerService->getAllConnections();

            $data = array_map(function (DatabaseConnection $conn) {
                return [
                    'id' => $conn->getId(),
                    'name' => $conn->getName(),
                    'host' => $conn->getHost(),
                    'port' => $conn->getPort(),
                    'username' => $conn->getUsername(),
                    'databaseName' => $conn->getDatabaseName()
                ];
            }, $connections);

            return $this->json($data);
        } catch (\Throwable $e) {
            return $this->json([
                'status' => false,
                'message' => 'Erreur lors de la récupération : ' . $e->getMessage()
            ], 500);
        }
    }
}
