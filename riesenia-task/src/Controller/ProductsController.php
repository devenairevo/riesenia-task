<?php

namespace App\Controller;

use App\Controller\Helpers\DataFormat;
use App\Model\Entity\Product;
use Cake\Datasource\EntityInterface;
use Cake\Http\Response;
use Cake\Utility\Text;
use Psr\Http\Message\UploadedFileInterface;

class ProductsController extends AppController
{
    public function index(): void
    {
        $products = $this->paginate($this->Products->find()->contain(['Categories', 'ProductImages']));
        $this->set(\compact('products'));
    }

    public function add(): ?Response
    {
        $product = $this->Products->newEmptyEntity();
        $categories = $this->Products->Categories->find('list')->all();
        $this->set(\compact('categories'));

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $trimmedData = DataFormat::trimData($data);

            $product = $this->Products->patchEntity($product, $trimmedData, [
                'associated' => ['ProductImages', 'Categories']
            ]);

            $productImage = $this->uploadImage($this->request->getData('product_image'));

            if ($productImage) {
                $product->product_images = [$productImage];
            }

            if ($this->Products->save($product, ['associated' => ['ProductImages', 'Categories']])) {
                $this->Flash->success(__('Product created successfully'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your product.'));
        }
        $this->set(\compact('product'));

        return null;
    }

    public function edit(int $id): ?Response
    {
        $product = $this->Products->get($id, contain: ['Categories', 'ProductImages']);

        $categories = $this->Products->Categories->find('list')->all();
        $this->set(\compact('categories'));

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $trimmedData = DataFormat::trimData($data);

            $product = $this->Products->patchEntity($product, $trimmedData, [
                'associated' => ['ProductImages', 'Categories']
            ]);

            $productImage = $this->uploadImage($this->request->getData('product_image'));

            if ($productImage) {
                $productImages = $this->Products->get($id, contain : ['ProductImages']);

                if ($productImages) {
                    $this->removeLocalImage($productImages);
                }

                $product->product_images = [$productImage];
            }

            if ($this->Products->save($product, ['associated' => ['ProductImages', 'Categories']])) {
                $this->Flash->success(__('Product updated successfully'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Product could not be updated. Please, try again.'));
        }
        $this->set(\compact('product'));

        return null;
    }

    public function delete(int $id): ?Response
    {
        $product = $this->Products->get($id, contain : ['ProductImages']);

        if ($this->Products->delete($product, ['cascade' => true])) {
            $this->removeLocalImage($product);
            $this->Flash->success(__('Product and all related data removed successfully'));

            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__('Product could not be deleted. Please, try again.'));

        return $this->redirect(['action' => 'index']);
    }

    private function uploadImage(UploadedFileInterface $file): ?EntityInterface
    {
        $imageFolder = 'img/uploads/';

        if ($file->getError() === UPLOAD_ERR_OK) {
            $productImage = $this->Products->ProductImages->newEmptyEntity();

            if ($file->getClientFilename()) {
                $newFileName = Text::uuid() . '.' . \pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);

                $uploadDir = WWW_ROOT . 'img' . DS . 'uploads' . DS;

                if (!\file_exists($uploadDir)) {
                    \mkdir($uploadDir, 0777, true);
                }

                $file->moveTo($uploadDir . $newFileName);

                $productImage->path = $imageFolder . $newFileName;
                $productImage->name = $file->getClientFilename();
                $productImage->image = $newFileName;

                return $productImage;
            }
        }

        return null;
    }

    private function removeLocalImage(Product $productImages): void
    {
        foreach ($productImages->product_images as $image) {
            $imagePath = WWW_ROOT . 'img' . DS . 'uploads' . DS . \basename($image['image']);

            if (\is_file($imagePath) && \file_exists($imagePath)) {
                try {
                    \unlink($imagePath);
                } catch (\Exception $e) {
                    $this->Flash->error(__('An error occurred: ' . $e->getMessage()));
                }
            } else {
                $this->Flash->error(__('Image not found: ' . $imagePath));
            }
        }
    }
}
