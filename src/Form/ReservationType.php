<?php

namespace App\Form;

use App\Entity\Material;
use App\Entity\Reservation;
use App\Service\ApiEleveService;
use stdClass;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    private $apiEleveService;
    public function __construct(ApiEleveService $apiEleveService)
    {
        $this->apiEleveService = $apiEleveService; 
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $tableau = [
        //  ['nom'=>'royer', 'prenom'=>'charline','mail'=>'croyer@normandiewebschool', 'id'=>1],
        //  ['nom'=>'vouin','prenom'=>'anthony','mail'=>'avouin@normandiewebschool', 'id'=>2],
        //  ['nom'=>'truc','prenom'=>'bidule','mail'=>'tbidule@normandiewebschool', 'id'=>3],
        // ];
        // $result = [];
        // foreach($tableau as $item){
        //     $nom = $item['nom'];
        //     $prenom = $item['prenom'];
        //     $mail = $item['mail'];
        //     $id = $item['id'];
        //     $option = "$nom - $prenom - $mail";
        //     $result[$option] = $id;
        // }

    
        // foreach($result as $item){
        //    $builder ->add('email', ChoiceType::class,[
                
        //     'choices'=> $result,
           
        
        //     ]);
        // };


       


        $elevesApi = $this->apiEleveService->getData();
        $resultEleves = [];
        foreach($elevesApi as $item){
            $nom = $item['nom'];
            $prenom = $item['prenom'];
            $mail = $item['mail'];
            $id = $item['id'];
            $option = " $nom $prenom : $mail";
            $resultEleves[$option] = $id;
        }

        $builder
            // ->add('empruntDate')

       
            ->add('studientId', ChoiceType::class,[
                // 'choices' => array_values($tableau['name'])
                'choices'=> $resultEleves,
                'label'=>"Étudiant",
                'attr' => array(
                    'class' => 'form-control mb-3'
                )
                
            ])
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
