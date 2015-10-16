<?php

namespace RideBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('RideBundle:Default:index.html.twig', array('name' => $name));
    }
}
