<?php

namespace App\Form\Type;

use App\Entity\Contacto;
use App\Entity\ContactoTipo;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contactoTipoRel', EntityType::class, [
                'required' => true,
                'class' => ContactoTipo::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'attr' => ['class' => 'form-control to-select-2']
            ])
            ->add('nombre', TextType::class, array('required' => true))
            ->add('telefono', TextType::class, array('required' => true))
            ->add('correo', TextType::class, array('required' => true))
            ->add('cargo', TextType::class, array('required' => true))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contacto::class,
        ]);
    }
}
