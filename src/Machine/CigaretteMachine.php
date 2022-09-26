<?php

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    public const ITEM_PRICE = 4.99;

    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItemInterface
    {
        $totalPrice = self::ITEM_PRICE * $purchaseTransaction->getItemQuantity();

        switch ($purchaseTransaction->getPaidAmount() <=> $totalPrice) {
            // not enough money given
            case -1:
                $numberPurchasable = floor($purchaseTransaction->getPaidAmount() / self::ITEM_PRICE);
                $neededPayment = self::ITEM_PRICE * $numberPurchasable;
                return new CigarettePack(
                    $numberPurchasable,
                    $neededPayment,
                    $purchaseTransaction->getPaidAmount() - $neededPayment
                );

            // more than needed, needs change
            case 1:
                return new CigarettePack(
                    $purchaseTransaction->getItemQuantity(),
                    $totalPrice,
                    $purchaseTransaction->getPaidAmount() - $totalPrice
                );

            // exactly the right amount
            default:
                return new CigarettePack(
                    $purchaseTransaction->getItemQuantity(),
                    $purchaseTransaction->getPaidAmount(),
                    0
                );
        }
    }
}