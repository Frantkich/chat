<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Entity\Group;

use App\Form\GroupType;


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

	public function creaConversation(Request $request) {
        $group = new Group;
        $form = $this -> createForm(GroupType::class, $group);
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid() ){
            $manager = $this -> getDoctrine() -> getManager();
            $manager -> persist($group);
            $group->setUserP(1);
            $group -> setDate(new \DateTime('now'));
            $manager -> flush();
            $this -> addFlash('success', 'Le group' . $group -> getId() . 'a bien été ajouté a la bdd');
            return $this -> redirectToRoute('/list_conversation');
        } 

        return $this->render('c_conversation/creaConversation.html.twig', [
            'postGroup' => $form -> createView()
        ]);
	}
}
