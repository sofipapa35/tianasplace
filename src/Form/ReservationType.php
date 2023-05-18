<?php

namespace App\Form;

use App\Entity\Personnes;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label'=>'Nom *', 'mapped'=>false])
            ->add('email', EmailType::class, ['label'=>'Email *', 'mapped'=>false])
            ->add('jour', DateType::class, ['widget'=>"single_text", 'label'=>"Date", "required"=>false, 'attr' => [
                'class' => 'js-datepicker',
                'min' => date('Y-m-d')
            ]])
            ->add('heure')
            ->add('personnes', EntityType::class, [
                'class' => Personnes::class,
                // 'choice_label' => 'personnes',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
