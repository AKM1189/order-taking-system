@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
        <a href="/manager/user" class="btn btn-danger mb-3">< Back</a>
            <h3 class="fs-3 mb-4">User</h3>
            <div class="form col-md-6 p-0">
                <form method="POST" id="form" action="{{ route('register') }}">
                    @csrf
                    @method('PUT')

                    <label for="name" class="col-form-label">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label for="role" class="col-form-label">Role</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" id="role" required>
                        <option value="">Choose Role</option>
                        @foreach ($roles as $role)
                            <option value={{ $role->id }}>{{ $role->rolename }}</option>
                        @endforeach
                    </select>

                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    <label for="password" class="col-form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                        <div id="error" class="text-danger"></div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                        autocomplete="new-password">
                        <div id="confirm-error" class="text-danger"></div>
                    <button type="submit" onclick='add(event)' class="btn btn-danger mt-3">
                        {{ __('Add') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function add(e) {
            let password = $('#password').val();
            let passwordConfirm = $('#password-confirm').val();
            // console.log(password == /^[a-zA-Z0-9]/);
            // if(password.match(/[A-Z]/g)) {
            //     console.log('valid');
            // }
            // else{
            //     console.log('invalid')
            // }
            // console.log(password.search(/[^a-zA-Z0-9]/))
            if($('#name').val() && $('#email').val() && $('#role').val()){
                if(password.length !== 0) {
                    if(password.length < 8) {
                        e.preventDefault();
                        $('#password').addClass('is-invalid');
                        $('#error').text('* Password length must be greater than 8.');
                    }
                    else if(password.length > 16) {
                        e.preventDefault();
                        $('#password').addClass('is-invalid');
                        $('#error').text('* Password length must be less than 16.');
                    }
                    else if(!password.match(/['a-z']/g)) {
                        e.preventDefault();
                        $('#password').addClass('is-invalid');
                        $('#error').text('* Password must include small letters.');
                    }
                    else if(!password.match(/['A-Z']/g)) {
                        e.preventDefault();
                        $('#password').addClass('is-invalid');
                        $('#error').text('* Password must include capital letters.');
                    }
                    else if(!password.match(/['0-9']/g)) {
                        e.preventDefault();
                        $('#password').addClass('is-invalid');
                        $('#error').text('* Password must include numbers.');
                    }
                    else if(passwordConfirm.length > 0 && password !== passwordConfirm) {
                        e.preventDefault();
                        $('#password').removeClass('is-invalid');
                        $('#error').text('');
                        $('#password-confirm').addClass('is-invalid');
                        $('#confirm-error').text('* Confirm Password is not same as Password.');
                    }
                    // else if(!password.search(/[^a-zA-Z0-9]/)){

                    // }
                    else if(passwordConfirm.length > 0){
                        $('#password').removeClass('is-invalid');
                        $('#error').text('');
                        $('#password-confirm').removeClass('is-invalid');
                        $('#confirm-error').text('');
                        $('#form').submit();
                    }
                    else{
                        $('#password').removeClass('is-invalid');
                        $('#error').text('');
                        $('#password-confirm').removeClass('is-invalid');
                        $('#confirm-error').text('');
                    }
                }

            }
        }
    </script>
@endsection
