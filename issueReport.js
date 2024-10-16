const form = document.getElementById('outageForm');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const problemType = document.getElementById('problemType').value;
    const location = document.getElementById('location').value;
    const comments = document.getElementById('comments').value;
    const photo = document.getElementById('photoUpload').files[0];
    const priorityLevel = document.getElementById('priorityLevel').value;

    if (!problemType || !location || !priorityLevel) {
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

     const report = {
        problemType: problemType,
        location: location,
        comments: comments,
        photo: photo,
        formData: formData
    };

    queue.enqueue(report, priorityLevel);
    
    processReportQueue(queue);
    
    document.getElementById('confirmationMessage').style.display = 'block';
    
function processReportQueue(queue) {
    // Process the queue 
    while (!queue.isEmpty) {
        const nextReport = queue.dequeue();
        console.log('Processing report:', nextReport);

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
}

