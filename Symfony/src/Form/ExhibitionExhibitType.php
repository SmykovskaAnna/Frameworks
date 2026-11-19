<?php

namespace App\Form;

use App\Entity\Exhibit;
use App\Entity\Exhibition;
use App\Entity\ExhibitionExhibit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExhibitionExhibitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('displayOrder')
            ->add('exhibition', EntityType::class, [
                'class' => Exhibition::class,
                'choice_label' => 'id',
            ])
            ->add('exhibit', EntityType::class, [
                'class' => Exhibit::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExhibitionExhibit::class,
        ]);
    }
}
