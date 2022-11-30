<?php


namespace App\Service;


use App\Entity\Country;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CountryService.php
 *
 * @author Kevin Tourret
 */
class CountryService
{

    public function __construct(
        private TextService $textService,
        private EntityManagerInterface $em
    )
    {
    }

    public function create(Country $country): Country
    {
        $country->setSlug($this->textService->slugify($country->getName()));
        $country->setUrlFlag('https://flagcdn.com/32x24/'.$country->getCode().'.png');
        $this->em->persist($country);
        $this->em->flush();
        return $country;
    }
}
