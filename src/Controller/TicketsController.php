<?php

namespace App\Controller;

use App\Entity\Tickets;
use App\Form\TicketsType;
use App\Repository\TicketsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Comments;

/**
 * @Route("/tickets")
 */
class TicketsController extends AbstractController
{
    /**
     * @Route("/", name="tickets_index", methods="GET")
     */
    public function index(TicketsRepository $ticketsRepository): Response
    {
        return $this->render('tickets/index.html.twig', ['tickets' => $ticketsRepository->findAll()]);
    }

    /**
     * @Route("/new", name="tickets_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $ticket = new Tickets();
        $form = $this->createForm(TicketsType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ticket);
            $manager->flush();

            return $this->redirectToRoute('tickets_index');
        }

        return $this->render('tickets/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tickets_show", methods="GET")
     */
    public function show(Tickets $ticket): Response
    {
      $manager = $this->getDoctrine()->getManager();
      $manager->persist($ticket);
      $manager->flush();
      $repository = $this->getDoctrine()->getRepository(Comments::class);
      $comments = $repository->findBy(['ticket_id' => $ticket->getId(),]);
      return $this->render('tickets/show.html.twig', ['ticket' => $ticket, 'comments' => $comments ]);
    }

    /**
     * @Route("/{id}/edit", name="tickets_edit", methods="GET|POST")
     */
    public function edit(Request $request, Tickets $ticket, AuthorizationCheckerInterface $authChecker): Response
    {

     // check for "edit" access: calls all voters
        $this->denyAccessUnlessGranted('edit', $ticket);
        $form = $this->createForm(TicketsType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tickets_edit', ['id' => $ticket->getId()]);
        }

        return $this->render('tickets/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tickets_delete", methods="DELETE")
     */
    public function delete(Request $request, Tickets $ticket): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($ticket);
            $manager->flush();
        }

        return $this->redirectToRoute('tickets_index');
    }
}
