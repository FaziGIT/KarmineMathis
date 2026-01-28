<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Form\JeuType;
use App\Form\FiltreJeuType;
use App\Repository\JeuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/jeu')]
class JeuController extends AbstractController
{

    public function __construct(private readonly JeuRepository $jeuRepository, private readonly PaginatorInterface $paginator)
    {
    }

    #[Route(path: '/new', name: 'app_jeu_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $jeu = new Jeu();
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->jeuRepository->add($jeu, true);

            $this->addFlash("success", "Le jeu à bien été ajouté");

            return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jeu/new.html.twig', [
            'jeu' => $jeu,
            'form' => $form,
        ]);
    }


    #[Route(path: '/', name: 'app_jeu_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $nom = null;
        $formFiltreJeu = $this->createForm(FiltreJeuType::class);
        $formFiltreJeu->handleRequest($request);
        if ($formFiltreJeu->isSubmitted() && $formFiltreJeu->isValid()) {
            // On récupère la saisie dans le formulaire du nom
            $nom = $formFiltreJeu->get('nom')->getData();
        }

        // dd($nom);


        $jeux = $this->paginator->paginate(
            $this->jeuRepository->listeJeuxPaginees($nom), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('jeu/index.html.twig', [
            'jeux' => $jeux,
            'formFiltreJeu' => $formFiltreJeu
        ]);
    }


    #[Route(path: '/{id}/edit', name: 'app_jeu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jeu $jeu): Response
    {
        $form = $this->createForm(JeuType::class, $jeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->jeuRepository->add($jeu, true);

            $this->addFlash("success", "Le jeu à bien été modifié");

            return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jeu/edit.html.twig', [
            'jeu' => $jeu,
            'form' => $form,
        ]);
    }

    #[Route(path: '/delete/{id}', name: 'app_jeu_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Jeu $jeu): Response
    {
        if ($this->isCsrfTokenValid('delete' . $jeu->getId(), $request->request->get('_token'))) {
            $this->jeuRepository->remove($jeu, true);

            $this->addFlash("success", "Le jeu à bien été supprimé");
        }


        return $this->redirectToRoute('app_jeu_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(path: '/{id}', name: 'app_jeu_show', methods: ['GET'])]
    public function show(Jeu $jeu): Response
    {
        return $this->render('jeu/show.html.twig', [
            'jeu' => $jeu,
        ]);
    }
}
