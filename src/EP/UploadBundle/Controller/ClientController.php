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

      $field = null;
      $value = null;
      $user = $this->container->get('security.context')->getToken()->getUser();

      $field = $this->getRequest()->query->get("type");
      $value = $this->getRequest()->query->get("search");

      $clients = $repository->findByField($field, $value, $user);

      return $this->render('EPUploadBundle:Client:showClient.html.twig',array(
          'clients' => $clients
        ));      
    }

    public function createAction(Request $request){
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

    public function deleteAction($id, Request $request)
    {
      $client = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Client")->findOneById($id);

      $em = $this->getDoctrine()->getManager();

      if ($this->getRequest()->isMethod('POST')) {
        $em->remove($client);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', "Le client a bien été supprimé.");

        return $this->redirectToRoute('ep_show_client');
      }

      return $this->render("EPUploadBundle:Client:deleteClient.html.twig", array(
        "client" => $client,
        // on ajoute un formulaire vide, qui contiendra automatiquement un champ csrf, 
        // pour protéger la suppression contre cette faille
        "form" => $this->createFormBuilder()->getForm()->createView()
      ));
    }

    public function editAction($id, Request $request)
    {
      $client = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Client")->findOneById($id);

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