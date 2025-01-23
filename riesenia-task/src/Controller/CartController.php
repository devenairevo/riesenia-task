<?php

namespace App\Controller;

use App\Model\Entity\Product;
use Cake\Http\Exception\UnauthorizedException;
use Cake\View\JsonView;
use Riesenia\Cart\Cart;
use Riesenia\Cart\CartItemInterface;

class CartController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function view(): void
    {
    }

    public function addToCart(int $productId, string $currentUserId): void
    {
        if (empty($currentUserId)) {
            throw new UnauthorizedException('You must be logged in');
        }

        /* @var Product $product */
        $this->Products = $this->fetchTable('Products');

        $product = $this->Products->get($productId);

        $session = $this->request->getSession();
        $cartKey = 'Cart_' . $currentUserId;

        $serializedCart = $session->read($cartKey);

        $cart = $serializedCart ? \unserialize($serializedCart) : new Cart();

        if (!$serializedCart) {
            $cart->setContext(['customer_id' => $currentUserId]);
            $cart->setPricesWithVat(true);
            $cart->setRoundingDecimals(2);
        }

        $cart->addItem($product, 1);

        $session->write($cartKey, \serialize($cart));

        $summary = $this->calculateCartSummary($cart);

        $session->write($cartKey . '_Summary', $summary);

        $this->set($summary);
        $this->viewBuilder()->setOption('serialize', \array_keys($summary));
        $this->viewBuilder()->setClassName('Json');
    }

    /**
     * @return array<string, mixed>
     *
     * @property CartItemInterface $vat_rate
     */
    private function calculateCartSummary(Cart $cart): array
    {
        $items = $cart->getItems();
        $totalIncludingVat = $cart->getTotal();
        $totalExcludingVat = $cart->getSubtotal();
        $vatRates = [];

        foreach ($items as $item) {
            $vatRates[] = $item->getTaxRate();
        }

        return [
            'Total Including Vat' => $totalIncludingVat->innerValue(),
            'Total Excluding Vat' => $totalExcludingVat->innerValue(),
            'Vat Rates' => $vatRates
        ];
    }
}
