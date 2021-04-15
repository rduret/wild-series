<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;

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
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();
        return $this->render('Program/index.html.twig', ['programs' => $programs]);
    }

    /**
    * @Route("{id}", 
    * name="show",
    * requirements={"id"="\d+"},
    * methods={"GET"})
    */
    public function show(int $id)
    {
        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $id]);
        
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

        return $this->render('Program/show.html.twig', ['program' => $program]);
    }
}