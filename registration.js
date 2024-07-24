document.getElementById('createUserForm').addEventListener('submit', function(event) {
    const password = document.getElementById('password1').value;
    const confirmPassword = document.getElementById('password2').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match!');
        event.preventDefault();
    }
});

function goBack() {
    window.history.back();
}
