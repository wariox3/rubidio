<?php

namespace App\Form\Type;


use App\Entity\CasoEscalado;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CasoEscaladoType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('usuarioDestinoRel', EntityType::class, [
                'required' => true,
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
            ->add('comentario', TextareaType::class, array('required' => false))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CasoEscalado::class,
        ]);
    }

}
