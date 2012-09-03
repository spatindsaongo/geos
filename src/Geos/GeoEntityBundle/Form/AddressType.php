<?php

namespace Geos\GeoEntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('geometrie')
            ->add('nom')
            ->add('zoi')
        ;
    }

    public function getName()
    {
        return 'geos_geoentitybundle_addresstype';
    }
}
