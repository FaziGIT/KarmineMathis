<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="app_user_profil")
     */
    public function userProfil(): Response
    {
        return $this->render('user/profil.html.twig');
    }

    /**
     * @Route("/profil/modifier/{id}", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            //on récupère l'avatar sélectionné
            $fichierImage=$form->get('avatarFile')->getData();
            if ($fichierImage !=null) {
                
                // On supprimer l'ancien avatar
                if($user->getAvatar()!="userVierge.png"){
                    \unlink($this->getParameter('imagesAvatarDestination').$user->getAvatar());
                }

                // On crée le nom du nouveau fichier avatar
                $fichier=md5(\uniqid()).".".$fichierImage->guessExtension();

                // on déplace le fichier chargé dans le dossier public
                $fichierImage->move($this->getParameter('imagesAvatarDestination'),$fichier);

                $user->setAvatar($fichier);
                
                $entityManager->flush();
                
            }


            $this->addFlash("success","Votre profil bien été modifié");

            return $this->redirectToRoute('app_user_profil', [], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash("red","Erreur : Le profil n'a pas pu être modifié");

        if ($this->getUser()==$user) {
            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }
        else {
                $this->addFlash("red","Erreur : Vous ne pouvez pas modifier le profil d'un autre utilisateur");
            return $this->redirectToRoute('app_user_profil');
        }
        
    }
}
