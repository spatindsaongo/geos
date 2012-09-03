<?php
namespace Geos\GeoEntityBundle\Form\Type\DataTransformer;
use Geos\GeoEntityBundle\Entity\Lot;

use Geos\GeoEntityBundle\Entity\Section;

use Geos\GeoEntityBundle\Entity\Province;

use Geos\GeoEntityBundle\Entity\Commune;

use Geos\GeoEntityBundle\Entity\Parcelle;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author spatindsaongo
 *
 */
class LocationToArrayTransformer implements DataTransformerInterface {

	private $zone;
	public function __construct($zone = null){
		
		$this->zone = $zone;
		
	}
	/**
	 * @param unknown_type $value
	 */
	public function transform($location) {
		$result = array('Region' => '',
						'Province' => '',
						'Commune' => '',
						'Section'=>'',
						'Lot'=>'',
						'Parcelle'=>'');
		
		if($location instanceof Province){ 
			$result['Region'] = $location->getRegion();
			$result['Province'] = $location;
		}
		elseif ($location instanceof Commune){
			$result['Region'] = $location->getProvince()->getRegion();
			$result['Province'] = $location->getProvince();
			$result['Commune'] = $location;

		}
		elseif($location instanceof Section){
			$result['Region'] = $location->getCommune()->getProvince()->getRegion();
			$result['Province'] = $location->getCommune()->getProvince();
			$result['Commune'] = $location->getCommune();
			$result['Section'] = $location;
		}
		elseif ($location instanceof Lot){
			$result['Region'] = $location->getSection()->getCommune()->getProvince()->getRegion();
			$result['Province'] = $location->getSection()->getCommune()->getProvince();
			$result['Commune'] = $location->getSection()->getCommune();
			$result['Section'] = $location->getSection();
			$result['Lot'] = $location;
		}
		elseif ($location instanceof Parcelle){
			$result['Region'] = $location->getLot()->getSection()->getCommune()->getProvince()->getRegion();
			$result['Province'] = $location->getLot()->getSection()->getCommune()->getProvince();
			$result['Commune'] = $location->getLot()->getSection()->getCommune();
			$result['Section'] = $location->getLot()->getSection();
			$result['Lot'] = $location->getLot();
			$result['Parcelle'] = $location;

		}
		
		return $result;
	}

	/**
	 * @param unknown_type $value
	 */
	public function reverseTransform($value) {
			$zoi = '';
			
			if(isset($value['Parcelle'])){
				$zoi = $value['Parcelle'];
			}
			elseif(isset($value['Lot'])){
				$zoi = $value['Lot'];
			}
			elseif(isset($value['Section'])){
				$zoi = $value['Section'];
			}
			elseif(isset($value['Commune'])){
				$zoi = $value['Commune'];
			}
			elseif(isset($value['Province'])){
				$zoi = $value['Province'];
			}
			elseif(isset($value['Region'])){
				$zoi = $value['Province'];
			}
			
		return $zoi;
	}
}
