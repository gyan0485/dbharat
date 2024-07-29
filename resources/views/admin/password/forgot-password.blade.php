<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="{{ url('') }}/asset/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="{{ url('') }}/asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="{{ url('') }}/asset/dist/css/adminlte.min.css">

  <!-- Add CSRF Token Meta Tag -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Admin</b></a>
    </div>

    <!-- Email Input Section -->
    <div class="card" id="email-section">
      <div class="card-body login-card-body">
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
        <form id="email-form">
          <div class="input-group mb-3">
            <input type="email" class="form-control" id="email" placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Request new password</button>
            </div>
          </div>
        </form>
        <p class="mt-3 mb-1">
          <a href="{{ url('/') }}">Login</a>
        </p>
      </div>
    </div>

    <!-- OTP Verification Section -->
    <div class="card" id="otp-section" style="display: none;">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Enter OTP</p>
        <form id="otp-form">
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="otp" placeholder="XXXXXX" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-key"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
            </div>
          </div>
        </form>
        <p class="mt-3 mb-1">
          <a href="{{ url('/') }}">Login</a>
        </p>
      </div>
    </div>

    <!-- Password Recovery Section -->
    <div class="card" id="password-section" style="display: none;">
      <div class="card-body login-card-body">
        <p class="login-box-msg">You are only one step away from your new password, recover your password now.</p>
        <form id="password-form">
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Change password</button>
            </div>
          </div>
        </form>
        <p class="mt-3 mb-1">
          <a href="{{ url('/') }}">Login</a>
        </p>
      </div>
    </div>

  </div>

  <script src="{{ url('') }}/asset/plugins/jquery/jquery.min.js"></script>
  <script src="{{ url('') }}/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ url('') }}/asset/dist/js/adminlte.min.js"></script>
  <script>
    $(document).ready(function() {
      // Set up global AJAX settings to include CSRF token
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      // Handle the email form submission
      $('#email-form').on('submit', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        $.post('{{ route("forgot.password.post") }}', {
            email: email
          })
          .done(function(data) {
            if (data.success) {
              $('#email-section').hide();
              $('#otp-section').show();
            } else {
              alert('Failed to send OTP.');
            }
          })
          .fail(function() {
            alert('Error occurred.');
          });
      });

      // Handle the OTP form submission
      $('#otp-form').on('submit', function(e) {
        e.preventDefault();
        var otp = $('#otp').val();
        $.post('{{ route("verify.otp") }}', {
            otp: otp
          })
          .done(function(data) {
            if (data.success) {
              $('#otp-section').hide();
              $('#password-section').show();
            } else {
              alert('Invalid OTP.');
            }
          })
          .fail(function() {
            alert('Error occurred.');
          });
      });

      // Handle the password form submission
      $('#password-form').on('submit', function(e) {
        e.preventDefault();

        var password = $('#password').val();
        var confirmPassword = $('#confirm-password').val();

        if (password === confirmPassword) {
          var otp = $('#otp').val(); // Get the OTP value from the hidden field or storage

          $.post('{{ route("reset.password") }}', {
              password: password,
              otp: otp
            })
            .done(function(data) {
              if (data.success) {
                alert('Password changed successfully.');
                window.location.href = '{{ url('/') }}';
              } else {
                alert('Failed to change password.');
              }
            })
            .fail(function() {
              alert('Error occurred.');
            });
        } else {
          alert('Passwords do not match.');
        }
      });
    });
  </script>
</body>
</html>