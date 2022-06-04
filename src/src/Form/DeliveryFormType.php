<?php

namespace App\Form;

use App\Entity\Delivery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DeliveryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Title'
                    ],
                    'label' => 'Title *',
                    'translation_domain' => 'messages',
                ]
            )
            ->add(
                'baseUrl',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'baseUrl'
                    ],
                    'label' => 'baseUrl *',
                    'translation_domain' => 'messages',
                ]
            )
            ->add('weight')
            ->add('fromDate')
            ->add('toDate')
            ->add('departure')
            ->add('destination')

            ->add('submit', SubmitType::class, [
                'label' => 'form.submit',
                'translation_domain' => 'messages',
                'attr' => [
                    'class' => 'input-submit',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Delivery::class,
        ]);
    }
}
