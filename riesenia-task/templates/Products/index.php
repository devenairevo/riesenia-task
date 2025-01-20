<?php
/**
 * @var Product $products
 */

use App\Model\Entity\Product;

?>
<h1>Products</h1>
<table>
    <tr>
        <th>Product</th>
        <th>Description</th>
        <th>Price</th>
        <th>VAT(%)</th>
        <th>Image</th>
        <th>Categories</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td>
                <?= $product->name ?>
            </td>
            <td>
                <?= $product->description ?>
            </td>
            <td>
                <?= $product->price ?>
            </td>
            <td>
                <?= $product->vat_rate ?>
            </td>
            <td>
                <?php if (!empty($product->product_images)): ?>
                    <?php foreach ($product->product_images as $image): ?>
                        <img src="<?= $this->Url->image('uploads/' . $image->image) ?>" style="width: 300px; height: auto;">
                        <?php break; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    No image
                <?php endif; ?>
            </td>
            <td>
                <?php foreach ($product->categories as $category): ?>
                    <li><?= $category->name ?></li>
                <?php endforeach; ?>
            </td>
            <td>
                <?= $product->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $product->id]) ?>
                <?= $this->Html->link(
                    'Delete',
                    ['action' => 'delete', $product->id],
                    ['confirm' => 'Are you sure you want to delete this category?']
                ) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?= $this->Html->link(__('Add Product'), ['action' => 'add'], ['class' => 'button']); ?>
</table>
