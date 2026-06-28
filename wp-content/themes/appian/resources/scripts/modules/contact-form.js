class ContactForm {
    constructor() {
        this.form = document.getElementById('js-contact-form');
        this.submitButton = this.form ? this.form.querySelector('.contact-form__submit') : null;
        this.inputs = this.form.querySelectorAll('input.contact-form__input, select.contact-form__input, textarea.contact-form__input');
        this.radioInputs = this.form ? this.form.querySelectorAll('.contact-form__radio') : [];

        this.formAction = this.form ? this.form.getAttribute('action') : '';
        
        // Get the max future period from the data attribute
        this.maxFuturePeriod = this.form ? this.form.closest('.contact-form-block').getAttribute('data-max-future-period') || '12' : '12';
        
        if (this.form) {
            this.init();
        }
    }

    init() {
        this.bindEvents();
        this.setupValidation();
        this.setupAccessibility();
        this.setupRadioDropdownToggle();
        this.setupDateRestrictions();
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

        const isDatePlaceholder = field.classList.contains('date-placeholder-mode');
        const effectiveValue = isDatePlaceholder ? '' : value;

        if (field.hasAttribute('required') && !effectiveValue) {
            this.showFieldError(field, 'This field is required');
            isValid = false;
        }

        const isNameField = field.name === 'first-name' || field.name === 'last-name';

        if (isNameField && effectiveValue) {
            const nameRegex = /^[a-zA-ZÀ-ÿ\s'\-]+$/;
            
            if (!nameRegex.test(effectiveValue)) {
                this.showFieldError(field, 'Please enter a valid name (letters, spaces, hyphens, and apostrophes only)');
                isValid = false;
            }
        }

        if (field.type === 'email' && effectiveValue) {
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
            
            let hasInvalidPattern = invalidPatterns.some(pattern => pattern.test(effectiveValue));
            
            if (!emailRegex.test(effectiveValue) || hasInvalidPattern) {
                this.showFieldError(field, 'Please enter a valid email address');
                isValid = false;
            }
        }

        if (field.type === 'tel' && effectiveValue) {
            const cleanPhone = effectiveValue.replace(/\D/g, '');
            
            const isAllZeros = /^0+$/.test(cleanPhone);
            const hasConsecutiveSpecialChars = /[\-\.]{2,}|[\s]{2,}|[\(\)]{2,}/.test(effectiveValue);
            const hasInvalidPatterns = /[^\+0-9\s.\-\(\)]/.test(effectiveValue);
            
            const startsOK = /^[\+\(0-9]/.test(effectiveValue);
            const endsOK = /[0-9\)]$/.test(effectiveValue);
            
            if (
                !startsOK ||                      
                !endsOK ||                        
                hasConsecutiveSpecialChars ||
                hasInvalidPatterns ||             
                isAllZeros ||                     
                cleanPhone.length < 7 ||
                cleanPhone.length > 15
            ) {
                this.showFieldError(field, 'Please enter a valid phone number');
                isValid = false;
            }
        }

        if (field.type === 'date' && effectiveValue) {
            const selectedDate = new Date(effectiveValue);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                this.showFieldError(field, 'Please select today\'s date or a future date');
                isValid = false;
            } else if (this.maxFuturePeriod !== 'unlimited') {
                const maxDate = new Date();
                const monthsToAdd = parseInt(this.maxFuturePeriod, 10);
                maxDate.setMonth(maxDate.getMonth() + monthsToAdd);
                maxDate.setHours(0, 0, 0, 0);
                
                if (selectedDate > maxDate) {
                    const periodText = this.getPeriodText();
                    this.showFieldError(field, `Please select a date within ${periodText}`);
                    isValid = false;
                }
            }
        }

        return isValid;
    }

    showFieldError(field, message) {
        field.classList.add('error');
        
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

        const sendAnotherBtn = successMessage.querySelector('.contact-form__send-another');
        sendAnotherBtn.addEventListener('click', () => {
            this.resetForm();
        });
    }

    resetForm() {
        const successMessage = this.form.querySelector('.form-success-message');
        if (successMessage) successMessage.remove();

        const formContainer = this.form.querySelector('.contact-form__grid');
        
        if (formContainer) {
            formContainer.classList.remove('form-hidden');
        }

        this.form.reset();
        this.clearAllErrors();

        this.form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    setupDateRestrictions() {
        const dateInputs = this.form.querySelectorAll('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];
        
        // Calculate max date based on the configured period
        let maxDateString;
        if (this.maxFuturePeriod === 'unlimited') {
            maxDateString = null; // No maximum date
        } else {
            const maxDate = new Date();
            const monthsToAdd = parseInt(this.maxFuturePeriod, 10);
            maxDate.setMonth(maxDate.getMonth() + monthsToAdd);
            maxDateString = maxDate.toISOString().split('T')[0];
        }
        
        dateInputs.forEach(input => {
            input.setAttribute('min', today);
            if (maxDateString) {
                input.setAttribute('max', maxDateString);
            }
            
            const originalPlaceholder = input.getAttribute('placeholder');
            
            if (!input.value) {
                input.setAttribute('type', 'text');
                input.setAttribute('placeholder', originalPlaceholder);
                input.classList.add('date-placeholder-mode');
            }
            
            input.addEventListener('click', () => {
                if (input.type === 'date') {
                    input.showPicker && input.showPicker();
                } else if (input.classList.contains('date-placeholder-mode')) {
                    input.setAttribute('type', 'date');
                    input.setAttribute('min', today);
                    if (maxDateString) {
                        input.setAttribute('max', maxDateString);
                    }
                    input.removeAttribute('placeholder');
                    input.classList.remove('date-placeholder-mode');
                    
                    setTimeout(() => {
                        input.showPicker && input.showPicker();
                    }, 10);
                }
            });
            
            input.addEventListener('focus', () => {
                if (input.classList.contains('date-placeholder-mode')) {
                    input.setAttribute('type', 'date');
                    input.setAttribute('min', today);
                    if (maxDateString) {
                        input.setAttribute('max', maxDateString);
                    }
                    input.removeAttribute('placeholder');
                    input.classList.remove('date-placeholder-mode');
                }
            });
            
            input.addEventListener('blur', () => {
                if (!input.value) {
                    input.setAttribute('type', 'text');
                    input.setAttribute('placeholder', originalPlaceholder);
                    input.classList.add('date-placeholder-mode');
                }
            });
            
            input.addEventListener('change', (e) => {
                if (e.target.type === 'date' && e.target.value) {
                    const selectedDate = new Date(e.target.value);
                    const todayDate = new Date(today);
                    
                    if (selectedDate < todayDate) {
                        this.showDateError(e.target, 'Please select today\'s date or a future date');
                    } else if (maxDateString) {
                        const maxDateObj = new Date(maxDateString);
                        if (selectedDate > maxDateObj) {
                            const periodText = this.getPeriodText();
                            this.showDateError(e.target, `Please select a date within ${periodText}`);
                        } else {
                            this.clearFieldError({ target: e.target });
                        }
                    } else {
                        this.clearFieldError({ target: e.target });
                    }
                }
            });
            
        });
    }

    getPeriodText() {
        const months = parseInt(this.maxFuturePeriod, 10);
        
        if (months === 3) return 'the next 3 months';
        if (months === 6) return 'the next 6 months';
        if (months === 12) return 'the next year';
        if (months === 24) return 'the next 2 years';
        if (months === 36) return 'the next 3 years';
        if (months === 60) return 'the next 5 years';
        
        // Fallback for custom values
        if (months < 12) {
            return `the next ${months} months`;
        } else {
            const years = Math.floor(months / 12);
            const remainingMonths = months % 12;
            if (remainingMonths === 0) {
                return `the next ${years} year${years > 1 ? 's' : ''}`;
            } else {
                return `the next ${years} year${years > 1 ? 's' : ''} and ${remainingMonths} month${remainingMonths > 1 ? 's' : ''}`;
            }
        }
    }

    showDateError(input, message = 'Please select today\'s date or a future date') {
        this.clearFieldError({ target: input });
        
        const existingError = input.parentNode.querySelector('.error-message');
        if (existingError) {
            return; 
        }
        
        input.classList.add('error');
        
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message body-small';
        errorElement.textContent = message;
        
        input.parentNode.appendChild(errorElement);
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

                const selectedLabel = document.querySelector(`label[for="${radio.id}"]`);
                if (selectedLabel) {
                    const placeholderElement = trigger.querySelector('.placeholder-text');
                    if (placeholderElement) {
                        placeholderElement.textContent = selectedLabel.textContent.trim();
                    }
                }
            });
        });

        const initialCheckedRadio = wrapper.querySelector('.contact-form__radio:checked');
        if (initialCheckedRadio) {
            const initialLabel = document.querySelector(`label[for="${initialCheckedRadio.id}"]`);
            if (initialLabel) {
                const placeholderElement = trigger.querySelector('.placeholder-text');
                if (placeholderElement) {
                    placeholderElement.textContent = initialLabel.textContent.trim();
                }
            }
            wrapper.classList.add('is-open');
        }
    }
}

if(document.querySelector('#js-contact-form')){
document.addEventListener('DOMContentLoaded', () => {
    new ContactForm();
});
}

export default ContactForm;