<?php
namespace Geos\GeoEntityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AjaxQueryController extends Controller {
	
	/**
	 * @todo A completer
	 * @Route("/getCommuneList", name="_getCommuneList")
	 */
	public function getEntityList(){
		
		$this->em = $this->get('doctrine')->getEntityManager();
		$html = '';
		
		$data = $this->get('request')->query->get('data');
		$dataType = $this->get('request')->query->get('datatype');
		
		if($dataType == "petype" || $dataType == "utility" ){
			
			if($data=="branchement" || $data=="domestique" ){
								
				$this->repository = $this->em->getRepository('GeosGeoEntityBundle:Parcelle');
				$parcelles = $this->repository->findAll(array('numero'=>'ASC'));
				
				if (isset($parcelles)) {
					foreach($parcelles as $parcelle)
					{
						$html = $html.sprintf("<option value=\"%d\">%s</option>",$parcelle->getId(),$parcelle);
					}
				}
			}
			elseif ($data=="pmh" || $data=="pem" || $data=="borne fontaine" || $data=="communautaire"){
				$this->repository = $this->em->getRepository('GeosGeoEntityBundle:Commune');
				$communes = $this->repository->findAll(array('nom'=>'ASC'));
				
				if (isset($communes)) {
					foreach($communes as $commune)
					{
						$html = $html.sprintf("<option value=\"%d\">%s</option>",$commune->getId(),$commune);
					}
				}
			}			
			else{
				$html = '<option value="type">'.$data.'</option>';
			}
		}
		elseif ($dataType == "entitytype"){
			if($data == "poi"){				
				$html = '<option value="pointeau">Point d\'eau</option>
						 <option value="ouvrageass">Ouvrage d\'assainissement</option>
						';				
			}
			elseif($data == "zoi"){
				$html = '<option value="region">Region</option>
						 <option value="province">Province</option>
						 <option value="commune">Commune</option>
						 <option value="section">Section</option>
						 <option value="lot">Lot</option>
						 <option value="parcelle">Parcelle</option>
				';			
			}
			elseif($data == "entityType"){
				$html = '<option value="Choix">Choix</option>';
			}
				
		}
		else{
			$html = '<option value="type">'.$dataType.'</option>';
		}
		
		return new Response($html);
	}
	
	/**
	 * @todo A completer
	 * @Route("/getProvincesByRegion", name="_getProvincesByRegion")
	 */
	
	public function getProvincesByRegion(){
	
		$this->em = $this->get('doctrine')->getEntityManager();
		$this->repository = $this->em->getRepository('GeosGeoEntityBundle:Region');
	
		$entityId = $this->get('request')->query->get('data');
		
		$entity = $this->repository->findOneBy(array('id'=>$entityId));
		$entities = $entity->getProvinces();
		
		$html = "<option value = '' >  choisir une province</option>";
		if (empty($entities)) {
			return new Response($html);
		}
	
		foreach($entities as $entity)
		{
			$html = $html . sprintf("<option value=\"%d\">%s</option>",$entity->getId(), $entity->getNom());
		}
	
		return new Response($html);
	}
	
	/**
	 * @todo A completer
	 * @Route("/getCommunesByProvince", name="_getCommunesByProvince")
	 */
	
	public function getCommunesByProvince(){
	
		$this->em = $this->get('doctrine')->getEntityManager();
		$this->repository = $this->em->getRepository('GeosGeoEntityBundle:Province');
	
		$entityId = $this->get('request')->query->get('data');
	
		$entity = $this->repository->findOneBy(array('id'=>$entityId));
		$entities = $entity->getCommunes();
	
		$html = "<option value = '' >  choisir une commune</option>";
		if (empty($entities)) {
			return new Response($html);
		}
	
		foreach($entities as $entity)
		{
			$html = $html . sprintf("<option value=\"%d\">%s</option>",$entity->getId(), $entity->getNom());
		}
	
		return new Response($html);
	}
	
	
	/**
	 * @todo A completer
	 * @Route("/getSectionsByCommune", name="_getSectionsByCommune")
	 */
	
	public function getSectionsByCommune(){
	
		$this->em = $this->get('doctrine')->getEntityManager();
		$this->repository = $this->em->getRepository('GeosGeoEntityBundle:Commune');
	
		$entityId = $this->get('request')->query->get('data');
	
		$entity = $this->repository->findOneBy(array('id'=>$entityId));
		$entities = $entity->getSections();
	
		$html = "<option value = '' > choisir une section</option>";
		if (empty($entities)) {
			return new Response($html);
		}
	
		foreach($entities as $entity)
		{
			$html = $html . sprintf("<option value=\"%d\">%s</option>",$entity->getId(), $entity->getNumero());
		}
	
		return new Response($html);
	}
	
	/**
	 * @todo A completer
	 * @Route("/getLotsBySection", name="_getLotsBySection")
	 */
	
	public function getLotsBySection(){
	
		$this->em = $this->get('doctrine')->getEntityManager();
		$this->repository = $this->em->getRepository('GeosGeoEntityBundle:Section');
	
		$entityId = $this->get('request')->query->get('data');
	
		$entity = $this->repository->findOneBy(array('id'=>$entityId));
		$entities = $entity->getLots();
	
		$html = "<option value = '' > choisir un lot</option>";
		if (empty($entities)) {
			return new Response($html);
		}
	
		foreach($entities as $entity)
		{
			$html = $html . sprintf("<option value=\"%d\">%s</option>",$entity->getId(), $entity->getNumero());
		}
	
		return new Response($html);
	}
	
	/**
	 * @todo A completer
	 * @Route("/getParcellesByLot", name="_getParcellesByLot")
	 */
	
	public function getParcellesByLot(){
	
		$this->em = $this->get('doctrine')->getEntityManager();
		$this->repository = $this->em->getRepository('GeosGeoEntityBundle:Lot');
	
		$entityId = $this->get('request')->query->get('data');
	
		$entity = $this->repository->findOneBy(array('id'=>$entityId));
		$entities = $entity->getParcelles();
	
		$html = "<option value = '' > choisir une parcelle</option>";
		if (empty($entities)) {
			return new Response($html);
		}
	
		foreach($entities as $entity)
		{
			$html = $html . sprintf("<option value=\"%d\">%s</option>",$entity->getId(), $entity->getNumero());
		}
	
		return new Response($html);
	}
	
	/**
	 * Retourne les entités d'un type de zone
	 * @Route("/getZoneTypeEntities", name="_getZoneTypeEntities")
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	
	public function getZoneTypeEntities(){
	
		$em = $this->getDoctrine()->getEntityManager();
		
	
		$zoneType = $this->get('request')->query->get('data');
		
		if ($zoneType == "commune") 
			$entities = $em->getRepository('GeosGeoEntityBundle:Commune')->findAll();
		elseif ($zoneType == "province")
			$entities = $em->getRepository('GeosGeoEntityBundle:Province')->findAll();
		elseif ($zoneType == "region") 
			$entities = $em->getRepository('GeosGeoEntityBundle:Region')->findAll();

	
		$html = "<option value = '' disabled='disabled' > choisir ...</option>";
		
		if (empty($entities)) {
			return new Response($html);
		}
	
		foreach($entities as $entity)
		{
			$html = $html.sprintf("<option value=\"%d\">%s</option>",$entity->getId(), $entity->getNom());
		}
	
		return new Response($html);
	}
		
}
