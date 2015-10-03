<?php

namespace EP\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
	/**
	 * @Security("has_role('ROLE_USER')")
	 */
    public function indexAction()
    {
        return $this->render('EPUserBundle:Default:index.html.twig');
    }

}
