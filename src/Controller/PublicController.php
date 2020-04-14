<?php

namespace GreenHollow\Pantry\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The public controller.
 */
class PublicController extends AbstractController
{
    /**
     * @Route("/", name="public_home")
     */
    public function homeAction(): Response
    {
        return $this->render('public/home.html.twig', []);
    }
}
