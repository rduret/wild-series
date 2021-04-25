<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Service\Slugify;
use App\Form\ProgramType;


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
    * @Route("new", 
    * name="new")
    */
    public function new(Request $request, EntityManagerInterface $entityManager, Slugify $slugify)
    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);

        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);

            $entityManager->persist($program);

            // Flush the persisted object
            $entityManager->flush();

            // Finally redirect to categories list
            return $this->redirectToRoute('program_index');
        }

        // Render the form
        return $this->render('Program/new.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
    * @Route("{slug}", 
    * name="show",
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
    * @Route("{slug}/seasons/{number}", 
    * name="season_show",
    * methods={"GET"})
    */
    public function showSeason(Program $program, Season $season)
    {
        return $this->render('Program/season_show.html.twig', ['program' => $program, 'season' => $season]);
    }


    /**
    * @Route("{program}/seasons/{number}/episodes/{episode}", 
    * name="episode_show",
    * requirements={"season"="\d+"},
    * methods={"GET"})
    * @ParamConverter("program", class="App\Entity\Program", options={"mapping": {"program": "slug"}})
    * @ParamConverter("episode", class="App\Entity\Episode", options={"mapping": {"episode": "slug"}})
    */
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('Program/episode_show.html.twig', 
            [
            'program' => $program, 
            'season' => $season,
            'episode' => $episode
            ]);
    }
}