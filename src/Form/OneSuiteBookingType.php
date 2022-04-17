<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OneSuiteBookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateStart', DateType::class, [
                'label' => 'Date d\'arrivée :',
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker',
                    'data-provide' => 'datetimepicker'
                ],
                'html5' => false
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'Date de départ :',
                'required' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'js-datepicker',
                    'data-provide' => 'datetimepicker'
                ],
                'html5' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Réserver mon séjour romantique',
                'attr' => [
                    'class' => 'btn btn-lg',
                    'style' => 'width: 100%;'
                ]
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
