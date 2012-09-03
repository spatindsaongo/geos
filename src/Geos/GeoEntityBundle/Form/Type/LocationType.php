<?php

namespace Geos\GeoEntityBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType,
	Symfony\Component\Form\FormBuilder,
    Geos\GeoEntityBundle\Form\Type\DataTransformer\LocationToArrayTransformer;

class LocationType extends AbstractType {
	
	private $zone;
	
	public function __construct($zone){
		$this->zone = $zone;
	}
	
	public function buildForm(FormBuilder $builder, array $options){
		

			$builder->add('Region','entity',array('empty_value' => 'choisir une region',
												  'class' => 'GeosGeoEntityBundle:Region',
												  'query_builder' =>  function(EntityRepository $er) {
        															  return $er->createQueryBuilder('r')
            								                                    ->orderBy('r.nom', 'ASC');},
            								))
					->add('Province','entity', array('empty_value' => 'choisir une province',
													 'class' => 'GeosGeoEntityBundle:Province',
												     'query_builder' =>  function(EntityRepository $er) {
        															  return $er->createQueryBuilder('p')
            								                                    ->orderBy('p.nom', 'ASC');},
            								))
					->add('Commune','entity', array('empty_value' => 'choisir une commune',
													'class' => 'GeosGeoEntityBundle:Commune',
												    'query_builder' =>  function(EntityRepository $er) {
        															  return $er->createQueryBuilder('c')
            								                                    ->orderBy('c.nom', 'ASC');},
        									))
					->add('Section','entity',array( 'empty_value' => 'choisir une section',
							                       'class' => 'GeosGeoEntityBundle:Section',
												   'query_builder' =>  function(EntityRepository $er) {
        															  return $er->createQueryBuilder('s')
            								                                    ->orderBy('s.numero', 'ASC');},
        									))
        			->add('Lot','entity',array('empty_value' => 'choisir un lot',
        											'class' => 'GeosGeoEntityBundle:Lot',
        											'query_builder' =>  function(EntityRepository $er) {
        											return $er->createQueryBuilder('s')
        											->orderBy('s.numero', 'ASC');
        									},
        									))
        			->add('Parcelle','entity',array('empty_value' => 'choisir une parcelle',
        											'class' => 'GeosGeoEntityBundle:Parcelle',
        											'query_builder' =>  function(EntityRepository $er) {
        											return $er->createQueryBuilder('s')
        											->orderBy('s.numero', 'ASC');
        									},
        									))
        			->appendClientTransformer(new LocationToArrayTransformer());
		
	}
	
	public function getDefaultOptions(array $options) {
		return array ('zone' => $this->zone,
						             );
	}
	
	public function getParent(array $options)
	{
		return 'form';
	}
	
	public function getName()
	{
		return 'location';
	}

}
