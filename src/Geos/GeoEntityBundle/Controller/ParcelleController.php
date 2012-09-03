<?php

namespace Geos\GeoEntityBundle\Controller;

use Geos\GeoEntityBundle\Lib\Geolib;
use Geos\MainBundle\Form\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\GeoEntityBundle\Entity\Parcelle;
use Geos\GeoEntityBundle\Form\ParcelleType;

/**
 * Parcelle controller.
 *
 * @Route("/parcelle")
 */
class ParcelleController extends Controller
{
    /**
     * Lists all Parcelle entities.
     *
     * @Route("/", name="parcelle")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT parcelle FROM GeosGeoEntityBundle:Parcelle parcelle ORDER BY parcelle.numero ASC";
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
     * Finds and displays a Parcelle entity.
     *
     * @Route("/{id}/show", name="parcelle_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosGeoEntityBundle:Parcelle')->find($id);

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
     * Displays a form to create a new Parcelle entity.
     *
     * @Route("/new", name="parcelle_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Parcelle();
        $form   = $this->createForm(new ParcelleType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Parcelle entity.
     *
     * @Route("/create", name="parcelle_create")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Parcelle:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Parcelle();
        $request = $this->getRequest();
        $form    = $this->createForm(new ParcelleType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('parcelle_show', array('id' => $entity->getId())));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Parcelle entity.
     *
     * @Route("/{id}/edit", name="parcelle_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Parcelle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parcelle entity.');
        }

        $editForm = $this->createForm(new ParcelleType(), $entity);
        
        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Parcelle entity.
     *
     * @Route("/{id}/update", name="parcelle_update")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Parcelle:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Parcelle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parcelle entity.');
        }

        $editForm   = $this->createForm(new ParcelleType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('parcelle_show', array('id' => $entity->getId())));


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Parcelle entity.
     *
     * @Route("/{id}/delete", name="parcelle_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {
        $request = $this->getRequest();

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosGeoEntityBundle:Parcelle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Parcelle entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('parcelle'));
    }
}
