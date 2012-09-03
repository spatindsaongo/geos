<?php

namespace Geos\AlimentaireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MarcheType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('status','choice', array( 'empty_value' => 'Choisir',
            								'choices'=>array('non'=>'non',
            												 'oui'=>'oui'	)))
            ->add('geometrie')
            ->add('nom')
            ->add('zoi','location')
        ;
    }

    public function getName()
    {
        return 'geos_alimentairebundle_marchetype';
    }
}
