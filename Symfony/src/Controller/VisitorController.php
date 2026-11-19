<?php

namespace App\Controller;

use App\Entity\Visitor;
use App\Form\VisitorType;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/visitor')]
final class VisitorController extends AbstractController
{
    #[Route(name: 'app_visitor_index', methods: ['GET'])]
    public function index(Request $request, VisitorRepository $visitorRepository): Response
    {
        $query = $visitorRepository->createQueryBuilder('x');
        if ($request->query->get('id') !== null && $request->query->get('id') !== '') {
            $query->andWhere('x.id LIKE :id')->setParameter('id', '%' . $request->query->get('id') . '%');
        }
        if ($request->query->get('firstName') !== null && $request->query->get('firstName') !== '') {
            $query->andWhere('x.firstName LIKE :firstName')->setParameter('firstName', '%' . $request->query->get('firstName') . '%');
        }
        if ($request->query->get('lastName') !== null && $request->query->get('lastName') !== '') {
            $query->andWhere('x.lastName LIKE :lastName')->setParameter('lastName', '%' . $request->query->get('lastName') . '%');
        }
        if ($request->query->get('email') !== null && $request->query->get('email') !== '') {
            $query->andWhere('x.email LIKE :email')->setParameter('email', '%' . $request->query->get('email') . '%');
        }
        $itemsPerPage = max(1, min(100, $request->query->getInt('itemsPerPage', 10)));
        $page = max(1, $request->query->getInt('page', 1));
        $total = (clone $query)->select('COUNT(x.id)')->getQuery()->getSingleScalarResult();
        $items = $query->setFirstResult(($page - 1) * $itemsPerPage)->setMaxResults($itemsPerPage)->getQuery()->getResult();

        return $this->render('visitor/index.html.twig', [
            'visitors' => $items,
            'filters' => $request->query->all(),
            'itemsPerPage' => $itemsPerPage,
            'page' => $page,
            'totalPages' => max(1, (int) ceil($total / $itemsPerPage)),
        ]);
    }

    #[Route('/new', name: 'app_visitor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $visitor = new Visitor();
        $form = $this->createForm(VisitorType::class, $visitor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($visitor);
            $entityManager->flush();

            return $this->redirectToRoute('app_visitor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visitor/new.html.twig', [
            'visitor' => $visitor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visitor_show', methods: ['GET'])]
    public function show(Visitor $visitor): Response
    {
        return $this->render('visitor/show.html.twig', [
            'visitor' => $visitor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_visitor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Visitor $visitor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VisitorType::class, $visitor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_visitor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('visitor/edit.html.twig', [
            'visitor' => $visitor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_visitor_delete', methods: ['POST'])]
    public function delete(Request $request, Visitor $visitor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visitor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($visitor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_visitor_index', [], Response::HTTP_SEE_OTHER);
    }
}
