<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EP\UploadBundle\Entity\Files;
use EP\UploadBundle\Form\FilesType;

class UploadController extends Controller
{
    public function indexAction()
    {
        return $this->render('EPUploadBundle:Upload:index.html.twig', array('name' => 'farid'));
        // return new Response("Hello World !");
    }

    public function uploadAction(Request $request)
    {
   	// On crée un objet Advert
    $file = new Files();
    // On crée le FormBuilder grâce au service form factory
    // $form = $this->get('form.factory')->create(new FilesType,$file);
	$form = $this->createForm(new FilesType(), $file);
    // On fait le lien Requête <-> Formulaire
    // À partir de maintenant, la variable $file contient les valeurs entrées dans le formulaire par le visiteur
    $form->handleRequest($request);

    // On vérifie que les valeurs entrées sont correctes
    // (Nous verrons la validation des objets en détail dans le prochain chapitre)
    if ($form->isValid()) {
      // On l'enregistre notre objet $advert dans la base de données, par exemple
      $em = $this->getDoctrine()->getManager();
      $em->persist($file);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

      // On redirige vers la page de visualisation de l'annonce nouvellement créée
      // return $this->redirect($this->generateUrl('ep_upload_home', array('id' => $file->getId())));
    }

    // À ce stade, le formulaire n'est pas valide car :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('EPUploadBundle:Upload:form.html.twig', array(
      'form' => $form->createView(),'file'=>$file
    ));
	}
}