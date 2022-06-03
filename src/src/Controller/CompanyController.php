<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
        CompanyRepository $companyRepository,
        Company $company
    ): Response {
        return new Response($this->twig->render('company/detail.html.twig', [
            'company' => $company
        ]));
    }
}
