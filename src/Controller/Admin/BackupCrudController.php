<?php

namespace App\Controller\Admin;

use App\Entity\Backup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FileField;

class BackupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Backup::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('filename'),
            FileField::new('file_path')->setFormTypeOption('mapped', false)
                ->setUploadDir('var/backup')  //Dossier de sauvegarde
                ->setBasePath('backup') //Chemin relatif pour l'affichage
                ->setRequired(true),
            

        ];
    }
    
}
