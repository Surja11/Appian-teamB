
        document.addEventListener('DOMContentLoaded', function() {
            var subscribeForm = document.querySelector('.footer-subscribe');
            var subscribeWrapper = document.querySelector('.footer-subscribe-wrapper');
            var emailInput = document.querySelector('.footer-subscribe__input');

            var submittedEmails = ['test@heffroncompany.com', 'admin@heffroncompany.com'];

            if (subscribeForm && subscribeWrapper && emailInput) {
                subscribeForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var emailValue = emailInput.value.trim().toLowerCase();

                    if (emailValue === "") {
                        alert("Error: Email field is required.");
                        emailInput.focus();
                        return;
                    }

                    if (!emailInput.checkValidity()) {
                        emailInput.reportValidity();
                        return;
                    }

                    var emailParts = emailValue.split('@');
                    var localPart = emailParts[0] || "";

                    if (localPart.length > 64) {
                        alert("Error: The local part of the email address (before the @ symbol) cannot exceed 64 characters.");
                        emailInput.focus();
                        return;
                    }

                    // Validate the complete email address limit (RFC specification)
                    if (emailValue.length > 254) {
                        alert("Error: The total email address cannot exceed 254 characters.");
                        emailInput.focus();
                        return;
                    }

                    if (submittedEmails.indexOf(emailValue) !== -1) {
                        alert("Error: This email address is already subscribed.");
                        emailInput.focus();
                        return;
                    }

                    submittedEmails.push(emailValue);
                    subscribeWrapper.classList.add('is-submitted');
                });
            }
        });
    