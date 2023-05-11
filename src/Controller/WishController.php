<?php

namespace App\Controller;

use App\Repository\WishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/wish', name: 'wish_')]
class WishController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(WishRepository $wishRepository): Response
    {
        $wishes =$wishRepository->findOrderedWishList();
        return $this->render('wish/list.html.twig', ['wish' =>$wishes]
        );
    }


    #[Route('/{id}', name: 'detail', requirements: ["id" => "\d+"])]
    public function show(int $id, WishRepository $wishRepository): Response
    {
        $wish= $wishRepository->find($id);

            if(!$wish){
            throw $this->createNotFoundException("Pas de souhaits trouvés !");
            }


        return $this->render('wish/show.html.twig',['wish'=>$wish]
        );
    }
}
