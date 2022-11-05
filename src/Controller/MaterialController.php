<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/materiel')]
class MaterialController extends AbstractController
{
    #[Route('/', name: 'app_material_index', methods: ['GET'])]
    public function index(MaterialRepository $materialRepository): Response
    {
        return $this->render('material/index.html.twig', [
            'materials' => $materialRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'app_material_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MaterialRepository $materialRepository): Response
    {
        $material = new Material();
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $material->getName();
            $materialRepository->save($material, true);
            $this->addFlash("success", "Le matériel $name à bien été créer" );

            return $this->redirectToRoute('app_material_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('material/new.html.twig', [
            'material' => $material,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_material_show', methods: ['GET'])]
    public function show(Material $material): Response
    {
        return $this->render('material/show.html.twig', [
            'material' => $material,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_material_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Material $material, MaterialRepository $materialRepository): Response
    {
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $name = $material->getName();
            $materialRepository->save($material, true);
            $this->addFlash("success", "Le matériel $name à bien été modifié" );

            return $this->redirectToRoute('app_material_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('material/edit.html.twig', [
            'material' => $material,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_material_delete', methods: ['POST'])]
    public function delete(Request $request, Material $material, MaterialRepository $materialRepository, ReservationRepository $reservationRepository): Response
    {
        $reservationsDelete = $reservationRepository->findBy(array('material' => $material->getId()));
 
        foreach($reservationsDelete as $item){
            $reservationRepository->remove($item, true);
        }
        
        if ($this->isCsrfTokenValid('delete'.$material->getId(), $request->request->get('_token'))) {
            $name = $material->getName();
            $this->addFlash("success", "Le matériel $name à bien été supprimé" );
            $materialRepository->remove($material, true);
        }

        return $this->redirectToRoute('app_material_index', [], Response::HTTP_SEE_OTHER);
    }
}
