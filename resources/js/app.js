import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const searchableFields = document.querySelectorAll('[data-select-search]');

    searchableFields.forEach((input) => {
        const targetId = input.getAttribute('data-select-search');
        const select = document.getElementById(targetId);

        if (!select) {
            return;
        }

        const allOptions = Array.from(select.options).map((option) => ({
            value: option.value,
            label: option.textContent.trim(),
            disabled: option.disabled,
        }));

        const renderOptions = (query = '') => {
            const normalizedQuery = query.trim().toLowerCase();
            const currentValue = select.value;

            select.innerHTML = '';

            allOptions.forEach((option) => {
                if (option.disabled) {
                    select.add(new Option(option.label, option.value, false, false));
                    select.options[select.options.length - 1].disabled = true;
                    return;
                }

                const matches =
                    normalizedQuery === '' ||
                    option.label.toLowerCase().includes(normalizedQuery);

                if (matches) {
                    const newOption = new Option(option.label, option.value, false, option.value === currentValue);
                    select.add(newOption);
                }
            });

            if (!Array.from(select.options).some((option) => option.value === currentValue)) {
                select.value = '';
            }
        };

        input.addEventListener('input', () => {
            renderOptions(input.value);
        });

        input.addEventListener('focus', () => {
            renderOptions(input.value);
        });

        select.addEventListener('change', () => {
            const selectedOption = select.selectedOptions[0];
            input.value = selectedOption && selectedOption.value ? selectedOption.textContent.trim() : '';
        });

        renderOptions(input.value);

        if (select.value) {
            const selectedOption = select.selectedOptions[0];
            if (selectedOption) {
                input.value = selectedOption.textContent.trim();
            }
        }
    });

    const interactionForm = document.querySelector('[data-interaction-form]');
    if (interactionForm) {
        interactionForm.addEventListener('submit', () => {
            const submitButton = interactionForm.querySelector('[data-submit-button]');

            if (!submitButton) {
                return;
            }

            const buttonText = submitButton.querySelector('.button-text');
            const buttonLoading = submitButton.querySelector('.button-loading');

            submitButton.setAttribute('disabled', 'disabled');

            if (buttonText) {
                buttonText.classList.add('d-none');
            }

            if (buttonLoading) {
                buttonLoading.classList.remove('d-none');
            }
        });
    }
});
