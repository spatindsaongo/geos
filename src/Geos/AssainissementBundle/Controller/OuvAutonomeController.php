<?php

namespace Geos\AssainissementBundle\Controller;

use Geos\GeoEntityBundle\Lib\Geolib;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\AssainissementBundle\Entity\OuvAutonome;
use Geos\AssainissementBundle\Form\OuvAutonomeType;

/**
 * OuvAutonome controller.
 *
 * @Route("/ouvautonome")
 */
class OuvAutonomeController extends Controller
{
    /**
     * Lists all OuvAutonome entities.
     *
     * @Route("/", name="ouvautonome")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT oa FROM GeosAssainissementBundle:OuvAutonome oa";
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
     * Finds and displays a OuvAutonome entity.
     *
     * @Route("/{id}/show", name="ouvautonome_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosAssainissementBundle:OuvAutonome')->find($id);

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
     * Displays a form to create a new OuvAutonome entity.
     *
     * @Route("/new", name="ouvautonome_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new OuvAutonome();
        $form   = $this->createForm(new OuvAutonomeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new OuvAutonome entity.
     *
     * @Route("/create", name="ouvautonome_create")
     * @Method("post")
     * @Template("GeosAssainissementBundle:OuvAutonome:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new OuvAutonome();
        $request = $this->getRequest();
        $form    = $this->createForm(new OuvAutonomeType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('ouvautonome_show', array('id' => $entity->getId())));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing OuvAutonome entity.
     *
     * @Route("/{id}/edit", name="ouvautonome_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAssainissementBundle:OuvAutonome')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OuvAutonome entity.');
        }

        $editForm = $this->createForm(new OuvAutonomeType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing OuvAutonome entity.
     *
     * @Route("/{id}/update", name="ouvautonome_update")
     * @Method("post")
     * @Template("GeosAssainissementBundle:OuvAutonome:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAssainissementBundle:OuvAutonome')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OuvAutonome entity.');
        }

        $editForm   = $this->createForm(new OuvAutonomeType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('ouvautonome_show', array('id' => $entity->getId())));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a OuvAutonome entity.
     *
     * @Route("/{id}/delete", name="ouvautonome_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosAssainissementBundle:OuvAutonome')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OuvAutonome entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('ouvautonome'));
    }
}
