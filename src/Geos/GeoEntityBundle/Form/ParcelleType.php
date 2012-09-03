<?php

namespace Geos\GeoEntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ParcelleType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('geometrie')
            ->add('numero')
            ->add('lot','location')
        ;
    }

    public function getName()
    {
        return 'geos_geoentitybundle_parcelletype';
    }
}
