<?php
namespace Geos\GeoEntityBundle\Lib;
use Doctrine\Bundle\DoctrineBundle\Registry;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * 
 * @author Patindsaongo SAM
 *
 */
class Point{

	protected $lon, $lat;
	
	public function __construct($lon=null, $lat=null){
		$this->lon=$lon;
		$this->lat=$lat;
	}
	
	public function getLon(){
		return $this->lon;
	}
	
	public function getLat(){
	    return $this->lat;
	}
	
	public function setLon($lon){
		$this->lon=$lon;
	}
	
	public function setLat($lat){
		$this->lat=$lat;
	}
	
	public function toWKT(){
		return 'POINT('.$this->lon.' '.$this->lat.')';
	}
	
	public function __toString(){
		return 'lon : '.$this->lon.' ; lat : '.$this->lat;
	}

}
