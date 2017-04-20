<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller{

  /**
  * @Route("/test/{username}", name="test", requirements={"username": "\D+"})
  */
  public function indexAction(Request $request, $username = 'Test'){
    return $this->render('test/test.html.twig', [
      'userName' => $username
    ]);
  }

  /**
  * @Route("/test/{username}/{page}", name="test_show", requirements={"page": "\d+"})
  */
  public function showAction($page){
    return new Response('Ma page est ' . $page);
  }

}

?>
