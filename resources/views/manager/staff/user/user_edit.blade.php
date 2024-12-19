@extends('dashboard.manager_dashboard')

@section('dashboard')
    <div class="main-panel">
        <div class="content-wrapper">
        <a href="/manager/user" class="btn btn-danger mb-3">< Back</a>
            <h3 class="fs-3 mb-4">Update User</h3>

            <div class="form col-6 p-0">
                <form method="POST" action="/manager/user/update/{{$updateuser->id}}">
                    @csrf
                    @method('PUT')

                        <label for="name" class="col-form-label">{{ __('Name') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required value="{{$updateuser->name}}" autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        <label for="email" class="col-form-label">{{ __('Email Address') }}</label>

                             <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$updateuser->email}}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        <label for="role" class="col-form-label">Role</label>
                          <select name="role" class="form-select @error('role') is-invalid @enderror" id="role" required>
                                <option value="">Choose Role</option>
                                @foreach($roles as $role)
                                <option value={{$role->id}} {{ $role->id == $updateuser->role_id ? 'selected' : '' }}>{{$role->rolename}}</option>
                                @endforeach
                            </select>

                            @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <p class="change-password text-danger col-md-4"></p>
                            <div class="change-password text-primary cursor-pointer p-0" role="button" onclick="handlepassword()">Change Password</div>
                            <div class="password">
                        <label for="password" class="col-form-label">{{ __('Password') }}</label>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                         <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>

                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">

                        </div>
                             <button type="submit" class="btn btn-danger mt-3">
                                {{ __('Update') }}
                            </button>
                    </form>
            </div>
        </div>      
    </div>

<script>
    let changePassword = document.getElementsByClassName('change-password');
    let password = document.getElementsByClassName('password');
    for(let i=0; i < password.length; i++){
        password[i].style.display = 'none';
    }

    function handlepassword() {
        for(let i=0; i < password.length; i++){
            if(password[i].style.display == 'none')
                password[i].style.display = 'block';
            else{
                password[i].style.display = 'none';
            }
        }
    }   
</script>
@endsection