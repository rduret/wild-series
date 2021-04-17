<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;

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

        $seasons = $program->getSeasons();
        var_dump(sizeof($seasons));

        return $this->render('Program/show.html.twig', ['program' => $program, 'seasons' => $seasons]);
    }

    /**
    * @Route("{programId}/seasons/{seasonId}", 
    * name="season_show",
    * requirements={"programId"="\d+", "seasonId"="\d+"},
    * methods={"GET"})
    */
    public function showSeason(int $programId, int $seasonId)
    {
        $program = $this->getDoctrine()->getRepository(Program::class)->findOneBy(['id' => $programId]);
        $season =  $this->getDoctrine()->getRepository(Season::class)->findOneBy(['id' => $seasonId]);

        return $this->render('Program/season_show.html.twig', ['program' => $program, 'season' => $season]);

    }
}