<?php

namespace App\Controller;

use App\Entity\Truc;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function index(EntityManagerInterface $em)
    {
        $res["ALL"] = $em->getRepository(Truc::class)->findAll();

        $res["WHERE ID > 3"] = $em->getRepository(Truc::class)->searchWhereIdGreaterThan(3);

        $em->getFilters()->disable("some_filter");
        $res["ALL (Filtre explicitement désactivé)"] = $em->getRepository(Truc::class)->findAll();

        print(json_encode($res));

        die();
    }

}