export function serializeForm(form, type = 'formdata') {
    switch (type) {
        case 'json':
            return Object.fromEntries(new FormData(form));
        case 'urlencoded':
            return new URLSearchParams(new FormData(form)).toString();
        case 'formdata':
        default:
            return new FormData(form);
    }
}

