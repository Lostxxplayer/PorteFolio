<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProjectType;


class PortefolioController extends AbstractController
{
    /**
    * @Route("/portefolio", name="portefolio")
    */
    public function index(ProjectRepository $repo)
    {
        
        $projects = $repo->findAll();
        
        
        return $this->render('portefolio/index.html.twig', [
            'controller_name' => 'PortefolioController',
            'projects' => $projects
            ]);
        }
        /**
        * @Route ("/", name="home")
        */
        public function home() {
            return $this->render ('portefolio/home.html.twig');
        } 
        /**
        * @Route ("/projects/new", name="project_create")
        * @Route ("/projects/{id}/edit", name="Project_edit")
        */
        public function form(Project $project = null, Request $request){
            
            
            if(!$project) {
                $project = new Project();
            }
            
            
            $entityManager = $this->getDoctrine()->getManager();
            
            $form = $this->createform(ProjectType::class, $project);
            
            $form->handleRequest($request);
            
            if($form->isSubmitted() && $form->isValid()){
                if(!$project->getid()){
                    $project->setCreatedAt(new \DateTime());  
                }
                
                
                $entityManager->persist($project);
                $entityManager->flush();
                
                return $this->redirectToRoute('projects_show', ['id' => $project->getId()]);
            }
            
            return $this->render('portefolio/create.html.twig',[
                'formProject' => $form->createView(),
                'editMode' => $project-> getId() !== null
                ]);
            }
            /**
            * @Route ("/projects/{id}", name="projects_show")
            */
            public function show(Project $project){
                
                return $this->render ('portefolio/show.html.twig',[
                    'project' => $project,
                    
                    ]);
                } 
                
            }
