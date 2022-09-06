<?php

namespace App\Form\Type;


use App\Entity\CasoTipo;
use App\Entity\Cliente;
use App\Entity\Prioridad;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CasoEditarAtenderType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('clienteRel', EntityType::class, array(
                'class' => Cliente::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombreCorto', 'ASC');
                },
                'required' => false,
                'choice_label' => 'nombreCorto',
                'placeholder' => 'TODOS',
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
            ->add('casoTipoRel', EntityType::class, array(
                'class' => CasoTipo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true,
            ))
            ->add('usuarioRel', EntityType::class, [
                'required' => false,
                'class' => Usuario::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.soporte = 1')
                        ->orderBy('u.nombres', 'ASC');
                },
                'choice_label' => function ($er) {
                    $campo = $er->getNombres() . ' ' . $er->getApellidos();
                    return $campo;
                },
                'attr' => ['class' => 'to-select-2'],
            ])
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
