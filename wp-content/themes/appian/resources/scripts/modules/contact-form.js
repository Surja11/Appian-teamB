// Contact form validation and submission
class ContactForm {
    constructor() {
        // Find form elements
        this.form = document.getElementById('js-contact-form');
        this.submitButton = this.form ? this.form.querySelector('.contact-form__submit') : null;
        this.inputs = this.form.querySelectorAll('input.contact-form__input, select.contact-form__input, textarea.contact-form__input');
        this.radioInputs = this.form ? this.form.querySelectorAll('.contact-form__radio') : [];

        this.formAction = this.form ? this.form.getAttribute('action') : '';
        if (this.form) {
            this.init();
        }
    }

    init() {
        this.bindEvents();
        this.setupValidation();
        this.setupAccessibility();
        this.setupRadioDropdownToggle();
    }

    bindEvents() {
        // Handle form submit
        this.form.addEventListener('submit', this.handleSubmit.bind(this));

        // Check fields when user clicks outside
        this.inputs.forEach(input => {
            input.addEventListener('blur', this.validateField.bind(this));
            input.addEventListener('input', this.clearFieldError.bind(this));
        });
    }

    setupValidation() {
        this.inputs.forEach(input => {
            input.addEventListener('invalid', this.handleInvalid.bind(this));
        });
    }

    setupAccessibility() {
        this.radioInputs.forEach(radio => {
            const label = document.querySelector(`label[for="${radio.id}"]`);
            if (label) {
                label.addEventListener('click', () => {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change'));
                });
            }
        });
    }

    handleSubmit(event) {
        event.preventDefault();

        // Only submit the form if valid
        if (this.validateForm()) {
            this.submitForm();
        }
    }

    validateForm() {
        let isValid = true;

        // Clear old errors and messages
        this.clearAllErrors();
        const existingStatus = this.form.querySelector('.form-success-message, .form-error-message');
        if (existingStatus) existingStatus.remove();

        // Check each input field
        this.inputs.forEach(input => {
            if (!this.validateField({ target: input })) {
                isValid = false;
            }
        });

        // Check radio buttons
        const radioWrapper = this.form.querySelector('.contact-form__radio-dropdown-wrapper');
        if (radioWrapper) {
            const radioGroupChecked = radioWrapper.querySelector('.contact-form__radio:checked');

            if (!radioGroupChecked) {
                const triggerBox = radioWrapper.querySelector('.contact-form__radio-trigger');
                triggerBox.classList.add('error');
                
                const oldError = radioWrapper.querySelector('.error-message');
                if (oldError) oldError.remove();

                const errorElement = document.createElement('div');
                errorElement.className = 'error-message body-small';
                errorElement.textContent = 'This field is required';

                radioWrapper.appendChild(errorElement);

                isValid = false;
            }
        }

        return isValid;
    }

    validateField(event) {
        const field = event.target;
        const value = field.value.trim();
        let isValid = true;

        // Check if required field is empty
        if (field.hasAttribute('required') && !value) {
            this.showFieldError(field, 'This field is required');
            isValid = false;
        }

        // Check name fields for valid characters
        const isNameField = field.name === 'first-name' || field.name === 'last-name';

        if (isNameField && value) {
            const nameRegex = /^[a-zA-ZÀ-ÿ\s'\-]+$/;
            
            if (!nameRegex.test(value)) {
                this.showFieldError(field, 'Please enter a valid name (letters, spaces, hyphens, and apostrophes only)');
                isValid = false;
            }
        }

        // Check email format
        if (field.type === 'email' && value) {
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
            
            let hasInvalidPattern = invalidPatterns.some(pattern => pattern.test(value));
            
            if (!emailRegex.test(value) || hasInvalidPattern) {
                this.showFieldError(field, 'Please enter a valid email address');
                isValid = false;
            }
        }

        // Check phone number format
        if (field.type === 'tel' && value) {
            const cleanPhone = value.replace(/\D/g, '');
            
            const isAllZeros = /^0+$/.test(cleanPhone);
            const hasConsecutiveSpecialChars = /[\-\.]{2,}|[\s]{2,}|[\(\)]{2,}/.test(value); // Only check dashes, dots, spaces or parentheses
            const hasInvalidPatterns = /[^\+0-9\s.\-\(\)]/.test(value);
            
            const startsOK = /^[\+\(0-9]/.test(value); // Start with +, ( or digit
            const endsOK = /[0-9\)]$/.test(value);    // End with digit or )
            
            // Phone must pass all these checks
            if (
                !startsOK ||                      
                !endsOK ||                        
                hasConsecutiveSpecialChars ||     // No double symbols or multiple spaces
                hasInvalidPatterns ||             
                isAllZeros ||                     // Can't be all zeros
                cleanPhone.length < 7 ||          // At least 7 numbers
                cleanPhone.length > 15            // Max 15 numbers
            ) {
                this.showFieldError(field, 'Please enter a valid phone number');
                isValid = false;
            }
        }

        // Check if date is in future
        if (field.type === 'date' && value) {
            const selectedDate = new Date(value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                this.showFieldError(field, 'Please select a future date');
                isValid = false;
            }
        }

        return isValid;
    }

    showFieldError(field, message) {
        field.classList.add('error');
        
        // Remove old error message
        const parent = field.parentNode;
        let existingError = parent.querySelector('.error-message');
        if (existingError) existingError.remove();

        // Add new error message
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message body-small';
        errorElement.textContent = message;

        parent.appendChild(errorElement);
    }

    clearFieldError(event) {
        const field = event.target;
        field.classList.remove('error');

        const errorMessage = field.parentNode.querySelector('.error-message');
        if (errorMessage) errorMessage.remove();
    }

    clearAllErrors() {
        const errorMessages = this.form.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());

        this.inputs.forEach(input => {
            input.classList.remove('error');
        });

        const radioWrapper = this.form.querySelector('.contact-form__radio-dropdown-wrapper');
        if (radioWrapper) {
            const triggerBox = radioWrapper.querySelector('.contact-form__radio-trigger');
            if (triggerBox) {
                triggerBox.classList.remove('error');
            }
        }
    }

    showError(message) {        
        let errorContainer = this.form.querySelector('.form-error-message');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.className = 'form-error-message';
            this.form.insertBefore(errorContainer, this.form.firstChild);
        }
        errorContainer.textContent = message;
    }

    handleInvalid(event) {
        event.preventDefault();
        this.validateField(event);
    }

    async submitForm() {
        this.setLoadingState(true);

        const structuralStatus = this.form.querySelector('.form-success-message, .form-error-message');
        if (structuralStatus) structuralStatus.remove();

        try {
            
            const formData = new FormData(this.form);

            formData.append('action', 'submit_form_action');
           
            const response = await fetch(this.formAction, {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error('Network error received.');

            const result = await response.json();

            if (result.success) {
                this.showSuccessMessage();
                this.form.reset();
                this.clearAllErrors();
            } else {
                this.showError(result.data.message || 'An entry processing error occurred.');
            }

        } catch (error) {
            this.showError('System submission error. Please try again later.');
        } finally {
            this.setLoadingState(false);
        }
    }

    setLoadingState(loading) {
        const textSpan = this.submitButton.querySelector('span');
        if (loading) {
            this.submitButton.disabled = true;
            this.submitButton.classList.add('loading');
            textSpan.textContent = 'Submitting...';
        } else {
            this.submitButton.disabled = false;
            this.submitButton.classList.remove('loading');
            textSpan.textContent = 'Submit';
        }
    }

    showSuccessMessage() {
        const formContainer = this.form.querySelector('.contact-form__grid');
        
        if (formContainer) {
            formContainer.classList.add('form-hidden');
        }

        const successMessage = document.createElement('div');
        successMessage.className = 'form-success-message';
        successMessage.innerHTML = `
            <div class="success-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12L3.41 13.41L9 19L21 7L19.59 5.59L9 16.17Z"/>
                </svg>
            </div>
            <h3 class="success-title">Thank you!</h3>
            <p class="success-text">Your message has been sent successfully.<br>We'll get back to you soon.</p>
            <button type="button" class="contact-form__send-another">Send another message</button>
        `;

        this.form.insertBefore(successMessage, this.form.firstChild);
        successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });

        // Add event listener for "Send another message" button
        const sendAnotherBtn = successMessage.querySelector('.contact-form__send-another');
        sendAnotherBtn.addEventListener('click', () => {
            this.resetForm();
        });
    }

    resetForm() {
        // Remove success message
        const successMessage = this.form.querySelector('.form-success-message');
        if (successMessage) successMessage.remove();

        // Show form again
        const formContainer = this.form.querySelector('.contact-form__grid');
        
        if (formContainer) {
            formContainer.classList.remove('form-hidden');
        }

        // Reset form fields
        this.form.reset();
        this.clearAllErrors();

        // Scroll back to form
        this.form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    setupRadioDropdownToggle() {
        const wrapper = document.querySelector('.contact-form__radio-dropdown-wrapper');
        if (!wrapper) return;

        const trigger = wrapper.querySelector('.contact-form__radio-trigger');
        const radios = wrapper.querySelectorAll('.contact-form__radio');

        trigger.addEventListener('click', () => {
            wrapper.classList.toggle('is-open');

            trigger.classList.remove('error');
            const localError = wrapper.querySelector('.error-message');
            if (localError) localError.remove();
        });

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                trigger.classList.remove('error');
                const localError = wrapper.querySelector('.error-message');
                if (localError) localError.remove();
            });
        });

        const initialCheckedRadio = wrapper.querySelector('.contact-form__radio:checked');
        if (initialCheckedRadio) {
            wrapper.classList.add('is-open');
        }
    }
}

if(document.querySelector('.contact-form-block')){
// Start contact form when page loads
document.addEventListener('DOMContentLoaded', () => {
    new ContactForm();
});
}

export default ContactForm;