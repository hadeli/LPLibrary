<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Category;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function list(){
        return $this->json($this->getDoctrine()->getRepository(Category::class)->findAll(),Response::HTTP_ACCEPTED);
    }

    public function getCategory($id){
        $category = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($id);
        if($category === NULL){
            return $this->json(array('message'=>'This category does not exist'),Response::HTTP_NOT_FOUND);
        }
        return $this->json($category);
    }

    public function create(Request $request){
        $category = new Category();
        $category->setCode($request->query->get('code'));
        $category->setLabel($request->query->get('label'));
        $this->getDoctrine()->getManager()->persist($category);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($category,Response::HTTP_CREATED);
    }

    public function edit($id, Request $request){
        /** @var Category $category */
        $category = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($id);
        if($category === NULL){
            return $this->json(array('message'=>'This category does not exist'),Response::HTTP_NOT_FOUND);
        }
        $category->setCode($request->query->get('code'));
        $category->setLabel($request->query->get('label'));

        $this->getDoctrine()->getManager()->persist($category);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($category,Response::HTTP_CREATED);
    }

    public function delete($id){
        $categoryToRemove = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($id);
        if($categoryToRemove === NULL){
            return $this->json(array('message'=>'This category does not exist'),Response::HTTP_NOT_FOUND);
        }
        try{
            $this->getDoctrine()->getManager()->remove($categoryToRemove);
            $this->getDoctrine()->getManager()->flush();
        }
        catch (ForeignKeyConstraintViolationException $e){
            return $this->json(array('message'=>'You can not delete this category : it is in use in the database'),Response::HTTP_NOT_FOUND);
        }
        return $this->json(array('message'=>'Category successfully deleted.'),Response::HTTP_ACCEPTED);
    }
}