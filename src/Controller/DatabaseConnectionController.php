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

    public function __construct(DatabaseConnectionService $connectionService)
    {
        $this->connectionService = $connectionService;
    }

    #[Route('/api/test-connection', name: 'test_connection', methods: ['POST'])]
    public function testConnection(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $connection = new DatabaseConnection();
        $connection->setHost($data['host'] ?? '');
        $connection->setPort($data['port'] ?? 3306);
        $connection->setUsername($data['username'] ?? '');
        $connection->setPassword($data['password'] ?? '');
        $connection->setDatabaseName($data['databaseName'] ?? '');

        $result = $this->connectionService->testConnection($connection);

        return $this->json($result, $result['status'] ? 200 : 400);
    }
}