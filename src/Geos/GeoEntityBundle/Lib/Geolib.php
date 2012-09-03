<?php

/**
 * @version 0.1
 * @author spatindsaongo
 *
 */
namespace Geos\GeoEntityBundle\Lib;

use Symfony\Component\DependencyInjection\ContainerAware;

class Geolib {
	
	
	protected $doctrine;
	
	public function __construct($doctrine){
		$this->doctrine = $doctrine;
	}

	/**
	 * Retourne sous forme de tableau les coordonnées d'un point à partir d'une expression "string"
	 * @param unknown_type $expression
	 * @return multitype:unknown mixed
	 */
	
	public function toWKT($expression) {
		
		$connection = $this->doctrine->getConnection();		
		$sql =  "SELECT ST_astext('".$expression."') as wkt;";				
		return  $connection->query($sql)->fetchColumn(0);
		
	}
	
	public function getPoint($expression)
	{
		list($lon,$lat) = sscanf($expression, '%f %f');
		return array('lon'=>$lon,
					 'lat'=>$lat
		);
	}
	
	public function getPolygon($expression)
	{
		$polygon = sprintf('POLYGON(%s)',$expression);
		return $polygon;
	}
	
	public static function getPolygonStatic($expression)
	{
		$polygon = sprintf('POLYGON(%s)',$expression);
		return $polygon;
	}
	
	/**
	 * @param unknown_type $entitiesId
	 */
	
	public function getPolygonCentroid($entityId){
	
		
		if (isset($entityId)){
			
			$connection = $this->doctrine->getConnection();
			$sqlPart = $entityId;
			$sql =  "SELECT ST_astext(ST_Centroid(geometrie)) as bbox FROM zoi WHERE id = ".$sqlPart." ;";
			
			$result = $connection->query($sql)->fetchColumn(0);
			list($lon,$lat) = sscanf($result, 'POINT( %f %f )');
			
			return array('lon'=>$lon,
				 		 'lat'=>$lat
			);
		}
	

	}
	
	
	public function getPolygonsCentroid($entitiesId){
		
		if(isset($entitiesId)){
			$connection = $this->doctrine->getConnection();
			$sqlPart = "";
			
			foreach ($entitiesId as $id){
				$sqlPart = $sqlPart.$id.', ';
			}
			
			$sqlPart = "(".$sqlPart." -1)";
			
			$sql =  "SELECT ST_astext(ST_Centroid(ST_collect(ST_Centroid(geometrie)))) as bbox FROM zoi WHERE id IN ".$sqlPart." ;";
	
			
			$result = $connection->query($sql)->fetchColumn(0);
			list($lon,$lat) = sscanf($result, 'POINT( %f %f )');
			
			return array('lon'=>$lon,
				 		 'lat'=>$lat
			);
		}
	}
	
	public function getPointsCentroid($entitiesId){
	
		if(isset($entitiesId)){
			$connection = $this->doctrine->getConnection();
			$sqlPart = "";
			
			foreach ($entitiesId as $id){
				$sqlPart = $sqlPart.$id.', ';
			}
			
			$sqlPart = "(".$sqlPart." -1)";
			
			$sql =  "SELECT ST_astext(ST_Centroid(ST_collect(geometrie))) as bbox FROM zoi WHERE id IN ".$sqlPart." ;";
	
			
			$result = $connection->query($sql)->fetchColumn(0);
			list($lon,$lat) = sscanf($result, 'POINT( %f %f )');
			
			return array('lon'=>$lon,
				 		 'lat'=>$lat
			);
		}
	}
	
	/**
	 * 
	 * @param Array $entitiesList Constitue une liste d'entités géolocalisée
	 */
	public function  getMarkers($entitiesList = NULL ){
		
		$scale = 10;   // Le niveau de zoom
		$mapCenter = '';// Centre de la carte
		$covers = array(); // les zones de couverture	
		$markers = array();// les marqueurs
		$entitiesId = array();

		if($entitiesList!=null){
			foreach ( $entitiesList as $entity) {
				if ($entity->getGeometrie()!=null){				
					$marker['coord'] = $this->getPoint($entity->getGeometrie());
					$marker['info'] = 'poi';
										
					$markers[]=$marker;
					$entitiesId[] = $entity->getId(); 
						
					unset($marker);
				}
			}
			$mapCenter = $this->getPointsCentroid($entitiesId);
		}
				
		$output = Array('scale'=>$scale,
						'mapCenter'=>$mapCenter,
						'markers' => $markers,
				);

		return $output;
		
	}
	
	/**
	 *
	 * @param Array $entitiesList Constitue une liste d'entités géolocalisée
	 */
	public function  getCovers($entitiesList = NULL ){
	
		$scale = 10;   // Le niveau de zoom
		$mapCenter = '';// Centre de la carte
		$covers = array(); // les zones de couverture
		$markers = array();// les marqueurs
		$entitiesId = array();
	
		if($entitiesList!=null){
			foreach ( $entitiesList as $entity) {
				
				if ($entity->getGeometrie()!=null){
					$marker['coord'] = $this->getPolygonCentroid($entity->getId());
					$marker['info'] = 'zoi';
					$cover = $this->getPolygon($entity->getGeometrie());
					$entitiesId[] = $entity->getId();
					
					$covers[]=$cover;
					$markers[]=$marker;
					
					unset($marker);
					unset($cover);
				}
				$mapCenter = $this->getPointsCentroid($entitiesId);
			}
		}
	
		$output = Array('scale'=>$scale,
						'mapCenter'=>$mapCenter,
						'markers' => $markers,
						'covers' => $covers
		);
	
		return $output;
	
	}

}
