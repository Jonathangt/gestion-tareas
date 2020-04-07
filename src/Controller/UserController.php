<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use App\Entity\User;
use App\Form\RegisterType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        //crear formulario
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        //vinculamos el form con el objeto
        $form->handleRequest($request);

        //si fue enviado recogo los datos
        if($form->isSubmitted() && $form->isValid()){
            //var_dump($user);
            //modificamos el obj para guardarlo y ciframos el pass
            $user->setRole('ROLE_USER');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            //$date_now = (new \DateTime())->format('d-m-Y H:i:s');
            $user->setCreatedAt(new \DateTime('now'));

            //guardar usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->render('user/register.html.twig', [
           'form' => $form->createView()
        ]);
    }

    public function login(AuthenticationUtils $autenticationUtils){
		$error = $autenticationUtils->getLastAuthenticationError();
		//guardo el nombre de usuario que ha fallado la autenticacion
		$lastUsername = $autenticationUtils->getLastUsername();
		//envio a la vista las variables
		return $this->render('user/login.html.twig', array(
			'error' => $error,
			'last_username' => $lastUsername
		));
	}
}
