<?php

namespace App\Form;

use App\Entity\Arbre;
use App\Entity\Parc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateArbreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('position')
            ->add('dateImplantation')
            ->add('aRisque')
            ->add('parc',EntityType::class,[
                'class'=>Parc::class,
                'choice_label'=>'nom',
                'multiple'=>false,
                'expanded'=>false,

            ])
            ->add('update',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Arbre::class,
        ]);
    }
}
