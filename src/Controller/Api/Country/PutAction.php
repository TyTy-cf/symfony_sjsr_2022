<?php


namespace App\Controller\Api\Country;


use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Service\CountryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PutAction.php
 *
 * @author Kevin Tourret
 */
class PutAction extends AbstractController
{

    public function __construct(
        private CountryService $countryService,
        private CountryRepository $countryRepository
    )
    {
    }

    /**
     * @param Request $request,
     * @return Country
     */
    public function edit(Request $request): Country
    {
        // On récupère le contenu JSON (body) envoyé par le POST de l'API
        $requestContent = $request->getContent();

        // On parse le JSON récupéré depuis le contenu (body) de la requête en tableau PHP
        $parsedContent = json_decode($requestContent, true);

        if (null !== $country = $this->countryRepository->findOneBy(['id' => $request->get('id')])) {
            $country->setName($parsedContent['name'])
                ->setCode($parsedContent['code'])
                ->setNationality($parsedContent['nationality'])
            ;

            return $this->countryService->create($country, false);
        }
    }

}
