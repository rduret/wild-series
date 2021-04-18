<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;

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
    public function show(Program $program)
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$program->getId().' found in program\'s table.'
            );
        }

        $seasons = $program->getSeasons();

        return $this->render('Program/show.html.twig', ['program' => $program, 'seasons' => $seasons]);
    }

    /**
    * @Route("{programId}/seasons/{seasonId}", 
    * name="season_show",
    * requirements={"program"="\d+", "season"="\d+"},
    * methods={"GET"})
    */
    public function showSeason(Program $programId, Season $seasonId)
    {
        return $this->render('Program/season_show.html.twig', ['program' => $programId, 'season' => $seasonId]);
    }


    /**
    * @Route("{programId}/seasons/{seasonId}/episodes/{episodeId}", 
    * name="episode_show",
    * requirements={"program"="\d+", "season"="\d+", "episode"="\d+"},
    * methods={"GET"})
    */
    public function showEpisode(Program $programId, Season $seasonId, Episode $episodeId)
    {
        return $this->render('Program/episode_show.html.twig', 
            [
            'program' => $programId, 
            'season' => $seasonId,
            'episode' => $episodeId
            ]);
    }
}