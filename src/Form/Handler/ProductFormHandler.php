<?php

namespace App\Form\Handler;

use App\Entity\Product;
use App\Form\DTO\EditProductModel;
use App\Utils\File\FileSaver;
use App\Utils\Manager\ProductManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;

class ProductFormHandler
{
    /**
     * @var FileSaver
     */
    private $fileSaver;
    /**
     * @var ProductManager
     */
    private $productManager;

    public function __construct(ProductManager $productManager, FileSaver $fileSaver)
    {
        $this->fileSaver = $fileSaver;
        $this->productManager = $productManager;
    }

    /**
     * @param EditProductModel $editProductModel
     * @param Form $form
     * @return Product|null
     */
    public function processEditForm(EditProductModel $editProductModel, Form $form)
    {
        $product = new Product();

        if($editProductModel->id){
            $product=$this->productManager->find($editProductModel->id);
        }

        $product->setTitle($editProductModel->title);
        $product->setPrice($editProductModel->price);
        $product->setDescription($editProductModel->description);
        $product->setQuantity($editProductModel->quantity);
        $product->setCategory($editProductModel->category);
        $product->setIsPublished($editProductModel->isPublished);
        $product->setIsDeleted($editProductModel->isDeleted);

        $this->productManager->save($product);

        $newImageFile=$form->get('newImage')->getData();

        $tempImageFilename = $newImageFile
            ? $this->fileSaver->saveUploadedFileIntoTemp($newImageFile)
            : null;
        $this->productManager->updateProductImages($product , $tempImageFilename);

        //TODO:ADD A NEW IMAGE WITH DIFFERENT SIZES TO THE PRODUCT
        //1. Save product's changes +
        //2. Save uploaded file in temporary directory +
        //3. Work with product (addProductImage) and ProductImage
        //3.1 Get path of folder with images
        //3.2 Work with ProductImage
        //3.2.1 Resize and image saving into folder (big small medium)
        //3.2.2 Create ProductImage and return to Product
        //3.3 Save Product with new ProductImage

        $this->productManager->save($product);
        return $product;
    }
}