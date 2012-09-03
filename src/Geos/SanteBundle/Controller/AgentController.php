<?php

namespace Geos\SanteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\SanteBundle\Entity\Agent;
use Geos\SanteBundle\Form\AgentType;

/**
 * Agent controller.
 *
 * @Route("/agent")
 */
class AgentController extends Controller
{
    /**
     * Lists all Agent entities.
     *
     * @Route("/", name="agent")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('GeosSanteBundle:Agent')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Agent entity.
     *
     * @Route("/{id}/show", name="agent_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosSanteBundle:Agent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agent entity.');
        }

        return array(
            'entity'      => $entity,    );
    }

    /**
     * Displays a form to create a new Agent entity.
     *
     * @Route("/{csId}/new", name="agent_new")
     * @Template()
     */
    public function newAction($csId)
    {
        $entity = new Agent();
        $form   = $this->createForm(new AgentType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        	'csId' => $csId
        );
    }

    /**
     * Creates a new Agent entity.
     *
     * @Route("/create", name="agent_create")
     * @Method("post")
     * @Template("GeosSanteBundle:Agent:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Agent();
        $request = $this->getRequest();
        $form    = $this->createForm(new AgentType(), $entity);
        $form->bindRequest($request);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('centresante_show', array('id' => $entity->getCentreSante()->getId())));

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Agent entity.
     *
     * @Route("/{id}/edit", name="agent_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosSanteBundle:Agent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agent entity.');
        }

        $editForm = $this->createForm(new AgentType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        	'csId' => $entity->getCentreSante()->getId()
        );
    }

    /**
     * Edits an existing Agent entity.
     *
     * @Route("/{id}/update", name="agent_update")
     * @Method("post")
     * @Template("GeosSanteBundle:Agent:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosSanteBundle:Agent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agent entity.');
        }

        $editForm   = $this->createForm(new AgentType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);


        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('agent_edit', array('id' => $id)));


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Agent entity.
     *
     * @Route("/{id}/delete", name="agent_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosSanteBundle:Agent')->find($id);
        
        $csId = $entity->getCentreSante()->getId();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agent entity.');
        }

        $em->remove($entity);
        $em->flush();


        return $this->redirect($this->generateUrl('centresante_show', array('id' => $csId)));
    }

}
