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
use Symfony\Component\HttpFoundation\File\File;
use Knp\Snappy\Pdf;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ACCESS_EDIT_FACTURE')")
 */
class FactureController extends Controller
{

    /**
      * Permet la création d'une facture
      * @param request : la requête envoyé
      */
    public function editAction(Request $request) {
    	$facture = new Facture();
        $user = $this->container->get('security.context')->getToken()->getUser();
    	$form = $this->createForm(new FactureType($user),$facture);
        $produits = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Produit")->findAll();
    	$clients = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Client")->findAll();

    	if($this->getRequest()->isMethod('POST')) {

		    if($form->handleRequest($request)->isValid()){		        
		        $em = $this->getDoctrine()->getManager();
		        $pem = $this->getDoctrine()->getManager()->getRepository("EPUploadBundle:Produit");

		        $facture->setOwner($user);
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
		        return $this->redirectToRoute("ep_view_file");
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
    

    /**
      * Permet la génération en PDF d'une facture
      * @param facture : la facture
      * @param listProduits : la liste des produits présents dans la facture
      */    
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
		$fileName = $facture->getId().'_facture_'.$dat.'.pdf';
        $this->get('knp_snappy.pdf')->generateFromHtml(
		    $html,
		    $path.$fileName
		);

		$myfile= new File($path.$fileName);

		$file->setFile($myfile);

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($file);
    	$em->flush();

    }

}