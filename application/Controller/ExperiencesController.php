<?php

namespace App\Controller;

use \Core\Service\db;
use \App\Modele\Article;

/**
* ExperiencesController
*/
class ExperiencesController extends \Core\Controller\Controller
{
	
	public function articleAction($url)
	{
		$article = Article::findOneBy(array('url' => $url));
		if(!$article) throw new \ErrorException("Article inaccessible ou inexistant", 1);

		return $this->render('Experiences/article.html.twig', array('article' => $article));
	}
}