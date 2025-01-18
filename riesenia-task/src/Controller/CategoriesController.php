<?php

namespace App\Controller;

use App\Controller\Helpers\DataFormat;
use Cake\Http\Response;

class CategoriesController extends AppController
{
    public function index(): void
    {
        $categories = $this->paginate($this->Categories);
        $this->set(\compact('categories'));
    }

    public function add(): ?Response
    {
        $category = $this->Categories->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $trimmedData = DataFormat::trimData($data);

            $category = $this->Categories->patchEntity($category, $trimmedData);

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Category created successfully'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your category.'));
        }
        $this->set('category', $category);

        return null;
    }

    public function edit(int $id): ?Response
    {
        $category = $this->Categories->get($id);

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $trimmedData = DataFormat::trimData($data);

            $category = $this->Categories->patchEntity($category, $trimmedData);

            if ($this->Categories->save($category)) {
                $this->Flash->success(__('Category updated successfully'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Category could not be updated. Please, try again.'));
            $this->set(\compact('category'));
        }
        $this->set(\compact('category'));

        return null;
    }

    public function delete(int $id): ?Response
    {
        $category = $this->Categories->get($id);

        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('Category removed successfully'));

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error(__('Category could not be deleted. Please, try again.'));

        return $this->redirect(['action' => 'index']);
    }
}
