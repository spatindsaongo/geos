<?php

namespace Geos\GeoEntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProvinceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('geometrie')
            ->add('nom')
            ->add('region')
        ;
    }

    public function getName()
    {
        return 'geos_geoentitybundle_provincetype';
    }
}
