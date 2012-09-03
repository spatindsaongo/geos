<?php

namespace Geos\GeoEntityBundle\Form\Type;
use Symfony\Component\Form\AbstractType,
	Symfony\Component\Form\FormBuilder;

class PointType extends AbstractType {
	
	protected $lon, $lat;
	
	public function __construct($lon=null, $lat=null){
		$this->lon = $lon;
		$this->lat = $lat;
	}
	
	public function buildForm(FormBuilder $builder, array $options){
		
		$builder->add('lon','number')
				->add('lat','number');		
	}
	
	public function getParent(array $options)
	{
		return 'form';
	}
	
	public function getName()
	{
		return 'point';
	}

}
