<?php

namespace Geos\GeoEntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RegionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('geometrie')
            ->add('nom')
            ->add('chefLieu','entity',array('class'=>'GeosGeoEntityBundle:Commune',
            								'empty_value'=>'choisir une commune',
            								'required' => false))
        ;
    }

    public function getName()
    {
        return 'geos_geoentitybundle_regiontype';
    }
}
