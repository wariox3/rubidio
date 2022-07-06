<?php

namespace App\Form\Type;

use App\Entity\EstudioDetalle;
use App\Entity\Modulo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstudioDetalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('moduloRel', EntityType::class, [
                'class' => Modulo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'required' => true,
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('responsable', TextType::class, array('required' => true))
            ->add('fechaValidacion', DateTimeType::class, ['widget' => 'single_text'])
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EstudioDetalle::class,
        ]);
    }
}