const navToggle = document.querySelector('[data-menu]');
const navLinks = document.querySelector('.nav-links');
if (navToggle && navLinks) {
  navToggle.addEventListener('click', () => navLinks.classList.toggle('open'));
}

document.querySelectorAll('[data-toggle-password]').forEach((button) => {
  button.addEventListener('click', () => {
    const input = document.getElementById(button.dataset.togglePassword);
    if (!input) return;
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    button.textContent = show ? 'Hide' : 'Show';
  });
});

document.querySelectorAll('[data-demo-form]').forEach((form) => {
  form.addEventListener('submit', (event) => {
    event.preventDefault();
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }
    const password = form.querySelector('#password');
    const confirmPassword = form.querySelector('#confirmPassword');
    if (password && confirmPassword && password.value !== confirmPassword.value) {
      confirmPassword.setCustomValidity('Passwords do not match');
      confirmPassword.reportValidity();
      confirmPassword.setCustomValidity('');
      return;
    }
    const notice = form.querySelector('[data-notice]');
    if (notice) {
      notice.textContent = form.dataset.message || 'Action completed successfully.';
      notice.style.display = 'block';
    }
  });
});

const dateFields = document.querySelectorAll('input[type="date"]');
dateFields.forEach((field) => {
  const today = new Date();
  field.min = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
});

const service = document.querySelector('#service');
const provider = document.querySelector('#provider');
const date = document.querySelector('#date');
const timeInputs = document.querySelectorAll('input[name="time"], input[name="booking_time"]');

const providerMap = {
  Hospital: ['Dr. Anjali Rao', 'Dr. Kiran Kumar', 'Dr. Meera Singh'],
  Salon: ['Sneha Stylist', 'Arjun Hair Expert', 'Riya Beauty Studio'],
  Gym: ['Coach Vikram', 'Trainer Nisha', 'FitPro Aman'],
  Consultant: ['Business Consultant Ravi', 'Career Mentor Priya', 'Finance Advisor Neha']
};

function fillProviders() {
  if (!service || !provider) return;
  const selected = service.value;
  provider.innerHTML = '<option value="">Select provider</option>';
  (providerMap[selected] || []).forEach((name) => {
    const option = document.createElement('option');
    option.value = name;
    option.textContent = name;
    provider.appendChild(option);
  });
  updateBookingSummary();
}

function selectedTime() {
  const checked = document.querySelector('input[name="time"]:checked, input[name="booking_time"]:checked');
  return checked ? checked.value : 'Not selected';
}

function updateBookingSummary() {
  const values = {
    service: service && service.value ? service.value : 'Not selected',
    provider: provider && provider.value ? provider.value : 'Not selected',
    date: date && date.value ? date.value : 'Not selected',
    time: selectedTime()
  };
  Object.entries(values).forEach(([key, value]) => {
    const target = document.querySelector(`[data-summary="${key}"]`);
    if (target) target.textContent = value;
  });
}

if (service) service.addEventListener('change', fillProviders);
if (provider) provider.addEventListener('change', updateBookingSummary);
if (date) date.addEventListener('change', updateBookingSummary);
timeInputs.forEach((input) => input.addEventListener('change', updateBookingSummary));

const query = new URLSearchParams(window.location.search);
if (service && query.get('service')) {
  service.value = query.get('service');
  fillProviders();
}
updateBookingSummary();
