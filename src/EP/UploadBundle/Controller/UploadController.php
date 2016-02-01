<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EP\UploadBundle\Entity\Files;
use EP\UploadBundle\Form\FilesType;
use Symfony\Component\HttpFoundation\Session\Session;

class UploadController extends Controller
{

    public function indexAction()
    {
        $authChecker = $this->get('security.authorization_checker');
        if ($authChecker->isGranted("ROLE_ADMIN")) {
          // return $this->forward("EPAdminBundle:Default:index");
          return $this->redirectToRoute('ep_admin_homepage');
        } else {
          return $this->redirectToRoute('ep_user_homepage');
        }

        // return $this->render('EPUploadBundle::layout.html.twig', array('name' => 'farid'));
        // return new Response("Hello World !");
    }

    public function homeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $clients_repository = $em->getRepository("EPUploadBundle:Client");
        $produits_repository = $em->getRepository("EPUploadBundle:Produit");
        $fichiers_repository = $em->getRepository("EPUploadBundle:Files");
        $factures_repository = $em->getRepository("EPUploadBundle:Facture");

        $clients = $clients_repository->findLast($user);
        $produits = $produits_repository->findLast($user);
        $fichiers = $fichiers_repository->findLast($user);
        
        $count = array();
        $count['clients'] = $clients_repository->count($user);
        $count['produits'] = $produits_repository->count($user);
        $count['fichiers'] = $fichiers_repository->count($user);
        $count['factures'] = $factures_repository->count($user);

        return $this->render("EPUploadBundle:Upload:home.html.twig", array(
            "clients" => $clients,
            "produits" => $produits,
            "fichiers" => $fichiers,
            "count" => $count
        ));
    }

    public function uploadAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $filesRepo = $em->getRepository("EPUploadBundle:Files");
      $session = $request->getSession();
      // On crée un objet Advert
      
      $file = new Files();
      if ($session->has('last_file_without_owner')) {
          $file = $filesRepo->findOneById($session->get('last_file_without_owner'));
      }

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
        $file->setOwner($this->container->get('security.context')->getToken()->getUser());
        $em->persist($file);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', 'Document bien enregistrée.');

        if ($session->has('last_file_without_owner')) {
            $session->remove('last_file_without_owner');

            $filesToRemove = $filesRepo->findByOwner(null);
            foreach($filesToRemove as $ftr) {
                $em->remove($ftr);
            }
        }

        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        // return $this->redirect($this->generateUrl('ep_upload_home', array('id' => $file->getId())));
      } else if ($request->isMethod('POST')) {
          $file->setFile($request->files->get('file'));
          $em->persist($file);
          $em->flush();

          $session->set('last_file_without_owner', $file->getId());
      }

      $listDocs = $filesRepo->findLast($this->container->get('security.context')->getToken()->getUser());

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
      $session = $this->getRequest()->getSession();

      if ($form->handleRequest($request)->isValid()) {
        $em->remove($doc);
        $em->flush();

        $request->getSession()->getFlashBag()->add('info', "Le document a bien été supprimée.");

        // return $this->redirect($this->generateUrl('ep_upload_file'));
        // 
        if ($session->get('referer') === null) {
          return $this->redirect($request->headers->get('referer'));
        } else {
          $referer = $session->get('referer');
          $session->remove('referer');
          return $this->redirect($referer);
        }
      } else {
        $session->set('referer', $request->headers->get('referer'));
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

      $categories = $this->getDoctrine()->getManager()->getRepository('EPUploadBundle:Category')->findAll();
      $extensions = ['jpeg','pdf','doc','docx','ppt','pptx','xls','xlsx','txt'];

      // $nbPerPagePossibilities = [5, 10, 15, 20, 25];

      // on parse la requête pour savoir s'il y a des paramètres
      // de tri, de recherche, etc.
      $search = $request->query->get('search') or $search = "";
      $orderby = $request->query->get('orderby') or $orderby = "date";
      $order = $request->query->get('order') or $order = "DESC";
      $categoryFilter = $request->query->get("categoryFilter") or $categoryFilter = "";
      $extFilter = $request->query->get("extFilter") or $extFilter = "";
      $nbPerPage = $request->query->get("nbPerPage") or $nbPerPage = 5;
      
      // on utilise la fonction de recherche permettant de récupérer
      // les fichiers en fonction de tout ces paramètres
      
      $query = $repository->getSearchQuery($this->container->get('security.context')->getToken()->getUser(), $search, $orderby, $order, $categoryFilter, $extFilter);
      // $listDocs = $repository->findAllWithParameters($search, $orderby, $categoryFilter, $extFilter);
      $listDocs = $this->get('knp_paginator')->paginate(
          $query, /* query NOT result */
          $request->query->getInt('page', 1)/*page number*/,
          $nbPerPage/*limit per page*/
      );


      // foreach ($listDocs as $doc) {
      //   // $advert est une instance de Advert
      //   echo $doc->getContent();
      // }
      // return $this->redirect($this->generateUrl('ep_upload_file', array('docs' => $listDocs)));
      return $this->render('EPUploadBundle:Upload:view_list.html.twig', array(
        'docs' => $listDocs,
        'categories' => $categories,
        'extensions' => $extensions
      ));

    }

    public function downloadAction($fileId, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $file = $em->getRepository("EPUploadBundle:Files")->findOneById($fileId);
      

      $fichier = $file->getName();
      $chemin = $file->getPath(); // emplacement de votre fichier .pdf

      if ($this->get('security.authorization_checker')->isGranted("ROLE_ADMIN")) {
        $file->setTreated();
        $em->persist($file);
        $em->flush();
      }

      $response = new Response();
      $response->setContent(file_get_contents($file->getWebPath()));
      $response->headers->set('Content-Type', 'application/force-download');
      $response->headers->set('Content-disposition', 'filename='. $fichier);

      return $response;
    }

    public function downloadUntreatedAction($username, Request $request) {
      $em = $this->getDoctrine()->getManager(); 
      $user = $this->container->get("fos_user_.user_manager")->findUserByUsername($username);
      $files = $em->getRepository("EPUploadBundle:Files")->findAllUntreated($user);

      if (count($files) > 0) {

          $oZip = new \ZipArchive();
          $archiveName = $username."_files.zip";
          $archivePath = $this->get('kernel')->getRootDir()."/../uploads/".$archiveName;

          $oZip->open($archivePath, \ZipArchive::CREATE);


          foreach ($files as $file) {
            $oZip->addFromString($file->getWebName(), file_get_contents($file->getWebPath()));

            if ($this->get('security.authorization_checker')->isGranted("ROLE_ADMIN")) {
                $file->setTreated();
                $em->persist($file);
                $em->flush();
            }

          }

          $oZip->close();
          $response = new Response();
          $response->setContent(file_get_contents($archivePath));
          $response->headers->set('Content-Type', 'application/force-download');
          $response->headers->set('Content-disposition', 'filename='.$archiveName);

          unlink($archivePath);

          return $response;
      }

      $request->getSession()->getFlashBag()->add('success', 'Tous les fichiers sont déjà traités');
      return $this->redirectToRoute('ep_admin_user_files', array("username" => $username));
      
    }
}
