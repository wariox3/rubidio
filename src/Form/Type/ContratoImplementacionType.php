<?php

namespace App\Form\Type;

use App\Entity\Contacto;
use App\Entity\Contrato;
use App\Entity\Modalidad;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratoImplementacionType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('modalidadRel', EntityType::class, [
                'required' => true,
                'class' => Modalidad::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'nombre:'
            ])
            ->add('contactoRepresentanteRel', EntityType::class, [
                'required' => true,
                'class' => Contacto::class,
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('c')
                        ->where("c.codigoClienteFk = " . $options['data']->getClienteRel()->getCodigoClientePk())
                        ->andWhere("c.codigoContactoTipoFk = 'REP'")
                        ->orderBy('c.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
                'label' => 'nombre:'
            ])
            ->add('fechaInicio', DateType::class, ['widget' => 'single_text', 'required' => false])
            ->add('numero', TextType::class, array('required' => true))
            ->add('numeroOferta', TextType::class, array('required' => false))
            ->add('vrImplementacion', NumberType::class, array('required' => true))
            ->add('guardar', SubmitType::class, array('label' => 'Guardar'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contrato::class,
        ]);
    }
}
