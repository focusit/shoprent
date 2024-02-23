@extends('masterlist')

@section('title', 'profile')

@section('body')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Profile Information</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card card-default">
                <!-- .card-body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="form-control"
                                    value="{{ auth()->user()->name }}" disabled>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('profile.update') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control"
                                        value="{{ auth()->user()->email }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" class="form-control"
                                        id="current_password">
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" class="form-control" id="new_password">
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control"
                                        id="new_password_confirmation">
                                </div>
                                <button type="submit" class="btn btn-success">Update Profile</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPasswordInput = document.getElementById('current_password');
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');
            const togglePassword = document.querySelector('.toggle-password');

            togglePassword.addEventListener('click', function() {
                togglePasswordState(currentPasswordInput);
                togglePasswordState(newPasswordInput);
                togglePasswordState(confirmPasswordInput);
            });

            function togglePasswordState(inputField) {
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
                togglePassword.classList.toggle('fa-eye-slash');
            }
        });
    </script>
@endsection
