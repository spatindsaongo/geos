<?php
namespace Geos\MainBundle\Form;
use Symfony\Component\Form\AbstractType,
	Symfony\Component\Form\FormBuilder;

class indicateurParameterType extends AbstractType {
	
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('interval', 'choice',array('choices'=>array('journalier'=>'journalier',
															'bimensuel'=>'bimensuel',
															'mensuel'=>'mensuel',
															'trimestriel'=>'trimestriel',
															'semestriel'=>'semestriel',
															'annuel'=>'annuel',),
										 'attr'=>array('class'=>'span2')
															))
		->add('dateDebut','date')
		->add('occurences','choice',array('attr'=>array('class'=>'span1'),
										  'choices'=>array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10)))
		->add('hierarchie','choice',array('choices'=>array('commune'=>'commune',
														   'province'=>'province',
														   'region'=>'region'),))
		->add('zone','entity',array('class'=>'GeosGeoEntityBundle:Zoi',
									'multiple'=>true,))
				;
	}
	
	public function getName()
	{
		return 'indicateur_parameter';
	}

}
