var stripe = Stripe('pk_test_8OdbLnw8GSMSPmJQ7VB3Y8KK001rmErRmv');
var elements = stripe.elements();

var button = document.getElementById('submit');
var err_msg = document.getElementById('card-errors');
var success_msg = document.getElementById('card-success');

var clientSecret = button.dataset.mami;
var card = elements.create('card', {
    iconStyle: 'solid',
    style: {
      base: {
        iconColor: '#c4f0ff',
        color: '#fff',
        fontWeight: 500,
        fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
        fontSize: '26px',
        fontSmoothing: 'antialiased',

        ':-webkit-autofill': {
          color: '#fce883',
        },
        '::placeholder': {
          color: '#87BBFD',
        },
      },
      invalid: {
        iconColor: '#FFC7EE',
        color: '#FFC7EE',
      },
    },
});
  card.mount('#card-element');


var form = document.getElementById('payment-form');

form.addEventListener('submit', function(ev) {
  ev.preventDefault();
  stripe.confirmCardPayment(clientSecret, {
    payment_method: {
      card: card,
      billing_details: {
        name: 'Jenny Rosen'
      }
    }
  }).then(function(result) {
    if (result.error) {
      // Show error to your customer (e.g., insufficient funds)
      console.log("This is only message it seems" + result.error.message);
      err_msg.classList.remove('hidden');
      success_msg.classList.add('hidden');
      err_msg.innerHTML = result.error.message;
    } else {
      // The payment has been processed!
      if (result.paymentIntent.status === 'succeeded') {
         err_msg.classList.add('hidden');
         success_msg.classList.remove('hidden');
         success_msg.innerHTML = 'Payment Success! Please wait while we redirect you.....';

         setTimeout(() => {
             window.location.href = '/post_checkout';
         }, 2000);
      }
    }
  });
});
