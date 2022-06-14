<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SoporteExternoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('contacto', TextType::class, array('required' => true))
            ->add('telefono', TextType::class, array('required' => true))
            ->add('correo', TextType::class, array('required' => true))
            ->add('clienteIngreso', TextType::class, array('required' => true))
            ->add('descripcion', TextareaType::class, array('required' => true))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
