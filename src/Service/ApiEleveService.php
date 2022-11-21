<?php

namespace App\Service;

use stdClass;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class ApiEleveService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getData(): array
    {
        $reponse = $this->client->request(
            'GET',
            'http://vps-a47222b1.vps.ovh.net:4242/Student'
        );

        return $reponse->toArray();
    }

    public function getReservationsInformation($listeReservations, $listeEleves){

        $result = [];
        foreach($listeReservations as $reservation){
            foreach($listeEleves as $studient){
                if($studient['id'] == $reservation->getStudientId()){
                    $item = new stdClass();
                    $item->id= $reservation->getId();
                    $item->material = $reservation->getMaterial();
                    $item->empruntDate = $reservation->getEmpruntDate();
                    $item->isRendered = $reservation->isIsRendered();
                    $item->rendered = $reservation->getRendered();
                    $item->studientId = $studient['mail'];
                    array_push($result, $item);
                }
            }
        }

        return $result;
    }

}