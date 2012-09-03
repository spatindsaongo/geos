<?php

namespace Geos\GeoEntityBundle\Form;
use Symfony\Component\Form\AbstractType,
	Symfony\Component\Form\FormBuilder;

class ZoiType extends AbstractType {	
	
	public function buildForm(FormBuilder $builder, array $options){
		$builder->add('typezoi','choice',array('choices'=>array('parcelle'=>'parcelle',
																 'lot'=>'lot')));
	
	}

	public function getName() {
		return 'zoitype';
	}	

}
