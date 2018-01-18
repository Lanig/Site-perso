<?php

namespace App\Controller;

/**
* IndexController
*/
class IndexController extends \Core\Controller\Controller
{
	
	public function indexAction()
	{
		return $this->render('Index/index.html.twig', array('test' => 'Fabien'));
	}
	
	public function contactAction()
	{
		global $config;
		$mail_address = $config->get('site')['mail'];

		return $this->render('Index/contact.html.twig', array('mail_address' => $mail_address));
	}
}