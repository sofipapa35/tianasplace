<?php

namespace App\Form;

use App\Form\PhotoType;
use App\Entity\Timeline;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TimelineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=> "Titre *", 
                'attr' => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('description', CKEditorType::class, ["required"=>false])
            ->add('dateActu', DateType::class, ['widget'=>"single_text", 'label'=>"Date d'actualité", "required"=>false])
        ;
        $builder
            ->add('photos', CollectionType::class, [
                'entry_type' => PhotoType::class,
                'label' => 'Photo',
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Timeline::class,
        ]);
    }
}
