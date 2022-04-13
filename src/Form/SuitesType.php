<?php

namespace App\Form;

use App\Entity\Suites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuitesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la suite'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de la suite'
            ])
            ->add('main_image', FileType::class, [
                'label' => 'Image Principale',
                'mapped' => false
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix par nuit',
                'currency' => 'EUR'
            ])
            ->add('booking_link', TextType::class, [
                'label' => 'Lien Booking de la suite'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Suites::class,
        ]);
    }
}
