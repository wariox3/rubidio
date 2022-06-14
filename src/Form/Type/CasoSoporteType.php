<?php

namespace App\Form\Type;


use App\Entity\Prioridad;
use App\Entity\Proyecto;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CasoSoporteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('prioridadRel', EntityType::class, array(
                'class' => Prioridad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.orden', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true,
            ))
            ->add('contacto', TextType::class, array('required' => true))
            ->add('telefono', TextType::class, array('required' => true))
            ->add('correo', TextType::class, array('required' => true))
            ->add('descripcion', TextareaType::class, array('required' => true))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
