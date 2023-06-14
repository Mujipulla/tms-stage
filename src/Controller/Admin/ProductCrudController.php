<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            TextField::new('name', 'Nom du produit'),
            SlugField::new('slug', 'Slug')->setTargetFieldName('name'),
            ImageField::new('illustration', 'Illustration')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextField::new('subtitle', 'Sous-titre'),
            AssociationField::new('category', 'Catégories'),
            AssociationField::new('pdfname', 'Support PDF'),
            BooleanField::new('isBest', 'Produit à la une'),
            BooleanField::new('isStock', 'En stock'),
            BooleanField::new('isChoix', 'Produit de choix'),
            MoneyField::new('price', 'Prix')->setCurrency('EUR')->setStoredAsCents(true),
            TextEditorField::new('description', 'Description'),
        ];
    }
}
