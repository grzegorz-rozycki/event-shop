<?php

namespace App\Http\Controllers\Resources;

use App\Aggregates\AggregateRootRepository\Factory;
use App\Aggregates\Cart\Aggregate as CartAggregate;
use App\Aggregates\Cart\Id;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartItem as CartItemResource;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    private $repository;

    public function __construct(Factory $factory)
    {
        $this->repository = $factory->make(CartAggregate::class);
    }

    public function index(string $cart)
    {
        /** @var CartAggregate $cart */
        $cart = $this->repository->retrieve(new Id($cart));

        return $cart->exists()
            ? CartItemResource::collection($cart->getItems())
            : abort(404);
    }

    public function store(Request $request, string $cart)
    {
        /** @var CartAggregate $cart */
        $cart = $this->repository->retrieve(new Id($cart));

        if (!$cart->exists())
            $cart->performCreated();

        $cart->performItemAdded($request->only(['amount', 'id']));
        $this->repository->persist($cart);

        return CartItemResource::collection($cart->getItems());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
