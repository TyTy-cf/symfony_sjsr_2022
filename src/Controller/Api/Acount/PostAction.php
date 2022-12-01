<?php


namespace App\Controller\Api\Acount;


use App\Entity\Account;
use App\Service\TextService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostAction.php
 *
 * @author Kevin Tourret
 */
class PostAction extends AbstractController
{

    public function __construct(
        private TextService $textService,
        private EntityManagerInterface $em
    )
    {
    }

    public function register(Request $request): Account
    {
        // On récupère le contenu JSON (body) envoyé par le POST de l'API
        $requestContent = $request->getContent();

        // On parse le JSON récupéré depuis le contenu (body) de la requête en tableau PHP
        $parsedContent = json_decode($requestContent, true);

        $account = (new Account())
            ->setName($parsedContent['name'])
            ->setEmail($parsedContent['email'])
            ->setNickname($parsedContent['nickname'])
            ->setSlug($this->textService->slugify($parsedContent['name']))
        ;

        $this->em->persist($account);
        $this->em->flush();

        return $account;
    }

}
