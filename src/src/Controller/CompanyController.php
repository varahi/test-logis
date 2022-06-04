<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Form\DeliveryFormType;
use App\Repository\CompanyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use App\Entity\Company;
use App\Controller\Traits\DataTrait;

class CompanyController extends AbstractController
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
     * @Route("/companies", name="app_company_list")
     */
    public function index(
        CompanyRepository $companyRepository
    ): Response {
        $companies = $companyRepository->findAllOrder(['id' => 'ASC']);

        return new Response($this->twig->render('company/index.html.twig', [
            'companies' => $companies
        ]));
    }

    /**
     * @Route("/api/companies", name="company_list")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getCompanyList(
        CompanyRepository $companyRepository
    ) {
        $companies = $companyRepository->findAllOrder(['id' => 'ASC']);
        $arrData = $this->getJsonArrData($companies);

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent(\json_encode($arrData));

        return $response;
    }

    /**
     * @Route("/company-detail/company-{id}", name="app_company_detail")
     */
    public function detail(
        Request $request,
        Company $company,
        TranslatorInterface $translator,
        NotifierInterface $notifier
    ): Response {
        $delivery = new Delivery();
        $form = $this->createForm(DeliveryFormType::class, $delivery, [
            'action' => $this->generateUrl('app_company_detail', ['id' => $company->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $this->doctrine->getManager();
            $delivery->setCompany($company);
            $entityManager->persist($delivery);
            $entityManager->flush();

            // Message
            $message = $translator->trans('Reservation updated', array(), 'flash');
            $notifier->send(new Notification($message, ['browser']));
            $referer = $request->headers->get('referer');
            return new RedirectResponse($referer);
        }

        return new Response($this->twig->render('company/detail.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/edit-delivery/delivery-{id}", name="app_edit_delivery")
     */
    public function editDelivery(
        Request $request,
        Delivery $delivery,
        CompanyRepository $companyRepository,
        TranslatorInterface $translator,
        NotifierInterface $notifier
    ): Response {
        $companyId = $request->query->get('company');
        $company = $companyRepository->findOneBy(['id' => $companyId]);
        $url = $this->generateUrl('app_company_detail', ['id' => $delivery->getCompany()->getId()]);

        $form = $this->createForm(DeliveryFormType::class, $delivery, [
            'action' => $this->generateUrl('app_edit_delivery', ['id' => $delivery->getId()]),
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($delivery);
            $entityManager->flush();

            $message = $translator->trans('Reservation updated', array(), 'flash');
            $notifier->send(new Notification($message, ['browser']));
            return $this->redirect($url);
        }

        return new Response($this->twig->render('company/edit_delivery.html.twig', [
            'company' => $company,
            'form' => $form->createView(),
        ]));
    }
}
