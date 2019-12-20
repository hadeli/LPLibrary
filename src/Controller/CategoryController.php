<?php


namespace Alexandrie\Controller;


use Alexandrie\Entity\Book;
use Alexandrie\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function get_category_list(){
        $category_list = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->json($category_list);
    }
    public function get_category($id){
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if(is_null($category))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        return $this->json($category);
    }
    public function put_category(Request $request){
        $category = new Category();

        $code = $request->query->get('code');
        $label = $request->query->get('label');

        $category->setCode($code);
        $category->setLabel($label);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return $this->json($category, Response::HTTP_CREATED);

    }
    public function patch_category($id, Request $request){
        /** @var Category $category */
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if(is_null($category))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);

        $code = $request->query->get('code');
        $label = $request->query->get('label');

        if(isset($code) && !empty($code))
            $category->setCode($code);
        if(isset($label) && !empty($label))
            $category->setLabel($label);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();

        return $this->json($category);

    }
    public function delete_category($id){
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        if(is_null($category))
            return $this->json(array("message" => "invalid id"), Response::HTTP_NOT_FOUND);
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}