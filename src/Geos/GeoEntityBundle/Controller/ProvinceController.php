<?php

namespace Geos\GeoEntityBundle\Controller;

use Geos\GeoEntityBundle\Lib\Geolib;
use Geos\MainBundle\Form\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\GeoEntityBundle\Entity\Province;
use Geos\GeoEntityBundle\Form\ProvinceType;

/**
 * Province controller.
 *
 * @Route("/province")
 */
class ProvinceController extends Controller
{
    /**
     * Lists all Province entities.
     *
     * @Route("/", name="province")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT province FROM GeosGeoEntityBundle:Province province ORDER BY province.nom ASC ";
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
     * Finds and displays a Province entity.
     *
     * @Route("/{id}/show", name="province_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosGeoEntityBundle:Province')->find($id);

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
     * Displays a form to create a new Province entity.
     *
     * @Route("/new", name="province_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Province();
        $form   = $this->createForm(new ProvinceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Province entity.
     *
     * @Route("/create", name="province_create")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Province:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Province();
        $request = $this->getRequest();
        $form    = $this->createForm(new ProvinceType(), $entity);
        $form->bindRequest($request);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('province_show', array('id' => $entity->getId())));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Province entity.
     *
     * @Route("/{id}/edit", name="province_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Province')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Province entity.');
        }

        $editForm = $this->createForm(new ProvinceType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Province entity.
     *
     * @Route("/{id}/update", name="province_update")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Province:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Province')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Province entity.');
        }

        $editForm   = $this->createForm(new ProvinceType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('province_show', array('id' => $entity->getId())));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Province entity.
     *
     * @Route("/{id}/delete", name="province_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {

            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GeosGeoEntityBundle:Province')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Province entity.');
            }

            $em->remove($entity);
            $em->flush();
 
        return $this->redirect($this->generateUrl('province'));
    }

}
