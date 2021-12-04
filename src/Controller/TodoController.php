<?php
namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Events;


class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(): Response
    {
        $events = $this->getDoctrine()->getRepository('App:Events')->findAll();
    //  dd($events);
        return $this->render('todo/index.html.twig', [
            'events'=> $events
        ]);
    }
    #[Route('/create', name: 'todo_create')]
    public function create(Request $request): Response
    {
        $events=new Events;
        $form = $this->createFormBuilder($events)
        ->add('name', TextType::class, array('attr' => array('class'=> 'form-control mb-3','style'=>'margin-bottom:15px')))
        ->add('datetime', DateTimeType::class, array('attr' => array('class'=> 'form-control dropdown-item')))
        ->add('description', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('img', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('capacity', IntegerType::class, array('attr' => array('class'=> 'form-control')))
        ->add('contactemail', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('contactphonenumber', IntegerType::class, array('attr' => array('class'=> 'form-control')))
        ->add('address', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('url', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('type',ChoiceType::class, array('choices'=>array('Music'=>'Music', 'Sport'=>'Sport', 'Movie'=>'Movie', 'Theater'=>'Theater','Performance'=>'Performance'),'attr' => array('class'=> ' dropdown-item', 'style'=>'margin-botton:15px')))
        ->add('save', SubmitType::class, array('label'=> 'add new event', 'attr' => array('class'=> 'btn btn-outline-success mt-3 mb-5')))
        ->getForm(); 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        $name = $form['name']->getData();
        $datetime = $form['datetime']->getData();
        $description = $form['description']->getData();
        $img = $form['img']->getData();
        $capacity = $form['capacity']->getData();
        $contactemail = $form['contactemail']->getData();
        $contactphonenumber = $form['contactphonenumber']->getData();
        $address = $form['address']->getData();
        $url = $form['url']->getData();
        $type = $form['type']->getData();
       
        $events->setName($name);
        $events->setDatetime($datetime);
        $events->setDescription($description);
        $events->setImg($img);
        $events->setCapacity($capacity);
        $events->setContactemail($contactemail);
        $events->setContactphonenumber($contactphonenumber);
        $events->setAddress($address);
        $events->setUrl($url);
        $events->setType($type);

        $em = $this->getDoctrine()->getManager();
        $em->persist($events);
        $em->flush();
        $this->addFlash( 'notice','Todo Added');
        return $this->redirectToRoute('todo');
}
return $this->render('todo/create.html.twig', array('form' => $form->createView()));
    }

    #[Route('/edit/{id}', name: 'todo_edit')]
    public function edit($id ,Request $request): Response
    {
      
        $events = $this->getDoctrine()->getRepository('App:Events')->find($id);
      

        $form = $this->createFormBuilder($events)
        ->add('name', TextType::class, array('attr' => array('class'=> 'form-control mb-3','style'=>'margin-bottom:15px')))
        ->add('datetime', DateTimeType::class, array('attr' => array('class'=> 'form-control dropdown-item')))
        ->add('description', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('img', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('capacity', IntegerType::class, array('attr' => array('class'=> 'form-control')))
        ->add('contactemail', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('contactphonenumber', IntegerType::class, array('attr' => array('class'=> 'form-control')))
        ->add('address', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('url', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('type',ChoiceType::class, array('choices'=>array('Music'=>'Music', 'Sport'=>'Sport', 'Movie'=>'Movie', 'Theater'=>'Theater','Performance'=>'Performance'),'attr' => array('class'=> ' dropdown-item', 'style'=>'margin-botton:15px')))
        ->add('save', SubmitType::class, array('label'=> 'save change', 'attr' => array('class'=> 'btn btn-outline-success mt-3 mb-5')))
        ->getForm(); 
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        $name = $form['name']->getData();
        $datetime = $form['datetime']->getData();
        $description = $form['description']->getData();
        $img = $form['img']->getData();
        $capacity = $form['capacity']->getData();
        $contactemail = $form['contactemail']->getData();
        $contactphonenumber = $form['contactphonenumber']->getData();
        $address = $form['address']->getData();
        $url = $form['url']->getData();
        $type = $form['type']->getData();
       
        $events->setName($name);
        $events->setDatetime($datetime);
        $events->setDescription($description);
        $events->setImg($img);
        $events->setCapacity($capacity);
        $events->setContactemail($contactemail);
        $events->setContactphonenumber($contactphonenumber);
        $events->setAddress($address);
        $events->setUrl($url);
        $events->setType($type);

        $em = $this->getDoctrine()->getManager();
        $em->persist($events);
        $em->flush();
        $this->addFlash( 'notice','Todo Edited');
        return $this->redirectToRoute('todo');
}
return $this->render('todo/edit.html.twig', array('form' => $form->createView()));
    }
    

    #[Route('/details/{id}', name: 'todo_details')]
    public function details($id): Response
    {
        $events = $this->getDoctrine()->getRepository('App:Events')->find($id);
        return $this->render('todo/details.html.twig', array('events' => $events));
    }


    #[Route("/delete/{id}", name:"todo_delete")]
    public function delete($id){
    $em = $this->getDoctrine()->getManager();
    $events = $em->getRepository('App:Events')->find($id);
    $em->remove($events);
    $em->flush();
    $this->addFlash('notice','Todo Removed');
    return $this->redirectToRoute('todo');

    }
}
