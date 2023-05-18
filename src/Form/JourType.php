<?php

namespace App\Form;

use App\Entity\Jour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class JourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // https://stackoverflow.com/questions/68743074/disable-a-future-date-using-the-symfony-datetype
        $builder
            ->remove('jour')
            ->add('dateStart', DateType::class, ['label'=>'Debut', 'widget' => 'single_text','mapped'=>false, 'attr' => [
                'class' => 'js-datepicker',
                'min' => date('Y-m-d')
            ]])
            ->add('dateEnd', DateType::class, ['label'=>'Fin', 'widget' => 'single_text','mapped'=>false, 'attr' => [
                'class' => 'js-datepicker',
                'min' => date('Y-m-d')
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jour::class,
        ]);
    }
}
