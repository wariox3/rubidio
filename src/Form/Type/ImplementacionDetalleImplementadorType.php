<?php

namespace App\Form\Type;


use App\Entity\Prioridad;
use App\Entity\Proyecto;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImplementacionDetalleImplementadorType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('fecha', DateTimeType::class, ['widget' => 'single_text'])
            ->add('fechaCompromiso', DateTimeType::class, ['widget' => 'single_text'])
            ->add('estadoInicio', CheckboxType::class, ['required' => false])
            ->add('estadoTerminado', CheckboxType::class, ['required' => false])
            ->add('estadoCapacitado', CheckboxType::class, ['required' => false])
            ->add('comentario', TextareaType::class, array('required' => false))
            ->add('comentarioImplementador', TextareaType::class, array('required' => false))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
