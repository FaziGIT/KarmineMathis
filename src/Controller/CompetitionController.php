<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Repository\CompetitionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/competition")
 */
class CompetitionController extends AbstractController
{
    /**
     * @Route("/", name="competition", methods={"GET"})
     */
    public function index(CompetitionRepository $competitionRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $competitions = $paginator->paginate(
            $competitionRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('competition/index.html.twig', [
            'competitions' => $competitions,
        ]);
    }

    /**
     * @Route("/new", name="competition_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompetitionRepository $competitionRepository): Response
    {
        $competition = new Competition();
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competitionRepository->add($competition, true);

            $this->addFlash("success","La compétition à bien été ajoutée");

            return $this->redirectToRoute('competition', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competition/new.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="competition_show", methods={"GET"})
     */
    public function show(Competition $competition): Response
    {
        return $this->render('competition/show.html.twig', [
            'competition' => $competition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="competition_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Competition $competition, CompetitionRepository $competitionRepository): Response
    {
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competitionRepository->add($competition, true);

            $this->addFlash("success","La compétition à bien été modifiée");

            return $this->redirectToRoute('competition', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competition/edit.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="competition_delete", methods={"POST"})
     */
    public function delete(Request $request, Competition $competition, CompetitionRepository $competitionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competition->getId(), $request->request->get('_token'))) {
            $competitionRepository->remove($competition, true);

            $this->addFlash("success","La compétition à bien été supprimé");
        }

        return $this->redirectToRoute('competition', [], Response::HTTP_SEE_OTHER);
    }
}
