<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Mtmue;
use App\Entity\User;
use App\Form\MtmueType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MtmueController extends AbstractController
{
    #[Route('/mtmue/add/{fid}/{uid}', name: 'addMtmue')]
    public function addUser($fid, $uid, Request $request, ManagerRegistry $doctrine): Response
    {
        $mtm = new Mtmue;
        $data = $doctrine->getManager();
        $res = $data->getRepository(Event::class)->find($fid);
        $res2 = $data->getRepository(User::class)->find($uid);

        $form = $this->createFormBuilder($mtm)
            ->add('sum', IntegerType::class, ['label' => 'Montant', "attr"=>["class"=>"form-control", "min" => "0"]])
            ->add('save', SubmitType::class, array('label' => 'Terminer'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $mtm->setEvent($res);
            $mtm->setUser($res2);
            $em->persist($mtm);
            $em->flush();
            return $this->redirectToRoute("event");
        }

        return $this->render('mtmue/add.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
