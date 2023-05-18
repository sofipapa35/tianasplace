<?php

namespace App\Form;

use App\Entity\Heure;
use App\Entity\Personnes;
use App\Entity\Disponibility;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DisponibilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label'=>'Nom *', 'mapped'=>false])
            ->add('email', EmailType::class, ['label'=>'Email *', 'mapped'=>false])
            ->add('jour', DateType::class, ['label'=>'Date *','widget' => 'single_text','mapped'=>false, 'attr' => [
                'class' => 'js-datepicker',
                'min' => date('Y-m-d')
            ]])
            ->add('personnes', EntityType::class, [
                'class'=>Personnes::class, 
                "label"=>"Nombre de personnes *"
                ])
            ->add('heure', EntityType::class, [
                'class'=>Heure::class, 
                "label"=>"Heure *"])
            ->remove('count')
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disponibility::class,
        ]);
    }
}
