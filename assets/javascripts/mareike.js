
function mareike_is_all_filled() {
const radioButtons = document.getElementsByName('confirmation_radio');
return Array.from(radioButtons).some(radio => radio.checked);
}

function mareike_show_adressdaten() {
document.getElementById('addressdaten').style.display = 'block';
document.getElementById('hider').style.display = 'block';

}


function mareike_nextpage(next_page) {
mareike_print_screen();

    document.getElementById('mareike-new-invoice-main-description').style.display = 'none';
    document.getElementById('mareike_new_invoice_index_table').style.display = 'none';
    document.getElementById(next_page).style.display = 'inline-block';
    document.getElementById('modus').innerHTML = next_page;

}


function mareike_select_event(next_page) {
    document.getElementById('eventauswahl').style.display = 'block';
    document.getElementById('hider').style.display = 'block';
    document.getElementById('modus').innerHTML = next_page;
}

function mareike_deny_invoice_printscreen() {
    document.getElementById('hider').style.display = 'none';
    document.getElementById('mareike-deny-invoice-dialog').style.display = 'none';
}


function mareike_print_screen() {
    document.getElementById('addressdaten').style.display = 'none';
    document.getElementById('eventauswahl').style.display = 'none';
    document.getElementById('hider').style.display = 'none';
}

function mareike_check_contact_name() {
    const contact_name_val = document.getElementById('contact_name').value.trim() !== '';
    const payment = document.getElementById('decision');

    if (contact_name_val) {
        payment.style.display = 'block';
        document.getElementById('account_owner').value = document.getElementById('contact_name').value.trim();

    } else {
        payment.style.display = 'none';
    }
}


document.addEventListener('DOMContentLoaded', () => {
    const kilometerField = document.getElementById('kilometer');
    const amountField = document.getElementById('oepnv_amount');
    const oepnv_button = document.getElementById('oepnv_receiptButton');
    const pkw_button = document.getElementById('pkw_abrechnen');
    const textField = document.getElementById('amount');
    const radioButtons = document.getElementsByName('kostengruppe');
    const button = document.getElementById('receiptButton');
    const ibanField = document.getElementById('account_iban');
    const radioButtonsConfirm = document.getElementsByName('confirmation_radio');
    const submitButton = document.getElementById('submit_button');



    function checkConditions() {
        const amountFieldVal = amountField.value.trim() !== '';
        const kilometerFieldVal = kilometerField.value.trim() !== '';
        const isTextFilled = textField.value.trim() !== '';
        const isRadioChecked = Array.from(radioButtons).some(radio => radio.checked);
        const isRadioConfirmedChecked = Array.from(radioButtonsConfirm).some(radio => radio.checked);
        const validIban = mareike_is_valid_iban();


        if (validIban) {
            document.getElementById('final_iban_check').style.display = 'block';
        } else {
            document.getElementById('final_iban_check').style.display = 'none';
        }

        if (isRadioConfirmedChecked) {
            submitButton.style.display = 'block';
        } else {
            submitButton.style.display = 'none';
        }

        if (amountFieldVal) {
            oepnv_button.style.display = 'block';
        } else {
            oepnv_button.style.display = 'none';
        }

        if (kilometerFieldVal) {
            pkw_button.style.display = 'block';
        } else {
            pkw_button.style.display = 'none';
        }

        if (isTextFilled && isRadioChecked) {
            button.style.display = 'block';
        } else {
            button.style.display = 'none';
        }
    }

    amountField.addEventListener('input', checkConditions);
    kilometerField.addEventListener('input', checkConditions);
    textField.addEventListener('input', checkConditions);
    radioButtons.forEach(radio => {
        radio.addEventListener('change', checkConditions);
    });

    ibanField.addEventListener('input', checkConditions);

    radioButtonsConfirm.forEach(radio => {
        radio.addEventListener('change', checkConditions);
    });


    checkConditions(); // Initial check on page load

    customElements.define('info-icon', class extends HTMLElement {
        connectedCallback() {
            const value = this.getAttribute('value') || '';
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = value;
            this.appendChild(tooltip);

            this.addEventListener('mouseover', () => {
                tooltip.style.visibility = 'visible';
                tooltip.style.opacity = '1';
            });

            this.addEventListener('mouseout', () => {
                tooltip.style.visibility = 'hidden';
                tooltip.style.opacity = '0';
            });
        }
    });
});

document.getElementById('amount').addEventListener('input', function(event) {
    let input = event.target.value;
    let regex = /^\d*(\,\d*)?$/;

    if (!regex.test(input)) {
        let cleanedInput = input.replace(/[^\d\,]/g, '');

        if (cleanedInput.split(',').length > 2) {
            cleanedInput = cleanedInput.replace(/\,/g, '');
        }

        if (cleanedInput === '' || cleanedInput.indexOf(',') !== cleanedInput.lastIndexOf(',')) {
            cleanedInput = '';
        }

        if (cleanedInput !== input) {
            event.target.value = cleanedInput;
        }
    }
});



document.getElementById('oepnv_amount').addEventListener('input', function(event) {
    let input = event.target.value;
    let regex = /^\d*(\,\d*)?$/;

    if (!regex.test(input)) {
        let cleanedInput = input.replace(/[^\d\,]/g, '');

        if (cleanedInput.split(',').length > 2) {
            cleanedInput = cleanedInput.replace(/\,/g, '');
        }

        if (cleanedInput === '' || cleanedInput.indexOf(',') !== cleanedInput.lastIndexOf(',')) {
            cleanedInput = '';
        }

        if (cleanedInput !== input) {
            event.target.value = cleanedInput;
        }
    }
});

document.getElementById('kilometer').addEventListener('input', function(event) {
    var kilometerpauschale = mareikeData.kilometerpauschale[document.getElementById('veranstaltung').value];
    let input = event.target.value;
    var usedata = input;
    let regex = /^\d*(\,\d*)?$/;

    if (!regex.test(input)) {
        let cleanedInput = input.replace(/[^\d\,]/g, '');

        if (cleanedInput.split(',').length > 2) {
            cleanedInput = cleanedInput.replace(/\,/g, '');
        }

        if (cleanedInput === '' || cleanedInput.indexOf(',') !== cleanedInput.lastIndexOf(',')) {
            cleanedInput = '';
        }

        if (cleanedInput !== input) {
            event.target.value = cleanedInput;
            usedata = cleanedInput;
        }
    }
    document.getElementById('kilometer_pauschale').innerHTML = kilometerpauschale;
    document.getElementById('kilometer_anzahl').innerHTML = usedata;

    const fixedNumber = Number.parseFloat(usedata * kilometerpauschale).toFixed(2);
    document.getElementById('kilometer_betrag').innerHTML =
        String(fixedNumber).replace(/\./g, ",");
});

function mareike_check_filesize(field_id) {
    if (document.getElementById(field_id).files[0].size <= mareikeData.max_size_mb * 1024 * 1024) {
        mareike_show_adressdaten();
    } else {
        alert('Die Uploadgröße ist auf maximal ' + mareikeData.max_size_mb + ' MB beschränkt!');
    }
}

function mareike_open_oeffis() {
    document.getElementById('oeffis').style.display='block';
    document.getElementById('verkehrsmittel').style.display='none';
    document.getElementById('pkw').style.display='none';
}

function mareike_open_pkw() {
    document.getElementById('oeffis').style.display='none';
    document.getElementById('verkehrsmittel').style.display='none';
    document.getElementById('pkw').style.display='block';
    document.getElementById('kilometer_pauschale').innerHTML = mareikeData.kilometerpauschale[document.getElementById('veranstaltung').value];
}

function mareike_open_donation() {
    document.getElementById('confirm_donation').style.display='block';
    document.getElementById('decision').style.display='none';
    document.getElementById('confirm_payment').style.display='none';
}

function mareike_open_payment() {
    document.getElementById('confirm_donation').style.display='none';
    document.getElementById('decision').style.display='none';
    document.getElementById('confirm_payment').style.display='block';
}
