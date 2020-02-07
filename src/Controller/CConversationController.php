<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\User;


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

	public function conversation($id){
   		//1 : Récupérer les données (infos, commentaires)
   		$repository = $this -> getDoctrine() -> getRepository(Message::class);
   		$messages = $repository -> findAll($id);

   		$manager = $this -> getDoctrine() -> getManager();
   		$post = $manager -> find(Message::class,$id);

   		//2 : Afficher la vue (avec les data transmises)
   		return $this -> render('post/show.html.twig', [
   			'post' => $post
   		]);
   	}

	/**
	* @Route("/creaConversation/", name="creaConversation")
	*/

	public function creaConversation(){

		
		
		return $this -> render('c_conversation/creaConversation.html.twig', []);
	}
}
