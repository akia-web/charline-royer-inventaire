<?php

namespace App\Form;

use App\Entity\Material;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('empruntDate')
       
            ->add('email', TextType::class, array(
                
                'label'=>"Email",
                'label_attr' => [
                    'class' => 'label ',
                ],
                'attr' => array(
                    'class' => 'form-control mb-3'
                )
            ))
            ->add('material',  EntityType::class, [
                'class' => Material::class,
                'label'=>"Matériel",
                'attr' => array(
                    'class' => 'form-control mb-3'
                )
            ],
             )
             ->add('rendered', DateTimeType::class,[
                'widget'=>'single_text',
                'label'=>"Date de rendu",
                'label_attr' => [
                    'class' => 'label2 ',
                ],
                'attr' => array(
                    'class' => 'mb-3'
                )
              
            ])
            ->add('isRendered', CheckboxType::class, array(
                'label'=>"Rendu",
                'required' => false,
                'label_attr' => [
                    'class' => 'label2',
                ],
                'attr' => array(
                    'class' => 'form-check-input mb-3'
                )
            ))
          
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
