
const form = document.querySelector('form');
const submitBtn = document.querySelector('button[type="submit"]');

submitBtn.addEventListener('click', function(event) {
    event.preventDefault();
    const pincode = document.querySelector('input[type="number"]').value;
    const rent = document.querySelector('input[type="number"]').value;
    const data = {
        pincode: pincode,
        rent: rent
    };
    submitForm(data);
});

function submitForm(data) {
    // TODO: Submit the form data to the server
    console.log(data);
}