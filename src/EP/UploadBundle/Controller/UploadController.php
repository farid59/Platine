<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends Controller
{
    public function indexAction()
    {
        return $this->render('EPUploadBundle:Upload:index.html.twig', array('name' => 'farid'));
        // return new Response("Hello World !");
    }
}
