<?php

namespace EP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\UserGrantsType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Je récupère l'ensemble des utilisateurs
        $users = $this->container->get("fos_user_.user_manager")->findUsers();
        $count = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->countUntreated();

        $untreated = array();
        foreach ($users as $key => $user) {
            $untreated[$user->getUsername()] = 0;
        }

        foreach($count as $c) {
            $untreated[$c['username']] = $c[1];
        }


        // Je retire les utilisateurs qui sont administrateurs
        foreach ($users as $key => $user) {
            if ($user->hasRole("ROLE_ADMIN")) {
                unset($users[$key]);
            }
        }

        return $this->render("EPAdminBundle:Default:index.html.twig", array(
            "count" => $untreated,
            "users" => $users
        ));
    }

    public function userAction($username, Request $request)
    {
        $user = $this->container->get("fos_user_.user_manager")->findUserByUsername($username);
        $userForm = $this->createForm(new UserGrantsType(), $user);

        if ($userForm->handleRequest($request)->isValid()) {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
        }

        $search = $request->query->get('search') or $search = "";
        $orderby = $request->query->get('orderby') or $orderby = "name";
        $order = $request->query->get('order') or $order = "ASC";
        $categoryFilter = $request->query->get("categoryFilter") or $categoryFilter = "";
        $extFilter = $request->query->get("extFilter") or $extFilter = "";
        $nbPerPage = $request->query->get("nbPerPage") or $nbPerPage = 5;

        $categories = $this->getDoctrine()->getManager()->getRepository('EPUploadBundle:Category')->findAll();
        $extensions = ['jpeg','pdf','doc','docx','ppt','pptx','xls','xlsx','txt'];
        
        $query = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('EPUploadBundle:Files')
            ->getSearchQuery($user, $search, $orderby, $order, $categoryFilter, $extFilter);

        $listDocs = $this->get('knp_paginator')->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $nbPerPage/*limit per page*/
        );

        return $this->render("EPAdminBundle:Default:user_files.html.twig",array(
            "user" => $user,
            "docs" => $listDocs,
            'categories' => $categories,
            'extensions' => $extensions,
            'userForm' => $userForm->createView()
        ));
    }

    public function setRightsAction($username, Request $request) {
        $user = $this->container->get("fos_user_.user_manager")->findUserByUsername($username);
        $userForm = $this->createForm(new UserGrantsType(), $user, array(
            "action" => $this->generateUrl('ep_set_rights', array("username" => $username)),
            "method" => "POST"
        ));

        if ($request->isMethod("POST")) {
            $userForm->handleRequest($request);
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('ep_admin_user_files', array("username" => $username));
        }

        return $this->render("EPAdminBundle:Default:setRights.html.twig",array(
            'userForm' => $userForm->createView()
        ));
    }
}
