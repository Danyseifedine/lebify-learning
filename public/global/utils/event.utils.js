export function dispatchFormEvent(form, eventName, detail) {
    form.dispatchEvent(new CustomEvent(eventName, { detail }));
}
