<?php

namespace NutricionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanillaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cedula')->add('nombre')->add('apellido')->add('nacimiento')->add('profesion')->add('ocupacion')->add('nacionalidad')->add('direccion')->add('ciudad')->add('estado')->add('pais')->add('cedulared')->add('nombrered')->add('apellidored')->add('clave')->add('username');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NutricionBundle\Entity\Planilla'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nutricionbundle_planilla';
    }


}
