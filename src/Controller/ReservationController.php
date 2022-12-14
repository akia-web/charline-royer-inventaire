<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Service\ApiEleveService;
use App\Service\MailService;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository, ApiEleveService $apiEleveService): Response
    {
        $allReservations = $reservationRepository->findAll();
        $allStudients = $apiEleveService->getData();
        $result = $apiEleveService->getReservationsInformation($allReservations, $allStudients);     
     
        return $this->render('reservation/index.html.twig', [
            'reservations' => $result,
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository, MailService $mailService, ApiEleveService $apiEleveService): Response
    {
        $_SESSION['nouveau'] = 1;
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setEmpruntDate(new \DateTime());
            $reservation->setIsRendered(false);
            $quantity = $reservation->getMaterial()->getQuantity()-1;
        
            $reservation->getMaterial()->setQuantity($quantity);
            $reservationRepository->save($reservation, true);
           
            // $dateEmprunt = $reservation->getEmpruntDate()->format('d-m-Y H:i');
            $listEleve = $apiEleveService->getData();
            $destinataire = null;
            foreach($listEleve as $eleve){
                if($eleve['id'] == $reservation->getStudientId()){
                    $destinataire = $eleve['mail'];
                }
            }
            
            // $dateRendu = $reservation->getRendered()->format('d-m-Y H:i');
            $materiel = $reservation->getMaterial()->getName();
            // $message = "
            // <h1>Nous confirmons l'emprunt du mat??riel : $materiel</h1>
            // <p>Informations : 
            //     <ul>
            //         <li>Mat??riel : $materiel</li>
            //         <li>Date d'emprunt : $dateEmprunt</li>
            //         <li>Date de retour du mat??riel : $dateRendu</li>
            //     </ul>       
            // </p>
            // <p> Merci de prendre soin de notre mat??riel
           
            // ";
            // $mailService->envoisMail($destinataire, "R??servation : $materiel ", $message);

            $this->addFlash("success", "L'emprunt de $materiel pour $destinataire ?? bien ??t?? enregistr??" );
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        
        $ancienReservation = $reservationRepository->find($reservation->getId());
        $isRendered = $ancienReservation->isIsRendered();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $quantity = $reservation->getMaterial()->getQuantity();
        
        if ($form->isSubmitted() && $form->isValid()) {
            if($isRendered != $reservation->isIsRendered()){

                if($reservation->isIsRendered()){
                    $reservation->getMaterial()->setQuantity($quantity + 1);
                }else{
                    $reservation->getMaterial()->setQuantity($quantity - 1);
                }                 
            }

             $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
