<?php

namespace Geos\MainBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class EntityType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
	    	->add('entityType', 'choice',array('choices'=>array('entityType'=>'Type d\'entité',
	    														'zoi'=>'zone d\'interêt',
	    												  		'poi'=>'point d\'interêt')))
	    	->add('entity','choice',array('choices'=>array('choix'=>'Choix')))
        ;
    }

    public function getName()
    {
        return 'entity';
    }
}
