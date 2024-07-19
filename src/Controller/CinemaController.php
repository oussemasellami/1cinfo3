<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\FilmType;
use App\Repository\CinemaRepository;
use App\Repository\SalleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CinemaController extends AbstractController
{
    #[Route('/cinema', name: 'app_cinema')]
    public function index(): Response
    {
        return $this->render('cinema/index.html.twig', [
            'controller_name' => 'CinemaController',
        ]);
    }

    #[Route('/showcinema', name: 'app_showcinema')]
    public function showcinema(CinemaRepository $cinemaRepository): Response
    {

        // $cinema = $cinemaRepository->findAll();
        $cinema = $cinemaRepository->adresseLike();
        return $this->render('cinema/showcinema.html.twig', [
            'cinema' => $cinema,
        ]);
    }

    #[Route('/showfilm', name: 'app_showfilm')]
    public function showfilm(SalleRepository $salleRepository): Response
    {

        //$film = $salleRepository->findAll();
        $film = $salleRepository->Orderby();
        return $this->render('cinema/showfilm.html.twig', [
            'film' => $film,
        ]);
    }




    #[Route('/Addfilm', name: 'app_Addfilm')]
    public function Addfilm(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $em = $managerRegistry->getManager();
        $author = new Salle();
        $form = $this->createForm(FilmType::class, $author);
        $form->handleRequest($req); //******************* */
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_showfilm');
        }

        return $this->renderForm('cinema/Addfilm.html.twig', [
            'filmform' => $form,
        ]);
    }



    #[Route('/deletecinema/{id}', name: 'app_deletecinema')]
    public function deleteauthornew($id, CinemaRepository $cinemaRepository, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        //var_dump($id) . die();
        $author = $cinemaRepository->find($id);
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('app_showcinema');
    }
}
