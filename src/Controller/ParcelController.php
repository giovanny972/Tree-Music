<?php

namespace App\Controller;

use App\Entity\Parcel;
use App\Form\ParcelType;
use App\Repository\ParcelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/parcel")
 */
class ParcelController extends AbstractController
{
    /**
     * @Route("/", name="parcel_index", methods={"GET"})
     */
    public function index(ParcelRepository $parcelRepository): Response
    {
        return $this->render('parcel/index.html.twig', [
            'parcels' => $parcelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="parcel_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parcel = new Parcel();
        $form = $this->createForm(ParcelType::class, $parcel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parcel);
            $entityManager->flush();

            return $this->redirectToRoute('parcel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parcel/new.html.twig', [
            'parcel' => $parcel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="parcel_show", methods={"GET"})
     */
    public function show(Parcel $parcel): Response
    {
        return $this->render('parcel/show.html.twig', [
            'parcel' => $parcel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="parcel_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Parcel $parcel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParcelType::class, $parcel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('parcel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parcel/edit.html.twig', [
            'parcel' => $parcel,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="parcel_delete", methods={"POST"})
     */
    public function delete(Request $request, Parcel $parcel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parcel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($parcel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('parcel_index', [], Response::HTTP_SEE_OTHER);
    }
}
