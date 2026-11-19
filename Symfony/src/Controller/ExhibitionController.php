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
    public function index(Request $request, ExhibitionRepository $exhibitionRepository): Response
    {
        $query = $exhibitionRepository->createQueryBuilder('x');
        if ($request->query->get('id') !== null && $request->query->get('id') !== '') {
            $query->andWhere('x.id LIKE :id')->setParameter('id', '%' . $request->query->get('id') . '%');
        }
        if ($request->query->get('name') !== null && $request->query->get('name') !== '') {
            $query->andWhere('x.name LIKE :name')->setParameter('name', '%' . $request->query->get('name') . '%');
        }
        if ($request->query->get('description') !== null && $request->query->get('description') !== '') {
            $query->andWhere('x.description LIKE :description')->setParameter('description', '%' . $request->query->get('description') . '%');
        }
        if ($request->query->get('startDate') !== null && $request->query->get('startDate') !== '') {
            $query->andWhere('x.startDate LIKE :startDate')->setParameter('startDate', '%' . $request->query->get('startDate') . '%');
        }
        if ($request->query->get('endDate') !== null && $request->query->get('endDate') !== '') {
            $query->andWhere('x.endDate LIKE :endDate')->setParameter('endDate', '%' . $request->query->get('endDate') . '%');
        }
        $itemsPerPage = max(1, min(100, $request->query->getInt('itemsPerPage', 10)));
        $page = max(1, $request->query->getInt('page', 1));
        $total = (clone $query)->select('COUNT(x.id)')->getQuery()->getSingleScalarResult();
        $items = $query->setFirstResult(($page - 1) * $itemsPerPage)->setMaxResults($itemsPerPage)->getQuery()->getResult();

        return $this->render('exhibition/index.html.twig', [
            'exhibitions' => $items,
            'filters' => $request->query->all(),
            'itemsPerPage' => $itemsPerPage,
            'page' => $page,
            'totalPages' => max(1, (int) ceil($total / $itemsPerPage)),
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
