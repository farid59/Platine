<?php

namespace EP\UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MessagesController extends Controller
{
    public function messagesAction()
    {
        return $this->render('EPUploadBundle:Messages:messages.html.twig', array(
                // ...
            ));    }

    public function sendMessageAction()
    {
        return $this->render('EPUploadBundle:Messages:sendMessage.html.twig', array(
                // ...
            ));    }

    public function messageAction()
    {
        return $this->render('EPUploadBundle:Messages:message.html.twig', array(
                // ...
            ));    }

}
