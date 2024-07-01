<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{


    public $formations = array(
        array(
            'ref' => 'form147', 'Titre' => 'Formation Symfony
        4', 'Description' => 'formation pratique',
            'date_debut' => '12/06/2020', 'date_fin' => '19/06/2020',
            'nb_participants' => 19
        ),
        array(
            'ref' => 'form177', 'Titre' => 'Formation SOA',
            'Description' => 'formation
        theorique', 'date_debut' => '03/12/2020', 'date_fin' => '10/12/2020',
            'nb_participants' => 0
        ),
        array(
            'ref' => 'form178', 'Titre' => 'Formation Angular',
            'Description' => 'formation
        theorique', 'date_debut' => '10/06/2020', 'date_fin' => '14/06/2020',
            'nb_participants' => 12
        )
    );


    #[Route('/formations', name: 'app_formations')]
    public function index(): Response
    {
        return $this->render('formations/index.html.twig', [
            'controller_name' => 'FormationsController',
        ]);
    }
    #[Route('/showformations', name: 'app_showformations')]
    public function showformations(): Response
    {
        return $this->render('formations/showformations.html.twig', [
            'formations' => $this->formations,
        ]);
    }
    #[Route('/detailsformations/{id}', name: 'app_detailsformations')]
    public function detailsformations($id): Response
    {

        // var_dump($id) . die();
        $x = null;
        foreach ($this->formations as $fd) {
            if ($fd['ref'] == $id) {
                $x = $fd;
            }
        }

        return $this->render('formations/detailsformations.html.twig', [
            'details' => $x,
        ]);
    }
}
