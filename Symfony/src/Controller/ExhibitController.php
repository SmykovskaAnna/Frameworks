<?php

namespace App\Controller;

use App\Entity\Exhibit;
use App\Form\ExhibitType;
use App\Repository\ExhibitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exhibit')]
final class ExhibitController extends AbstractController
{
    #[Route(name: 'app_exhibit_index', methods: ['GET'])]
    public function index(ExhibitRepository $exhibitRepository): Response
    {
        return $this->render('exhibit/index.html.twig', [
            'exhibits' => $exhibitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exhibit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exhibit = new Exhibit();
        $form = $this->createForm(ExhibitType::class, $exhibit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exhibit);
            $entityManager->flush();

            return $this->redirectToRoute('app_exhibit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exhibit/new.html.twig', [
            'exhibit' => $exhibit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exhibit_show', methods: ['GET'])]
    public function show(Exhibit $exhibit): Response
    {
        return $this->render('exhibit/show.html.twig', [
            'exhibit' => $exhibit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exhibit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exhibit $exhibit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExhibitType::class, $exhibit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exhibit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exhibit/edit.html.twig', [
            'exhibit' => $exhibit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exhibit_delete', methods: ['POST'])]
    public function delete(Request $request, Exhibit $exhibit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exhibit->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exhibit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exhibit_index', [], Response::HTTP_SEE_OTHER);
    }
}
