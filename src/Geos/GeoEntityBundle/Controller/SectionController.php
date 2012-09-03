<?php

namespace Geos\GeoEntityBundle\Controller;

use Geos\GeoEntityBundle\Lib\Geolib;
use Geos\MainBundle\Form\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\GeoEntityBundle\Entity\Section;
use Geos\GeoEntityBundle\Form\SectionType;

/**
 * Section controller.
 *
 * @Route("/section")
 */
class SectionController extends Controller
{
    /**
     * Lists all Section entities.
     *
     * @Route("/", name="section")
     * @Template()
     */
    public function indexAction()
    {
    	$em = $this->get('doctrine.orm.entity_manager');
    	$dql = "SELECT section FROM GeosGeoEntityBundle:Section section ORDER BY section.numero ASC";
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
     * Finds and displays a Section entity.
     *
     * @Route("/{id}/show", name="section_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosGeoEntityBundle:Section')->find($id);

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
     * Displays a form to create a new Section entity.
     *
     * @Route("/new", name="section_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Section();
        $form   = $this->createForm(new SectionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Section entity.
     *
     * @Route("/create", name="section_create")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Section:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Section();
        $request = $this->getRequest();
        $form    = $this->createForm(new SectionType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('section_show', array('id' => $entity->getId())));


        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Section entity.
     *
     * @Route("/{id}/edit", name="section_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Section')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Section entity.');
        }

        $editForm = $this->createForm(new SectionType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Section entity.
     *
     * @Route("/{id}/update", name="section_update")
     * @Method("post")
     * @Template("GeosGeoEntityBundle:Section:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosGeoEntityBundle:Section')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Section entity.');
        }

        $editForm   = $this->createForm(new SectionType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('section_show', array('id' => $entity->getId())));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Section entity.
     *
     * @Route("/{id}/delete", name="section_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosGeoEntityBundle:Section')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Section entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('section'));
    }

}
