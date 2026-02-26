const els = document.querySelectorAll('[data-clipboard]');

const copyToClipboard = async (text, successMessage) => {
    try {
        await navigator.clipboard.writeText(text);
        // Optional: Display a success message to the user
        alert(successMessage);
    } catch (error) {
        console.error("Failed to copy to clipboard:", error);
        // Optional: Display an error message to the user
    }
};

els.forEach((el) => {
    const text = el.dataset.clipboard;
    const successMessage = el.dataset.clipboardSuccessMessage ?? 'Text copied!';
    el.addEventListener('click', (e) => {
       copyToClipboard(text, successMessage);
    });
});
