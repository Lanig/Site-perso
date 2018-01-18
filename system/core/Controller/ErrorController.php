<?php

namespace Core\Controller;

/**
* ErrorController
*/
class ErrorController extends Controller
{
	
	public function NotFoundAction()
	{
		header("HTTP/1.0 404 Not Found");
		return $this->render('Error/404.html.twig', array());
	}
}