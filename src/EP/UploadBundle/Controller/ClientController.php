<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\Files;
use EP\UploadBundle\Form\FilesType;

class ClientController extends Controller
{
    public function showAction() 
    {
      return $this->render('EPUploadBundle:Client:showClient.html.twig');      
    }

    public function editAction(){
      return $this->render('EPUploadBundle:Client:showClient.html.twig');      
    }

}