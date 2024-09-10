<?php

namespace App\Controller\Admin;

use App\Entity\DatabaseConnection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class DatabaseConnectionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DatabaseConnection::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('host'),
            IntegerField::new('port'),
            TextField::new('username'),
            TextField::new('password')->hideOnIndex(),
            TextField::new('databaseName'),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
        ];
    }
}
