<?php
/**
 * @var Category $categories
 */

use App\Model\Entity\Category;

?>
<h1>Categories</h1>
<table>
    <tr>
        <th>Category</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td>
                <?= $category->name ?>
            </td>
            <td>
                <?= $category->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $category->id]) ?> |
                <?= $this->Html->link(
                    'Delete',
                    ['action' => 'delete', $category->id],
                    ['confirm' => 'Are you sure you want to delete this category?']
                ) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?= $this->Html->link(__('Add Category'), ['action' => 'add'], ['class' => 'button']); ?>
</table>
