<?php

namespace App\Controller\Admin;

use App\Entity\SupportPDF;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints\File;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SupportPDFCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SupportPDF::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('pdfname', 'Nom du PDF'),
            
            FormField::addPanel('Fichier PDF'),
            
            FormField::addPanel('Informations')->setIcon('fa fa-info')->addCssClass('panel-info'),
            FormField::addPanel('Téléchargement')->setIcon('fa fa-download')->addCssClass('panel-info'),
            
            TextField::new('pdfFile', 'Télécharger un support PDF')
                ->setFormType(VichFileType::class)
                ->setFormTypeOptions([
                    'allow_delete' => false,
                    'download_label' => 'Télécharger',
                    'download_uri' => true,
                    'asset_helper' => true,
                    'required' => false,
                    'constraints'=> [
                        new File([
                            'maxSize' => '20M',
                            'mimeTypes' => [
                                'application/pdf',
                                'application/x-pdf',
                            ],
                            'mimeTypesMessage' => 'Veuillez télécharger un fichier PDF valide.',
                        ]),
                    ], 
                ])
                ->setCustomOption('data_class', null)
                ->onlyOnForms(), 
                
            UrlField::new('getFullPdfUrl'),
        ];
    }
    
    
}
