<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\FiltrePersonneType;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    
    
    /**
     * @Route("/", name="app_personne_index", methods={"GET"})
     */
    public function index(PersonneRepository $personneRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $nom=null;
        $formFiltrePersonne = $this->createForm(FiltrePersonneType::class);
        $formFiltrePersonne->handleRequest($request);
        if($formFiltrePersonne->isSubmitted() && $formFiltrePersonne->isValid()){
            // on récupère la saisie dans le formulaire
            $nom=$formFiltrePersonne->get('nom')->getData();
        }
        $personnes = $paginator->paginate(
            $personneRepository->listePersonnesCompletePaginee($nom), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'formFiltrePersonne' => $formFiltrePersonne->createView()
        ]);
    }


    /**
     * @Route("/new", name="app_personne_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PersonneRepository $personneRepository): Response
    {
        $personne = new Personne();
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->add($personne, true);

            $this->addFlash("success","La personne à bien été ajoutée");

            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne/new.html.twig', [
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_personne_show", methods={"GET"})
     */
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_personne_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $personneRepository->add($personne, true);

            $this->addFlash("success","La personne à bien été modifiée");

            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne/edit.html.twig', [
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_personne_delete", methods={"POST"})
     */
    public function delete(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getId(), $request->request->get('_token'))) {
            $personneRepository->remove($personne, true);

            $this->addFlash("success","La personne à bien été supprimée");

        }

        return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{role}", name="filtreRole", methods={"GET", "POST"})
     */
    public function listePersonnesRole(PersonneRepository $personneRepository, $role): Response
    {
        $personnes = $personneRepository->findByRole($role);
        return $this->render('personne/listePersonnesRole.html.twig', [
            'personnes' => $personnes
        ]);
    }
}
