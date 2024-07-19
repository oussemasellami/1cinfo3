<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AuthorRepository;
use App\Entity\Author;
use App\Form\AuthorType;
use App\Form\MinmaxType;
use App\Form\SearchType;
use Doctrine\Persistence\ManagerRegistry;

class AuthornewController extends AbstractController
{
    #[Route('/authornew', name: 'app_authornew')]
    public function index(): Response
    {
        return $this->render('authornew/index.html.twig', [
            'controller_name' => 'AuthornewController',
        ]);
    }

    #[Route('/showauthornew', name: 'app_showauthornew')]
    public function showauthornew(AuthorRepository $authorRepository, Request $req): Response
    {
        $authors = $authorRepository->findAll();
        // $form = $this->createForm(SearchType::class);
        /*********************************************** */
        $form = $this->createForm(MinmaxType::class);
        /************************************************* */
        $form->handleRequest($req);
        /*************************search************************* */
        // $username = $form->get('username')->getData();
        /****************************************************** */
        $min = $form->get('min')->getData();
        $max = $form->get('max')->getData();
        //var_dump($min,$max) . die();
        if ($form->isSubmitted()) {
            /*************************search**************************** */
            // $author = $authorRepository->SearchAuthor($username);
            /**************************************************************** */
            $author = $authorRepository->minmaxbydql($min, $max);
            //$authors=$authorRepository->Orderby();
            //$authors = $authorRepository->UserenameLike();
            //$authors = $authorRepository->Orderbydql();
            //$authors = $authorRepository->UserenameLikemiddl();
            return $this->renderForm('authornew/showauthornew.html.twig', [
                'authors' => $author, 'f' => $form
            ]);
        }
        return $this->renderForm('authornew/showauthornew.html.twig', [
            'authors' => $authors, 'f' => $form
        ]);
    }


    #[Route('/Addauthornew', name: 'app_Addauthornew')]
    public function Addauthornew(ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        $author = new Author();
        $author->setUsername("mohamed");
        $author->setEmail("mohamed@esprit.tn");
        $author->setNbBooks(7);
        $em->persist($author);
        $em->flush();

        return new Response("great add");
    }

    #[Route('/Addformauthornew', name: 'app_Addformauthornew')]
    public function Addformauthornew(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $em = $managerRegistry->getManager();
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($req); //******************* */
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($author);
            $em->flush();
        }

        return $this->renderForm('authornew/Addformauthornew.html.twig', [
            'notreformulaire' => $form,
        ]);
    }

    #[Route('/detailsauthornew/{id}', name: 'app_detailsauthornew')]
    public function detailsauthornew($id, AuthorRepository $authorRepository): Response
    {
        $name = 'hhhhhhhhhhhhhhhhhhhhhhh';
        //var_dump($id) . die();
        //$author = $authorRepository->find($id);
        $author = $authorRepository->showauthorbook($id);
        //var_dump($author) . die();
        return $this->render('authornew/detailsauthornew.html.twig', [
            'author' => $author, 'name' => $name
        ]);
    }

    #[Route('/updateauthornew/{id}', name: 'app_updateauthornew')]
    public function updateauthornew($id, AuthorRepository $authorRepository, ManagerRegistry $managerRegistry, Request $req): Response
    {
        $em = $managerRegistry->getManager();
        //var_dump($id) . die();
        $author = $authorRepository->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($req); //******************* */
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_showauthornew');
        }

        return $this->renderform('authornew/updateauthornew.html.twig', [
            'formauthor' => $form,
        ]);
    }
    #[Route('/deleteauthornew/{id}', name: 'app_deleteauthornew')]
    public function deleteauthornew($id, AuthorRepository $authorRepository, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        //var_dump($id) . die();
        $author = $authorRepository->find($id);
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('app_showauthornew');
    }
}