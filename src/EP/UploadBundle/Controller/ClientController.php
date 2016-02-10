<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\Client;
use EP\UploadBundle\Form\ClientType;
use EP\UploadBundle\Form\ClientRestType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @Security("has_role('ACCESS_EDIT_FACTURE')")
 */
class ClientController extends Controller
{

    /**
      * Affiche la liste des clients
      */
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

    /**
     * Permet la création d'un nouveau client
     * @param request : la requête envoyé
     */
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

    /**
      * Permet la suppression d'un client
      * @param request : la requête envoyé
      * @param id : l'identifiant du client à supprimer
      */
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

    /**
      * Permet la modification des informations d'un client
      * @param request : la requête envoyé
      * @param id : l'identifiant du client
      */
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

    /**
      * Permet la création d'un client 
      * Cette méthode est appelé lors de la création à la volée lors de l'édition de facture
      * @param request : la requête envoyé
      */
    public function createRestAction(Request $request) {

        if ($request->isMethod('POST')) {
            $data = $request->request->get('client');

            $client = new Client();
            $client->setNom($data['nom']);
            $client->setOwner($this->container->get('security.context')->getToken()->getUser());
            $client->setPrenom($data['prenom']);
            $client->setCivilite($data['civilite']);
            $client->setSociete($data['societe']);
            $client->setEmail($data['email']);
            $client->setDestinataire($data['destinataire']);
            $client->setAdresse($data['adresse']);
            $client->setCodePostal($data['codePostal']);
            $client->setVille($data['ville']);
            $client->setPays($data['pays']);
            $client->setTelephone($data['telephone']);
            $client->setMobile($data['mobile']);
            $client->setFax($data['fax']);
            $client->setTva($data['tva']);
            $client->setReference($data['reference']);
            $client->setConditionPaiement($data['conditionsPaiement']);


            $this->getDoctrine()->getManager()->persist($client);
            $this->getDoctrine()->getManager()->flush();

            $res = array(
              "id" => $client->getId(),
              "nom" => $client->getNom(),
              "prenom" => $client->getPrenom(),
              "destinataire" => $client->getDestinataire(),
              "conditionsPaiement" => $client->getConditionPaiement(),
            );

            $response = new Response(json_encode($res));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        } else if ($request->isMethod('GET')) {
            $form = $this->createForm(new ClientRestType(), new Client());
            return $this->render('EPUploadBundle:Client:formClientModal.html.twig', array(
              "form" => $form->createView()
            ));
        }

        throw new NotFoundHttpException("Cette page n'existe pas.");
    }

}