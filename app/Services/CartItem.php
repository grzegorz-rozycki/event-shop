<?php

namespace App\Services;

use App\Aggregates\AggregateRootRepository\Factory;
use App\Aggregates\Cart\Aggregate as CartAggregate;
use App\Aggregates\Cart\Id;

class CartItem
{
    private $repository;

    public function __construct(Factory $factory)
    {
        $this->repository = $factory->make(CartAggregate::class);
    }

    public function findCartById(string $id): CartAggregate
    {
        return $this->repository->retrieve(new Id($id));
    }

    public function addItem(string $cartId, int $productId, int $productAmount = 1): CartAggregate
    {
        $cart = $this->findCartById($cartId);

        if (!$cart->exists())
            $cart->performCreated();

        $cart->performItemAdded(['amount' => $productAmount, 'id' => $productId]);
        $this->repository->persist($cart);

        return $cart;
    }
}
