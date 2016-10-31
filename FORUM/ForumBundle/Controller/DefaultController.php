<?php

namespace FORUM\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FORUMForumBundle:Default:index.html.twig');
    }
}
