<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label'=> "Titre *", 
                'attr' =>[
                    'placeholder' => 'ex. Gumbo'
            ]])
            ->add('description', CKEditorType::class, [
                "label"=>"Description",
                'required' => false
                ])
            ->add('price', TextType::class, [
                'label'=> "Prix *", 
                'attr' =>[ 
                    'placeholder' => 'ex. 20'
            ]])
            ->add('imageFile', FileType::class, ['label'=>'Image', 'required' => false])
            ->add('addCart', CheckboxType::class, ['label'=> "Ajouter au panier ?"])
            ->add('active', CheckboxType::class, ['label'=> "C'est active ?"])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                "label"=>"Categorie *"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
