<?php

namespace App\Controller;

use App\Model\Entity\Product;
use Cake\Http\Exception\UnauthorizedException;
use Cake\View\JsonView;

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

        $this->Products = $this->fetchTable('Products');

        /** @var Product $product */
        $product = $this->Products->get($productId);

        $session = $this->request->getSession();
        $cartKey = 'Cart_' . $currentUserId;
        $cart = $session->read($cartKey) ?? [];

        $cart[] = [
            'name' => $product->name,
            'price' => $product->price,
            'vat_rate' => $product->vat_rate,
        ];
        $session->write($cartKey, $cart);

        $summary = $this->calculateCartSummary($cart);

        $session->write($cartKey . '_Summary', $summary);

        $this->set($summary);
        $this->viewBuilder()->setOption('serialize', \array_keys($summary));
        $this->viewBuilder()->setClassName('Json');
    }

    /**
     * @param array<int, array{name: string, price: float, vat_rate: float}> $cart
     *
     * @return array<string, mixed>
     */
    private function calculateCartSummary(array $cart): array
    {
        $totalIncludingVat = 0;
        $totalExcludingVat = 0;
        $vatRates = [];

        foreach ($cart as $item) {
            $totalIncludingVat += $item['price'] + ($item['price'] * $item['vat_rate'] / 100);
            $totalExcludingVat += $item['price'];
            $vatRates[] = $item['vat_rate'];
        }

        return [
            'Total Including Vat' => \round($totalIncludingVat, 2),
            'Total Excluding Vat' => \round($totalExcludingVat, 2),
            'Vat Rates' => \array_unique($vatRates)
        ];
    }
}
