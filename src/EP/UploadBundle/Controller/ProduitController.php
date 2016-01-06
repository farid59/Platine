<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\Files;
use EP\UploadBundle\Form\FilesType;

class ProduitController extends Controller
{
    public function editAction() {
    	// $facture = new Facture();
    	// $form = $this->createForm(new FactureType(),$facture);
    	return $this->render('EPUploadBundle:Produit:showProduits.html.twig');
    }

    public function showAction(){
    	return $this->render('EPUploadBundle:Produit:showProduits.html.twig');	
    }

}