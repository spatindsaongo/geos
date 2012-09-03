<?php

namespace Geos\GeoEntityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('geometrie')
            ->add('numero')
            ->add('commune','location')
        ;
    }

    public function getName()
    {
        return 'geos_geoentitybundle_sectiontype';
    }
}
