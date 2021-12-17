<?php

namespace App\Controller;

use App\Entity\Mtmue;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/add/{fid}', name: 'addUser')]
    public function addUser($fid, Request $request, ManagerRegistry $doctrine): Response
    {
        $user = new User;

        $form = $this->createFormBuilder($user)
            ->add('name')
            ->add('surname')
            ->add('save', SubmitType::class, array('label' => 'Créer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $uid = $user->getId();
            return $this->redirectToRoute('addMtmue', array('fid' => $fid, 'uid' => $uid));
        }

        return $this->render('user/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/user/edit/{fid}/{uid}', name:'editUser')]
    public function editUser($fid, $uid, Request $request, ManagerRegistry $doctrine)
    {
        $user = $doctrine->getRepository(User::class)->find($uid);

        $form = $this->createFormBuilder($user)
            ->add('name')
            ->add('surname')
            ->add('save', SubmitType::class, array('label' => 'Mettre à jour'))
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render("user/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    #[Route('/user/editSum/{fid}/{uid}', name:'editSum')]
    public function editSum($fid, $uid, Request $request, ManagerRegistry $doctrine)
    {
        $mtm = $doctrine->getRepository(Mtmue::class)->findOneBy(['event' => $fid, 'user' => $uid]);

        $form = $this->createFormBuilder($mtm)
            ->add('sum', IntegerType::class, ['label' => 'Objectif', "attr"=>["class"=>"form-control", "min" => "0"]])
            ->add('save', SubmitType::class, array('label' => 'Mettre à jour'))
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($mtm);
            $em->flush();
        }

        return $this->render("user/editSum.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    #[Route('/user/remove/{uid}', name: 'removeUser')]
    public function removeUser($uid, Request $request, ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(User::class);
        $user = $repo->find($uid);

        if($user) {
            $em = $doctrine->getManager();
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute("event");
        }

        return $this->render('event/index.html.twig', [
            'user' => $user,
        ]);
    }
}
