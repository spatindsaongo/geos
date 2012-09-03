<?php
namespace Geos\GeoEntityBundle\Type;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class PointType extends Type {

	const POINT = 'point';
	
	public function getSQLDeclaration($fieldDeclaration,
			AbstractPlatform $platform) {
		// TODO: Auto-generated method stub
		return 'GEOMETRY';
	}
	
	/**
	 * @param unknown_type $value
	 * @param AbstractPlatform $platform
	 * @return mixed
	 */
	public function convertToPHPValue($value, AbstractPlatform $platform) {
		// TODO: Auto-generated method stub
		list($longitude, $latitude) = sscanf($value, 'POINT(%f %f)');		
		return 'lon : '.$longitude.'; lat : '.$latitude;
	}
	
	/**
	 * @param unknown_type $value
	 * @param AbstractPlatform $platform
	 * @return mixed
	 */
	public function convertToDatabaseValue($value, AbstractPlatform $platform) {
		// TODO: Auto-generated method stub
		$value = sprintf("POINT(%s)", $value);
		return $value;
	}

	/**
	 * @return boolean
	 */
	public function canRequireSQLConversion() {
		// TODO: Auto-generated method stub
		return true;
	}
	
	/**
	 * @param unknown_type $sqlExpr
	 * @param unknown_type $platform
	 * @return string
	 */
	public function convertToPHPValueSQL($sqlExpr, AbstractPlatform $platform) {
		// TODO: Auto-generated method stub
		return sprintf('ST_AsText(%s)', $sqlExpr);
	}
	
	/**
	 * @param unknown_type $sqlExpr
	 * @param AbstractPlatform $platform
	 * @return string
	 */
	public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform) {
		// TODO: Auto-generated method stub
		return sprintf("ST_GeomFromText(%s)", $sqlExpr);
	}


	public function getName() {
		// TODO: Auto-generated method stub
		return self::POINT;
	}

}
