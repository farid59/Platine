<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\FactureProduit;
use EP\UploadBundle\Form\FactureProduitType;
use EP\UploadBundle\Entity\Facture;
use EP\UploadBundle\Form\FactureType;

class FactureController extends Controller
{
    public function editAction(Request $request) {
    	$facture = new Facture();
    	$form = $this->createForm(new FactureType(),$facture,array("csrf_protection"=>false));
    	$produits = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Produit")->findAll();

    	if($this->getRequest()->isMethod('POST')) {

		    if($form->handleRequest($request)->isValid()){		        
		        $em = $this->getDoctrine()->getManager();
		        $pem = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Produit");
		        // $em->persist(new Facture());
		        // $id = $em->getConnection()->lastInsertId();

		        // $facture->setId($id);
		        $facture->setOwner($this->container->get('security.context')->getToken()->getUser());
		        $listProduits = clone $facture->getProduits();
		        
		        foreach ($facture->getProduits() as $p){
		        	$facture->removeProduit($p);
		        }
		        $em->persist($facture);
		        
		        foreach ($listProduits as $p){
		        	$p->setFacture($facture);
		        }

		        foreach ($listProduits as $p){
		        	$em->persist($p);
		        }
		        $em->flush();


		        return $this->redirectToRoute("ep_show_client");
		    } else {
		    	return new Response("<body></body>");
		    }
    	}

    	return $this->render('EPUploadBundle:Facture:editFacture.html.twig', array(
    		'form'=> $form->createView(),
    		'produits' => $produits
    		));
    }

    // TODO DownloadAction
    

}