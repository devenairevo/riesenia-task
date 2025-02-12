<?php
/**
 * @var User $users
 */

use App\Model\Entity\User;

?>
<h1>Users</h1>
<table>
    <tr>
        <th>Username</th>
        <th>Created</th>
        <th>Action</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr>
            <td>
                <?= $user->username ?>
            </td>
            <td>
                <?= $user->created->format(DATE_RFC850) ?>
            </td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?> |
                <?= $this->Html->link(
                    'Delete',
                    ['action' => 'delete', $user->id],
                    ['confirm' => 'Are you sure you want to delete this user?']
                ) ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
