<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class, [
                'label' => 'Votre nom et prénom ',
                'required' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez entrer votre nom complet',
                    ]),
                ],
            ])
            ->add('email',  TextType::class, [
                'label' => 'Votre adresse email',
                'required' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez entrer votre email'
                    ]),
                ],
            ])
            ->add('sujet', TextType::class, [
                'label' => 'Votre sujet',
                'required' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez entrer un sujet',
                    ]),
                ],
            ])
            ->add('message', TextareaType::class, [
                'label'=> 'Message',
                'required' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Veuillez entrer votre message',
                    ]),
                    new Length([
                        'max' => 500,
                        'maxMessage' => 'Votre message ne doit pas dépasser {{ limit }} caractères',
                    ]),
                ],
                'help' => '500 caractères maximum',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-dark col-md-6 mt-5 mx-auto d-flex justify-content-center'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
