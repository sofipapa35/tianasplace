<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                "label"=>"Nouvelle Address",
                'required' => false,
                "attr"=>[
                    'placeholder'=>'ex. rue de soleil'
                ]])
            ->add('zip', IntegerType::class, [
                "label"=>"Modifier Code Postal",
                'required' => false,
                "attr"=>[
                    'placeholder'=>'ex. 75000'
                ]])
            ->add('ville', TextType::class, [
                "label"=>"Modifier Ville",
                'required' => false,
                "attr"=>[
                    'placeholder'=>'ex. Paris'
                ]])
        ;
        if($options['email']){
            $builder
            ->add('email', EmailType::class, [
                "label"=>"Modifier E-mail",
                "required"=>false,
                "attr"=>[
                    'placeholder'=>'Veuillez saisir votre e-mail'
            ]])
            ->add('telephone', TelType::class, [
                "label"=>"Nouveau Numero Téléphone",
                'invalid_message' => 'Veuillez saisir un chiffre',
                'required' => false,
                "attr"=>[
                    'placeholder'=>'Veuillez saisir votre nouveau numero téléphone'
                ]]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'email' => false,
        ]);
    }
}
