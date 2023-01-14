<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Conference;

class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        return $this->render('conference/index.html.twig', ['conferences' => $conferenceRepository->findAll()]);
    }

    #[Route('/conference/{id}', name: 'conference')]
    public function show(Conference $conference, CommentRepository $commentRepository)
    {
        $comments = $commentRepository->findBy(['conference' => $conference]);

        return $this->render('conference/show.html.twig', compact('conference', 'comments'));
    }
}
