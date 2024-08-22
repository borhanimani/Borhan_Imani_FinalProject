<?php

namespace App\Controller;

use App\Entity\SystemInformation;
use App\Form\SystemInformationType;
use App\Repository\SystemInformationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/system/information')]
class SystemInformationController extends AbstractController
{
    #[Route('/', name: 'app_system_information_index', methods: ['GET'])]
    public function index(SystemInformationRepository $systemInformationRepository): Response
    {
        return $this->render('system_information/index.html.twig', [
            'system_informations' => $systemInformationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_system_information_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $systemInformation = new SystemInformation();
        $form = $this->createForm(SystemInformationType::class, $systemInformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($systemInformation);
            $entityManager->flush();

            return $this->redirectToRoute('app_system_information_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('system_information/new.html.twig', [
            'system_information' => $systemInformation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_system_information_show', methods: ['GET'])]
    public function show(SystemInformation $systemInformation): Response
    {
        return $this->render('system_information/show.html.twig', [
            'system_information' => $systemInformation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_system_information_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SystemInformation $systemInformation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SystemInformationType::class, $systemInformation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_system_information_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('system_information/edit.html.twig', [
            'system_information' => $systemInformation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_system_information_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, SystemInformation $systemInformation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $systemInformation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($systemInformation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_system_information_index', [], Response::HTTP_SEE_OTHER);
    }
}
