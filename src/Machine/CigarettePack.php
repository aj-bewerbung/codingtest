<?php

namespace App\Machine;

class CigarettePack implements PurchasedItemInterface
{

    private int $quantity;
    private float $totalAmount;
    private float $change;

    public function __construct(int $quantity, float $totalPrice, float $change)
    {
        $this->quantity = $quantity;
        $this->totalAmount = $totalPrice;
        $this->change = $change;
    }

    public function getItemQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function getChange(): array
    {
        // calculate in cent to prevent float rounding errors
        $restInCent = (int)ceil($this->change * 100);

        foreach ([2, 1, 0.5, 0.2, 0.1, 0.05, 0.02, 0.01] as $coin) {
            $coinInCent = $coin * 100;

            $coinAmount = (int)floor($restInCent / $coinInCent);
            $restInCent -= $coinInCent * $coinAmount;

            $change[] = [(string)$coin, $coinAmount];
        }

        return $change;
    }
}