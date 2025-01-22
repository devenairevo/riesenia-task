<?php
/**
 * @var Category $categories
 */

use App\Model\Entity\Category;

?>
<h1>Category - <?= $categories->name ?></h1>
<table>
    <tr>
        <th>Product</th>
        <th>Description</th>
        <th>Price</th>
        <th>VAT(%)</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    <?php if (!empty($categories->products)): ?>
        <?php foreach ($categories->products as $product): ?>
            <tr>
                <td>
                    <?= $this->Html->link($product->name, ['controller' => 'Products', 'action' => 'edit', $product->id]) ?>
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
                            <img src="<?= $this->Url->image('uploads/' . $image->image) ?>" style="width: 150px; height: 150px;">
                            <?php break; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        No image
                    <?php endif; ?>
                </td>
                <td>
                    <?= $this->Html->link('Add to Cart', ['controller' => 'Cart', 'action' => 'addToCart', $product->id, $this->Identity->get('id')]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <strong>No Products yet</strong>
    <?php endif; ?>
</table>
