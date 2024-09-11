<?php

namespace App\Service;

use App\Entity\DatabaseConnection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class DatabaseConnectionService
{
    /**
     * Teste la connexion à une base de données externe.
     *
     * Cette méthode tente d'établir une connexion à la base de données spécifiée
     * en utilisant les informations fournies dans l'objet DatabaseConnection.
     *
     * @param DatabaseConnection $connection L'entité contenant les informations de connexion
     * @return array Un tableau contenant:
     *               - 'status' (bool) : true si la connexion est réussie, false sinon
     *               - 'message' (string) : Un message décrivant le résultat de la tentative de connexion
     * @throws \Exception Si une erreur inattendue se produit lors de la tentative de connexion
     */
    public function testConnection(DatabaseConnection $connection): array
    {
        $connectionParams = [
            'dbname' => $connection->getDatabaseName(),
            'user' => $connection->getUsername(),
            'password' => $connection->getPassword(),
            'host' => $connection->getHost(),
            'port' => $connection->getPort(),
            'driver' => 'pdo_mysql', // Assurez-vous que c'est le bon driver pour votre cas
        ];

        try {
            $conn = DriverManager::getConnection($connectionParams);
            $conn->connect();

            if ($conn->isConnected()) {
                return [
                    'status' => true,
                    'message' => 'Connexion réussie à la base de données.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Échec de la connexion pour une raison inconnue.'
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Erreur de connexion : ' . $e->getMessage()
            ];
        }
    }
}
