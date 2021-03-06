<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\Files;
use EP\UploadBundle\Form\FilesType;
use EP\UploadBundle\Entity\Produit;
use EP\UploadBundle\Form\ProduitRestType;
use EP\UploadBundle\Form\ProduitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ACCESS_EDIT_FACTURE')")
 */
class ProduitController extends Controller
{

    /**
      * Affiche la liste des produits
      */
    public function showAction() {
      $repository = $this->getDoctrine()->getManager()->getRepository('EPUploadBundle:Produit');
      
      $field = null;
      $value = null;
      $user = $this->container->get('security.context')->getToken()->getUser();

      $field = $this->getRequest()->query->get("type");
      $value = $this->getRequest()->query->get("search");

      
      $produits = $repository->findByField($field, $value, $user);

      return $this->render('EPUploadBundle:Produit:showProduit.html.twig',array(
          'produits' => $produits
        )); 
    }


    /**
      * Permet la création d'un nouveau produit
      * @param request : la requête envoyé
      */
    public function createAction(Request $request){
      $produit = new Produit();
      $form = $this->createForm(new ProduitType(),$produit);
      $form->handleRequest($request);

      if($form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $produit->setOwner($this->container->get('security.context')->getToken()->getUser());
        $em->persist($produit);
        $em->flush();
        return $this->redirectToRoute("ep_show_produit");
      }
      return $this->render('EPUploadBundle:Produit:newProduit.html.twig', array(
        "form" => $form->createView()
        ));      
    }

    /**
      * Permet la suppression d'un produit
      * @param request : la requête envoyé
      * @param id : l'identifiant du produit
      */
    public function deleteAction($id, Request $request)
    {
        $produit = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Produit")->findOneById($id);

        $em = $this->getDoctrine()->getManager();

        if ($this->getRequest()->isMethod('POST')) {
          $em->remove($produit);
          $em->flush();

          $request->getSession()->getFlashBag()->add('info', "Le produit a bien été supprimé.");

          return $this->redirectToRoute('ep_show_produit');
        }

        return $this->render("EPUploadBundle:Produit:deleteProduit.html.twig", array(
          "produit" => $produit,
          // on ajoute un formulaire vide, qui contiendra automatiquement un champ csrf, 
          // pour protéger la suppression contre cette faille
          "form" => $this->createFormBuilder()->getForm()->createView()
        ));
    }

    /**
      * Permet la modification d'un produit
      * @param request : la requête envoyé
      * @param id : l'identifiant du produit
      */
    public function editAction($id, Request $request)
    {
        $produit = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Produit")->findOneById($id);

        $form = $this->createForm(new ProduitType(),$produit);
        $form->handleRequest($request);

        if($form->isValid()){
          $em = $this->getDoctrine()->getManager();
          $produit->setOwner($this->container->get('security.context')->getToken()->getUser());
          $em->persist($produit);
          $em->flush();
          return $this->redirectToRoute("ep_show_produit");
        }
        return $this->render('EPUploadBundle:Produit:newProduit.html.twig', array(
          "form" => $form->createView()
        ));      
    }

    /**
      * Permet la création d'un produit 
      * Cette méthode est appelé lors de la création à la volée lors de l'édition de facture
      * @param request : la requête envoyé
      */
    public function createRestAction(Request $request) {
        if ($request->isMethod('POST')) {
            $data = $request->request->get('produit');

            $produit = new Produit();
            $produit->setOwner($this->container->get('security.context')->getToken()->getUser());
            $produit->setDesignation($data['designation']);
            $produit->setdescription($data['description']);
            $produit->setReference($data['reference']);
            $produit->setMontantUnitaireHT($data['montantUnitaireHT']);
            $produit->setTva($data['tva']);

            $this->getDoctrine()->getManager()->persist($produit);
            $this->getDoctrine()->getManager()->flush();

            $res = array(
              "id" => $produit->getId(),
              "designation" => $produit->getDesignation(),
              "prix" => $produit->getMontantUnitaireHT(),
              "tva" => $produit->getTva()
            );

            $response = new Response(json_encode($res));
            $response->headers->set('Content-Type', 'application/json');

            return $response;

        } else if ($request->isMethod('GET')) {
            $form = $this->createForm(new ProduitRestType(), new Produit());
            return $this->render('EPUploadBundle:Produit:formProduitModal.html.twig', array(
              "form" => $form->createView()
            ));
        } 

        throw new NotFoundHttpException("Cette page n'existe pas.");
    }

}