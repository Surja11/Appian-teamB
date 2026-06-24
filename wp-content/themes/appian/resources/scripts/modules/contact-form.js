class ContactForm {
    constructor() {
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
        this.form.addEventListener('submit', this.handleSubmit.bind(this));

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

        if (this.validateForm()) {
            this.submitForm();
        }
    }

    validateForm() {
        let isValid = true;

        this.clearAllErrors();
        const existingStatus = this.form.querySelector('.form-success-message, .form-error-message');
        if (existingStatus) existingStatus.remove();

        this.inputs.forEach(input => {
            if (!this.validateField({ target: input })) {
                isValid = false;
            }
        });

        const radioWrapper = this.form.querySelector('.contact-form__radio-dropdown-wrapper');
        if (radioWrapper) {
            const radioGroupChecked = radioWrapper.querySelector('.contact-form__radio:checked');

            if (!radioGroupChecked) {
                const triggerBox = radioWrapper.querySelector('.contact-form__radio-trigger');
                
                const primaryRed = getComputedStyle(document.documentElement).getPropertyValue('--color-primary-red') || '#d72027';

                triggerBox.classList.add('error');
                triggerBox.style.borderColor = primaryRed;
                
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

        if (field.hasAttribute('required') && !value) {
            this.showFieldError(field, 'This field is required');
            isValid = false;
        }

        const isNameField = field.name === 'first-name' || field.name === 'last-name';

        if (isNameField && value) {
            const nameRegex = /^[a-zA-ZÀ-ÿ\s'\-]+$/;
            
            if (!nameRegex.test(value)) {
                this.showFieldError(field, 'Please enter a valid name (letters, spaces, hyphens, and apostrophes only)');
                isValid = false;
            }
        }

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

        if (field.type === 'tel' && value) {
            const phoneStructureRegex = /^\+?[0-9\s.\-\(\)]+$/;
            
            const cleanPhone = value.replace(/\D/g, '');
            
            const isAllZeros = /^0+$/.test(cleanPhone);

            if (!phoneStructureRegex.test(value) || isAllZeros || cleanPhone.length < 7 || cleanPhone.length > 15) {
                this.showFieldError(field, 'Please enter a valid phone number');
                isValid = false;
            }
        }

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
        const primaryRed = getComputedStyle(document.documentElement).getPropertyValue('--color-primary-red') || '#d72027';
        
        field.classList.add('error');
        field.style.borderColor = primaryRed;
        
        const parent = field.parentNode;
        let existingError = parent.querySelector('.error-message');
        if (existingError) existingError.remove();

        const errorElement = document.createElement('div');
        errorElement.className = 'error-message body-small';
        errorElement.textContent = message;

        parent.appendChild(errorElement);
    }

    clearFieldError(event) {
        const field = event.target;
        field.classList.remove('error');
        field.style.borderColor = '';

        const errorMessage = field.parentNode.querySelector('.error-message');
        if (errorMessage) errorMessage.remove();
    }

    clearAllErrors() {
        const errorMessages = this.form.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());

        this.inputs.forEach(input => {
            input.classList.remove('error');
            input.style.borderColor = '';
        });

        const radioWrapper = this.form.querySelector('.contact-form__radio-dropdown-wrapper');
        if (radioWrapper) {
            const triggerBox = radioWrapper.querySelector('.contact-form__radio-trigger');
            if (triggerBox) {
                triggerBox.classList.remove('error');
                triggerBox.style.borderColor = '';
            }
        }
    }

    showError(message) {
        const primaryRed = getComputedStyle(document.documentElement).getPropertyValue('--color-primary-red') || '#d72027';
        
        let errorContainer = this.form.querySelector('.form-error-message');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.className = 'form-error-message';
            errorContainer.style.cssText = `
                background-color: #fbe9e9;
                color: ${primaryRed};
                padding: 14px 16px;
                margin-bottom: 24px;
                border-left: 4px solid ${primaryRed};
                font-size: 14px;
                font-family: inherit;
            `;
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
            console.error('AJAX Execution Fail Error logs:', error);
        } finally {
            this.setLoadingState(false);
        }
    }

    setLoadingState(loading) {
        const textSpan = this.submitButton.querySelector('span');
        if (loading) {
            this.submitButton.disabled = true;
            textSpan.textContent = 'Submitting...';
            this.submitButton.style.opacity = '0.7';
        } else {
            this.submitButton.disabled = false;
            textSpan.textContent = 'Submit';
            this.submitButton.style.opacity = '1';
        }
    }

    showSuccessMessage() {
        const successMessage = document.createElement('div');
        successMessage.className = 'form-success-message';
        successMessage.style.cssText = `
            background-color: #e7f5e7;
            color: #2d5f2d;
            padding: 16px;
            margin-bottom: 24px;
            border-left: 4px solid #4caf50;
            font-size: 16px;
            border-radius: 4px;
            font-family: inherit;
        `;
        successMessage.innerHTML = `<strong>Thank you!</strong> Your message has been sent successfully. We'll get back to you soon.`;

        this.form.insertBefore(successMessage, this.form.firstChild);
        successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    setupRadioDropdownToggle() {
        const wrapper = document.querySelector('.contact-form__radio-dropdown-wrapper');
        if (!wrapper) return;

        const trigger = wrapper.querySelector('.contact-form__radio-trigger');
        const radios = wrapper.querySelectorAll('.contact-form__radio');

        trigger.addEventListener('click', (e) => {
            wrapper.classList.toggle('is-open');

            trigger.classList.remove('error');
            trigger.style.borderColor = '';
            const localError = wrapper.querySelector('.error-message');
            if (localError) localError.remove();
        });

        radios.forEach(radio => {
            radio.addEventListener('change', () => {
                trigger.classList.remove('error');
                trigger.style.borderColor = '';
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
document.addEventListener('DOMContentLoaded', () => {
    new ContactForm();
});
}

export default ContactForm;