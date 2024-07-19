<?php

namespace App\Controller;

use App\Entity\Arbre;
use App\Entity\Parc;
use App\Form\ArbreType;
use App\Form\UpdateArbreType;
use App\Repository\ArbreRepository;
use App\Repository\ParcRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExamenController extends AbstractController
{
    #[Route('/examen', name: 'app_examen')]
    public function index(): Response
    {
        return $this->render('examen/index.html.twig', [
            'controller_name' => 'ExamenController',
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addabre(Request $req, ManagerRegistry $mr, ParcRepository $repo)
    {
        $arbre = new Arbre();
        $f = $this->createForm(ArbreType::class, $arbre);
        $f->handleRequest($req);
        if ($f->isSubmitted()) {
            $arbre->setParc($repo->find(33));
            //$arbre->setAmount(500);
            $em = $mr->getManager();
            $em->persist($arbre);
            $em->flush();
        }
        return $this->renderForm("examen/addarbre.html.twig", [
            'arbreform' => $f,
        ]);
    }

    #[Route('/listaccount', name: 'listaccount')]
    public function listaccount(ArbreRepository $repo)
    {
        return $this->render('examen/listaccount.html.twig', [
            'a' => $repo->findAll()
        ]);
    }
    #[Route('/remove/{id}', name: 'remove')]
    public function removearbre(EntityManagerInterface $em, Arbre $a)
    {
        $em->remove($a);
        $em->flush();
        return $this->redirectToRoute('listaccount');
    }
    #[Route('/update/{id}', name: 'update')]
    public function updateArbre(EntityManagerInterface $em, $id, Request $req, ArbreRepository $repo)
    {

        $arbre = $repo->find($id);
        if ($arbre != null) {
            $f = $this->createForm(UpdateArbreType::class, $arbre);
            $f->handleRequest($req);
            if ($f->isSubmitted()) {
                $em->persist($arbre);
                $em->flush();
                return $this->redirectToRoute('listaccount');
            }
            return $this->renderForm("examen/update.html.twig", [
                'arbreFormToUpdate' => $f,
            ]);
        } else {
            return new Response("TREES not found");
        }
    }

    #[Route('/search', name: 'search')]
    public function searcharbre(Request $req, ParcRepository $repo, ArbreRepository $repoA)
    {
        $getValueFromInput = $req->query->get('searchbyparc');
        $parc = $repo->findBynom($getValueFromInput); //get parc object
        $result = $repoA->findByparc($parc); //search by parc
        return $this->render('examen/listaccount.html.twig', [
            'a' => $result // send list to same file of list arbre
        ]);
    }
}
