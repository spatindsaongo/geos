<?php

namespace Geos\EauBundle\Form;

use Geos\GeoEntityBundle\Form\Type\PointType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PointEauType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('geometrie')
            ->add('peType', 'choice', array('empty_value' => 'Choisir',
            								'choices'=>array('branchement'=>'branchement',
            												 'borne fontaine'=>'borne fontaine',
            												 'pem'=>'pem',
            												 'pmh'=>'pmh'
            		)))
            ->add('dateMes')
            ->add('status','choice', array( 'empty_value' => 'Choisir',
            								'choices'=>array('non'=>'non',
            												'oui'=>'oui'	)))
            ->add('zoi','location')
        ;
    }

    public function getName()
    {
        return 'geos_eaubundle_pointeautype';
    }
}
