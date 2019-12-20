<?php


namespace Alexandrie\Controller\Library;


use Alexandrie\Entity\Library\Category;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function listCategories()
    {
        $categories = $this-> getDoctrine()
            -> getRepository(Category::class)
            -> findAll();

        try {
            return new Response($this-> json($categories));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function showCategory($id)
    {
        $category = $this-> getDoctrine()
            -> getRepository(Category::class)
            -> find($id);

        try {
            return new Response($this-> json($category));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function createCategory(Request $request)
    {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $category = new Category();
        if (null !== $request->get('label')) {
            if ($request->get('label'))
                $category->setLabel($request->get('label'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('category')) {
            if ($request->get('category'))
                $category->setCode($request->get('category'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($category);
        try {
            $entityManager-> flush();
            return new Response($this-> json($category));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function updateCategory(Request $request, $id)
    {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $category = $this-> getDoctrine()
            -> getRepository(Category::class)
            -> find($id);

        if (null !== $request->get('label')) {
            if ($request->get('label'))
                $category->setLabel($request->get('label'));
            else
                return new Response("There was an error");
        }
        if (null !== $request->get('category')) {
            if ($request->get('category'))
                $category->setCode($request->get('category'));
            else
                return new Response("There was an error");
        }

        $entityManager-> persist($category);
        try {
            $entityManager-> flush();
            return new Response($this-> json($category));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }

    public function deleteCategory($id) {
        $entityManager = $this-> getDoctrine()
            -> getManager();

        $category = $this-> getDoctrine()
            -> getRepository(Category::class)
            -> find($id);

        $entityManager-> remove($category);
        try {
            $entityManager-> flush();
            return new Response($this-> json($category));
        } catch (Exception $exception) {
            return $exception-> getMessage();
        }
    }
}