@extends('user.layouts.app')
@section('content')
<div class="container">
    <form id="payment-form" class="text-center">
        <div id="paymentCard">
        </div>
        <button id="submit" class="btn btn-success my-2" style="display: none">Save Card</button>
    </form>
</div>
@endsection
@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const appearance = { theme: 'flat'};
    var stripe = Stripe('{{ env("STRIPE_KEY") }}');
    var elements = stripe.elements({
                        clientSecret: '{{ $data->client_secret }}',
                        appearance
                    });
    var paymentElement = elements.create('payment');
    paymentElement.mount('#paymentCard');
    paymentElement.on('change', function(event) {
        if (event.complete) {
            console.log(event.complete);
            $('#submit').show();
        }
    });
    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const {error} = await stripe.confirmSetup({
            //`Elements` instance that was used to create the Payment Element
            elements,
            confirmParams: {
                return_url: '{{ route("user.setup-complete") }}',
            }
        });
        if (error) {
            // This point will only be reached if there is an immediate error when
            // confirming the payment. Show error to your customer (for example, payment
            // details incomplete)
            const messageContainer = document.querySelector('#error-message');
            messageContainer.textContent = error.message;
        }
    });
</script>
@endsection
