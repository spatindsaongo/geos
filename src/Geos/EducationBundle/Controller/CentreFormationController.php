<?php

namespace Geos\EducationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\EducationBundle\Entity\CentreFormation;
use Geos\EducationBundle\Form\CentreFormationType;

/**
 * CentreFormation controller.
 *
 * @Route("/centreformation")
 */
class CentreFormationController extends Controller
{
    /**
     * Lists all CentreFormation entities.
     *
     * @Route("/", name="centreformation")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT centreformation FROM GeosEducationBundle:CentreFormation centreformation ORDER BY centreformation.nom ASC";
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
     * Finds and displays a CentreFormation entity.
     *
     * @Route("/{id}/show", name="centreformation_show")
     * @Template()
     */
    public function showAction($id)
    {
	
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosEducationBundle:CentreFormation')->find($id);     
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
     * Displays a form to create a new CentreFormation entity.
     *
     * @Route("/new", name="centreformation_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CentreFormation();
        $form   = $this->createForm(new CentreFormationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new CentreFormation entity.
     *
     * @Route("/create", name="centreformation_create")
     * @Method("post")
     * @Template("GeosEducationBundle:CentreFormation:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new CentreFormation();
        $request = $this->getRequest();
        $form    = $this->createForm(new CentreFormationType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centreformation_show', array('id' => $entity->getId())));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing CentreFormation entity.
     *
     * @Route("/{id}/edit", name="centreformation_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEducationBundle:CentreFormation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CentreFormation entity.');
        }

        $editForm = $this->createForm(new CentreFormationType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing CentreFormation entity.
     *
     * @Route("/{id}/update", name="centreformation_update")
     * @Method("post")
     * @Template("GeosEducationBundle:CentreFormation:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEducationBundle:CentreFormation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CentreFormation entity.');
        }

        $editForm   = $this->createForm(new CentreFormationType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centreformation_show', array('id' => $id)));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a CentreFormation entity.
     *
     * @Route("/{id}/delete", name="centreformation_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosEducationBundle:CentreFormation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CentreFormation entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centreformation'));
    }

}
