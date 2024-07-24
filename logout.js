
function logout() {
    localStorage.removeItem('loggedInUser');
    window.location.href = 'LogIn.html';
}
