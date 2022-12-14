<?php

namespace App\Test\Controller;

use App\Entity\Material;
use App\Entity\Reservation;
use App\Repository\MaterialRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ReservationRepository $repository; 
    // private MaterialRepository $materialRepository;
    private string $path = '/reservation/';

    // protected function setUp(): void
    // {
    //     $this->client = static::createClient();
    //     $this->repository = static::getContainer()->get('doctrine')->getRepository(Reservation::class);
    //     $this->materialRepository = static::getContainer()->get('doctrine')->getRepository(Material::class);

    //     foreach ($this->repository->findAll() as $object) {
    //         $this->repository->remove($object, true);
    //     }
    //     // foreach ($this->materialRepository->findAll() as $object) {
    //     //     $this->materialRepository->remove($object, true);
    //     // }
    // }

    // public function testIndex(): void
    // {
    //     $crawler = $this->client->request('GET', $this->path);

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Reservation index');

    //    // Use the $crawler to perform additional assertions e.g.
    //  //   self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    // }

    // public function testNew(): void
    // {
    //     $fixture = new Material();
    //     $fixture->setName('p');
    //     $fixture->setQuantity(18);
    //     $this->materialRepository->save($fixture, true);

    //     $originalNumObjectsInRepository = count($this->repository->findAll());
        
    //     $materiels = $this->materialRepository->findAll();
    //     // self::assertNotEquals(0, $materiels[0]->getQuantity());

    //     // $this->markTestIncomplete();
    //     $this->client->request('GET', sprintf('%snew', $this->path));

    //     self::assertResponseStatusCodeSame(200);
 

    //     $this->client->submitForm('Enregistrer', [
    //         'reservation[email]' => 'ch.royer15@gmail.com',
    //         'reservation[rendered]' => "2022-12-30 12:10:00",
    //         'reservation[material]' => $materiels[0]->getId(),
    //     ]);

    //     // self::assertResponseRedirects('/reservation/');

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

    //     $this->materialRepository->remove($materiels[0], true);
    // }

    // public function testShow(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Reservation();
    //     $fixture->setEmpruntDate('My Title');
    //     $fixture->setRendered('My Title');
    //     $fixture->setEmail('My Title');
    //     $fixture->setIsRendered('My Title');
    //     $fixture->setMaterial('My Title');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Reservation');

    //     // Use assertions to check that the properties are properly displayed.
    // }

    // public function testEdit(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Reservation();
    //     $fixture->setEmpruntDate('My Title');
    //     $fixture->setRendered('My Title');
    //     $fixture->setEmail('My Title');
    //     $fixture->setIsRendered('My Title');
    //     $fixture->setMaterial('My Title');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

    //     $this->client->submitForm('Update', [
    //         'reservation[empruntDate]' => 'Something New',
    //         'reservation[rendered]' => 'Something New',
    //         'reservation[email]' => 'Something New',
    //         'reservation[isRendered]' => 'Something New',
    //         'reservation[material]' => 'Something New',
    //     ]);

    //     self::assertResponseRedirects('/reservation/');

    //     $fixture = $this->repository->findAll();

    //     self::assertSame('Something New', $fixture[0]->getEmpruntDate());
    //     self::assertSame('Something New', $fixture[0]->getRendered());
    //     self::assertSame('Something New', $fixture[0]->getEmail());
    //     self::assertSame('Something New', $fixture[0]->getIsRendered());
    //     self::assertSame('Something New', $fixture[0]->getMaterial());
    // }

    // public function testRemove(): void
    // {
    //     $this->markTestIncomplete();

    //     $originalNumObjectsInRepository = count($this->repository->findAll());

    //     $fixture = new Reservation();
    //     $fixture->setEmpruntDate('My Title');
    //     $fixture->setRendered('My Title');
    //     $fixture->setEmail('My Title');
    //     $fixture->setIsRendered('My Title');
    //     $fixture->setMaterial('My Title');

    //     $this->repository->add($fixture, true);

    //     self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
    //     $this->client->submitForm('Delete');

    //     self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
    //     self::assertResponseRedirects('/reservation/');
    // }
}
