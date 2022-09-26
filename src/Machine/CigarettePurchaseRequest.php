<?php

namespace App\Machine;

class CigarettePurchaseRequest implements PurchaseTransactionInterface
{

    private int $quantity;
    private float $paidAmount;

    public function __construct(int $quantity, float $paidAmount)
    {
        $this->quantity = $quantity;
        $this->paidAmount = $paidAmount;
    }

    public function getItemQuantity(): int
    {
        return $this->quantity;
    }

    public function getPaidAmount(): float
    {
        return $this->paidAmount;
    }
}