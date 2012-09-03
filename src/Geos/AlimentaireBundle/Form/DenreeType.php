<?php

namespace Geos\AlimentaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DenreeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
        	->add('libelle')
            ->add('categorie')
        ;
    }

    public function getName()
    {
        return 'geos_alimentairebundle_denreetype';
    }
}
