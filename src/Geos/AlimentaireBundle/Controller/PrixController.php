<?php

namespace Geos\AlimentaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Geos\AlimentaireBundle\Entity\Prix;
use Geos\AlimentaireBundle\Form\PrixType;

/**
 * Prix controller.
 *
 * @Route("/prix")
 */
class PrixController extends Controller
{
    /**
     * Lists all Prix entities.
     * @todo Ajouter le filtrage des prix à afficher en fonction des marchés et des denrée
     * @Route("/", name="prix")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT prix FROM GeosAlimentaireBundle:Prix prix";
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
     * Finds and displays a Prix entity.
     *
     * @Route("/{id}/show", name="prix_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAlimentaireBundle:Prix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prix entity.');
        }


        return array(
            'entity'      => $entity,  );
    }

    /**
     * Displays a form to create a new Prix entity.
     *
     * @Route("/new", name="prix_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Prix();
        $form   = $this->createForm(new PrixType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Prix entity.
     *
     * @Route("/create", name="prix_create")
     * @Method("post")
     * @Template("GeosAlimentaireBundle:Prix:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Prix();
        $request = $this->getRequest();
        $form    = $this->createForm(new PrixType(), $entity);
        $form->bindRequest($request);


        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('prix'));


        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Prix entity.
     *
     * @Route("/{id}/edit", name="prix_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAlimentaireBundle:Prix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prix entity.');
        }

        $editForm = $this->createForm(new PrixType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Prix entity.
     *
     * @Route("/{id}/update", name="prix_update")
     * @Method("post")
     * @Template("GeosAlimentaireBundle:Prix:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('GeosAlimentaireBundle:Prix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prix entity.');
        }

        $editForm   = $this->createForm(new PrixType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('prix'));


        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Prix entity.
     *
     * @Route("/{id}/delete", name="prix_delete")
     * @Method("get")
     */
    public function deleteAction($id)
    {


        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('GeosAlimentaireBundle:Prix')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Prix entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('prix'));
    }
    
    private function createFilterForm($id)
    {
    	return $this->createFormBuilder()->add('critere', 'choice',array('choices'=>array('marche'=>'marche',
    																					  'denree'=>'denree')))
    									 ->add('valeur')
    	->getForm()
    	;
    }


}
