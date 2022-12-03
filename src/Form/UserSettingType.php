<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'User Name',
            ])
            ->add('admin', CheckboxType::class, [
                'label' => 'Is Admin',
                'required' => false,
            ])
            ->add('locked', CheckboxType::class, [
                'label' => 'Locked Account',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Settings',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'form_data' => [],
        ]);
    }
}
