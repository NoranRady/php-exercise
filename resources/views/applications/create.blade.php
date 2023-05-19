@extends('layouts.app')

@section('content')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            axios.get('/api/companies', {})
                .then(function(response) {
                    const companies = response.data;
                    const assignedToSelect = document.getElementById('company_symbol');
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

                axios.post('/api/applications', {
                        company_id: company_id,
                        start_date: start_date,
                        end_date: end_date,
                        email: email,
                    }, {})
                    .then(function(response) {
                        console.log(response.data);
                    })
                    .catch(function(error) {
                        console.log(error.response.data);
                    });
            });
            document.getElementById('create-application-form').style.display = 'block';
        });
    </script>

    <div id="create-application-form">
        <form>
            <div class="form-group">
                <label for="company_symbol">Company Symbol</label>
                <select class="form-control" id="company_symbol" name="company_symbol" required>
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
