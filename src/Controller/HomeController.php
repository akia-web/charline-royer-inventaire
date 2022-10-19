<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $result = [];
        $list = $reservationRepository->findBy(array('isRendered' => false));
       
        foreach ($list as $eleve){
            $item = new stdClass();
            $item->id = $eleve->getId();
            $item->email =  substr($eleve->getEmail(),0, -22);
            $item->dateEmprunt = $eleve->getEmpruntDate()->format("d-m-Y");
            $item->dateRendered = $eleve->getRendered()->format("d-m-Y");
            $item->isRendered = $eleve->isIsRendered();
            $item->material = $eleve->getMaterial();
            array_push($result, $item);
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'list'=> $result
        ]);
    }
}
