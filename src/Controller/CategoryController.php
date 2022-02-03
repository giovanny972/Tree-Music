<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{  /**
    * @Route("/{category}", name="index")
    */
    public function index(CategoryRepository $categoryRepository, Category $category = null ): Response
    {   
        if ($category == null) {
            $category = new Category();
            $plant = $category->getPlant();
        }
        $categories = $categoryRepository->findall();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'plant' => $plant
        ]);
    }
}
