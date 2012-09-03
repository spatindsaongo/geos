<?php

namespace Geos\SanteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\SanteBundle\Entity\CentreSante;
use Geos\SanteBundle\Form\CentreSanteType;

/**
 * CentreSante controller.
 *
 * @Route("/centresante")
 */
class CentreSanteController extends Controller
{
    /**
     * Lists all CentreSante entities.
     *
     * @Route("/", name="centresante")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT centresante FROM GeosSanteBundle:CentreSante centresante ORDER BY centresante.nom ASC";
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
     * Finds and displays a CentreSante entity.
     *
     * @Route("/{id}/show", name="centresante_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosSanteBundle:CentreSante')->find($id);     
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
     * Displays a form to create a new CentreSante entity.
     *
     * @Route("/new", name="centresante_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CentreSante();
        $form   = $this->createForm(new CentreSanteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new CentreSante entity.
     *
     * @Route("/create", name="centresante_create")
     * @Method("post")
     * @Template("GeosSanteBundle:CentreSante:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new CentreSante();
        $request = $this->getRequest();
        $form    = $this->createForm(new CentreSanteType(), $entity);
        $form->bindRequest($request);


        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centresante_show', array('id' => $entity->getId())));
            

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing CentreSante entity.
     *
     * @Route("/{id}/edit", name="centresante_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosSanteBundle:CentreSante')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CentreSante entity.');
        }

        $editForm = $this->createForm(new CentreSanteType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing CentreSante entity.
     *
     * @Route("/{id}/update", name="centresante_update")
     * @Method("post")
     * @Template("GeosSanteBundle:CentreSante:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosSanteBundle:CentreSante')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CentreSante entity.');
        }

        $editForm   = $this->createForm(new CentreSanteType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centresante_show', array('id' => $id)));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a CentreSante entity.
     *
     * @Route("/{id}/delete", name="centresante_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);


        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosSanteBundle:CentreSante')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CentreSante entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('centresante'));
    }

}
