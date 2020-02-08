<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\User;
use App\Form\UserType;

class CLoginController extends AbstractController
{
    /**
	* @Route("/", name="login")
	*/

	public function login(AuthenticationUtils $auth){
		
		$lastUsername = $auth -> getLastUsername();
		$error = $auth -> getLastAuthenticationError();

		if($error){
			$this -> addFlash('errors', 'identifier error !!!');
		}

		return $this -> render('c_login/connexion.html.twig', [
			'lastUsername' => $lastUsername
		]);
	}

	/**
	* @Route("/logout", name="logout")
	*/
	public function logout(){}


	/**
	* @Route("/login_check", name="login_check")
	*/

	public function loginCheck(){}


	/**
	* @Route("/signUp", name="signUp")
	*/

	public function signUp(UserPasswordEncoderInterface $encoder, Request $request){

		$user = new User;

		$form = $this -> createForm(UserType::class, $user);
		$form -> handleRequest($request);

		if ($form -> isSubmitted() && $form -> isValid()) {
			$manager = $this -> getDoctrine() -> getManager();
			
			$manager -> persist($user);
			$user -> setRole('ROLE_USER');
			$password = $user -> getPassword();
			$newPassword = $encoder -> encodePassword($user, $password);
			$user -> setPassword($newPassword);

			$manager -> flush();
			return $this -> redirectToRoute('listeConversation');
		}

		return $this -> render('c_login/signUp.html.twig',[
			'userForm' => $form -> createView()
		]);
	}
}
