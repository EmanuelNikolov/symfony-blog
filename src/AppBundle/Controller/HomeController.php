<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{

    /**
     * @Route("/", name="home_page", methods={"GET"})
     */
    public function indexAction()
    {
        return $this->render("default/index.html.twig");
    }
}
