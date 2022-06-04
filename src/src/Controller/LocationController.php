<?php

namespace App\Controller;

use App\Controller\Traits\DataTrait;
use App\Entity\Location;
use App\Form\LocationFormType;
use App\Repository\CompanyRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Twig\Environment;

class LocationController extends AbstractController
{
    use DataTrait;

    private $twig;

    private $doctrine;

    /**
     * @param Environment $twig
     * @param ManagerRegistry $doctrine
     */
    public function __construct(
        Environment $twig,
        ManagerRegistry $doctrine
    ) {
        $this->twig = $twig;
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/locations", name="app_location_list")
     */
    public function index(
        Request $request,
        TranslatorInterface $translator,
        NotifierInterface $notifier
    ): Response {
        $location = new Location();
        $form = $this->createForm(LocationFormType::class, $location, [
            'action' => $this->generateUrl('app_location_list'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($location);
            $entityManager->flush();

            // Message and redirect
            $message = $translator->trans('Location updated', array(), 'flash');
            $notifier->send(new Notification($message, ['browser']));
            return $this->redirectToRoute("app_location_list");
        }

        return $this->render('location/index.html.twig', [
            'controller_name' => 'LocationController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/api/locations", name="location_list")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getLocations(
        LocationRepository $locationRepository
    ) {
        $locations = $locationRepository->findAllOrder(['id' => 'ASC']);
        $arrData = $this->getJsonArrData($locations);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent(\json_encode($arrData));

        return $response;
    }

    /**
     * @Route("/edit-location/location-{id}", name="app_edit_location")
     */
    public function editLocation(
        Request $request,
        Location $location,
        CompanyRepository $companyRepository,
        TranslatorInterface $translator,
        NotifierInterface $notifier
    ): Response {
        $form = $this->createForm(LocationFormType::class, $location, [
            'action' => $this->generateUrl('app_edit_location', ['id' => $location->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($location);
            $entityManager->flush();
            // Message and redirect
            $message = $translator->trans('Location updated', array(), 'flash');
            $notifier->send(new Notification($message, ['browser']));
            return $this->redirectToRoute("app_location_list");
        }

        return new Response($this->twig->render('location/edit_location.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]));
    }
}
