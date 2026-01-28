<?php

namespace App\Controller;

use App\Entity\Sponsor;
use App\Form\SponsorType;
use App\Repository\SponsorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/sponsor')]
class SponsorController extends AbstractController
{

    public function __construct(private readonly SponsorRepository $sponsorRepository, private readonly PaginatorInterface $paginator)
    {
    }

    #[Route(path: '/', name: 'sponsor', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $sponsors = $this->paginator->paginate(
            $this->sponsorRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        return $this->render('sponsor/index.html.twig', [
            'sponsors' => $sponsors,
        ]);

    }

    #[Route(path: '/new', name: 'sponsor_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $sponsor = new Sponsor();
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sponsorRepository->add($sponsor, true);

            $this->addFlash("success", "Le sponsor à bien été ajouté");

            return $this->redirectToRoute('sponsor', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sponsor/new.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form,
        ]);
    }

    #[Route(path: '/{id}', name: 'sponsor_show', methods: ['GET'])]
    public function show(Sponsor $sponsor): Response
    {
        return $this->render('sponsor/show.html.twig', [
            'sponsor' => $sponsor,
        ]);
    }

    #[Route(path: '/{id}/edit', name: 'sponsor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sponsor $sponsor): Response
    {
        $form = $this->createForm(SponsorType::class, $sponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sponsorRepository->add($sponsor, true);

            $this->addFlash("success", "Le sponsor à bien été modifié");

            return $this->redirectToRoute('sponsor', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sponsor/edit.html.twig', [
            'sponsor' => $sponsor,
            'form' => $form,
        ]);
    }

    #[Route(path: '/delete/{id}', name: 'sponsor_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Sponsor $sponsor): Response
    {

        if ($this->isCsrfTokenValid('delete' . $sponsor->getId(), $request->request->get('_token'))) {
            $this->sponsorRepository->remove($sponsor, true);

            $this->addFlash("success", "Le sponsor à bien été supprimé");
        } else {
            $this->addFlash("danger", "Le sponsor n'a pas été supprimé");

        }

        return $this->redirectToRoute('sponsor');
    }
}
