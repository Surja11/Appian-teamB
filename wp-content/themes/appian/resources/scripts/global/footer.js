document.addEventListener('DOMContentLoaded', function () {

    let subscribeWrapper = document.getElementsByClassName('custom-footer__subscribe')[0];
    let subscribeForm = document.getElementsByClassName('custom-footer__form')[0];
    let emailInput = document.getElementsByClassName('custom-footer__input')[0];
    let errorDiv = document.getElementsByClassName('custom-footer__input-error')[0];
    let thankYou = document.querySelector('.custom-footer__thank-you');

    if (!subscribeForm || !subscribeWrapper || !emailInput) return;

    var submittedEmails = JSON.parse(localStorage.getItem('footer_subscribed_emails') || '[]');

    function isValidEmail(email) {
        const emailRegex = /^[a-zA-Z0-9][a-zA-Z0-9._%+-]*[a-zA-Z0-9]@[a-zA-Z0-9][a-zA-Z0-9.-]*[a-zA-Z0-9]\.[a-zA-Z]{2,}$/;

        const invalidPatterns = [
            /\.{2,}/,
            /^\./,
            /\.$/,
            /@\./,
            /\.@/,
            /@@/,
            /@.*@/,
            /\s/,
            /[#%^]/
        ];

        const hasInvalidPattern = invalidPatterns.some(pattern => pattern.test(email));

        return !(!emailRegex.test(email) || hasInvalidPattern);
    }

    function showError(msg) {
        if (errorDiv) {
            errorDiv.textContent = msg;
        }
        emailInput.focus();
    }

    function clearError() {
        if (errorDiv) {
            errorDiv.textContent = '';
        }
    }

    emailInput.addEventListener('input', clearError);

    subscribeForm.addEventListener('submit', function (e) {
        e.preventDefault();
        clearError();

        let emailValue = emailInput.value.trim().toLowerCase();

        if (emailValue === '') {
            showError('Email field is required.');
            return;
        }

        if (!isValidEmail(emailValue)) {
            showError('Please enter a valid email address.');
            return;
        }

        const local = emailValue.split('@')[0];
        if (local.length > 64) {
            showError('The part before @ cannot exceed 64 characters.');
            return;
        }

        if (emailValue.length > 254) {
            showError('The email address cannot exceed 254 characters.');
            return;
        }

        if (submittedEmails.indexOf(emailValue) !== -1) {
            showError('This email address has already subscribed.');
            return;
        }

        submittedEmails.push(emailValue);
        localStorage.setItem('footer_subscribed_emails', JSON.stringify(submittedEmails));

        let label = subscribeWrapper.querySelector('.custom-footer__label');
        let form = subscribeWrapper.querySelector('.custom-footer__form');
        let error = subscribeWrapper.querySelector('.custom-footer__input-error');
        let thanks = subscribeWrapper.querySelector('.custom-footer__thank-you');

        if (label) label.style.display = 'none';
        if (form) form.style.display = 'none';
        if (error) error.style.display = 'none';
        if (thanks) {
            thanks.style.display = 'block';
        }
    });

});