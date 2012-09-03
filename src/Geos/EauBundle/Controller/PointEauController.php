<?php

namespace Geos\EauBundle\Controller;

use Geos\MainBundle\Form\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
	Geos\EauBundle\Entity\PointEau,
	Geos\GeoEntityBundle\Form\ZoiType,
	Geos\EauBundle\Form\PointEauType,
	Geos\GeoEntityBundle\Lib\Geolib,
	Geos\MainBundle\Form\indicateurParameterType;

/**
 * PointEau controller.
 *
 * @Route("/pointeau")
 */
class PointEauController extends Controller
{
    /**
     * Lists all PointEau entities.
     * @Route("/", name="pointeau")
     * @Template()
     */
    public function indexAction()
    {
        
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT pe FROM GeosEauBundle:PointEau pe";
    	$query = $em->createQuery($dql);
    	
    	$paginator = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
    			$query,
    			$this->get('request')->query->get('page', 1)/*page number*/,
    			10/*limit per page*/
    	);

    	return compact('pagination');
    	
    }

    /**
     * Finds and displays a PointEau entity.
     *
     * @Route("/{id}/show", name="pointeau_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosEauBundle:PointEau')->find($id);        
        $entitiesList[] = $entity; 
        
        $markers = $this->get("geolib")->getMarkers($entitiesList);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PointEau entity.');
        }
		
        print_r($markers);
        
        return array(
            'entity'      => $entity,
        	'mapcenter'   => $markers['mapCenter'],
	       	'scale'		  => $markers['scale'],
        	'covers'	  => '',
        	'markers'	  => $markers['markers'], //très important à ne pas supprimer
        	//'test' => $markers
       );
    }

    /**
     * Displays a form to create a new PointEau entity.
     *
     * @Route("/new", name="pointeau_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PointEau();
        $form   = $this->createForm(new PointEauType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new PointEau entity.
     * @todo structure de controle 'if' enlever
     * @Route("/create", name="pointeau_create")
     * @Method("post")
     * @Template("GeosEauBundle:PointEau:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new PointEau();
        $request = $this->getRequest();
        $form    = $this->createForm(new PointEauType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('pointeau_show', array('id' => $entity->getId())));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing PointEau entity.
     *
     * @Route("/{id}/edit", name="pointeau_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEauBundle:PointEau')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PointEau entity.');
        }

        $editForm = $this->createForm(new PointEauType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	'message'     => '',
        );
    }

    /**
     * Edits an existing PointEau entity.
     *
     * @Route("/{id}/update", name="pointeau_update")
     * @Method("post")
     * @Template("GeosEauBundle:PointEau:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosEauBundle:PointEau')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PointEau entity.');
        }
        
        $editForm   = $this->createForm(new PointEauType(), $entity);
       
        $request = $this->getRequest();
        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('pointeau_show', array('id' => $entity->getId())));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a PointEau entity.
     *
     * @Route("/{id}/delete", name="pointeau_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosEauBundle:PointEau')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PointEau entity.');
        }
        
        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('pointeau'));
    }
    
	/**
	 * Affiche la page de presentation d'un indicateur : Nombre de branchement pour un type de zone donné
	 * @Route("/nbreBranchementPage", name="pointeau_nbre_branchement_page")
	 * @Method("get")
	 * @Template()
	 */
    
    public function nbreBranchementPageAction(){
    	
    	$form = $this->createForm(new indicateurParameterType());
    	
    	return array(
    			'form' => $form->createView(),
    			'covers' =>'',
    			'table' => '',    			
    			);
    }
    
	/**
	 * Affiche la page de presentation d'un indicateur : Nombre de borne fontaine pour un type de zone donné
	 * @Route("/nbreBorneFontainePage", name="pointeau_nbre_borne_fontaine_page")
	 * @Method("get")
	 * @Template()
	 * @return multitype:string \Symfony\Component\Form\FormView
	 */
    
    public function nbreBorneFontainePageAction(){
    	$form = $this->createForm(new indicateurParameterType());
    	
    	return array (
    			'form'=>$form->createView(),
    			'covers' => '',
    			'table' => '',
    			);
    }
    
    /**
     * Affiche la page de presentation d'un indicateur : Nombre de PEM pour un type de zone donné
     * @Route("/nbrePemPage", name="pointeau_nbre_pem_page")
     * @Method("get")
     * @Template()
     * @return multitype:string \Symfony\Component\Form\FormView
     */
    public function nbrePemPageAction(){
    	$form = $this->createForm(new indicateurParameterType());
    
    	return array (
    			'form'=>$form->createView(),
    			'covers' => '',
    			'table' => '',
    	);
    }
    
    /**
     * Affiche la page de presentation d'un indicateur : Nombre de PMH pour un type de zone donné
     * @Route("/nbrePmhPage", name="pointeau_nbre_pmh_page")
     * @Method("get")
     * @Template()
     * @return multitype:string \Symfony\Component\Form\FormView	
	 */    
    public function nbrePmhPageAction(){
    	$form = $this->createForm(new indicateurParameterType());
    	 
    	return array (
    			'form'=>$form->createView(),
    			'covers' => '',
    			'table' => '',
    	);
    }
    
    
    /**
     * @Route("nbreBranchementPost", name="pointeau_nbre_branchement_post")
     * @Method("post")
     * @Template("GeosEauBundle:PointEau:nbreBranchementPage.html.twig")
     */
    
    public function nbreBranchementPostAction(){
    	
  	
    	$form = $this->createForm(new indicateurParameterType());
    	
    	$request = $this->getRequest();
    	$form->bindRequest($request);
    	
    	$data = $form->getData();
    	
    	$interval = $data['interval'];
    	$date = $data["dateDebut"];
    	$occurences = $data['occurences'];
    	$hierarchie = $data['hierarchie'];
    	$zone = $data['zone'];
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$queryData = $em->getRepository('GeosEauBundle:PointEau')->findNbreBranchement($interval, $date, $occurences, $hierarchie , $zone);
    	
    	$table = $queryData['table']; 	
    	
    	return array (
    		'form' => $form->createView(),
    		'covers' =>'',
    		'table'=>$table,
    	);
    	
    }
    
    /**
     * @Route("nbreBorneFontainePost", name="pointeau_nbre_borne_fontaine_post")
     * @Method("post")
     * @Template("GeosEauBundle:PointEau:nbreBorneFontainePage.html.twig")
     */
    
    public function nbreBorneFontainePostAction(){    	 
    	 
    	$form = $this->createForm(new indicateurParameterType());
    	 
    	$request = $this->getRequest();
    	$form->bindRequest($request);
    	 
    	$data = $form->getData();
    	 
    	$interval = $data['interval'];
    	$date = $data["dateDebut"];
    	$occurences = $data['occurences'];
    	$hierarchie = $data['hierarchie'];
    	$zone = $data['zone'];
    	 
    	$em = $this->getDoctrine()->getEntityManager();
    	 
    	$queryData = $em->getRepository('GeosEauBundle:PointEau')->findNbreBorneFontaine($interval, $date, $occurences, $hierarchie , $zone);
    	 
    	$table = $queryData['table'];
    	 
    	return array (
    			'form' => $form->createView(),
    			'covers' =>'',
    			'table'=>$table,
    	);    	 
    }
    
    /**
     * @Route("nbrePemPost", name="pointeau_nbre_pem_post")
     * @Method("post")
     * @Template("GeosEauBundle:PointEau:nbrePemPage.html.twig")
     */
    
    public function nbrePemPostAction(){
    
    	$form = $this->createForm(new indicateurParameterType());
    
    	$request = $this->getRequest();
    	$form->bindRequest($request);
    
    	$data = $form->getData();
    
    	$interval = $data['interval'];
    	$date = $data["dateDebut"];
    	$occurences = $data['occurences'];
    	$hierarchie = $data['hierarchie'];
    	$zone = $data['zone'];
    
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$queryData = $em->getRepository('GeosEauBundle:PointEau')->findNbrePem($interval, $date, $occurences, $hierarchie , $zone);
    
    	$table = $queryData['table'];
    
    	return array (
    			'form' => $form->createView(),
    			'covers' =>'',
    			'table'=>$table,
    	);
    }
    
    /**
     * @Route("nbrePmhPost", name="pointeau_nbre_pmh_post")
     * @Method("post")
     * @Template("GeosEauBundle:PointEau:nbrePmhPostPage.html.twig")
     */
    
    public function nbrePmhPostAction(){
    
    	$form = $this->createForm(new indicateurParameterType());
    
    	$request = $this->getRequest();
    	$form->bindRequest($request);
    
    	$data = $form->getData();
    
    	$interval = $data['interval'];
    	$date = $data["dateDebut"];
    	$occurences = $data['occurences'];
    	$hierarchie = $data['hierarchie'];
    	$zone = $data['zone'];
    
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$queryData = $em->getRepository('GeosEauBundle:PointEau')->findNbrePmh($interval, $date, $occurences, $hierarchie , $zone);
    
    	$table = $queryData['table'];
    
    	return array (
    			'form' => $form->createView(),
    			'covers' =>'',
    			'table'=>$table,
    	);
    }
    
    
    

}
