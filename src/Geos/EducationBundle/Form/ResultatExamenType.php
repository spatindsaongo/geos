<?php

namespace Geos\EducationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ResultatExamenType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        	->add('classe')
            ->add('libelle')
            ->add('admisFeminin')
            ->add('admisMasculin')
        ;
    }

    public function getName()
    {
        return 'geos_educationbundle_resultatexamentype';
    }
}
