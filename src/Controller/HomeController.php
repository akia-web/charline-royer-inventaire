<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Service\ApiEleveService;
use App\Service\MailService;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ReservationRepository $reservationRepository, SessionInterface $session, ApiEleveService $apiEleveService): Response
    {
        $session->set('id', 'bar');
        $list = $reservationRepository->findBy(array('isRendered' => false));
        $eleves = $apiEleveService->getData();
        $result = $apiEleveService->getReservationsInformation($list, $eleves);
      
     
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'list'=> $result,
            
        ]);
    }

    #[Route('/emailRetard/{id}', name: 'app_emailrecap',  methods: ['POST'])]
    public function mail(MailService $mailService,  Reservation $reservation) 
    {
        // $dateEmprunt = $reservation->getEmpruntDate()->format('d-m-Y H:i:s');
        // $destinataire = $reservation->getEmail();
        // $dateRendu = $reservation->getRendered()->format('d-m-Y H:i:s');
        // $materiel = $reservation->getMaterial()->getName();
        // $message = "
        // <p>Nous vous rappelons que vous avez emprunté : $materiel le $dateEmprunt</p>
        // <p> Vous devez le rendre le : $dateRendu </p>
               
        // ";
        // $mailService->envoisMail($destinataire, "Rappel rendu matériel : $materiel ", $message);
        // $this->addFlash("success", "Le mail à bien été envoyé à $destinataire" );

       
        // return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);

    }
}
