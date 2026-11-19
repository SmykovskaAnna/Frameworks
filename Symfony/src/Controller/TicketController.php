<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ticket')]
final class TicketController extends AbstractController
{
    #[Route(name: 'app_ticket_index', methods: ['GET'])]
    public function index(Request $request, TicketRepository $ticketRepository): Response
    {
        $query = $ticketRepository->createQueryBuilder('x');
        if ($request->query->get('id') !== null && $request->query->get('id') !== '') {
            $query->andWhere('x.id LIKE :id')->setParameter('id', '%' . $request->query->get('id') . '%');
        }
        if ($request->query->get('purchaseDate') !== null && $request->query->get('purchaseDate') !== '') {
            $query->andWhere('x.purchaseDate LIKE :purchaseDate')->setParameter('purchaseDate', '%' . $request->query->get('purchaseDate') . '%');
        }
        if ($request->query->get('price') !== null && $request->query->get('price') !== '') {
            $query->andWhere('x.price LIKE :price')->setParameter('price', '%' . $request->query->get('price') . '%');
        }
        if ($request->query->get('ticketType') !== null && $request->query->get('ticketType') !== '') {
            $query->andWhere('x.ticketType LIKE :ticketType')->setParameter('ticketType', '%' . $request->query->get('ticketType') . '%');
        }
        if ($request->query->get('visitorId') !== null && $request->query->get('visitorId') !== '') {
            $query->andWhere('x.visitor.id LIKE :visitorId')->setParameter('visitorId', '%' . $request->query->get('visitorId') . '%');
        }
        if ($request->query->get('exhibitionId') !== null && $request->query->get('exhibitionId') !== '') {
            $query->andWhere('x.exhibition.id LIKE :exhibitionId')->setParameter('exhibitionId', '%' . $request->query->get('exhibitionId') . '%');
        }
        $itemsPerPage = max(1, min(100, $request->query->getInt('itemsPerPage', 10)));
        $page = max(1, $request->query->getInt('page', 1));
        $total = (clone $query)->select('COUNT(x.id)')->getQuery()->getSingleScalarResult();
        $items = $query->setFirstResult(($page - 1) * $itemsPerPage)->setMaxResults($itemsPerPage)->getQuery()->getResult();

        return $this->render('ticket/index.html.twig', [
            'tickets' => $items,
            'filters' => $request->query->all(),
            'itemsPerPage' => $itemsPerPage,
            'page' => $page,
            'totalPages' => max(1, (int) ceil($total / $itemsPerPage)),
        ]);
    }

    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }
}
