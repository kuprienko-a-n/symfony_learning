<?php

namespace Kan\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($page)
    {
        return $this->render('KanCmsBundle:Default:index.html.twig', array('page' => $page));
    }
}
