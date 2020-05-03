<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalQuantity = 0;
    public $totalPrice = 0;

    public function __construct($oldCart) {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQuantity = $oldCart->totalQuantity;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function add($item, $id)
    {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id]; // Overwriting first line in the method
            }
        }

        $storedItem['qty']++;
        $storedItem['price'] = $storedItem['qty'] * $item->price;

        $this->items[$id] = $storedItem;
        $this->totalQuantity++;
        $this->totalPrice += $item->price;
    }

    public function reduce($item, $id)
    {
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $item->price;

        $this->totalQuantity--;
        $this->totalPrice -= $item->price;
    }

    public function remove($id) {
        $this->totalQuantity -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['price'];
        unset($this->items[$id]);
    }
}
