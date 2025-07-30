<?php

namespace App\Tests\Entity;

use App\Entity\DatabaseConnection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DatabaseConnectionValidationTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }

    public function testEmptyNameShouldFailValidation(): void
    {
        $connection = new DatabaseConnection();
        $connection->setName(''); // ← champ vide
        $connection->setHost('host.docker.internal'); // ← pour accéder à ta BDD locale
        $connection->setPort(3306);
        $connection->setUsername('root');
        $connection->setPassword(null);
        $connection->setDatabaseName('mydb');

        $errors = $this->validator->validate($connection);

        $this->assertCount(1, $errors, 'Un champ vide pour "name" devrait générer une erreur de validation.');
        $this->assertSame('Le nom ne peut pas être vide', $errors[0]->getMessage());
    }
}
