<?php

namespace App\Form\Type;

use App\Entity\Modulo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CasoSoporteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('moduloRel', EntityType::class, array(
                'class' => Modulo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'placeholder' => 'Seleccione un modulo',
                'required' => true,
            ))
            ->add('contacto', TextType::class, array('required' => true))
            ->add('telefono', TextType::class, array('required' => true))
            ->add('correo', TextType::class, array('required' => true))
            ->add('clienteIngreso', TextType::class, array('required' => true))
            ->add('descripcion', TextareaType::class, array('required' => true))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
