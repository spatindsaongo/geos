<?php
namespace Geos\GeoEntityBundle\Type;
use Doctrine\DBAL\Types\Type,
	Doctrine\DBAL\Platforms\AbstractPlatform,
	Geos\GeoEntityBundle\Lib\Point,
	Doctrine\DBAL\Connection;

/**
 * @author Patindsaongo SAM
 * @TODO Trouver un moyen pour obtenir la connection à la base de données à partir de doctrine
 */

class GeometryType extends Type {
	
	const GEOMETRY = 'geometry';

	public function getSQLDeclaration(array $fieldDeclaration,	AbstractPlatform $platform) {
		
		return "GEOMETRY";
	}

	/**
	 * @param unknown_type $value
	 * @param AbstractPlatform $platform
	 * @return mixed
	 * @TODO Incomplète: Prendre compte les linestring
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform) {		
		
		$con =  pg_connect("host=localhost  port=5432 dbname=geos user=postgres password=lk2xFNyA");
		
		if($value!=null){
			$result = pg_query($con,"SELECT ST_astext('".$value."') as wkt;");
			$rawdata = pg_fetch_all($result);
			$text = $rawdata[0]['wkt'];
			
			list($type, $data) = explode('(', $text,2);
			
			if($type=='POINT'){
				list($lon,$lat) = sscanf($data, '%f %f)');
				return $lon.' '.$lat;
			}
			elseif ($type=='POLYGON'){
				list($polygon, $l) = explode(')', $data,2);						
				return $polygon.')';
			}
			else{
				return $data;
				$value = 'donnée non définie ';
			}
		}
		else {
			return $value;
		}		
	}

	/**
	 * @param unknown_type $value
	 * @param AbstractPlatform $platform
	 * @return string
	 * @TODO Incomplète : Prendre en compte les linestring.
	 */
	
	public function convertToDatabaseValue($value, AbstractPlatform $platform) {
		if($value!=null){
			if(substr_count($value, ',')==0)
			{
				list($lon,$lat) = sscanf($value, '%f %f');
				$geometrie = new Point($lon,$lat);
				$value = $geometrie->toWKT();
			}
			else 
			{
				$value = 'POLYGON('.$value.')';	
			}
		}	
		
		return $value;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Doctrine\DBAL\Types.Type::getName()
	 */
	public function getName() {
		
		return self::GEOMETRY;
	}

}
