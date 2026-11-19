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
    public function index(Request $request, ExhibitRepository $exhibitRepository): Response
    {
        $query = $exhibitRepository->createQueryBuilder('x');
        if ($request->query->get('id') !== null && $request->query->get('id') !== '') {
            $query->andWhere('x.id LIKE :id')->setParameter('id', '%' . $request->query->get('id') . '%');
        }
        if ($request->query->get('name') !== null && $request->query->get('name') !== '') {
            $query->andWhere('x.name LIKE :name')->setParameter('name', '%' . $request->query->get('name') . '%');
        }
        if ($request->query->get('description') !== null && $request->query->get('description') !== '') {
            $query->andWhere('x.description LIKE :description')->setParameter('description', '%' . $request->query->get('description') . '%');
        }
        if ($request->query->get('author') !== null && $request->query->get('author') !== '') {
            $query->andWhere('x.author LIKE :author')->setParameter('author', '%' . $request->query->get('author') . '%');
        }
        if ($request->query->get('creationDate') !== null && $request->query->get('creationDate') !== '') {
            $query->andWhere('x.creationDate LIKE :creationDate')->setParameter('creationDate', '%' . $request->query->get('creationDate') . '%');
        }
        $itemsPerPage = max(1, min(100, $request->query->getInt('itemsPerPage', 10)));
        $page = max(1, $request->query->getInt('page', 1));
        $total = (clone $query)->select('COUNT(x.id)')->getQuery()->getSingleScalarResult();
        $items = $query->setFirstResult(($page - 1) * $itemsPerPage)->setMaxResults($itemsPerPage)->getQuery()->getResult();

        return $this->render('exhibit/index.html.twig', [
            'exhibits' => $items,
            'filters' => $request->query->all(),
            'itemsPerPage' => $itemsPerPage,
            'page' => $page,
            'totalPages' => max(1, (int) ceil($total / $itemsPerPage)),
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
