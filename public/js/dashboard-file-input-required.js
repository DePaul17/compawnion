
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('type_client');

    const pieceIdentiteField = document.getElementById('identity_document_field');
    const pieceIdentiteInput = document.getElementById('identity_document');

    const attestationField = document.getElementById('attestation_field');
    const attestationInput = document.getElementById('attestation');

    const acacedField = document.getElementById('petsitter_certificate_acaced_field');
    const acacedInput = document.getElementById('petsitter_certificate_acaced');

    select.addEventListener('change', function () {
        const value = this.value;

        if (value === 'petsitter') {
            // Affiche et rend requis
            pieceIdentiteField.classList.remove('hidden');
            pieceIdentiteInput.required = true;

            acacedField.classList.remove('hidden');
            acacedInput.required = true;

            // Cache les autres
            attestationField.classList.add('hidden');
            attestationInput.required = false;
        }
        else if (value === 'specialist') {
            pieceIdentiteField.classList.remove('hidden');
            pieceIdentiteInput.required = true;

            attestationField.classList.remove('hidden');
            attestationInput.required = true;

            acacedField.classList.add('hidden');
            acacedInput.required = false;
        }
        else {
            // Client ou rien sélectionné
            pieceIdentiteField.classList.add('hidden');
            pieceIdentiteInput.required = false;

            attestationField.classList.add('hidden');
            attestationInput.required = false;

            acacedField.classList.add('hidden');
            acacedInput.required = false;
        }
    });
});
