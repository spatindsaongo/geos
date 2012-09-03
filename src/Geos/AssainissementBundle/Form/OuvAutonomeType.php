<?php

namespace Geos\AssainissementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class OuvAutonomeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('status','choice',array('empty_value' => 'choisir', 
            							  'choices'=>array('non' => 'non',
            											   'oui' => 'oui',)))
            ->add('geometrie')
            ->add('ouvType','choice',array('empty_value' => 'choisir', 
            							  'choices'=>array('vip' => 'vip',
            											   'latrine' => 'latrine',
            												'rehabiliation' => 'rehabilitation')))
            ->add('utility', 'choice',array('empty_value' => 'choisir', 
            							  'choices'=>array('domestique' => 'domestique',
            											   'communautaire' => 'communautaire',)))
            ->add('nbrePoste')
            ->add('dateMes')
            ->add('zoi','location')
        ;
    }

    public function getName()
    {
        return 'geos_assainissementbundle_ouvautonometype';
    }
}
