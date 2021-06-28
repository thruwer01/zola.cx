window.onload = () => {
    const emailInput = document.querySelector('#email');
    const passInput = document.querySelector('#password');
    const signUpBtn = document.querySelector('#signUpBtn');
    
    signUpBtn.addEventListener('click', signUpHandler)    
    
    const alert = document.querySelector('#alert');
    const alertTitle = alert.querySelector('#alertTitle');

    function signUpHandler() {
        let email = emailInput.value;
        let pass = passInput.value;
        alert.style.display = 'none';
        alert.classList.remove('alert-success');
        alert.classList.remove('alert-danger');
        if (email) {
            if( /(.+)@(.+){2,}\.(.+){2,}/.test(email) ){
                if (pass.length     >= 6) {
                    $.ajax({
                        method: "GET",
                        url: "/api/v1/users/signup/",
                        data: {
                            email,
                            password: pass
                        },
                        beforeSend: () => {
                            signUpBtn.innerHTML = `
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Sign up
                            `;
                        },
                        success: (data) => {
                            signUpBtn.innerHTML = `
                                Sign up
                            `;
                            alert.style.display = 'none';
                            alert.classList.remove('alert-success');
                            alert.classList.remove('alert-danger');
                            if (data.result == 'success') {
                                alert.classList.add('alert-success');
                                alertTitle.innerText = data.msg;
                                alert.style.display = 'block';
                            } else if (data.result == 'error') {
                                alert.classList.add('alert-danger');
                                alertTitle.innerText = data.msg;
                                alert.style.display = 'block';
                            }
                        }
                    }); 
                } else {
                    alert.classList.add('alert-danger');
                    alertTitle.innerText = "Password must be at least 6 characters";
                    alert.style.display = 'block';
                }
            } else {
                alert.classList.add('alert-danger');
                alertTitle.innerText = "Invalid email";
                alert.style.display = 'block';
            }
        }
    }
    
    
    }