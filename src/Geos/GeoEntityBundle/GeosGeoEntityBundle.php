<?php

namespace Geos\GeoEntityBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms;


class GeosGeoEntityBundle extends Bundle
{

	public function boot() {
		Type::addType('geometry', 'Geos\GeoEntityBundle\Type\GeometryType');
		//Type::addType('point', 'Geos\GeoEntityBundle\Type\PointType');
		//Type::addType('polygon', 'Geos\GeoEntityBundle\Type\PolygonType');
		$em = $this->container->get('doctrine')->getConnection();
		$em->getDatabasePlatform()->registerDoctrineTypeMapping('geometry', 'geometry');
		//$em->getDatabasePlatform()->registerDoctrineTypeMapping('point', 'point');
		//$em->getDatabasePlatform()->registerDoctrineTypeMapping('polygon', 'polygon');
	}

}
