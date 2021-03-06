<?php

namespace App\Form;

use App\Entity\SyncData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EasilyParsedDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dataString0', TextType::class, [
                'required' => false,
            ])
            ->add('dataString1', TextType::class, [
                'required' => false,
            ])
            ->add('dataString2', TextType::class, [
                'required' => false,
            ])
            ->add('dataString3', TextType::class, [
                'required' => false,
            ])
            ->add('dataString4', TextType::class, [
                'required' => false,
            ])
            ->add('dataString5', TextType::class, [
                'required' => false,
            ])
            ->add('dataID', TextType::class, [
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary float-left'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SyncData::class,
        ]);
    }
}
