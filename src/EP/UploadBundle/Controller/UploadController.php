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
        return $this->render('EPUploadBundle::layout.html.twig', array('name' => 'farid'));
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

      $request->getSession()->getFlashBag()->add('info', 'Document bien enregistrée.');

      // On redirige vers la page de visualisation de l'annonce nouvellement créée
      // return $this->redirect($this->generateUrl('ep_upload_home', array('id' => $file->getId())));
    }

        $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('EPUploadBundle:Files')
    ;
    $listDocs = $repository->findAll();

    // À ce stade, le formulaire n'est pas valide car :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('EPUploadBundle:Upload:upload.html.twig', array(
      'form' => $form->createView(),
      'file'=>$file, 
      'docs'=>$listDocs
    ));
	}

  public function deleteAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    // On récupère le document $id
    $doc = $em->getRepository('EPUploadBundle:Files')->find($id);

    if (null === $doc) {
      throw new NotFoundHttpException("Le document d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->createFormBuilder()->getForm();

    if ($form->handleRequest($request)->isValid()) {
      $em->remove($doc);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "Le document a bien été supprimée.");

      return $this->redirect($this->generateUrl('ep_upload_file'));
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('EPUploadBundle:Upload:delete.html.twig', array(
      'doc' => $doc,
      'form'   => $form->createView()
    ));
  }

  public function listAction(Request $request){
    $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('EPUploadBundle:Files')
    ;

    // on parse la requête pour savoir s'il y a des paramètres
    // de tri, de recherche, etc.
    $search = $request->query->get('search');
    $orderby = $request->query->get('orderby');
    if (null === $orderby) {
      $orderby = "name";
    }
    
    // on utilise la fonction de recherche permettant de récupérer
    // les fichiers en fonction de tout ces paramètres
    $listDocs = $repository->findAllWithParameters($search, $orderby);


    // foreach ($listDocs as $doc) {
    //   // $advert est une instance de Advert
    //   echo $doc->getContent();
    // }
    // return $this->redirect($this->generateUrl('ep_upload_file', array('docs' => $listDocs)));
    return $this->render('EPUploadBundle:Upload:view_list.html.twig', array(
      'docs' => $listDocs
    ));

  }
}
