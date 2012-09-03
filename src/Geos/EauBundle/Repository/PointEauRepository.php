<?php

namespace Geos\EauBundle\Repository;

use Geos\MainBundle\Lib\StatLib;

use Geos\GeoEntityBundle\Lib\Geolib;

use Doctrine\ORM\EntityRepository;

/**
 * PointEauRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PointEauRepository extends EntityRepository
{
	
	/**
	 * Indicateur du nombre de branchement par zone et par periode
	 * @version 0.0
	 * @param unknown_type $interval, unknown_type $date, unknown_type $occurences, unknown_type $hierarchie, unknown_type $zone, multitype:string unknown
	 */
	public function findNbreBranchement($interval = 'annuel',$date, $occurences = 10, $hierarchie = 'Commune', $zones ){
	
	//Variables utiliser dans la methode	
	$em = $this->getEntityManager();
	$zoneId = "'-1'"; // Liste des id des zones		
	$table = array(); //Tableaux contenant les valeurs de l'indication par zone et par date
	$periodArray = array(); // Tableau des périodes
	$covers = 'temp';
	$indicCodeColor = new StatLib();
	
	// parametre de date
	if($interval =="journalier")
		$dateInterval = new \DateInterval("P1D");
	elseif ($interval == "bimensuel")
		$dateInterval = new \DateInterval("P15D");
	elseif ($interval == "mensuel")
		$dateInterval = new \DateInterval("P1M");
	elseif ($interval == "trimestriel")
		$dateInterval = new \DateInterval("P3M");
	elseif ($interval == "semestriel")
		$dateInterval = new \DateInterval("P6M");
	elseif ($interval == "annuel")
		$dateInterval = new \DateInterval("P1Y");
	
	$dateDebut = $date->sub($dateInterval);	
	$period = new \DatePeriod($dateDebut,$dateInterval,$occurences);
	
	foreach ($period as $dt ) {
		$periodArray [] = $dt;
	}
	// fin parametre de date
	

	// Construction d'une partie de la requete sql : Definition des Entités de zones participant à la requete
	if($hierarchie == 'region')	{
		$dqlPart = "GeosGeoEntityBundle:Region r JOIN r.provinces pr JOIN pr.communes c";
		$dqlPart1 = "r";
	}
	elseif($hierarchie == 'province'){
		$dqlPart = "GeosGeoEntityBundle:Province pr JOIN pr.communes c";
		$dqlPart1 = "pr";
	}
	elseif($hierarchie == 'commune'){
		$dqlPart = "GeosGeoEntityBundle:Commune c";
		$dqlPart1 = "c";
	}
	// Fin de la construction
	
	//liste de zones
	foreach ($zones as $zone) {
		$zoneId = $zoneId.",".$zone->getId();
		
		$table['zone'][]= array ("zoneName"=>$zone->getNom(),				
						  "zoneId"=>$zone->getId(),
						  "coord"=> Geolib::getPolygonStatic($zone->getGeometrie()),
						  "indic"=>array());		
	}
	$zoneId = "(".$zoneId.")";
	//Fin
	   
	//Requete
	for($i=1;$i<(count($periodArray));$i++){		
		
		$dtStart = $periodArray[$i-1];
		$dtEnd = $periodArray[$i];		
			
		$query = $em->createQuery("SELECT ".$dqlPart1.".id as zoneId, count(br.id) as indic 
								  FROM ".$dqlPart." JOIN c.sections s JOIN s.lots l JOIN l.parcelles p JOIN p.pois pe , GeosEauBundle:PointEau br
								  WHERE  (pe.id = br.id) AND (".$dqlPart1.".id IN ".$zoneId.") AND br.peType = 'branchement' AND (br.dateMes BETWEEN '".$dtStart->format("Y-m-d")."' AND '".$dtEnd->format("Y-m-d")."') GROUP BY ".$dqlPart1.".id");
		$qR = $query->getResult();			
		
		foreach ($table['zone'] as $key => $row){
			
			$indic = array('value'=>'0', 'colorCode'=>'#ef2929');			
			if($qR!=null){
				// tri
				foreach ($qR as $valeur) $indicTab[] = $valeur['indic'];
								
				$indicCodeColor->setMaxValue(max($indicTab));
				
				foreach ($qR as $q) {	
					if($q["zoneId"]===$row["zoneId"]){					
						$indic['value'] = $q["indic"]; $indic['colorCode'] = $indicCodeColor->getColorCode($q["indic"]);						
					}
				}
			}			
			$table['zone'][$key]["indic"][$i-1]= $indic;
		}
		
		if($interval =="journalier" || $interval =="bimensuel")	$periodString[$i-1]['value'] = $dtEnd->format("d M Y");
		elseif ($interval == "mensuel"||$interval == "trimestriel"||$interval == "semestriel")	$periodString[$i-1]['value'] = $dtEnd->format("M Y");
		elseif ($interval == "annuel")	$periodString[$i-1]['value'] = $dtEnd->format("Y");
			
		$periodString[$i-1]['legende'] = $indicCodeColor->getLegend();
	}	
	
	$table["periode"] = $periodString;	

	return array('table' => $table);
	
	}
	
	/**
	 * Indicateur du nombre de branchement par zone et par periode
	 * @version 0.0
	 * @FIXME Voir pour les valeurs de retour du tableau
	 * @param unknown_type $interval, unknown_type $date, unknown_type $occurences, unknown_type $hierarchie, unknown_type $zone, multitype:string unknown
	 */
	public function findNbreBorneFontaine($interval = 'annuel',$date, $occurences = 10, $hierarchie = 'Commune', $zones ){
	
		//Variables utiliser dans la methode
		$em = $this->getEntityManager();
		$zoneId = "'-1'"; // Liste des id des zones
		$table = array(); //Tableaux contenant les valeurs de l'indication par zone et par date
		$periodArray = array(); // Tableau des périodes
		$covers = 'temp';
		$indicCodeColor = new StatLib();
	
		// parametre de date
		if($interval =="journalier")
			$dateInterval = new \DateInterval("P1D");
		elseif ($interval == "bimensuel")
		$dateInterval = new \DateInterval("P15D");
		elseif ($interval == "mensuel")
		$dateInterval = new \DateInterval("P1M");
		elseif ($interval == "trimestriel")
		$dateInterval = new \DateInterval("P3M");
		elseif ($interval == "semestriel")
		$dateInterval = new \DateInterval("P6M");
		elseif ($interval == "annuel")
		$dateInterval = new \DateInterval("P1Y");
	
		$dateDebut = $date->sub($dateInterval);
		$period = new \DatePeriod($dateDebut,$dateInterval,$occurences);
	
		foreach ($period as $dt ) {
			$periodArray [] = $dt;
		}
		// fin parametre de date
	
	
		// Construction d'une partie de la requete sql : Definition des Entités de zones participant à la requete
		if($hierarchie == 'region')	{
			$dqlPart = "GeosGeoEntityBundle:Region r JOIN r.provinces pr JOIN pr.communes c";
			$dqlPart1 = "r";
		}
		elseif($hierarchie == 'province'){
			$dqlPart = "GeosGeoEntityBundle:Province pr JOIN pr.communes c";
			$dqlPart1 = "pr";
		}
		elseif($hierarchie == 'commune'){
			$dqlPart = "GeosGeoEntityBundle:Commune c";
			$dqlPart1 = "c";
		}
		// Fin de la construction
	
		//liste de zones
		foreach ($zones as $zone) {
			$zoneId = $zoneId.",".$zone->getId();
	
			$table['zone'][]= array ("zoneName"=>$zone->getNom(),
					"zoneId"=>$zone->getId(),
					"coord"=> Geolib::getPolygonStatic($zone->getGeometrie()),
					"indic"=>array());
		}
		$zoneId = "(".$zoneId.")";
		//Fin
	
		//Requete
		for($i=1;$i<(count($periodArray));$i++){
	
			$dtStart = $periodArray[$i-1];
			$dtEnd = $periodArray[$i];
				
			$query = $em->createQuery("SELECT ".$dqlPart1.".id as zoneId, count(bf.id) as indic
					FROM ".$dqlPart." JOIN  c.pois pe , GeosEauBundle:PointEau bf
					WHERE  (pe.id = bf.id) AND (".$dqlPart1.".id IN ".$zoneId.") AND bf.peType = 'borne fontaine' AND (bf.dateMes BETWEEN '".$dtStart->format("Y-m-d")."' AND '".$dtEnd->format("Y-m-d")."') GROUP BY ".$dqlPart1.".id");
			$qR = $query->getResult();
	
			foreach ($table['zone'] as $key => $row){
					
				$indic = array('value'=>'0', 'colorCode'=>'#ef2929');
				if($qR!=null){
					// tri
					foreach ($qR as $valeur) $indicTab[] = $valeur['indic'];
	
					$indicCodeColor->setMaxValue(max($indicTab));
	
					foreach ($qR as $q) {
						if($q["zoneId"]===$row["zoneId"]){
							$indic['value'] = $q["indic"]; $indic['colorCode'] = $indicCodeColor->getColorCode($q["indic"]);
						}
					}
				}
				$table['zone'][$key]["indic"][$i-1]= $indic;
			}
	
			if($interval =="journalier" || $interval =="bimensuel")	$periodString[$i-1]['value'] = $dtEnd->format("d M Y");
			elseif ($interval == "mensuel"||$interval == "trimestriel"||$interval == "semestriel")	$periodString[$i-1]['value'] = $dtEnd->format("M Y");
			elseif ($interval == "annuel")	$periodString[$i-1]['value'] = $dtEnd->format("Y");
				
			$periodString[$i-1]['legende'] = $indicCodeColor->getLegend();
		}
	
		$table["periode"] = $periodString;
	
		return array('table' => $table);
	
	}
	
	public function findNbrePmh($interval = 'annuel',$date, $occurences = 10, $hierarchie = 'Commune', $zones ){
	
		//Variables utiliser dans la methode
		$em = $this->getEntityManager();
		$zoneId = "'-1'"; // Liste des id des zones
		$table = array(); //Tableaux contenant les valeurs de l'indication par zone et par date
		$periodArray = array(); // Tableau des périodes
		$covers = 'temp';
		$indicCodeColor = new StatLib();
	
		// parametre de date
		if($interval =="journalier")
			$dateInterval = new \DateInterval("P1D");
		elseif ($interval == "bimensuel")
		$dateInterval = new \DateInterval("P15D");
		elseif ($interval == "mensuel")
		$dateInterval = new \DateInterval("P1M");
		elseif ($interval == "trimestriel")
		$dateInterval = new \DateInterval("P3M");
		elseif ($interval == "semestriel")
		$dateInterval = new \DateInterval("P6M");
		elseif ($interval == "annuel")
		$dateInterval = new \DateInterval("P1Y");
	
		$dateDebut = $date->sub($dateInterval);
		$period = new \DatePeriod($dateDebut,$dateInterval,$occurences);
	
		foreach ($period as $dt ) {
			$periodArray [] = $dt;
		}
		// fin parametre de date
	
	
		// Construction d'une partie de la requete sql : Definition des Entités de zones participant à la requete
		if($hierarchie == 'region')	{
			$dqlPart = "GeosGeoEntityBundle:Region r JOIN r.provinces pr JOIN pr.communes c";
			$dqlPart1 = "r";
		}
		elseif($hierarchie == 'province'){
			$dqlPart = "GeosGeoEntityBundle:Province pr JOIN pr.communes c";
			$dqlPart1 = "pr";
		}
		elseif($hierarchie == 'commune'){
			$dqlPart = "GeosGeoEntityBundle:Commune c";
			$dqlPart1 = "c";
		}
		// Fin de la construction
	
		//liste de zones
		foreach ($zones as $zone) {
			$zoneId = $zoneId.",".$zone->getId();
	
			$table['zone'][]= array ("zoneName"=>$zone->getNom(),
					"zoneId"=>$zone->getId(),
					"coord"=> Geolib::getPolygonStatic($zone->getGeometrie()),
					"indic"=>array());
		}
		$zoneId = "(".$zoneId.")";
		//Fin
	
		//Requete
		for($i=1;$i<(count($periodArray));$i++){
	
			$dtStart = $periodArray[$i-1];
			$dtEnd = $periodArray[$i];
	
			$query = $em->createQuery("SELECT ".$dqlPart1.".id as zoneId, count(bf.id) as indic
					FROM ".$dqlPart." JOIN  c.pois pe , GeosEauBundle:PointEau bf
					WHERE  (pe.id = bf.id) AND (".$dqlPart1.".id IN ".$zoneId.") AND bf.peType = 'pmh' AND (bf.dateMes BETWEEN '".$dtStart->format("Y-m-d")."' AND '".$dtEnd->format("Y-m-d")."') GROUP BY ".$dqlPart1.".id");
			$qR = $query->getResult();
	
			foreach ($table['zone'] as $key => $row){
					
				$indic = array('value'=>'0', 'colorCode'=>'#ef2929');
				if($qR!=null){
					// tri
					foreach ($qR as $valeur) $indicTab[] = $valeur['indic'];
	
					$indicCodeColor->setMaxValue(max($indicTab));
	
					foreach ($qR as $q) {
						if($q["zoneId"]===$row["zoneId"]){
							$indic['value'] = $q["indic"]; $indic['colorCode'] = $indicCodeColor->getColorCode($q["indic"]);
						}
					}
				}
				$table['zone'][$key]["indic"][$i-1]= $indic;
			}
	
			if($interval =="journalier" || $interval =="bimensuel")	$periodString[$i-1]['value'] = $dtEnd->format("d M Y");
			elseif ($interval == "mensuel"||$interval == "trimestriel"||$interval == "semestriel")	$periodString[$i-1]['value'] = $dtEnd->format("M Y");
			elseif ($interval == "annuel")	$periodString[$i-1]['value'] = $dtEnd->format("Y");
	
			$periodString[$i-1]['legende'] = $indicCodeColor->getLegend();
		}
	
		$table["periode"] = $periodString;
	
		return array('table' => $table);
	
	}

	public function findNbrePem($interval = 'annuel',$date, $occurences = 10, $hierarchie = 'Commune', $zones ){
	
		//Variables utiliser dans la methode
		$em = $this->getEntityManager();
		$zoneId = "'-1'"; // Liste des id des zones
		$table = array(); //Tableaux contenant les valeurs de l'indication par zone et par date
		$periodArray = array(); // Tableau des périodes
		$covers = 'temp';
		$indicCodeColor = new StatLib();
	
		// parametre de date
		if($interval =="journalier")
			$dateInterval = new \DateInterval("P1D");
		elseif ($interval == "bimensuel")
		$dateInterval = new \DateInterval("P15D");
		elseif ($interval == "mensuel")
		$dateInterval = new \DateInterval("P1M");
		elseif ($interval == "trimestriel")
		$dateInterval = new \DateInterval("P3M");
		elseif ($interval == "semestriel")
		$dateInterval = new \DateInterval("P6M");
		elseif ($interval == "annuel")
		$dateInterval = new \DateInterval("P1Y");
	
		$dateDebut = $date->sub($dateInterval);
		$period = new \DatePeriod($dateDebut,$dateInterval,$occurences);
	
		foreach ($period as $dt ) {
			$periodArray [] = $dt;
		}
		// fin parametre de date
	
	
		// Construction d'une partie de la requete sql : Definition des Entités de zones participant à la requete
		if($hierarchie == 'region')	{
			$dqlPart = "GeosGeoEntityBundle:Region r JOIN r.provinces pr JOIN pr.communes c";
			$dqlPart1 = "r";
		}
		elseif($hierarchie == 'province'){
			$dqlPart = "GeosGeoEntityBundle:Province pr JOIN pr.communes c";
			$dqlPart1 = "pr";
		}
		elseif($hierarchie == 'commune'){
			$dqlPart = "GeosGeoEntityBundle:Commune c";
			$dqlPart1 = "c";
		}
		// Fin de la construction
	
		//liste de zones
		foreach ($zones as $zone) {
			$zoneId = $zoneId.",".$zone->getId();
	
			$table['zone'][]= array ("zoneName"=>$zone->getNom(),
					"zoneId"=>$zone->getId(),
					"coord"=> Geolib::getPolygonStatic($zone->getGeometrie()),
					"indic"=>array());
		}
		$zoneId = "(".$zoneId.")";
		//Fin
	
		//Requete
		for($i=1;$i<(count($periodArray));$i++){
	
			$dtStart = $periodArray[$i-1];
			$dtEnd = $periodArray[$i];
	
			$query = $em->createQuery("SELECT ".$dqlPart1.".id as zoneId, count(bf.id) as indic
					FROM ".$dqlPart." JOIN  c.pois pe , GeosEauBundle:PointEau bf
					WHERE  (pe.id = bf.id) AND (".$dqlPart1.".id IN ".$zoneId.") AND bf.peType = 'pem' AND (bf.dateMes BETWEEN '".$dtStart->format("Y-m-d")."' AND '".$dtEnd->format("Y-m-d")."') GROUP BY ".$dqlPart1.".id");
			$qR = $query->getResult();
	
			foreach ($table['zone'] as $key => $row){
					
				$indic = array('value'=>'0', 'colorCode'=>'#ef2929');
				if($qR!=null){
					// tri
					foreach ($qR as $valeur) $indicTab[] = $valeur['indic'];
	
					$indicCodeColor->setMaxValue(max($indicTab));
	
					foreach ($qR as $q) {
						if($q["zoneId"]===$row["zoneId"]){
							$indic['value'] = $q["indic"]; $indic['colorCode'] = $indicCodeColor->getColorCode($q["indic"]);
						}
					}
				}
				$table['zone'][$key]["indic"][$i-1]= $indic;
			}
	
			if($interval =="journalier" || $interval =="bimensuel")	$periodString[$i-1]['value'] = $dtEnd->format("d M Y");
			elseif ($interval == "mensuel"||$interval == "trimestriel"||$interval == "semestriel")	$periodString[$i-1]['value'] = $dtEnd->format("M Y");
			elseif ($interval == "annuel")	$periodString[$i-1]['value'] = $dtEnd->format("Y");
	
			$periodString[$i-1]['legende'] = $indicCodeColor->getLegend();
		}
	
		$table["periode"] = $periodString;
	
		return array('table' => $table);
	
	}
	
}