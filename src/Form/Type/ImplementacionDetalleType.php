<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImplementacionDetalleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('fechaCompromiso', DateTimeType::class, ['widget' => 'single_text', 'required' => false])
            ->add('fechaCapacitacion', DateTimeType::class, ['widget' => 'single_text', 'required' => false])
            ->add('estadoInicio', CheckboxType::class, ['required' => false])
            ->add('estadoTerminado', CheckboxType::class, ['required' => false])
            ->add('estadoCapacitado', CheckboxType::class, ['required' => false])
            ->add('responsable', TextType::class, array('required' => true))
            ->add('comentario', TextareaType::class, array('required' => false))
            ->add('comentarioImplementador', TextareaType::class, array('required' => false))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
