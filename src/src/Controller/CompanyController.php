<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Form\DeliveryFormType;
use App\Form\Invoice\EditInvoiceFormType;
use App\Form\Objet\EditEquipmentFormType;
use App\Repository\CompanyRepository;
use App\Repository\DeliveryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;
use App\Entity\Company;

class CompanyController extends AbstractController
{
    private $twig;

    /**
     * @param Environment $twig
     */
    public function __construct(
        Environment $twig
    ) {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="app_home")
     */
    public function index(
        CompanyRepository $companyRepository
    ): Response {
        $companies = $companyRepository->findAllOrder(['id' => 'ASC']);

        return new Response($this->twig->render('company/index.html.twig', [
            //'add_task_form' => $form->createView(),
            'companies' => $companies
        ]));
    }

    /**
     * @Route("/company-detail/company-{id}", name="app_company_detail")
     */
    public function detail(
        Company $company
    ): Response {
        return new Response($this->twig->render('company/detail.html.twig', [
            'company' => $company
        ]));
    }

    /**
     * @Route("/edit-delivery/delivery-{id}", name="app_edit_delivery")
     */
    public function editDelivery(
        Request $request,
        ManagerRegistry $doctrine,
        Delivery $delivery,
        CompanyRepository $companyRepository,
        TranslatorInterface $translator,
        NotifierInterface $notifier
    ): Response {
        $companyId = $request->query->get('company');
        $company = $companyRepository->findOneBy(['id' => $companyId]);
        $url = $this->generateUrl('app_company_detail', ['id' => $delivery->getId(), 'company' => $companyId]);

        //$delivery = new Delivery();
        $form = $this->createForm(DeliveryFormType::class, $delivery, [
            //'action' => $this->generateUrl('app_edit_delivery', ['id' => $delivery->getId(), 'company' => $companyId]),
            'action' => $this->generateUrl('app_edit_delivery', ['id' => $delivery->getId()]),
            'method' => 'POST',
        ]);

        /*
        $form = $this->createForm(EditInvoiceFormType::class, $invoice, [
            'action' => $url,
            'userId' => $user->getId(),
            'method' => 'POST',
        ]);
        */

        /*
            $form = $this->createForm(EditEquipmentFormType::class, $equipment, [
                'action' => $this->generateUrl('app_edit_equipment', ['id' => $equipment->getId()]),
                //'apartmentId' => $equipment->getId(),
                'method' => 'POST'
            ]);
         */

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
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
