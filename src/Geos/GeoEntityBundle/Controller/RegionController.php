<?php

namespace Geos\GeoEntityBundle\Controller;

use Geos\GeoEntityBundle\Lib\Geolib;
use Geos\MainBundle\Form\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\GeoEntityBundle\Entity\Region;
use Geos\GeoEntityBundle\Form\RegionType;

/**
 * Region controller.
 *
 * @Route("/region")
 */
class RegionController extends Controller
{
    /**
     * Lists all Region entities.
     *
     * @Route("/", name="region")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT region FROM GeosGeoEntityBundle:Region region ORDER BY region.nom ASC";
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
     * Finds and displays a Region entity.
     *
     * @Route("/{id}/show", name="region_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosGeoEntityBundle:Region')->find($id);
		
        $entitiesList[] = $entity;
        
        $markers = $this->get("geolib")->getCovers($entitiesList);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }


        return array(
	            'entity'      => $entity,
	        	'mapcenter'   => $markers['mapCenter'],
		       	'scale'		  => $markers['scale'],
	        	'markers'	  => $markers['markers'],
	        	'covers'	  => $markers['covers'],  
        		);
    }

    /**
     * Displays a form to create a new Region entity.
     *
     * @Route("/new", name="region_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Region();
        $form   = $this->createForm(new RegionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Region entity.
     *
     * @Route("/create", name="region_create")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Region:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Region();
        $request = $this->getRequest();
        $form    = $this->createForm(new RegionType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();
        return $this->redirect($this->generateUrl('region_show', array('id' => $entity->getId())));
 

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Region entity.
     *
     * @Route("/{id}/edit", name="region_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $editForm = $this->createForm(new RegionType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Region entity.
     *
     * @Route("/{id}/update", name="region_update")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Region:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $editForm   = $this->createForm(new RegionType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('region_show', array('id' => $entity->getId())));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Region entity.
     *
     * @Route("/{id}/delete", name="region_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosGeoEntityBundle:Region')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Region entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('region'));
    }

}
