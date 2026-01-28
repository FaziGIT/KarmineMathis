<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\FiltrePersonneType;
use App\Form\PersonneType;
use App\Model\FiltrePersonne;
use App\Repository\PersonneRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/personne')]
class PersonneController extends AbstractController
{


    public function __construct(private readonly PersonneRepository $personneRepository, private readonly PaginatorInterface $paginator)
    {
    }

    #[Route(path: '/', name: 'app_personne_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $filtre = new FiltrePersonne();
        $formFiltrePersonne = $this->createForm(FiltrePersonneType::class, $filtre);
        $formFiltrePersonne->handleRequest($request);
        $personnes = $this->paginator->paginate(
            $this->personneRepository->listePersonnesCompletePaginee($filtre), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'formFiltrePersonne' => $formFiltrePersonne
        ]);
    }


    #[Route(path: '/new', name: 'app_personne_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->personneRepository->add($personne, true);

            $this->addFlash("success", "La personne à bien été ajoutée");

            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('personne/new.html.twig', [
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    #[Route(path: '/show/{id}', name: 'app_personne_show', methods: ['GET'])]
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'app_personne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Personne $personne): Response
    {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            if ($form->get("radioButton")->getViewData() == 0) {
                $personne->setCoach(null);
                $personne->setJoueur(null);
            }
            $this->personneRepository->add($personne, true);

            $this->addFlash("success", "La personne à bien été modifiée");

            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('personne/edit.html.twig', [
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_personne_delete', methods: ['POST'])]
    public function delete(Request $request, Personne $personne): Response
    {
        if ($this->isCsrfTokenValid('delete' . $personne->getId(), $request->request->get('_token'))) {
            $this->personneRepository->remove($personne, true);

            $this->addFlash("success", "La personne à bien été supprimée");

        }

        return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(path: '/{role}', name: 'filtreRole', methods: ['GET', 'POST'])]
    public function listePersonnesRole($role): Response
    {
        $personnes = $this->personneRepository->findByRole($role);
        return $this->render('personne/listePersonnesRole.html.twig', [
            'personnes' => $personnes
        ]);
    }
}
