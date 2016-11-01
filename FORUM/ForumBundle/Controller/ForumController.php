<?php
namespace FORUM\ForumBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use FORUM\ForumBundle\Entity\thread;
use FORUM\ForumBundle\Entity\User;
use FORUM\ForumBundle\Form\threadType;

class ForumController extends Controller
{
    public function indexAction()
    {
        return $this->render('FORUMForumBundle:Forum:index.html.twig');
    }

    public function threadAction(Request $request)
    {
    	if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      		throw new AccessDeniedException('Accès limité aux auteurs.');
		}
		$thread = new thread();
		$em = $this->getDoctrine()->getEntityManager();
		$form = $this->createForm(threadType::class, $thread);
		$user = new User();
		$email = $this->getUser()->getId();
		$Username = $this->getUser();
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
  			$thread->setEmail($email);
  			$thread->setUsername($Username);
      		$em->persist($thread);
      		$em->flush();
      	}
      	$messages = $em->getRepository("FORUMForumBundle:thread")->findAll();
    	return $this->render('FORUMForumBundle:Forum:thread.html.twig', 
    		array('messages' => $messages, 'form' => $form->createView(),
    		));
    }
}