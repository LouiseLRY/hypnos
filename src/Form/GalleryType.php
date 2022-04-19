<?php

namespace App\Form;

use App\Entity\Gallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $imageConstraints =  new Image([
            'maxSize' => '1M',
            'allowPortrait' => false
        ]);

        $builder
            ->add('photo1', FileType::class, [
                'label' => 'Photo N°1 : ',
                'mapped' => false,
                'constraints' => $imageConstraints
            ])
            ->add('photo2', FileType::class, [
                'label' => 'Photo N°1 : ',
                'mapped' => false,
                'constraints' => $imageConstraints
            ])
            ->add('photo3', FileType::class, [
                'label' => 'Photo N°1 : ',
                'mapped' => false,
                'constraints' => $imageConstraints
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gallery::class,
        ]);
    }
}
