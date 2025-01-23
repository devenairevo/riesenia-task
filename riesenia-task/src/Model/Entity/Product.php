<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Riesenia\Cart\CartContext;
use Riesenia\Cart\CartItemInterface;

/**
 * @property mixed  $product_images
 * @property int    $id
 * @property string $name
 * @property float  $price
 * @property float  $vat_rate
 */
class Product extends Entity implements CartItemInterface
{
    protected float $cartQuantity = 1.0;
    protected array $_accessible = [
        'name' => true,
        'description' => true,
        'price' => true,
        'vat_rate' => true,
        'product_images' => true,
        'categories' => true,
        'categories._ids' => true
    ];

    public function getCartId(): string
    {
        return (string) $this->id;
    }

    public function getCartType(): string
    {
        return 'product';
    }

    public function getCartName(): string
    {
        return 'MINI cart';
    }

    public function setCartContext(CartContext $context): void
    {
    }

    public function setCartQuantity(float $quantity): void
    {
        $this->cartQuantity = $quantity;
    }

    public function getCartQuantity(): float
    {
        return $this->cartQuantity;
    }

    public function getUnitPrice(): float
    {
        return (float) $this->price;
    }

    public function getTaxRate(): float
    {
        return (float) $this->vat_rate;
    }
}
