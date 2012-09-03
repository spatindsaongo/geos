<?php

namespace Geos\GeoEntityBundle\Controller;

use Geos\GeoEntityBundle\Lib\Geolib;
use Geos\MainBundle\Form\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\GeoEntityBundle\Entity\Lot;
use Geos\GeoEntityBundle\Form\LotType;

/**
 * Lot controller.
 *
 * @Route("/lot")
 */
class LotController extends Controller
{
    /**
     * Lists all Lot entities.
     *
     * @Route("/", name="lot")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT lot FROM GeosGeoEntityBundle:Lot lot ORDER BY lot.numero ASC";
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
     * Finds and displays a Lot entity.
     *
     * @Route("/{id}/show", name="lot_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosGeoEntityBundle:Lot')->find($id);

        $entitiesList[] = $entity;
        
        $markers = $this->get("geolib")->getCovers($entitiesList);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commune entity.');
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
     * Displays a form to create a new Lot entity.
     *
     * @Route("/new", name="lot_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lot();
        $form   = $this->createForm(new LotType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Lot entity.
     *
     * @Route("/create", name="lot_create")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Lot:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Lot();
        $request = $this->getRequest();
        $form    = $this->createForm(new LotType(), $entity);
        $form->bindRequest($request);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lot_show', array('id' => $entity->getId())));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Lot entity.
     *
     * @Route("/{id}/edit", name="lot_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Lot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lot entity.');
        }

        $editForm = $this->createForm(new LotType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Lot entity.
     *
     * @Route("/{id}/update", name="lot_update")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Lot:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Lot')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lot entity.');
        }

        $editForm   = $this->createForm(new LotType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);


            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lot_show', array('id' => $entity->getId())));


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Lot entity.
     *
     * @Route("/{id}/delete", name="lot_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosGeoEntityBundle:Lot')->find($id);

        if (!$entity) {
        	throw $this->createNotFoundException('Unable to find Lot entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('lot'));
    }

}
