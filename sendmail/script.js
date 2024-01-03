function sendEmail() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const message = document.getElementById('message').value;
    const user_email = document.getElementById('user_email').value;

    const data = {
        name: name,
        email: email,
        message: message,
        user_email: user_email
    };

    fetch('sendmail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(result => {
        console.log(result);
        alert(result.message);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to send email.');
    });
}
