document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('w3p-excerpt')) {
        let title = document.getElementById('w3p-title'),
            excerpt = document.getElementById('w3p-excerpt');

        function changeMeter(val, low, high, max, meter) {
            // order of colours is: red, orange, green
            let color = (val <= low || val > max) ? '#e74c3c' : val < high ? '#e67e22' : '#27ae60';

            let val_percentage = (100 * val) / max;

            meter.style.background = color;
            meter.value = val;

            if (val <= max) {
                meter.style.width = `${val_percentage}%`;
            }
        }

        changeMeter(title.value.length, 20, 40, 60, document.getElementById('w3p-meter--title'));
        changeMeter(excerpt.value.length, 60, 120, 160, document.getElementById('w3p-meter--excerpt'));

        title.addEventListener('input', () => {
            changeMeter(title.value.length, 20, 40, 60, document.getElementById('w3p-meter--title'));
        });

        excerpt.addEventListener('input', () => {
            changeMeter(excerpt.value.length, 60, 120, 160, document.getElementById('w3p-meter--excerpt'));
        });
    }



    if (document.querySelector('.w3p-add-repeater-field')) {
        const repeaterContainer = document.querySelector('.w3p-repeater-container');
        const repeaterFields = repeaterContainer.querySelector('.w3p-repeater-fields');
        const addFieldButton = repeaterContainer.querySelector('.w3p-add-repeater-field');

        // Add a new repeater field
        addFieldButton.addEventListener('click', function () {
            const lastField = repeaterFields.querySelector('.w3p-repeater-field:last-of-type');
            console.log(lastField);
            const newFieldIndex = lastField ? parseInt(lastField.dataset.index) + 1 : 0;
            const newField = document.createElement('div');
            newField.className = 'w3p-repeater-field';
            newField.setAttribute('draggable', true);
            newField.dataset.index = newFieldIndex;
            newField.innerHTML = '<span class="dashicons dashicons-move"></span>' +
                '<input type="text" class="regular-text" name="w3p_link_repeater[' + newFieldIndex + '][title]" placeholder="Title">' +
                '<input type="url" class="regular-text" name="w3p_link_repeater[' + newFieldIndex + '][url]" placeholder="URL">' +
                '<input type="text" class="regular-text" name="w3p_link_repeater[' + newFieldIndex + '][rel]" placeholder="Relationship">' +
                '<button type="button" class="button button-secondary w3p-remove-repeater-field">Remove</button>';
            repeaterFields.appendChild(newField);

            // Add event listener to remove button
            const removeFieldButton = newField.querySelector('.w3p-remove-repeater-field');
            removeFieldButton.addEventListener('click', function () {
                repeaterFields.removeChild(newField);
            });
        });

        // Add event listener to remove button for existing fields
        repeaterFields.querySelectorAll('.w3p-remove-repeater-field').forEach(function (button) {
            button.addEventListener('click', function () {
                button.closest('.w3p-repeater-field').remove();
            });
        });
    }
});
