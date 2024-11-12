@if ($errors->any())
    <div class="alert alert-danger" id="error-alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger" id="session-error-alert">
        {{ session('error') }}
    </div>
@endif

<style>
    .alert {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 10px;
  border-radius: 5px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  z-index: 1000;
  display: none; /* Initially hidden */
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}

</style>
<script>
    // Display the alert and hide it after 5 seconds
document.addEventListener('DOMContentLoaded', function () {
    // Show the alert messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        alert.style.display = 'block';
        setTimeout(function() {
            alert.style.display = 'none';
        }, 5000); // Hide after 5 seconds (5000 ms)
    });
});

</script>