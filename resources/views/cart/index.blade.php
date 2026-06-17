@extends('layouts.app')

@section('title', 'Shopping Cart - E-Commerce Store')

@section('content')
<h1 class="mb-4">Shopping Cart</h1>

@if($cart && $cart->items->count() > 0)
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->images->first())
                                                <img src="{{ $item->product->images->first()->image_url }}"
                                                     alt="{{ $item->product->name }}" style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                            @endif
                                            <div>
                                                <h6 class="mb-0">
                                                    <a href="{{ route('products.show', $item->product) }}" class="text-decoration-none">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h6>
                                                @if($item->variant)
                                                    <small class="text-muted">{{ $item->variant->name }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                   max="{{ $item->variant ? $item->variant->stock_quantity : $item->product->stock_quantity }}"
                                                   class="form-control" style="width: 70px;" onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td>${{ number_format($item->getSubtotal(), 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Continue Shopping</a>
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Clear entire cart?')">Clear Cart</button>
                </form>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <strong>${{ number_format($cart->total_price, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (0%):</span>
                        <strong>$0.00</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <strong>Free</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5">Total:</span>
                        <h5>${{ number_format($cart->total_price, 2) }}</h5>
                    </div>
                    <a href="{{ route('orders.create') }}" class="btn btn-primary w-100 btn-lg">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">
        <h4>Your cart is empty</h4>
        <p>Start shopping to add items to your cart.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
@endif
@endsection
