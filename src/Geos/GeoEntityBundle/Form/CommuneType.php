<?php

namespace Geos\GeoEntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CommuneType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('geometrie')
            ->add('nom')
            ->add('province','location')
            ->add('status','choice',array('empty_value' => 'Choisir un statut',
            							  'choices'=>array('urbain'=>'urbain',
            											   'rural'=>'rural')))
        ;
    }

    public function getName()
    {
        return 'geos_geoentitybundle_communetype';
    }
}
