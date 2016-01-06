<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\Client;
use EP\UploadBundle\Form\ClientType;

class ClientController extends Controller
{
    public function showAction() 
    {
      $repository = $this->getDoctrine()->getManager()->getRepository('EPUploadBundle:Client');
      $clients = $repository->findByOwner($this->container->get('security.context')->getToken()->getUser());
      return $this->render('EPUploadBundle:Client:showClient.html.twig',array(
          'clients' => $clients
        ));      
    }

    public function editAction(Request $request){
      $client = new Client();
      $form = $this->createForm(new ClientType(),$client);
      $form->handleRequest($request);

      if($form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $client->setOwner($this->container->get('security.context')->getToken()->getUser());
        $em->persist($client);
        $em->flush();
        return $this->redirectToRoute("ep_show_client");
      }
      return $this->render('EPUploadBundle:Client:newClient.html.twig', array(
        "form" => $form->createView()
        ));      
    }

}