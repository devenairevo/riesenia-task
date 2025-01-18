<?php
/**
 * @var AppView $this
 * @var Category $category
 */

use App\Model\Entity\Category;
use App\View\AppView;

?>
<div class="categories form content">
    <?= $this->Form->create($category, ['type' => 'post']) ?>
    <fieldset>
        <?= $this->Form->control('name', ['required' => false]) ?>
    </fieldset>
    <?= $this->Form->button(__('Save')); ?>
    <?= $this->Form->button(__('Cancel', ['action' => 'index'])); ?>
    <?= $this->Form->end() ?>
</div>
