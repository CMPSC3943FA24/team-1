const form = document.getElementById('outageForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const problemType = document.getElementById('problemType').value;
    const location = document.getElementById('location').value;
    const comments = document.getElementById('comments').value;
    const photo = document.getElementById('photoUpload').files[0];

    if (!problemtype || !location) {
        alert('Please fill in required fields.');
        return;
    }

    const formData = new FormData();
    formData.append('problemType', problemType);
    formData.append('location', location);
    formData.append('comments', comments);
    if (photo) {
        formData.append('photo', photo);
    }

    fetch('/submitOutage', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('confirmationMessage').style.display = 'block';
        } else {
            alert('There was an error submitting your report. Please try again.');
        };
    });
})