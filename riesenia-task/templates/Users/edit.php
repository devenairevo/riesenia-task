<?php
/**
 * @var AppView $this
 * @var User $user
 */

use App\Model\Entity\User;
use App\View\AppView;

?>
<div class="users form content">
    <?= $this->Form->create($user, ['type' => 'post']) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?= $this->Form->control('username', ['required' => false]) ?>
        <?= $this->Form->control('password', [
            'type' => 'password',
            'value' => '',
            'required' => false,
            'placeholder' => 'Leave empty to keep current password',
            ]) ?>
        <?= $this->Form->control('password_confirmation', ['required' => false, 'type' => 'password']) ?>
    </fieldset>
    <?= $this->Form->button(__('Save')); ?>
    <?= $this->Form->button(__('Cancel', ['action' => 'index'])); ?>
    <?= $this->Form->end() ?>
</div>
