@extends('layouts.app')

@section('content')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedSymbol = '';
            const assignedToSelect = document.getElementById('company_symbol');
            assignedToSelect.selectedIndex = -1;
            assignedToSelect.addEventListener('change', function() {
                selectedSymbol = assignedToSelect.options[assignedToSelect.selectedIndex].text;
            });
            axios.get('/api/companies', {})
                .then(function(response) {
                    const companies = response.data;
                    // const assignedToSelect = document.getElementById('company_symbol');
                    companies.forEach(function(company) {
                        const option = document.createElement('option');
                        option.value = company.id;
                        option.text = company.symbol;
                        assignedToSelect.add(option);
                    });
                })
                .catch(function(error) {
                    console.log(error.response.data);
                });
            document.getElementById('create-application-form').addEventListener('submit', function(event) {
                event.preventDefault();
                const form = event.target;
                const company_id = form.elements.company_symbol.value;
                const start_date = form.elements.start_date.value;
                const end_date = form.elements.end_date.value;
                const email = form.elements.email.value;
                // Validate form fields
                const currentDate = new Date().toISOString().slice(0, 10);
                let errors = [];
                if (!company_id) {
                    errors.push('Please select a company.');
                }
                if (!start_date || !isValidDate(start_date)) {
                    errors.push('Please enter a valid start date.');
                }
                if (!end_date || !isValidDate(end_date)) {
                    errors.push('Please enter a valid end date.');
                }
                if (start_date && end_date && start_date > end_date) {
                    errors.push('Start date must be less than or equal to end date.');
                }
                if (start_date && start_date > currentDate) {
                    errors.push('Start date cannot be in the future.');
                }
                if (end_date && end_date > currentDate) {
                    errors.push('End date cannot be in the future.');
                }
                if (!email || !isValidEmail(email)) {
                    errors.push('Please enter a valid email address.');
                }
                if (errors.length > 0) {
                    // Show error messages to user
                    const errorAlert = document.createElement('div');
                    errorAlert.className = 'alert alert-danger';
                    errors.forEach(function(error) {
                        const errorMessage = document.createElement('p');
                        errorMessage.textContent = error;
                        errorAlert.appendChild(errorMessage);
                    });
                    // Append the error message after the form
                    const form = document.getElementById('create-application-form');
                    form.parentNode.insertBefore(errorAlert, form.nextSibling);
                    // Remove error messages after 5 seconds
                    setTimeout(function() {
                        errorAlert.remove();
                    }, 5000);
                } else {
                    // Submit the form
                    axios.post('/api/applications', {
                            company_id: company_id,
                            start_date: start_date,
                            end_date: end_date,
                            email: email,
                        }, {})
                        .then(function(response) {
                            // Show success message to user
                            const successMessage = document.createElement('div');
                            successMessage.className = 'alert alert-success';
                            successMessage.textContent = 'Application created successfully.';
                            document.getElementById('message').appendChild(successMessage);
                            // Remove success message after 5 seconds
                            setTimeout(function() {
                                successMessage.remove();
                            }, 5000);
                            window.location.href = "{{ route('applications.historics', ':symbol') }}".replace(':symbol', selectedSymbol);
                        })
                        .catch(function(error) {
                            // Show error message to user
                            const errorMessage = document.createElement('div');
                            errorMessage.className = 'alert alert-danger';
                            errorMessage.textContent = 'Error creating application. Please try again.';
                            document.getElementById('message').appendChild(errorMessage);
                            // Remove error message after 5 seconds
                            setTimeout(function() {
                                errorMessage.remove();
                            }, 5000);
                        });
                }
            });
            // Show the create task form
            document.getElementById('create-application-form').style.display = 'block';

            // Utility function to validate dates
            function isValidDate(dateString) {
                const pattern = /^\d{4}-\d{2}-\d{2}$/;
                if (!pattern.test(dateString)) {
                    return false;
                }
                const date = new Date(dateString);
                if (isNaN(date.getTime())) {
                    return false;
                }
                return true;
            }

            // Utility function to validate email addresses
            function isValidEmail(emailString) {
                const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return pattern.test(emailString);
            }
        });
    </script>
    <div id="message"></div>
    <div id="create-application-form">
        <form>
            <div class="form-group">
                <label for="company_symbol">Company Symbol</label>
                <select class="form-control" id="company_symbol" name="company_symbol" required>
                    <option value="">Select a company</option>
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                    required placeholder="example@example.com">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
