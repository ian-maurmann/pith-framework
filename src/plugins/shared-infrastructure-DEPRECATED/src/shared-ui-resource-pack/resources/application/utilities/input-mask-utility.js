//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// Input Mask Utility
// ──────────────────
//
// noinspection ES6ConvertVarToLetConst --- Ignore var here.
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

// noinspection JSUnusedAssignment
if(typeof SharedUI === 'undefined' || SharedUI === null || SharedUI === false){
    var SharedUI = {};
}

if(typeof SharedUI.InputMaskUtility === 'undefined' || SharedUI.InputMaskUtility === null || SharedUI.InputMaskUtility === false){
    SharedUI.InputMaskUtility = {};
}



SharedUI.InputMaskUtility.filterToAllowedChars = function(given_string, allowed_string){
    // Default to empty string
    let $filtered_string = '';

    // Filter to allowed chars
    for (let i = 0; i < given_string.length; i++) {
        let current_char = given_string.charAt(i);
        let is_allowed   = (allowed_string.indexOf(current_char) !== -1);
        if(is_allowed){
            $filtered_string += current_char;
        }
    }

    // Return the filtered string
    return $filtered_string;
}





// Currency Mask
SharedUI.InputMaskUtility.currency_mask = function(element){
    // Vars
    let self           = SharedUI.InputMaskUtility;
    let input_string   = String(element.value);
    let allowed_string = '0123456789';
    let masked_string  = '';

    // Filter to allowed chars
    masked_string = self.filterToAllowedChars(input_string, allowed_string);

    // Clean-up leading zeros
    let masked_int       = parseInt(masked_string);
    let clean_string     = isNaN(masked_int) ? '' : String(masked_int);
    let formatted_string = '';

    // Add decimal point
    if(clean_string.length === 0){
        formatted_string = '0.00'
    }
    else if(clean_string.length === 1){
        formatted_string = '0.0' + clean_string;
    }
    else if(clean_string.length === 2){
        formatted_string = '0.' + clean_string;
    }
    else if(clean_string.length > 2){
        let insert_pos = clean_string.length - 2;
        formatted_string = clean_string.substring(0, insert_pos) + '.' + clean_string.substr(insert_pos);
    }

    // Update the field value
    element.value = formatted_string;
};

// apply Currency Mask
// <input type="text" onkeyup="SharedUI.InputMaskUtility.currency_mask(this);" />






// date mmddyyyy Mask
SharedUI.InputMaskUtility.date_mmddyyyy_mask = function(element, event){
    // Vars
    let self             = SharedUI.InputMaskUtility;
    let input_string     = String(element.value);
    let allowed_string   = '0123456789';
    let clean_string     = '';
    let formatted_string = '';
    let is_backspace     = false;

    if (event.keyCode === 8) {
        is_backspace = true
    }

    if(!is_backspace){
        // Filter to allowed chars
        clean_string = self.filterToAllowedChars(input_string, allowed_string);

        // Add decimal point
        if(clean_string.length === 0){
            formatted_string = ''
        }
        else if(clean_string.length === 1){
            formatted_string = clean_string;
        }
        else if(clean_string.length === 2){
            formatted_string = clean_string + ' / ';
        }
        else if(clean_string.length === 3){
            formatted_string = clean_string.substring(0,2) + ' / ' + clean_string.substring(2,3);
        }
        else if(clean_string.length === 4){
            formatted_string = clean_string.substring(0,2) + ' / ' + clean_string.substring(2,4) + ' / ';
        }
        else if(clean_string.length === 5){
            formatted_string = clean_string.substring(0,2) + ' / ' + clean_string.substring(2,4) + ' / ' + clean_string.substring(4,5);
        }
        else if(clean_string.length === 6){
            formatted_string = clean_string.substring(0,2) + ' / ' + clean_string.substring(2,4) + ' / ' + clean_string.substring(4,6);
        }
        else if(clean_string.length === 7){
            formatted_string = clean_string.substring(0,2) + ' / ' + clean_string.substring(2,4) + ' / ' + clean_string.substring(4,7);
        }
        else if(clean_string.length > 7){
            formatted_string = clean_string.substring(0,2) + ' / ' + clean_string.substring(2,4) + ' / ' + clean_string.substring(4,8);
        }

        // Update the field value
        element.value = formatted_string;
    }
};

// apply Currency Mask
// <input type="text" onkeyup="SharedUI.InputMaskUtility.date_mmddyyyy_mask(this, event);" />








// Username Mask
SharedUI.InputMaskUtility.username_mask = function(element){
    // Vars
    let self           = SharedUI.InputMaskUtility;
    let input_string   = String(element.value);
    let allowed_string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
    let masked_string  = '';

    // Filter to allowed chars
    masked_string = self.filterToAllowedChars(input_string, allowed_string);

    // Update the field value
    element.value = masked_string;
};

// apply Currency Mask
// <input type="text" onkeyup="SharedUI.InputMaskUtility.username_mask(this);" />