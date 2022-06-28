<?php

namespace App\Form\Type;


use App\Entity\Cliente;
use App\Entity\Implementador;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            ->add('inventario', CheckboxType::class, array('required' => false))
            ->add('compra', CheckboxType::class, array('required' => false))
            ->add('tesoreria', CheckboxType::class, array('required' => false))
            ->add('venta', CheckboxType::class, array('required' => false))
            ->add('cartera', CheckboxType::class, array('required' => false))
            ->add('recursoHumano', CheckboxType::class, array('required' => false))
            ->add('turno', CheckboxType::class, array('required' => false))
            ->add('transporte', CheckboxType::class, array('required' => false))
            ->add('crm', CheckboxType::class, array('required' => false))
            ->add('financiero', CheckboxType::class, array('required' => false))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
