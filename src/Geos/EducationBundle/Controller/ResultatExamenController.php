<?php

namespace Geos\EducationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\EducationBundle\Entity\ResultatExamen;
use Geos\EducationBundle\Form\ResultatExamenType;

/**
 * ResultatExamen controller.
 *
 * @Route("/resultatexamen")
 */
class ResultatExamenController extends Controller
{
    /**
     * Lists all ResultatExamen entities.
     *
     * @Route("/", name="resultatexamen")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GeosEducationBundle:ResultatExamen')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a ResultatExamen entity.
     *
     * @Route("/{id}/show", name="resultatexamen_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEducationBundle:ResultatExamen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultatExamen entity.');
        }

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new ResultatExamen entity.
     *
     * @Route("/{clId}/new", name="resultatexamen_new")
     * @Template()
     */
    public function newAction($clId)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$entity = new ResultatExamen();
    	
    	$cl = $em->getRepository('GeosEducationBundle:Classe')->find($clId);    	
    	
		$entity->setClasse($cl);
    	
        $form   = $this->createForm(new ResultatExamenType(), $entity);
        
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'cfId' => $cl->getCentreFormation()->getId()
        );
    }

    /**
     * Creates a new ResultatExamen entity.
     *
     * @Route("/create", name="resultatexamen_create")
     * @Method("post")
     * @Template("GeosEducationBundle:ResultatExamen:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new ResultatExamen();
        $request = $this->getRequest();
        $form    = $this->createForm(new ResultatExamenType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centreformation_show', array('id' => $entity->getClasse()->getCentreFormation()->getId())));
            

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing ResultatExamen entity.
     *
     * @Route("/{id}/edit", name="resultatexamen_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEducationBundle:ResultatExamen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultatExamen entity.');
        }

        $editForm = $this->createForm(new ResultatExamenType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	'cfId' => $entity->getClasse()->getCentreFormation()->getId()
        );
    }

    /**
     * Edits an existing ResultatExamen entity.
     *
     * @Route("/{id}/update", name="resultatexamen_update")
     * @Method("post")
     * @Template("GeosEducationBundle:ResultatExamen:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEducationBundle:ResultatExamen')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultatExamen entity.');
        }

        $editForm   = $this->createForm(new ResultatExamenType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centreformation_show', array('id' => $entity->getClasse()->getCentreFormation()->getId())));

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a ResultatExamen entity.
     *
     * @Route("/{id}/delete", name="resultatexamen_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosEducationBundle:ResultatExamen')->find($id);
        $cfId = $entity->getClasse()->getCentreFormation()->getId();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ResultatExamen entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('centreformation_show', array('id' => $cfId)));
    }

}
