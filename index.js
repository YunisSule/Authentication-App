const registerUrl = 'http://localhost/auth/auth/register.php';
const loginUrl = 'http://localhost/auth/auth/login.php';
const testUrl = 'http://localhost/auth/auth/test.php';
const logoutUrl = 'http://localhost/auth/auth/logout.php';
const getUserDataUrl = 'http://localhost/auth/user/getuserdata.php';

let loginForm = document.getElementById('login');
let registerForm = document.querySelector('#register');
let loginContainer = document.getElementById('login-container');
let registerBtn = document.getElementById('register-btn');
let logoutBtn = document.getElementById('logout-btn');
let userData = document.getElementById('user-data');
let ul = document.querySelector('#info');

registerForm.addEventListener('submit', register);
loginForm.addEventListener('submit', login);
logoutBtn.addEventListener('click', logout);

// Call test function to test if logged in
test();

// Register and login
/**
 *
 * @param {Event} e
 */
function register(e) {
  e.preventDefault();
  let data = new FormData(registerForm);
  let userInfo = {
    username: data.get('username'),
    password: data.get('password'),
    firstname: data.get('firstname'),
    lastname: data.get('lastname'),
    email: data.get('email'),
    city: data.get('city'),
    address: data.get('address'),
    zip: data.get('zip')
  };

  let params = {
    method: 'post',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(userInfo)
  };
  fetch(registerUrl, params)
    .then((res) => res.json())
    .then((data) => {
      alert(data.info);
      if (data.status === 'ok') {
        window.location.reload();
      }
    })
    .catch((e) => {
      alert('Internal server error!');
    });
}
// Register and login ends

// Login
/**
 *
 * @param {Event} e
 */
function login(e) {
  e.preventDefault();
  let data = new FormData(loginForm);

  let base64cred = btoa(data.get('username') + ':' + data.get('password'));

  let params = {
    method: 'post',
    withCredentials: true,
    headers: { Authorization: 'Basic ' + base64cred }
  };
  fetch(loginUrl, params)
    .then((res) => res.json())
    .then((data) => {
      if (data.status === 'ok') {
        window.location.reload();
      } else alert(data.info);
    })
    .catch((e) => {
      alert('Internal server error!');
    });
}
// Login ends

// Logout
function logout() {
  let params = {
    method: 'get',
    headers: { 'Content-Type': 'application/json' }
  };
  fetch(logoutUrl, params)
    .then((res) => res.json())
    .then((data) => {
      if (!data.logged) {
        logoutBtn.classList = 'hide-element';
        registerBtn.classList.remove('hide-element');
        loginContainer.classList.remove('hide-element');
        userData.classList.add('hide-element');
      }
    })
    .catch((e) => {
      alert('Internal server error!');
    });
}
// Logout ends

// Test if logged in
function test() {
  let params = {
    method: 'get',
    headers: { 'Content-Type': 'application/json' }
  };
  fetch(testUrl, params)
    .then((res) => res.json())
    .then((data) => {
      if (data.logged) {
        logoutBtn.classList.remove('hide-element');
        registerBtn.classList.add('hide-element');
        loginContainer.classList.add('hide-element');
        userData.classList.remove('hide-element');
        getUserData();
      }
    })
    .catch((e) => {
      alert('Internal server error!');
    });
}
// Test if logged in ends

// Get user information
function getUserData() {
  let params = {
    method: 'get',
    headers: { 'Content-Type': 'application/json' }
  };
  fetch(getUserDataUrl, params)
    .then((res) => res.json())
    .then((res) => {
      for (let i = 0; i <= 7; i++) {
        let li = document.createElement('li');
        li.classList = 'list-group-item';
        li.textContent = res[i];
        ul.append(li);
      }
      userData.classList.remove('hide-element');
    })
    .catch((e) => {
      alert('Internal server error!');
    });
}
