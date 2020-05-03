var card = new Card({
    form: document.querySelector('#payment-form'),
    container: '.card-wrapper',
    formSelectors: {
        numberInput: 'input#number',
        expiryInput: 'input#expiry-month, input#expiry-year',
        cvcInput: 'input#cvc',
        nameInput: 'input#name'
    },
    placeholders: {
        number: '•••• •••• •••• ••••',
        name: 'Full Name',
        expiry: '••/••',
        cvc: '•••'
    }
});
