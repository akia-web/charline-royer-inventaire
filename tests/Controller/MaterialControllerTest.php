<?php

namespace App\Test\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MaterialControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MaterialRepository $repository;
    private ReservationRepository $reservationRepository;
    private string $path = '/materiel/';

   
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Material::class);
        // $this->reservationRepository = static::getContainer()->get('doctrine')->getRepository(Reservation::class);

        // foreach ($this->reservationRepository->findAll() as $object) {
        //     $this->reservationRepository->remove($object, true);
        // }

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
       

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->client->request('GET', sprintf('%snouveau', $this->path));
        
        self::assertResponseStatusCodeSame(200);
    
        $this->client->submitForm('Enregistrer', [
            'material[name]' => 'Testing',
            'material[quantity]' => 15,
        ]);

        // self::assertResponseRedirects('/material/');

         self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
      
    }

    // public function testShow(): void
    // {
    //     $this->markTestIncomplete();
    //     $fixture = new Material();
    //     $fixture->setName('My Title');
    //     $fixture->setQuantity('My Title');

    //     $this->repository->add($fixture, true);

    //     $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

    //     self::assertResponseStatusCodeSame(200);
    //     self::assertPageTitleContains('Material');

    //     // Use assertions to check that the properties are properly displayed.
    // }

    public function testEdit(): void
    {
        $fixture = new Material();
        $fixture->setName('My Title');
        $fixture->setQuantity(18);

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Modifier', [
            'material[name]' => 'Something New',
            'material[quantity]' => 20,
        ]);

        // self::assertResponseRedirects('/material/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame(20, $fixture[0]->getQuantity());
    }

    public function testRemove(): void
    {
       

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Material();
        $fixture->setName('My Title');
        $fixture->setQuantity(5);

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Supprimer');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        // self::assertResponseRedirects('/material/');
    }
}
