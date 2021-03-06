<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Mtmue;
use App\Entity\User;
use App\Form\EventType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event', name:'event')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Event::class);
        $events = $repo->findAll();

        return $this->render('event/index.html.twig', [
            'event' => $events,
        ]);
    }

    #[Route('/event/add', name:'addEvent')]
    public function addEvent(Request $request, ManagerRegistry $doctrine): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($event);
            $em->flush();
            //return $this->redirectToRoute("addUser", ['fid' => $event->getId()]);
            return $this->redirectToRoute("event");
        }

        return $this->render('event/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/event/view/{fid}', name:'viewEvent')]
    public function viewEvent($fid, Request $request, ManagerRegistry $doctrine) {

        $name = $doctrine->getRepository(Event::class)->find($fid);

        $events = $doctrine->getRepository(Mtmue::class)->findBy(
            ['event' => $fid]
        );

        $queryAvgMember = $doctrine->getRepository(Mtmue::class)->createQueryBuilder('m')
            ->select("count(m.user)")
            ->where('m.event = :fid')
            ->setParameter('fid', $fid)
            ->getQuery()
            ->getArrayResult();

        $queryMember = $doctrine->getRepository(Mtmue::class)->createQueryBuilder('m')
            ->select("m")
            ->where('m.event = :fid')
            ->setParameter('fid', $fid)
            ->getQuery()
            ->getArrayResult();



        $queryAvgScore = $doctrine->getRepository(Mtmue::class)->createQueryBuilder('m')
            ->select("sum(m.sum)")
            ->where('m.event = :fid')
            ->setParameter('fid', $fid)
            ->getQuery()
            ->getArrayResult();

        /*
         * Code fonctionnel ?? 50%
         * Le while va trop loin par rapport ?? l'array $compteur ou $compteur2
         * et je ne trouve pas comment le fix

        $compteur = 0;
        $compteur2 = 0;
        $personne_qui_Doit = array();
        $personnd_qui_recoivent = array();

        if ($queryAvgMember[0][1] > 0) {
            $argent_a_rendre = Round($queryAvgScore[0][1] / $queryAvgMember[0][1]);
            print_r($argent_a_rendre);
            print_r('<br>');

            foreach ($queryMember as $member)
            {
                Round($member['sum'] = $member['sum'] - $argent_a_rendre, 2);
                if ($member['sum'] > 0)
                {
                    array_push($personnd_qui_recoivent, $member);
                }
                if ($member['sum'] < 0)
                {
                    array_push($personne_qui_Doit, $member);
                }
            }

            while ($queryAvgMember[0][1] > $compteur + $compteur2)
            {
                if ($personnd_qui_recoivent[$compteur]['sum'] <= -$personne_qui_Doit[$compteur2]['sum'])
                {
                    $compteur++;
                }
                else
                {
                    $compteur2++;
                }
            }
        }
        */

        return $this->render("event/view.html.twig", [
            'event' => $events,
            'id' => $fid,
            'name' => $name,
        ]);
    }

    #[Route('/event/edit/{id}', name:'editEvent')]
    public function editEvent($id, Request $request, ManagerRegistry $doctrine) {
        $repo = $doctrine->getRepository(Event::class);
        $event = $repo->find($id);

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute("event");
        }

        return $this->render("event/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route('/event/remove/{id}', name:'supprEvent')]
    public function supprEvent($id, Request $request, ManagerRegistry $doctrine) {
        $repo = $doctrine->getRepository(Event::class);
        $event = $repo->find($id);

        $res = $doctrine->getRepository(Mtmue::class)->findBy(
            ['event' => $id]
        );

        foreach ($res as $r) {
            $user = $doctrine->getRepository(User::class)->find($r);
        }

        if($event) {
            $em = $doctrine->getManager();
            $em->remove($event);
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute("event");
        }

        return $this->render('event/index.html.twig', [
            'event' => $event,
        ]);
    }
}
