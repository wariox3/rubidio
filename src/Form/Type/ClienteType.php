<?php

namespace App\Form\Type;




use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClienteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nombreCorto', TextType::class, array('required' => true))
            ->add('nombreExtendido', TextType::class, array('required' => false))
            ->add('telefono', TextType::class, array('required' => false))
            ->add('direccion', TextType::class, array('required' => false))
            ->add('nit', TextType::class, array('required' => false))
            ->add('digitoVerificacion', TextType::class, array('required' => false))
            ->add('suscriptor', TextType::class, array('required' => false))
            ->add('empleador', TextType::class, array('required' => false))
            ->add('facturacionElectronica', CheckboxType::class, array('required' => false))
            ->add('nominaElectronica', CheckboxType::class, array('required' => false))
            ->add('setPruebas', CheckboxType::class, array('required' => false))
            ->add('setPruebasNomina', CheckboxType::class, array('required' => false))
            ->add('correoError', TextType::class, array('required' => false))
            ->add('codigoSetPruebas', TextType::class, array('required' => false))
            ->add('codigoSetPruebasNominas', TextType::class, array('required' => false))
            ->add('servicioSoporte', CheckboxType::class, array('required' => false))
            ->add('fechaSuspension', DateType::class, array('required' => false, 'widget' => 'single_text', 'format' => 'yyyy-MM-dd', 'attr' => array('class' => 'date',)))
            ->add('guardar', SubmitType::class,array('label'=>'Guardar'));
    }

}
