<?php

namespace Geos\SanteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('libelle','choice',array('choices'=>array('medecin'=>'medecin',
            												'infirmier'=>'infirmier',
            												'sage femme' =>'sage femme',
            												'accoucheuse' => 'accoucheuse'),
            							   'empty_value'=>'choisir une profession'))
            ->add('nombre')
            ->add('centreSante')
        ;
    }

    public function getName()
    {
        return 'geos_santebundle_agenttype';
    }
}
