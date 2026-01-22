<?php
namespace App\Models;

class Cart
{
    private array $items = [];

    public function __construct($items = [])
    {
        if (is_array($items)) {
            $this->items = $items;
        } else {
            $this->items = [];
        }
    }

    public function addItem(int $id, string $name, float $price, int $quantity): void
    {
        if (isset($this->items[$id])) {
            $this->items[$id]['quantity'] += $quantity;
        } else {
            $this->items[$id] = [
                'id'       => $id,
                'name'     => $name,
                'price'    => $price,
                'quantity' => $quantity
            ];
        }
    }

    public function updateQuantity(int $id, int $quantity): void
    {
        if ($quantity <= 0) {
            unset($this->items[$id]);
        } elseif (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantity;
        }
    }

    public function removeItem(int $id): void
    {
        unset($this->items[$id]);
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function getCount(): int
    {
        return array_sum(array_column($this->items, 'quantity'));
    }

    public function getTotal(): float
    {
        return array_reduce($this->items, fn($t, $i) => $t + ($i['price'] * $i['quantity']), 0);
    }

    public function calculateLoyaltyPoints(): int
    {
        return (int) floor($this->getTotal() / 100) * 10;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }
}
