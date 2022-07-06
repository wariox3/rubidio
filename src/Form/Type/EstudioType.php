<?php

namespace App\Form\Type;


use App\Entity\Cliente;
use App\Entity\Estudio;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstudioType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('clienteRel', EntityType::class, array(
                'class' => Cliente::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombreCorto', 'ASC');
                },
                'choice_label' => 'nombreCorto',
                'required' => true,
            ))
            ->add('fecha', DateType::class, ['widget' => 'single_text'])
            ->add('responsable', TextType::class, array('required' => true))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Estudio::class,
        ]);
    }

}
