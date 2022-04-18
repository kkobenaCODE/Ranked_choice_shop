<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\DTO\EditCategoryModel;
use App\Form\EditCategoryFormType;
use App\Form\Handler\CategoryFormHandler;
use App\Form\Handler\ProductFormHandler;
use App\Repository\CategoryRepository;
use App\Utils\Manager\CategoryManager;
use App\Utils\Manager\ProductManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/category", name="admin_category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy(['isDeleted' => false],['id'=>'DESC']);
        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * @Route("/add", name="add")
     */
    public function edit(Request $request, CategoryFormHandler $categoryFormHandler , Category $category = null): Response
    {
      $editCategoryModel = EditCategoryModel::makeFromCategory($category);

        $form = $this->createForm(EditCategoryFormType::class , $editCategoryModel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $category = $categoryFormHandler->processEditForm($editCategoryModel);

            $this->addFlash('success','Your changes was saving correctly.');

            return $this->redirectToRoute('admin_category_edit', ['id' => $category->getId()]);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('warning','Something went wrong.Check your form please.');
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Category $category , CategoryManager $categoryManager): Response
    {
        $categoryManager->remove($category);
        $this->addFlash('warning' , 'Category was successfully deleted.');
        return $this->redirectToRoute('admin_category_list');
    }

}
