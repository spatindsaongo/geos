<?php

namespace Geos\AlimentaireBundle\Controller;

use Doctrine\ORM\Mapping\Id;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\AlimentaireBundle\Entity\Marche;
use Geos\AlimentaireBundle\Form\MarcheType;

/**
 * Marche controller.
 *
 * @Route("/marche")
 */
class MarcheController extends Controller
{
    /**
     * Lists all Marche entities.
     *
     * @Route("/", name="marche")
     * @Template()
     * 
     */
    public function indexAction()
    {
        
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT marche FROM GeosAlimentaireBundle:Marche marche";
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
     * Finds and displays a Marche entity.
     *
     * @Route("/{id}/show", name="marche_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entitiesList = array();

        $entity = $em->getRepository('GeosAlimentaireBundle:Marche')->find($id);        
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
       );
    }

    /**
     * Displays a form to create a new Marche entity.
     *
     * @Route("/new", name="marche_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Marche();
        $form   = $this->createForm(new MarcheType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Marche entity.
     *
     * @Route("/create", name="marche_create")
     * @Method("post")
     * @Template("GeosAlimentaireBundle:Marche:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Marche();
        $request = $this->getRequest();
        $form    = $this->createForm(new MarcheType(), $entity);
        $form->bindRequest($request);


        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('marche'));
            

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Marche entity.
     *
     * @Route("/{id}/edit", name="marche_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAlimentaireBundle:Marche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marche entity.');
        }

        $editForm = $this->createForm(new MarcheType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Marche entity.
     *
     * @Route("/{id}/update", name="marche_update")
     * @Method("post")
     * @Template("GeosAlimentaireBundle:Marche:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAlimentaireBundle:Marche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marche entity.');
        }

        $editForm   = $this->createForm(new MarcheType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('marche_edit'));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Marche entity.
     *
     * @Route("/{id}/delete", name="marche_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosAlimentaireBundle:Marche')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Marche entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('marche'));
    }

}
