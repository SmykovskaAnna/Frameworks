<?php

namespace App\Controller;

use App\Entity\Exhibition;
use App\Form\ExhibitionType;
use App\Repository\ExhibitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exhibition')]
final class ExhibitionController extends AbstractController
{
    #[Route(name: 'app_exhibition_index', methods: ['GET'])]
    public function index(ExhibitionRepository $exhibitionRepository): Response
    {
        return $this->render('exhibition/index.html.twig', [
            'exhibitions' => $exhibitionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exhibition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exhibition = new Exhibition();
        $form = $this->createForm(ExhibitionType::class, $exhibition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exhibition);
            $entityManager->flush();

            return $this->redirectToRoute('app_exhibition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exhibition/new.html.twig', [
            'exhibition' => $exhibition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exhibition_show', methods: ['GET'])]
    public function show(Exhibition $exhibition): Response
    {
        return $this->render('exhibition/show.html.twig', [
            'exhibition' => $exhibition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exhibition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Exhibition $exhibition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExhibitionType::class, $exhibition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exhibition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exhibition/edit.html.twig', [
            'exhibition' => $exhibition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exhibition_delete', methods: ['POST'])]
    public function delete(Request $request, Exhibition $exhibition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exhibition->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exhibition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exhibition_index', [], Response::HTTP_SEE_OTHER);
    }
}
