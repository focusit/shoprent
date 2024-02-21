<!-- resources/views/auth/register.blade.php -->
@extends('layout')

@section('title', 'Register')

@section('content')
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <h2>WELCOME TO EXPLORE </h2>
                    <img src="{{ asset('login-asset/images/img-01.png') }}" alt="IMG">
                </div>
                <form method="POST" action="{{ route('register') }}" class="login100-form validate-form">
                    @csrf
                    <span class="login100-form-title">
                        Member Registration
                    </span>

                    <!-- Display Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="name" placeholder="Name">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="email" name="email" placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="password" name="password" id="password" placeholder="Password"
                            minlength="6">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                        <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    </div>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="password" name="password_confirmation" placeholder="Confirm Password"
                            minlength="6">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>

                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_admin" class="form-check-input" value="1">
                        <span class="focus-input100"></span>
                        <label class="form-check-label" for="is_admin">Register as Admin</label>
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Register
                        </button>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="{{ route('login') }}">
                            Already have an account? Login here
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const togglePassword = document.querySelector('.toggle-password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>
