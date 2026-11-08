<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Salon;
use App\Form\MessageType;
use App\Form\SalonType;
use App\Repository\SalonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/salon')]
final class SalonController extends AbstractController
{
    #[Route(name: 'app_salon_index', methods: ['GET'])]
    public function index(SalonRepository $salonRepository): Response
    {
        return $this->render('salon/index.html.twig', [
            'salons' => $salonRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_salon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $salon = new Salon();
        $form = $this->createForm(SalonType::class, $salon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $salon->setOwner($this->getUser());
            $entityManager->persist($salon);
            $entityManager->flush();

            $this->addFlash('success', 'Salon créé.');

            return $this->redirectToRoute('app_salon_show', ['id' => $salon->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salon/new.html.twig', [
            'salon' => $salon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_salon_show', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function show(Salon $salon, Request $request, EntityManagerInterface $entityManager, SalonRepository $salonRepository): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setAuthor($this->getUser());
            $message->setSalon($salon);
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_salon_show', ['id' => $salon->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salon/show.html.twig', [
            'salon' => $salon,
            'salons' => $salonRepository->findBy([], ['name' => 'ASC']),
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_salon_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Salon $salon, EntityManagerInterface $entityManager): Response
    {
        if ($salon->getOwner() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas modifier ce salon.');
        }

        $form = $this->createForm(SalonType::class, $salon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Salon modifié.');

            return $this->redirectToRoute('app_salon_show', ['id' => $salon->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('salon/edit.html.twig', [
            'salon' => $salon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_salon_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Salon $salon, EntityManagerInterface $entityManager): Response
    {
        if ($salon->getOwner() !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas supprimer ce salon.');
        }

        if ($this->isCsrfTokenValid('delete'.$salon->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($salon);
            $entityManager->flush();

            $this->addFlash('success', 'Salon supprimé.');
        }

        return $this->redirectToRoute('app_salon_index', [], Response::HTTP_SEE_OTHER);
    }
}