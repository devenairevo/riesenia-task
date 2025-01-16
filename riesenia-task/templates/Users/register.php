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
        <legend><?= __('Register New User') ?></legend>
        <?= $this->Form->control('username', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true, 'type' => 'password']) ?>
        <?= $this->Form->control('password_confirmation', ['required' => true, 'type' => 'password']) ?>
    </fieldset>
    <?= $this->Form->button(__('Register')); ?>
    <?= $this->Form->end() ?>
    <div class="text">
        <?= $this->Html->link(__('Already have an account? Login'), ['action' => 'login']) ?>
    </div>
</div>
