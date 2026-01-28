<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/equipe')]
class EquipeController extends AbstractController
{
    public function __construct(private readonly EquipeRepository $equipeRepository, private readonly PaginatorInterface $paginator)
    {
    }

    #[Route(path: '/', name: 'app_equipe_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $equipes = $this->paginator->paginate(
            $this->equipeRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipes,
        ]);
    }

    #[Route(path: '/new', name: 'app_equipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->equipeRepository->add($equipe, true);

            $this->addFlash("success", "L'équipe à bien été ajoutée");

            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'app_equipe_show', methods: ['GET'])]
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'app_equipe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Equipe $equipe): Response
    {
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->equipeRepository->add($equipe, true);

            $this->addFlash("success", "L'équipe à bien été modifiée");

            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe/edit.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    #[Route(path: '/delete/{id}', name: 'app_equipe_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Equipe $equipe): Response
    {
        if ($this->isCsrfTokenValid('delete' . $equipe->getId(), $request->request->get('_token'))) {
            $this->equipeRepository->remove($equipe, true);

            $this->addFlash("success", "L'équipe à bien été supprimée");
        }


        return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
    }
}
