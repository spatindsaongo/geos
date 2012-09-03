<?php

namespace Geos\MainBundle\Controller;

use Geos\MainBundle\Form\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/main", name="_main")
     * @Template("GeosMainBundle::homepage.html.twig")
     */
    public function indexAction()
    {
       return $this->render('GeosMainBundle::homepage.html.twig');
    }
    
    /**
     * @Route("/entityManagement", name="_entityManagement")
     * @Template("GeosMainBundle::entityManagement.html.twig")
     */    
    public function entityManagementAction(Request $request){
    	
    	$form =$this->createForm(new EntityType());
    	
    	if ($request->getMethod() == 'POST') {
    		$form->bindRequest($request);
    		$data = $form->getData();
    		
    		print_r($data);
    		$entity = $data['entity'];
    		//Zone d'interêt
    		if($entity == "commune"){
    			return $this->redirect($this->generateUrl('commune'));
    		}
    		elseif($entity == "region"){
    			return $this->redirect($this->generateUrl('region'));
    		}
    		elseif($entity == "province"){
    			return $this->redirect($this->generateUrl('province'));
    		}
    		elseif($entity == "section"){
    			return $this->redirect($this->generateUrl('section'));
    		}
    		elseif($entity == "lot"){
    			return $this->redirect($this->generateUrl('lot'));
    		}
    		elseif($entity == "parcelle"){
    			return $this->redirect($this->generateUrl('parcelle'));
    		}
    		
    		//Point d'interêt
    		elseif($entity == "pointeau"){
    			return $this->redirect($this->generateUrl('pointeau'));
    		}
    	}
    	 
    	return $this->render('GeosMainBundle::entityManagement.html.twig',array(
    			'form'=>$form->createView(),
    			));
    }
}
