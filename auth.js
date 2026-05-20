// Authentication handling

// Check if we're on a login/register page or main app page
const isAuthPage = document.querySelector('.auth-page') !== null;

// Form elements
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const loginError = document.getElementById('loginError');
const registerError = document.getElementById('registerError');

// Login form submission handler
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        
        // Simple validation
        if (!email || !password) {
            if (loginError) loginError.textContent = "Please enter both email and password.";
            return false;
        }
        
        // Check if user exists in localStorage
        const users = JSON.parse(localStorage.getItem('bookExplorerUsers') || '[]');
        const userExists = users.find(user => user.email === email && user.password === password);
        
        if (!userExists) {
            if (loginError) loginError.textContent = "Invalid email or password or user doesn't exist.";
            return false;
        }
        
        // Store logged in user info
        const loggedInUser = {
            email: userExists.email,
            fullName: userExists.fullName,
            isLoggedIn: true
        };
        
        localStorage.setItem('bookExplorerUser', JSON.stringify(loggedInUser));
        
        // Redirect to main page
        window.location.href = 'index.html';
    });
}

// Register form submission handler
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const fullName = document.getElementById('fullName').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const confirmPassword = document.getElementById('confirmPassword').value.trim();
        
        // Simple validation
        if (!fullName || !email || !password || !confirmPassword) {
            if (registerError) registerError.textContent = "Please fill in all fields.";
            return false;
        }
        
        if (!email.includes('@')) {
            if (registerError) registerError.textContent = "Please enter a valid email address.";
            return false;
        }
        
        if (password.length < 6) {
            if (registerError) registerError.textContent = "Password must be at least 6 characters.";
            return false;
        }
        
        if (password !== confirmPassword) {
            if (registerError) registerError.textContent = "Passwords do not match.";
            return false;
        }
        
        // Check if email is already registered
        const users = JSON.parse(localStorage.getItem('bookExplorerUsers') || '[]');
        if (users.some(user => user.email === email)) {
            if (registerError) registerError.textContent = "This email is already registered.";
            return false;
        }
        
        // Add new user to users array
        users.push({
            fullName: fullName,
            email: email,
            password: password
        });
        
        // Save updated users array
        localStorage.setItem('bookExplorerUsers', JSON.stringify(users));
        
        // After registration, redirect to login page instead of main page
        window.location.href = 'login.html';
    });
}

// Check if we should redirect
if (isAuthPage) {
    // If user is already logged in, redirect to main page
    const currentUser = localStorage.getItem('bookExplorerUser');
    if (currentUser) {
        try {
            const user = JSON.parse(currentUser);
            if (user && user.isLoggedIn) {
                window.location.href = 'index.html';
            }
        } catch (error) {
            console.error('Error parsing user data:', error);
            // Clear invalid data
            localStorage.removeItem('bookExplorerUser');
        }
    }
} else {
    // On main page, check if user is logged in
    const currentUser = localStorage.getItem('bookExplorerUser');
    if (!currentUser) {
        // Redirect to login if not logged in
        window.location.href = 'login.html';
    } else {
        try {
            const user = JSON.parse(currentUser);
            if (!user || !user.isLoggedIn) {
                // Redirect to login if not properly logged in
                window.location.href = 'login.html';
            }
        } catch (error) {
            console.error('Error parsing user data:', error);
            // Clear invalid data and redirect
            localStorage.removeItem('bookExplorerUser');
            window.location.href = 'login.html';
        }
    }
}

// Password Strength Indicator Functions
function checkPasswordStrength(password) {
    // Initialize score
    let score = 0;
    
    // Length check
    if (password.length >= 8) score += 1;
    if (password.length >= 12) score += 1;
    
    // Character checks
    if (/[A-Z]/.test(password)) score += 1; // Has uppercase
    if (/[a-z]/.test(password)) score += 1; // Has lowercase
    if (/[0-9]/.test(password)) score += 1; // Has number
    if (/[^A-Za-z0-9]/.test(password)) score += 1; // Has special character
    
    // Map score to strength
    let strength = '';
    let color = '';
    
    if (password.length === 0) {
        strength = '';
        color = '#ddd';
    } else if (score < 3) {
        strength = 'Weak';
        color = '#e74c3c';
    } else if (score < 5) {
        strength = 'Medium';
        color = '#f39c12';
    } else {
        strength = 'Strong';
        color = '#27ae60';
    }
    
    return { score, strength, color };
}

// Update the password strength indicator
function updatePasswordStrength() {
    const passwordInput = document.getElementById('password');
    const strengthMeter = document.getElementById('password-strength-meter');
    const strengthText = document.getElementById('password-strength-text');
    
    if (passwordInput && strengthMeter && strengthText) {
        const password = passwordInput.value;
        const { score, strength, color } = checkPasswordStrength(password);
        
        // Update the meter width based on score (0-6 range)
        const percentage = (score / 6) * 100;
        strengthMeter.style.width = `${percentage}%`;
        strengthMeter.style.backgroundColor = color;
        
        // Update the strength text
        strengthText.textContent = strength;
        strengthText.style.color = color;
    }
}

// Add password strength indicator elements to the register page
function addPasswordStrengthIndicator() {
    const registerForm = document.getElementById('registerForm');
    const passwordGroup = registerForm?.querySelector('div.form-group:nth-of-type(3)');
    
    if (passwordGroup) {
        // Create password strength container
        const strengthContainer = document.createElement('div');
        strengthContainer.className = 'password-strength-container';
        strengthContainer.innerHTML = `
            <div class="password-strength-meter-container">
                <div id="password-strength-meter" class="password-strength-meter"></div>
            </div>
            <div id="password-strength-text" class="password-strength-text"></div>
        `;
        
        // Insert after the password input
        passwordGroup.appendChild(strengthContainer);
        
        // Add event listener to password input
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', updatePasswordStrength);
        }
    }
}

// Add password strength indicator when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the register page
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        // Add password strength indicator
        addPasswordStrengthIndicator();
    }
});






