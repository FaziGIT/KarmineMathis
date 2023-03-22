<?php

namespace App\Controller;

use App\Entity\CategorieJeu;
use App\Form\CategorieJeuType;
use App\Repository\CategorieJeuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categorie/jeu")
 */
class CategorieJeuController extends AbstractController
{
    /**
     * @Route("/", name="app_categorie_jeu_index", methods={"GET"})
     */
    public function index(CategorieJeuRepository $categorieJeuRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $categorie_jeus = $paginator->paginate(
            $categorieJeuRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            5 /*limit per page*/
        );

        return $this->render('categorie_jeu/index.html.twig', [
            'categorie_jeus' => $categorie_jeus,
        ]);
    }

    /**
     * @Route("/new", name="app_categorie_jeu_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategorieJeuRepository $categorieJeuRepository): Response
    {
        $categorieJeu = new CategorieJeu();
        $form = $this->createForm(CategorieJeuType::class, $categorieJeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieJeuRepository->add($categorieJeu, true);

            $this->addFlash("success","La catégorie à bien été ajoutée");

            return $this->redirectToRoute('app_categorie_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_jeu/new.html.twig', [
            'categorie_jeu' => $categorieJeu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_categorie_jeu_show", methods={"GET"})
     */
    public function show(CategorieJeu $categorieJeu): Response
    {
        return $this->render('categorie_jeu/show.html.twig', [
            'categorie_jeu' => $categorieJeu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_categorie_jeu_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CategorieJeu $categorieJeu, CategorieJeuRepository $categorieJeuRepository): Response
    {
        $form = $this->createForm(CategorieJeuType::class, $categorieJeu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieJeuRepository->add($categorieJeu, true);

            $this->addFlash("success","La catégorie à bien été modifiée");

            return $this->redirectToRoute('app_categorie_jeu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_jeu/edit.html.twig', [
            'categorie_jeu' => $categorieJeu,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_categorie_jeu_delete", methods={"POST"})
     */
    public function delete(Request $request, CategorieJeu $categorieJeu, CategorieJeuRepository $categorieJeuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieJeu->getId(), $request->request->get('_token'))) {
            $categorieJeuRepository->remove($categorieJeu, true);

            $this->addFlash("success","La catégorie à bien été supprimée ");
        }


        return $this->redirectToRoute('app_categorie_jeu_index', [], Response::HTTP_SEE_OTHER);
    }
}
