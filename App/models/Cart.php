<?php
namespace App\Models;

class Cart {
    private array $items = [];

    public function addItem(int $id, string $name, float $price, int $quantity): void {
        $this->items[$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    public function getItems(): array {
        return $this->items;
    }

    public function getCount(): int {
        return count($this->items);
    }

    public function getTotal(): float {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function calculateLoyaltyPoints(): int {
        return (int) floor($this->getTotal() / 100) * 10;
    }

    public function isEmpty(): bool {
        return empty($this->items);
    }

    public function clear(): void {
        $this->items = [];
    }

    public function updateQuantity(int $id, int $quantity): void {
        if ($quantity <= 0) {
            unset($this->items[$id]);
        } elseif (isset($this->items[$id])) {
            $this->items[$id]['quantity'] = $quantity;
        }
    }

    public function removeItem(int $id): void {
        unset($this->items[$id]);
    }
}