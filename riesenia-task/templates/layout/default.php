<?php
/**
 * @var AppView $this
 * @var $cartSummary
 */

use App\View\AppView;

$description = 'MINI STORE';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $description ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <script src="https://kit.fontawesome.com/4ddfe8dc82.js" crossorigin="anonymous"></script>
    <style>
        .float-right {
            position: absolute;
            top: 2em;
            right: 2em;
            width: auto;
        }
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Mini</span>Store</a>
        </div>
        <div class="top-nav-links">
            <?php if ($this->Identity->isLoggedIn()): ?>
                <?= $this->Html->link('Categories', ['controller' => 'Categories', 'action' => 'index'], ['target' => '_self']) ?>|
                <?= $this->Html->link('Products', ['controller' => 'Products', 'action' => 'index'], ['target' => '_self']) ?>|
                <?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index'], ['target' => '_self']) ?>|
                <?= $this->Html->link('Log Out', ['controller' => 'Users', 'action' => 'logout', $this->Identity->get('id')], ['target' => '_self']) ?> | <i class="fa-solid fa-user"></i>  <strong><?= $this->Identity->get('username') ?></strong>
            <?php endif; ?>
        </div>
    </nav>
    <?php if ($this->Identity->isLoggedIn()): ?>
        <div class="float-right">
            <h3>Cart Summary</h3>
            <p>Total Excluding VAT: <?= $cartSummary['Total Excluding Vat'] ?></p>
            <p>Total Including VAT: <?= $cartSummary['Total Including Vat'] ?></p>
            <p>VAT Rates: <?= implode(', ', $cartSummary['Vat Rates']) ?></p>
        </div>
    <?php endif; ?>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
