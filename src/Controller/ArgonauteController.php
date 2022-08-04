<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;
use App\Repository\ArgonauteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class ArgonauteController extends AbstractController
{
    #[Route('/', name: 'app_argonaute_index', methods: ['GET'])]
    public function index(ArgonauteRepository $argonauteRepository): Response
    {
        return $this->render('argonaute/index.html.twig', [
            'argonautes' => $argonauteRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_argonaute_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArgonauteRepository $argonauteRepository): Response
    {
        $argonaute = new Argonaute();
        $form = $this->createForm(ArgonauteType::class, $argonaute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $argonauteRepository->add($argonaute, true);

            return $this->redirectToRoute('app_argonaute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('argonaute/new.html.twig', [
            'argonaute' => $argonaute,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_argonaute_show', methods: ['GET'])]
    public function show(Argonaute $argonaute): Response
    {
        return $this->render('argonaute/show.html.twig', [
            'argonaute' => $argonaute,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_argonaute_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Argonaute $argonaute, ArgonauteRepository $argonauteRepository): Response
    {
        $form = $this->createForm(ArgonauteType::class, $argonaute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $argonauteRepository->add($argonaute, true);

            return $this->redirectToRoute('app_argonaute_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('argonaute/edit.html.twig', [
            'argonaute' => $argonaute,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_argonaute_delete', methods: ['POST'])]
    public function delete(Request $request, Argonaute $argonaute, ArgonauteRepository $argonauteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$argonaute->getId(), $request->request->get('_token'))) {
            $argonauteRepository->remove($argonaute, true);
        }

        return $this->redirectToRoute('app_argonaute_index', [], Response::HTTP_SEE_OTHER);
    }
}
