<?php

namespace App\Controller;

use App\Entity\CategorieJeu;
use App\Form\CategorieJeuType;
use App\Repository\CategorieJeuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/categorie/jeu')]
class CategorieJeuController extends AbstractController
{
    public function __construct(private readonly CategorieJeuRepository $categorieJeuRepository, private readonly PaginatorInterface $paginator)
    {
    }

    #[Route(path: '/', name: 'app_categorie_jeu_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $categorie_jeus = $this->paginator->paginate(
            $this->categorieJeuRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('categorie_jeu/index.html.twig', [
            'categorie_jeus' => $categorie_jeus,
        ]);
    }

    #[Route(path: '/new', name: 'app_categorie_jeu_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $categorieJeu = new CategorieJeu();
        $form = $this->createForm(CategorieJeuType::class, $categorieJeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categorieJeuRepository->add($categorieJeu, true);

            $this->addFlash("success", "La catégorie à bien été ajoutée");

            return $this->redirectToRoute('app_categorie_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_jeu/new.html.twig', [
            'categorie_jeu' => $categorieJeu,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_categorie_jeu_show', methods: ['GET'])]
    public function show(CategorieJeu $categorieJeu): Response
    {
        return $this->render('categorie_jeu/show.html.twig', [
            'categorie_jeu' => $categorieJeu,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'app_categorie_jeu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieJeu $categorieJeu): Response
    {
        $form = $this->createForm(CategorieJeuType::class, $categorieJeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categorieJeuRepository->add($categorieJeu, true);

            $this->addFlash("success", "La catégorie à bien été modifiée");

            return $this->redirectToRoute('app_categorie_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie_jeu/edit.html.twig', [
            'categorie_jeu' => $categorieJeu,
            'form' => $form,
        ]);
    }

    #[Route(path: '/delete/{id}', name: 'app_categorie_jeu_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieJeu $categorieJeu): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categorieJeu->getId(), $request->request->get('_token'))) {
            $this->categorieJeuRepository->remove($categorieJeu, true);

            $this->addFlash("success", "La catégorie à bien été supprimée ");
        }


        return $this->redirectToRoute('app_categorie_jeu_index', [], Response::HTTP_SEE_OTHER);
    }
}
