window.onload = () => {
const emailInput = document.querySelector('#email');
const passInput = document.querySelector('#password');
const signInBtn = document.querySelector('#signInBtn');

const alert = document.querySelector('#alert');
const alertTitle = alert.querySelector('#alertTitle');


signInBtn.addEventListener('click', signInHandler)    


function signInHandler() {
    let email = emailInput.value;
    let pass = passInput.value;
    alert.style.display = 'none';
    if (email) {
        if( /(.+)@(.+){2,}\.(.+){2,}/.test(email) ){
            if (pass.length >= 6) {
                $.ajax({
                    method: "GET",
                    url: "/api/v1/users/login",
                    data: {
                        email,
                        password: pass
                    },
                    beforeSend: () => {
                        signInBtn.innerHTML = `
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Sign in
                        `;
                    },
                    success: (data) => {
                        signInBtn.innerHTML = `
                            Sign in
                        `;
                        alert.style.display = 'none';
                        if (data.result == 'success') {
                            document.location.href = '/statistics';
                        } else if (data.result == 'error') {
                            alert.style.display = 'block';
                            alertTitle.innerText = data.msg;
                        }
                    }
                }); 
            } else {
                alert.style.display = 'block';
                alertTitle.innerText = "Password must be at least 6 characters";
            }
        } else {
            alert.style.display = 'block';
            alertTitle.innerText = 'Invalid email';
        }
    }
}


}