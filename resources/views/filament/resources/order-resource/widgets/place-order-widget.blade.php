<x-filament::widget>
    <x-filament::card>

        @if ($placeOrder)
            <div class="mt-4" style="display: grid; grid-template-columns: 1fr 1fr;gap: 24px">
                <p><strong>Customer:</strong> {{ $placeOrder->customer->full_name }}</p>
                <p><strong>From Address:</strong> {{ $placeOrder->address_from }}</p>
                <p><strong>To Address:</strong> {{ $placeOrder->address_to }}</p>
                <p><strong>Price:</strong> EGP {{ number_format($placeOrder->price, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($placeOrder->payment_method) }}</p>
            </div>

        @else
            <p class="text-gray-500">No order data available.</p>
        @endif
    </x-filament::card>

</x-filament::widget>
