<?php

namespace App\Controller\Admin;

use App\Entity\About;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AboutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           ImageField::new('aboutImage', 'Image')
           ->setBasePath('uploads/')
           ->setUploadDir('public/uploads')
           ->setUploadedFileNamePattern('[randomhash].[extension]')
           ->setRequired(false),
           TextEditorField::new('aboutText', 'Texte'),
        ];
    }
    
}
