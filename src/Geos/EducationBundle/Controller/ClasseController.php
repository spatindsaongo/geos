<?php

namespace Geos\EducationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\EducationBundle\Entity\Classe;
use Geos\EducationBundle\Form\ClasseType;

/**
 * Classe controller.
 *
 * @Route("/classe")
 */
class ClasseController extends Controller
{
    /**
     * Lists all Classe entities.
     *
     * @Route("/", name="classe")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GeosEducationBundle:Classe')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Classe entity.
     *
     * @Route("/{id}/show", name="classe_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEducationBundle:Classe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Classe entity.
     *
     * @Route("/{cfId}/new", name="classe_new")
     * @Template()
     */
    public function newAction($cfId)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
        $entity = new Classe();
        
        $cf = $em->getRepository('GeosEducationBundle:CentreFormation')->find($cfId);
        
        $entity->setCentreFormation($cf);
        
        $form   = $this->createForm(new ClasseType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'cfId' => $cfId
        );
    }

    /**
     * Creates a new Classe entity.
     *
     * @Route("/create", name="classe_create")
     * @Method("post")
     * @Template("GeosEducationBundle:Classe:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Classe();
        $request = $this->getRequest();
        $form    = $this->createForm(new ClasseType(), $entity);
        $form->bindRequest($request);


        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centreformation_show', array('id' => $entity->getCentreFormation()->getId())));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Classe entity.
     *
     * @Route("/{id}/edit", name="classe_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEducationBundle:Classe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classe entity.');
        }

        $editForm = $this->createForm(new ClasseType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	'cfId' => $entity->getCentreFormation()->getId()
        );
    }

    /**
     * Edits an existing Classe entity.
     *
     * @Route("/{id}/update", name="classe_update")
     * @Method("post")
     * @Template("GeosEducationBundle:Classe:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosEducationBundle:Classe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classe entity.');
        }

        $editForm   = $this->createForm(new ClasseType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centreformation_show', array('id' => $entity->getCentreFormation()->getId())));


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Classe entity.
     *
     * @Route("/{id}/delete", name="classe_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {


        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosEducationBundle:Classe')->find($id);
        
        $cfId = $entity->getCentreFormation()->getId();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Classe entity.');
        }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('centreformation_show', array('id' => $cfId)));
    }

}
