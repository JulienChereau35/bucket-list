<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findOrderedWishList();
        return $this->render('wish/list.html.twig', ['wish' => $wishes]
        );
    }


    #[Route('/{id}', name: 'detail', requirements: ["id" => "\d+"])]
    public function show(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);

        if (!$wish) {
            throw $this->createNotFoundException("Pas de souhaits trouvés !");
        }


        return $this->render('wish/show.html.twig', ['wish' => $wish]
        );
    }

    #[Route('/add', name: 'add')]
    public function add(Request                $request,
                        WishRepository         $wishRepository,
    ): Response
    {
        $wish = new Wish();
        $wish->setAuthor($this->getUser()->getUsername());
        $wishform = $this->createForm(WishType::class, $wish);

        $wishform->handleRequest($request);
        if ($wishform->isSubmitted() && $wishform->isValid()) {


            //$wish->setDateCreated(new \DateTime());
            //$wish->setIsPublished(true);
            $wishRepository->save($wish, true);
            $this->addFlash('success', 'Wish added !');
            dump($wish);
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }


        return $this->render('wish/add.html.twig', [
                'wishForm' => $wishform->createView()
            ]
        );
    }
}
