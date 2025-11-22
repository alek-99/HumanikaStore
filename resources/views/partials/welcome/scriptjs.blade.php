   <script>
        function switchTab(tab) {
            // Update tabs
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');

            // Update forms
            document.querySelectorAll('.form-container').forEach(f => f.classList.remove('active'));
            document.getElementById(tab + '-form').classList.add('active');

            // Clear alerts
            hideAlert('login');
            hideAlert('register');
        }

        function showAlert(form, type, message) {
            const alert = document.getElementById(form + '-alert');
            alert.className = 'alert ' + type;
            alert.textContent = message;
            alert.style.display = 'block';
        }

        function hideAlert(form) {
            const alert = document.getElementById(form + '-alert');
            alert.style.display = 'none';
        }

        function handleLogin(event) {
            event.preventDefault();
            showAlert('login', 'success', 'Login berhasil! Mengalihkan ke dashboard...');
            
            setTimeout(() => {
                // Redirect logic here
                console.log('Redirecting to dashboard...');
            }, 1500);
        }

        function handleRegister(event) {
            event.preventDefault();
            const passwords = event.target.querySelectorAll('input[type="password"]');
            
            if (passwords[0].value !== passwords[1].value) {
                showAlert('register', 'error', 'Password tidak cocok!');
                return;
            }

            showAlert('register', 'success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
            
            setTimeout(() => {
                switchTab('login');
                document.querySelector('#login-form form').reset();
            }, 2000);
        }

        function socialLogin(provider) {
            alert('Login dengan ' + provider + ' akan segera tersedia!');
        }
    </script>