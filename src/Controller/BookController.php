<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Form\BookType;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/showbook', name: 'app_showbook')]
    public function showbook(BookRepository $bookRepository): Response
    {
        $book = $bookRepository->findAll();
        return $this->render('book/showbook.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/addbook', name: 'app_addbook')]
    public function addbook(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $em = $managerRegistry->getManager();
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_showbook');
        }
        return $this->renderForm('book/addbook.html.twig', [
            'f' => $form,
        ]);
    }


    #[Route('/updatebook/{id}', name: 'app_updatebook')]
    public function updatebook($id, ManagerRegistry $managerRegistry, Request $req, BookRepository $bookRepository): Response
    {
        $em = $managerRegistry->getManager();
        //$book = new Book();
        $book = $bookRepository->find($id);
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($req);
        if ($form->isSubmitted()) {
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_showbook');
        }
        return $this->renderForm('book/addbook.html.twig', [
            'f' => $form,
        ]);
    }

    #[Route('/deletebook/{id}', name: 'app_deletebook')]
    public function deletebook($id, BookRepository $bookRepository, ManagerRegistry $managerRegistry): Response
    {
        $em = $managerRegistry->getManager();
        $authorbyid = $bookRepository->find($id);
        $em->remove($authorbyid);
        $em->flush();

        return $this->redirectToRoute('app_showbook');
    }
}
