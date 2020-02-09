<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Entity\Group;
use App\Entity\Message;


use App\Form\GroupType;
use App\Form\MessageType;


class CConversationController extends AbstractController
{

    /**
	* @Route("/list_conversation/", name="listeConversation")
	*/

	public function listeConversation(){

		$User = $this -> getUser();

		return $this -> render('c_conversation/listConversation.html.twig', [
			'user' => $User
		]);
	}


	/**
	* @Route("/conversation/{id}", name="conversation")
	*/

	public function conversation($id, Request $request){

      $repository = $this -> getDoctrine() -> getRepository(Group::class);
      $group = $repository -> find($id);

      $user = $this -> getUser();

      $message = new Message;
      $form = $this -> createForm(MessageType::class, $message);
      $form -> handleRequest($request);

      if($form -> isSubmitted() && $form -> isValid() ){
          $manager = $this -> getDoctrine() -> getManager();
          $manager -> persist($message);
          $message -> setDate(new \DateTime('now'));
          $message -> setUser($user);
          $repository = $this -> getDoctrine() -> getRepository(Group::class);
          $group = $repository -> find($id);
          $message -> setGroupe($group);
          $manager -> flush();
          return $this -> redirectToRoute('conversation', array('id' => $id));
      } 
   		
   		return $this -> render('c_conversation/Conversation.html.twig', [
   			'messageForm' => $form -> createView(),
        'group' => $group,
        'user' => $user
   		]);
   	}

	/**
	* @Route("/creaConversation/", name="creaConversation")
	*/

	public function creaConversation(Request $request) {
        $group = new Group;
        $form = $this -> createForm(GroupType::class, $group);
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid() ){
            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($group);
            $userp = $this -> getUser();
            $group->setUserP($userp);
            $group -> setDate(new \DateTime('now'));
            $manager -> flush();
            return $this -> redirectToRoute('listeConversation');
        } 

        return $this->render('c_conversation/creaConversation.html.twig', [
            'groupForm' => $form -> createView()
        ]);
	}
}
