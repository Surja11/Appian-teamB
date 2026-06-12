document.addEventListener('DOMContentLoaded', function () {

    var subscribeWrapper = document.querySelector('.custom-footer__subscribe');
    var subscribeForm    = document.querySelector('.custom-footer__form');
    var emailInput       = document.querySelector('.custom-footer__input');
    var errorEl          = document.querySelector('.custom-footer__input-error');
    var thankYou         = document.querySelector('.custom-footer__thank-you');

    if (!subscribeForm || !subscribeWrapper || !emailInput) return;

    var submittedEmails = JSON.parse(localStorage.getItem('footer_subscribed_emails') || '[]');


    function showError(msg) {
        if (errorEl) {
            errorEl.textContent = msg;
            errorEl.setAttribute('aria-live', 'polite');
        }
        emailInput.focus();
    }

    function clearError() {
        if (errorEl) errorEl.textContent = '';
    }

    emailInput.addEventListener('input', clearError);

  
    subscribeForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearError();

        var emailValue = emailInput.value.trim().toLowerCase();

        if (emailValue === '') {
            showError('Email field is required.');
            return;
        }

  
        if (!emailInput.checkValidity()) {
            showError('Please enter a valid email address.');
            return;
        }

   
        var localPart = emailValue.split('@')[0] || '';
        if (localPart.length > 64) {
            showError('The part before @ cannot exceed 64 characters.');
            return;
        }

        if (emailValue.length > 254) {
            showError('The email address cannot exceed 254 characters.');
            return;
        }
        if (submittedEmails.indexOf(emailValue) !== -1) {
            showError('This email address is already subscribed.');
            return;
        }

        submittedEmails.push(emailValue);
        localStorage.setItem('footer_subscribed_emails', JSON.stringify(submittedEmails));

     
        var label = subscribeWrapper.querySelector('.custom-footer__label');
        var form  = subscribeWrapper.querySelector('.custom-footer__form');
        var error = subscribeWrapper.querySelector('.custom-footer__input-error');
        var thanks = subscribeWrapper.querySelector('.custom-footer__thank-you');

        if (label) label.style.display = 'none';
        if (form)  form.style.display  = 'none';
        if (error) error.style.display = 'none';
        if (thanks) {
            thanks.style.display = 'block';
        }
    });

});
