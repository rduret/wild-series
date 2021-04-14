<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
* @Route("/programs/", name="program_")
*/
class ProgramController extends AbstractController
{
    /**
    * @Route("", name="index")
    */
    public function index(): Response
    {
        return $this->render('Program/list.html.twig');
    }

    /**
    * @Route("{id}", name="show", requirements={"id"="\d+"}, methods={"GET"})
    */
    public function show(int $id)
    {
        return $this->render('Program/show.html.twig', ['id' => $id]);
    }
}