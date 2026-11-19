<?php

namespace App\Form;

use App\Entity\Exhibition;
use App\Entity\Ticket;
use App\Entity\Visitor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('purchaseDate')
            ->add('price')
            ->add('ticketType')
            ->add('visitor', EntityType::class, [
                'class' => Visitor::class,
                'choice_label' => 'id',
            ])
            ->add('exhibition', EntityType::class, [
                'class' => Exhibition::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
