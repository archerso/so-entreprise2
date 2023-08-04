<?php

namespace App\Controller;


use App\Entity\Employe;
use App\Form\FormsalarieType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalarieController extends AbstractController
{
    #[Route('/', name: 'app_salarie')]
    public function accueil(): Response
    {
        return $this->render('salarie/index.html.twig', [
            'SalarieController' => 'Bienvenue au salarié ',
        ]);
    }

    #[Route('/salarie/salarie', name: 'salarie_form')]
    // Request permet de recuperer les GLOBAL, 
    public function ajout(Request $request, EntityManagerInterface $manager): Response
    {
        $employe = new Employe;
        // je crée une variable dans laquelle je stocke mon formulaire crée grace à createForm() et a son formBuilder (FormsalarieType)
        // click droit pour importer la class

        // 
        $form = $this->createForm(FormsalarieType::class, $employe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($employe);
            // persist() permet de préparer les requette SQL par rapport à l'objet qu'on lui donne enn paramètre
            $manager->flush();
            // flus() permet d'executer toutes les requettes précédentes
            return $this->redirectToRoute('app_salarie');
        }
        // dans render le se second le premier parametre est le chemin le SECOND EST UN TABLEAU
        return $this->render('salarie/salarie.html.twig', [
            'formsalarie' => $form,
        ]);
    }
    #[Route('/salarie/show', name: 'showsalarie')]
    public function showsalarie( EmployeRepository $repo): Response
    {
        $employe = $repo->findAll();
        return $this->render('salarie/show.html.twig', [
            'formsalarie' => $employe,
            // 'SalarieController' => 'Bienvenue au salarié ',
        ]);
    }
}
