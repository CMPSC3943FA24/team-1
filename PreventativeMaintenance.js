import PriorityQueue from './priorityQueue.js'; //need to test this to be sure this is the correct way to link

const form = document.getElementById('maintenanceForm');
const queue = new PriorityQueue();

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const treesinlines = document.getElementById('treesinlines').value;
    const physicaldamage = document.getElementById('physicaldamage').value;
    const lightsout = document.getElementById('lightsout').value;
    
    
    const formData = new FormData();
        formData.append('treesinlines', problemType);
        formData.append('physicaldamage', physicaldamage);
        formData.append('lightsout', lightsout);
    
    
    const report = {
        treesinlines: treesinlines,
        physicaldamage: physicaldamage,
        lightsout: lightsout,
    };
    
    queue.enqueue(report, priorityLevel);
    
    processReportQueue(queue);
    
    document.getElementById('confirmationMessage').style.display = 'block';
    
function processReportQueue(queue) {
    // Process the queue 
    while (!queue.isEmpty) {
        const nextReport = queue.dequeue();
        console.log('Processing report:', nextReport);

        fetch('/maintenanceForm', {
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
