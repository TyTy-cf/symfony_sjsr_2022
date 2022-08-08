<?php

namespace App\Controller\Back;

use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use App\Service\TextService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/country')]
class CountryController extends AbstractController
{

    public function __construct(
        private TextService $textService,
        private EntityManagerInterface $entityManager,
    ) { }

    #[Route('/', name: 'app_admin_country_index')]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        CountryRepository $countryRepository
    ): Response {
        $countries = $paginator->paginate(
            $countryRepository->getQbAll(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('back/country/index.html.twig', [
            'countries' => $countries,
        ]);
    }

    #[Route('/new', name: 'app_admin_country_new')]
    public function new(
        Request $request
    ): Response
    {
        return $this->handleForm(
            new Country(), $request
        );
    }

    #[Route('/edit/{slug}', name: 'app_admin_country_edit')]
    public function edit(
        Request $request,
        Country $country
    ): Response
    {
        return $this->handleForm(
            $country, $request, 'back/country/edit.html.twig'
        );
    }

    public function handleForm(
        Country $country,
        Request $request,
        string $template = 'back/country/new.html.twig'
    ): Response {
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Country $data */
            $data = $form->getData();
            $data->setSlug($this->textService->slugify($data->getNationality()));
            $data->setUrlFlag('https://flagcdn.com/32x24/'.$data->getCode().'.png');
            $this->entityManager->persist($data); // => insert into country
            $this->entityManager->flush(); // on tire la chasse => COMMIT
            return $this->redirectToRoute('app_admin_country_index');
        }

        return $this->render($template, [
            'form' => $form->createView(),
        ]);
    }
}
