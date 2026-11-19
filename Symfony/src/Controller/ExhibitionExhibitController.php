<?php

namespace App\Controller;

use App\Entity\ExhibitionExhibit;
use App\Form\ExhibitionExhibitType;
use App\Repository\ExhibitionExhibitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/exhibition/exhibit')]
final class ExhibitionExhibitController extends AbstractController
{
    #[Route(name: 'app_exhibition_exhibit_index', methods: ['GET'])]
    public function index(ExhibitionExhibitRepository $exhibitionExhibitRepository): Response
    {
        return $this->render('exhibition_exhibit/index.html.twig', [
            'exhibition_exhibits' => $exhibitionExhibitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_exhibition_exhibit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $exhibitionExhibit = new ExhibitionExhibit();
        $form = $this->createForm(ExhibitionExhibitType::class, $exhibitionExhibit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($exhibitionExhibit);
            $entityManager->flush();

            return $this->redirectToRoute('app_exhibition_exhibit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exhibition_exhibit/new.html.twig', [
            'exhibition_exhibit' => $exhibitionExhibit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exhibition_exhibit_show', methods: ['GET'])]
    public function show(ExhibitionExhibit $exhibitionExhibit): Response
    {
        return $this->render('exhibition_exhibit/show.html.twig', [
            'exhibition_exhibit' => $exhibitionExhibit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_exhibition_exhibit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExhibitionExhibit $exhibitionExhibit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExhibitionExhibitType::class, $exhibitionExhibit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_exhibition_exhibit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('exhibition_exhibit/edit.html.twig', [
            'exhibition_exhibit' => $exhibitionExhibit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_exhibition_exhibit_delete', methods: ['POST'])]
    public function delete(Request $request, ExhibitionExhibit $exhibitionExhibit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exhibitionExhibit->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($exhibitionExhibit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_exhibition_exhibit_index', [], Response::HTTP_SEE_OTHER);
    }
}
