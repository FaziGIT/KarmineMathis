<?php

namespace App\Controller;

use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Model\FiltreCompetition;
use App\Form\FiltreCompetitionType;
use App\Repository\CompetitionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/competition')]
class CompetitionController extends AbstractController
{
    public function __construct(private readonly CompetitionRepository $competitionRepository, private readonly PaginatorInterface $paginator)
    {
    }

    #[Route(path: '/', name: 'competition', methods: ['GET'])]
    public function index(Request $request): Response
    {

        $filtre = new FiltreCompetition();
        $formFiltreCompetition = $this->createForm(FiltreCompetitionType::class, $filtre);
        $formFiltreCompetition->handleRequest($request);
        $competitions = $this->paginator->paginate(
            $this->competitionRepository->listeCompetitionsCompletePaginee($filtre), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('competition/index.html.twig', [
            'competitions' => $competitions,
            'formFiltreCompetition' => $formFiltreCompetition
        ]);
    }

    #[Route(path: '/new', name: 'competition_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $competition = new Competition();
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->competitionRepository->add($competition, true);

            $this->addFlash("success", "La compétition à bien été ajoutée");

            return $this->redirectToRoute('competition', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('competition/new.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'competition_show', methods: ['GET'])]
    public function show(Competition $competition): Response
    {
        return $this->render('competition/show.html.twig', [
            'competition' => $competition,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'competition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Competition $competition): Response
    {
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->competitionRepository->add($competition, true);

            $this->addFlash("success", "La compétition à bien été modifiée");

            return $this->redirectToRoute('competition', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('competition/edit.html.twig', [
            'competition' => $competition,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'competition_delete', methods: ['POST'])]
    public function delete(Request $request, Competition $competition): Response
    {
        if ($this->isCsrfTokenValid('delete' . $competition->getId(), $request->request->get('_token'))) {
            $this->competitionRepository->remove($competition, true);

            $this->addFlash("success", "La compétition à bien été supprimé");
        }

        return $this->redirectToRoute('competition', [], Response::HTTP_SEE_OTHER);
    }
}
