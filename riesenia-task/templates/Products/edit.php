<?php
/**
 * @var AppView $this
 * @var Product $product
 * @var Category $categories
 */

use App\Model\Entity\Category;
use App\Model\Entity\Product;
use App\View\AppView;

?>
<div class="products form content">
    <?= $this->Form->create($product, ['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('Edit Product') ?></legend>
        <?= $this->Form->control('name', ['required' => true]) ?>
        <?= $this->Form->control('description', ['type' => 'textarea', 'required' => false]) ?>
        <?= $this->Form->control('categories._ids', [
            'type' => 'select',
            'options' => $categories,
            'label' => __('Categories'),
            'multiple' => true,
            'empty' => __('Select categories')
        ]) ?>
        <?= $this->Form->control('price', ['type' => 'number', 'required' => true]) ?>
        <?= $this->Form->control('vat_rate', ['type' => 'number', 'min' => '0', 'max' => '100', 'required' => true, 'label' => __('VAT Rate (%)')]) ?>
        <?= $this->Form->control('product_image', ['type' => 'file', 'label' => __('Upload Image')]) ?>
    </fieldset>
    <?= $this->Form->button(__('Save'), ['action' => 'edit']); ?>
    <?= $this->Form->button(__('Cancel'), ['action' => 'index']); ?>
    <?= $this->Form->end() ?>
</div>
