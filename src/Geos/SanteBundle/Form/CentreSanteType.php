<?php

namespace Geos\SanteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CentreSanteType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('status','choice',array('choices'=>array('oui'=>'oui',
            											   'non'=>'non'),
            							  'empty_value'=>'choisir'))
            ->add('geometrie')
            ->add('nom')
            ->add('creation')
            ->add('categorie','choice',array('choices'=>array('csps'=>'csps',
            												  'cma' =>'cma',
            												  'chr'=>'chr',
            												  'chu'=>'chu',
            												  'clinique'=>'clinique'),
            								 'empty_value'=>'choisir'))
            ->add('propriete','choice',array('choices'=>array('privé'=>'privé',
            												  'public'=>'public',
            												  'semi-public'=>'semi-public'),
            								 'empty_value'=>'choisir'))
            ->add('zoi','location')
        ;
    }

    public function getName()
    {
        return 'geos_santebundle_centresantetype';
    }
}
