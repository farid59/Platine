<?php

namespace EP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Je récupère l'ensemble des utilisateurs
        $users = $this->container->get("fos_user_.user_manager")->findUsers();

        // Je retire les utilisateurs qui sont administrateurs
        foreach ($users as $key => $user) {
            if ($user->hasRole("ROLE_ADMIN")) {
                unset($users[$key]);
            }
        }

        return $this->render("EPAdminBundle:Default:index.html.twig", array(
            "users" => $users
        ));
    }

    public function userAction($username, Request $request)
    {
        $user = $users = $this->container->get("fos_user_.user_manager")->findUserByUsername($username);

        $search = $request->query->get('search') or $search = "";
        $orderby = $request->query->get('orderby') or $orderby = "name";
        $categoryFilter = $request->query->get("categoryFilter") or $categoryFilter = "";
        $extFilter = $request->query->get("extFilter") or $extFilter = "";
        $nbPerPage = $request->query->get("nbPerPage") or $nbPerPage = 5;

        $categories = $this->getDoctrine()->getManager()->getRepository('EPUploadBundle:Category')->findAll();
        $extensions = ['jpeg','pdf','doc','docx','ppt','pptx','xls','xlsx','txt'];
        
        $query = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EPUploadBundle:Files')
            ->getSearchQuery($user, $search, $orderby, $categoryFilter, $extFilter);

        $listDocs = $this->get('knp_paginator')->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $nbPerPage/*limit per page*/
        );

        return $this->render("EPAdminBundle:Default:user_files.html.twig",array(
            "user" => $user,
            "docs" => $listDocs,
            'categories' => $categories,
            'extensions' => $extensions
        ));
    }
}
