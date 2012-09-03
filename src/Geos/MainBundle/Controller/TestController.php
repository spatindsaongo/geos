<?php
namespace Geos\MainBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
	Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller {
	
	/**
	 *@Route("/statView1")
	 */
	
	public function statView1Action(){
		
		return $this->render('GeosMainBundle:Test:statisticsView1.html.twig');

	}
	
	/**
	 *@Route("/statView2", name = "dashbord")
	 */
	
	public function statView2Action(){
	
		return $this->render('GeosMainBundle:Test:statisticsView2.html.twig');
	
	}

}
