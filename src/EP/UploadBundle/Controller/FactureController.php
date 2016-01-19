<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\FactureProduit;
use EP\UploadBundle\Form\FactureProduitType;
use EP\UploadBundle\Entity\Facture;
use EP\UploadBundle\Form\FactureType;
use EP\UploadBundle\Entity\Files;


use Knp\Snappy\Pdf;


class FactureController extends Controller
{
    public function editAction(Request $request) {
    	$facture = new Facture();
    	$form = $this->createForm(new FactureType(),$facture);
        $produits = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Produit")->findAll();
    	$clients = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Client")->findAll();

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
		        $this->generatePdf($facture,$listProduits);
		        return $this->redirectToRoute("ep_show_client");
		    } else {
		    	return new Response("<body></body>");
		    }
    	}

    	return $this->render('EPUploadBundle:Facture:editFacture.html.twig', array(
    		'form'=> $form->createView(),
            'produits' => $produits,
    		'clients' => $clients
    	));
    }
    
    public function generatePdf($facture , $listProduits){
        $category_comptable = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Category")->findOneByName('Comptable');

    	$file = new Files();
    	$file->setOwner($this->container->get('security.context')->getToken()->getUser());
    	$file->setCategory($category_comptable);
		$html = $this->renderView('EPUploadBundle:Facture:facturePDF.html.twig',
		        array(
		            'facture' => $facture,
		            'produits' => $listProduits		        
		            ));
		$dat = $facture->getDate()->format('Y-m-d');
		$path = $file->getUploadRootDir().'/';
		// $path = '../uploads/tmp/'.$facture->getId().'_facture_'.$dat.'.pdf';
		$fileName = $facture->getId().'_facture_'.$dat.'.pdf';
        $this->get('knp_snappy.pdf')->generateFromHtml(
		    $html,
		    $path.$fileName
		);
		
		$file->setName($fileName);
        $file->setExt('pdf');

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($file);
    	$em->flush();


		// $response =  new Response(
		//     $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
		//     200,
		//     array(
		//         'Content-Type'          => 'application/pdf',
		//         'Content-Disposition'   => 'attachment; filename='.$path2
		//     )
		// );
		// $pdf = $this->get('knp_snappy.pdf')->getOutputFromHtml($html);
		
		// return $response;
		//$file->setFile($fichier);
    }

}