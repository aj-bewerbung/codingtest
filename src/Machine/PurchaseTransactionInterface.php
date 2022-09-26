<?php

namespace App\Machine;

/**
 * Interface PurchasableItemInterface
 * @package App\Machine
 */
interface PurchaseTransactionInterface
{
    /**
     * @return int
     */
    public function getItemQuantity();

    /**
     * @return float
     */
    public function getPaidAmount();
}