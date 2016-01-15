<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\Files;
use EP\UploadBundle\Form\FilesType;
use EP\UploadBundle\Entity\Produit;
use EP\UploadBundle\Form\ProduitType;

class ProduitController extends Controller
{
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

}