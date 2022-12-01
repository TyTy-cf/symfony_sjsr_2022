<?php


namespace App\Controller\Api\Publisher;


use App\Entity\Publisher;
use App\Repository\CountryRepository;
use App\Repository\PublisherRepository;
use App\Service\TextService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FormAction.php
 *
 * @author Kevin Tourret
 */
class FormAction extends AbstractController
{

    public function __construct(
        private CountryRepository $countryRepository,
        private PublisherRepository $publisherRepository,
        private EntityManagerInterface $em,
        private TextService $textService
    )
    { }

    /**
     * @throws Exception
     */
    public function handleForm(Request $request): Publisher
    {
        $requestContent = $request->getContent();
        $parsedContent = json_decode($requestContent, true);
        $country = $this->countryRepository->findOneBy([
            'name' => $parsedContent['country']['name']]
        );

        if ($country !== null) {
            $isPut = $request->getMethod() === 'PUT';
            $publisher = new Publisher();

            if ($isPut) {
                $publisher = $this->publisherRepository->findOneBy(['id' => $request->get('id')]);
            }

            if ($publisher !== null) {
                $publisher->setName($parsedContent['name'])
                    ->setWebsite($parsedContent['website'])
                    ->setCreatedAt(new DateTime($parsedContent['createdAt']))
                    ->setCountry($country)
                    ->setSlug($this->textService->slugify($parsedContent['name']))
                ;

                if (!$isPut) {
                    $this->em->persist($publisher);
                }

                $this->em->flush();

                return $publisher;
            }
        }
    }

}
