<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Establishment;
use App\Entity\Suites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('establishment', EntityType::class, [
                'label' => 'Établissement : ',
                'placeholder' => 'Choisir un établissement',
                'class' => Establishment::class
            ])
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

        $formModifier = function (FormInterface $form, Establishment $establishment = null) {

            $suites = (null === $establishment) ? [] : $establishment->getSuites();

            $form->add('suite', EntityType::class, [
                'class' => Suites::class,
                'choices' => $suites,
                'label' => 'Suite'
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getEstablishment());
            }
        );

        $builder->get('establishment')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $establishment = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $establishment);
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
