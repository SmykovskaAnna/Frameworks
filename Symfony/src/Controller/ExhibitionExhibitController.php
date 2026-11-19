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
    public function index(Request $request, ExhibitionExhibitRepository $exhibitionExhibitRepository): Response
    {
        $query = $exhibitionExhibitRepository->createQueryBuilder('x');
        if ($request->query->get('id') !== null && $request->query->get('id') !== '') {
            $query->andWhere('x.id LIKE :id')->setParameter('id', '%' . $request->query->get('id') . '%');
        }
        if ($request->query->get('displayOrder') !== null && $request->query->get('displayOrder') !== '') {
            $query->andWhere('x.displayOrder LIKE :displayOrder')->setParameter('displayOrder', '%' . $request->query->get('displayOrder') . '%');
        }
        if ($request->query->get('exhibitionId') !== null && $request->query->get('exhibitionId') !== '') {
            $query->andWhere('x.exhibition.id LIKE :exhibitionId')->setParameter('exhibitionId', '%' . $request->query->get('exhibitionId') . '%');
        }
        if ($request->query->get('exhibitId') !== null && $request->query->get('exhibitId') !== '') {
            $query->andWhere('x.exhibit.id LIKE :exhibitId')->setParameter('exhibitId', '%' . $request->query->get('exhibitId') . '%');
        }
        $itemsPerPage = max(1, min(100, $request->query->getInt('itemsPerPage', 10)));
        $page = max(1, $request->query->getInt('page', 1));
        $total = (clone $query)->select('COUNT(x.id)')->getQuery()->getSingleScalarResult();
        $items = $query->setFirstResult(($page - 1) * $itemsPerPage)->setMaxResults($itemsPerPage)->getQuery()->getResult();

        return $this->render('exhibition_exhibit/index.html.twig', [
            'exhibition_exhibits' => $items,
            'filters' => $request->query->all(),
            'itemsPerPage' => $itemsPerPage,
            'page' => $page,
            'totalPages' => max(1, (int) ceil($total / $itemsPerPage)),
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
