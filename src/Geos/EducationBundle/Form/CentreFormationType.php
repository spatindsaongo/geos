<?php

namespace Geos\EducationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CentreFormationType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('geometrie')
            ->add('nom')
            ->add('cftype','choice', array( 'empty_value' => 'Choisir',
            								'choices'=>array('primaire',
            										         'lycée'=>'lycée',
            												 'college'=>'collège'
            												 )))
            ->add('responsable')
            ->add('creation')
            ->add('propriete','choice', array( 'empty_value' => 'Choisir',
            								'choices'=>array('prive'=>'prive',
            												 'public'=>'public',
            												 'semi-public'=>'semi-public'	)))
            ->add('status','choice', array( 'empty_value' => 'Choisir',
            								'choices'=>array('non'=>'non',
            												 'oui'=>'oui'	)))
            ->add('zoi','location')
        ;
    }

    public function getName()
    {
        return 'geos_educationbundle_centreformationtype';
    }
}
