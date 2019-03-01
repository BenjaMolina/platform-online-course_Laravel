{{-- <form action="{{ route('subscriptions.process_subscription') }}" method="POST"> --}}
    {{-- @csrf --}}
    {{-- <input 
        type="text" 
        class="form-control"
        placeholder="{{ __("¿Tiene un cupon?") }}"
    />
    <input type="hidden" class="" name="type" value="{{ $product['type'] }}">
    <hr> --}}
    <stripe-form
        stripe_key="{{ env('STRIPE_KEY') }}"
        name="{{ $product['name'] }}"
        amount="{{ $product['amount'] }}"
        description="{{ $product['description'] }}"
        action="{{ route('subscriptions.process_subscription') }}"
        placeholder="{{ __("¿Tiene un cupon?") }}"
        type="{{ $product['type'] }}"
    >
    </stripe-form>
{{-- </form> --}}