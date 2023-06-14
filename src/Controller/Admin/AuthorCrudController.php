<?php

namespace App\Controller\Admin;

use App\Entity\Author;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AuthorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Author::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('authorFullname', 'Nom et prénom'),
            EmailField::new('authorEmail', 'Adresse e-mail'),
            ImageField::new('authorImage', 'Image')
            ->setBasePath('uploads/')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false),
            TextEditorField::new('authorBio', 'Biographie'),
        ];
    }
    
}
