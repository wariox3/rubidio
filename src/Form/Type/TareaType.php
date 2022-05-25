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

class TareaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('usuarioRel', EntityType::class, array(
                'class' => Usuario::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.codigoUsuarioPk', 'ASC')
                        ->where('u.adicionarTarea=1');
                },
                'choice_label' => 'codigoUsuarioPk',
                'required' => true,
            ))
            ->add('prioridadRel', EntityType::class, array(
                'class' => Prioridad::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.orden', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true,
            ))
            ->add('proyectoRel', EntityType::class, array(
                'class' => Proyecto::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('py')
                        ->orderBy('py.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => false,
            ))
            ->add('descripcion', TextareaType::class, array('required' => true))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
