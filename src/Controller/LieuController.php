<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/lieu')]
class LieuController extends AbstractController
{
    public function __construct(private readonly LieuRepository $lieuRepository)
    {
    }

    #[Route(path: '/', name: 'app_lieu_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('lieu/index.html.twig', [
            'lieus' => $this->lieuRepository->findAll(),
        ]);
    }

    #[Route(path: '/count', name: 'app_lieu_indexCount', methods: ['GET'])]
    public function indexCount(): Response
    {
        $countLieuCompetition = $this->lieuRepository->countLieuCompetition();
        // dd($countLieuCompetition);
        return $this->render('lieu/indexCount.html.twig', [
            'countLieuCompetition' => $countLieuCompetition
        ]);
    }

    #[Route(path: '/new', name: 'app_lieu_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $lieu = new Lieu();
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->lieuRepository->add($lieu, true);

            return $this->redirectToRoute('app_lieu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lieu/new.html.twig', [
            'lieu' => $lieu,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_lieu_show', methods: ['GET'])]
    public function show(Lieu $lieu): Response
    {
        return $this->render('lieu/show.html.twig', [
            'lieu' => $lieu,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'app_lieu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lieu $lieu): Response
    {
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->lieuRepository->add($lieu, true);

            return $this->redirectToRoute('app_lieu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lieu/edit.html.twig', [
            'lieu' => $lieu,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_lieu_delete', methods: ['POST'])]
    public function delete(Request $request, Lieu $lieu): Response
    {
        if ($this->isCsrfTokenValid('delete' . $lieu->getId(), $request->request->get('_token'))) {
            $this->lieuRepository->remove($lieu, true);
        }

        return $this->redirectToRoute('app_lieu_index', [], Response::HTTP_SEE_OTHER);
    }
}
