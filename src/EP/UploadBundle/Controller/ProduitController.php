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
      $produits = $repository->findByOwner($this->container->get('security.context')->getToken()->getUser());
      return $this->render('EPUploadBundle:Produit:showProduit.html.twig',array(
          'produits' => $produits
        )); 
    }


    public function editAction(Request $request){
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

}