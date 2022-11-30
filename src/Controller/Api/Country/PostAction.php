<?php


namespace App\Controller\Api\Country;


use App\Entity\Country;
use App\Service\CountryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostAction.php
 *
 * @author Kevin Tourret
 */
class PostAction extends AbstractController
{
    public function __construct(private CountryService $countryService)
    {
    }

    /**
     * @param Request $request,
     * @return Country
     */
    public function handle(Request $request): Country
    {
        // On récupère le contenu JSON (body) envoyé par le POST de l'API
        $requestContent = $request->getContent();

        // On parse le JSON récupéré depuis le contenu (body) de la requête en tableau PHP
        $parsedContent = json_decode($requestContent, true);

        // On créé notre objet à partir des informations envoyées par la requête
        $country = (new Country())
            ->setName($parsedContent['name'])
            ->setCode($parsedContent['code'])
            ->setNationality($parsedContent['nationality'])
        ;

        return $this->countryService->create($country);
    }
}

