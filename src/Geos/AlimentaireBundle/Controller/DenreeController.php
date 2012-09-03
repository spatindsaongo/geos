<?php

namespace Geos\AlimentaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\AlimentaireBundle\Entity\Denree;
use Geos\AlimentaireBundle\Form\DenreeType;

/**
 * Denree controller.
 *
 * @Route("/denree")
 */
class DenreeController extends Controller
{
    /**
     * Lists all Denree entities.
     *
     * @Route("/", name="denree")
     * @Template()
     */
	
    public function indexAction()
    {
        
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT denree FROM GeosAlimentaireBundle:Denree denree";
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
     * Finds and displays a Denree entity.
     *
     * @Route("/{id}/show", name="denree_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAlimentaireBundle:Denree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Denree entity.');
        }

        return array(
            'entity'      => $entity
        		     );
    }

    /**
     * Displays a form to create a new Denree entity.
     *
     * @Route("/new", name="denree_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Denree();
        $form   = $this->createForm(new DenreeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Denree entity.
     *
     * @Route("/create", name="denree_create")
     * @Method("post")
     * @Template("GeosAlimentaireBundle:Denree:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Denree();
        $request = $this->getRequest();
        $form    = $this->createForm(new DenreeType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('denree'));
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Denree entity.
     *
     * @Route("/{id}/edit", name="denree_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAlimentaireBundle:Denree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Denree entity.');
        }

        $editForm = $this->createForm(new DenreeType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Denree entity.
     *
     * @Route("/{id}/update", name="denree_update")
     * @Method("post")
     * @Template("GeosAlimentaireBundle:Denree:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAlimentaireBundle:Denree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Denree entity.');
        }

        $editForm   = $this->createForm(new DenreeType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('denree'));


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Denree entity.
     *
     * @Route("/{id}/delete", name="denree_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosAlimentaireBundle:Denree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Denree entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('denree'));
    }

}
