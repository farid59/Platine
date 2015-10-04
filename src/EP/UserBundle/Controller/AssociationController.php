<?php

namespace EP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AssociationController extends Controller
{

    /**
     * @Security("has_role('ROLE_EMPTY')")
     */
    public function createAction()
    {
        return $this->render('EPUserBundle:Association:create.html.twig', array(
                // ...
            ));    
    }
    /**
     * @Security("has_role('ROLE_EMPTY')")
     */
    public function joinAction() {

        return $this->render('EPUserBundle:Association:join.html.twig', array(
                // ...
            ));    
    }

    /**
     * Il faut être admin ou employee d'une associaiton pour pouvoir la quitter
     *
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_EMPLOYEE')")
     */
    public function leaveAction() {

        return $this->render('EPUserBundle:Association:leave.html.twig', array(
                // ...
            ));    
    }

}
