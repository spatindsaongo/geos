<?php

namespace Geos\GeoEntityBundle\Controller;

use Geos\GeoEntityBundle\Lib\Geolib;

use Geos\MainBundle\Form\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\GeoEntityBundle\Entity\Commune;
use Geos\GeoEntityBundle\Form\CommuneType;

/**
 * Commune controller.
 *
 * @Route("/commune")
 */
class CommuneController extends Controller
{
    /**
     * Lists all Commune entities.
     *
     * @Route("/", name="commune")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT  commune FROM GeosGeoEntityBundle:Commune commune ORDER BY commune.nom ASC ";
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
     * Finds and displays a Commune entity.
     *
     * @Route("/{id}/show", name="commune_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosGeoEntityBundle:Commune')->find($id);
        
        $entitiesList[] = $entity;
        
        $markers = $this->get("geolib")->getCovers($entitiesList);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commune entity.');
        }

        print_r($markers);
        
        return array(
            'entity'      => $entity,
        	'mapcenter'   => $markers['mapCenter'],
	       	'scale'		  => $markers['scale'],
        	'markers'	  => $markers['markers'],
        	'covers'	  => $markers['covers'],
        	);
    }

    /**
     * Displays a form to create a new Commune entity.
     *
     * @Route("/new", name="commune_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Commune();
        $form   = $this->createForm(new CommuneType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Commune entity.
     *
     * @Route("/create", name="commune_create")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Commune:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Commune();
        $request = $this->getRequest();
        $form    = $this->createForm(new CommuneType(), $entity);
        $form->bindRequest($request);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('commune_show', array('id' => $entity->getId())));


        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Commune entity.
     *
     * @Route("/{id}/edit", name="commune_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Commune')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commune entity.');
        }

        $editForm = $this->createForm(new CommuneType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Commune entity.
     *
     * @Route("/{id}/update", name="commune_update")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Commune:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Commune')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Commune entity.');
        }

        $editForm   = $this->createForm(new CommuneType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('commune_show', array('id' => $entity->getId())));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Commune entity.
     *
     * @Route("/{id}/delete", name="commune_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {


            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('GeosGeoEntityBundle:Commune')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Commune entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('commune'));
    }

}
