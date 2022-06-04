<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class OrderController extends AbstractController
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
     * @Route("/order", name="app_order")
     */
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    /**
     * @Route("/order-form", name="app_order_form")
     */
    public function orderForm(
        Request $request,
        ManagerRegistry $doctrine,
        TranslatorInterface $translator,
        NotifierInterface $notifier
    ): Response {
        $order = new Order();
        $form = $this->createForm(OrderFormType::class, $order, [
            'action' => $this->generateUrl('app_order_form'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            $message = $translator->trans('Reservation updated', array(), 'flash');
            $notifier->send(new Notification($message, ['browser']));
        }

        return new Response($this->twig->render('order/order_form.html.twig', [
            'form' => $form->createView(),
        ]));
    }
}
