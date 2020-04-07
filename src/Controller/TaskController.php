<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Task; //importacion del modelo
use App\Entity\User; //importacion del modelo

class TaskController extends AbstractController
{
  
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        /*$task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findAll();

        foreach($tasks as $task){
            echo $task->getUser()->getEmail().'_'.$task->getTitle()."<br/>";
        }*/

        /*$user_repo = $this->getDoctrine()->getRepository(User::class);
        $users = $user_repo->findAll();
        
        foreach($users as $user){
            echo $user->getName().'_'.$user->getSurname()."<br/>";

            foreach($user->getTasks() as $task){
                echo $task->getTitle()."<br/>";
            }

        }*/


        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
