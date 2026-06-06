/**
 * @param {string} to receiver email address
 * @param {string} subject email subject
 * @param {string} body email body
 * @returns {void} 
 */
function openEmailClient(to, subject, body) {
    subject = encodeURIComponent(subject);
    body = encodeURIComponent(body);

    const mailtoLink = `mailto:${ to }?subject=${ subject }&body=${ body }`;
    window.location.href = mailtoLink;
}

/** 
 * @param {HTMLButtonElement} el 
 * @returns {void}
 */
function copyToClipboard(el) {
    const tempTextArea = document.createElement('textarea');
    const quoteApprovalEmailBody = document.querySelector('#quote-approval-email-body');

    tempTextArea.value = quoteApprovalEmailBody.innerText;
    document.body.appendChild(tempTextArea);
    tempTextArea.select();
    document.execCommand('copy');
    document.body.removeChild(tempTextArea);
    alert('Text has been copied to the clipboard!');
}

/**
 * 
 */
function onQuoteApprovalFormSubmit(quoteApprovalForm) {
    alert('Hello');
}
