<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Conference;
use Symfony\Component\HttpFoundation\Request;

class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        return $this->render('conference/index.html.twig', ['conferences' => $conferenceRepository->findAll()]);
    }

    #[Route('/conference/{id}', name: 'conference')]
    public function show(Request $request, Conference $conference, CommentRepository $commentRepository)
    {
        $offset = $request->query->getInt('offset', 0);
        $comments = $commentRepository->getCommentPaginator($conference, $offset);
        $prev = $offset - CommentRepository::PAGINATOR_PER_PAGE;
        $next = min(count($comments), $offset + CommentRepository::PAGINATOR_PER_PAGE);


        return $this->render('conference/show.html.twig', compact('conference', 'comments', 'prev', 'next'));
    }
}
