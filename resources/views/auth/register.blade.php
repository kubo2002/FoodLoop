<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Bootstrap layout -->
<div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="col-md-5">

            <!-- Karta s registracnym formularom -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <h3 class="text-center mb-4">Create Account</h3>

                    <!-- Zaciatok formulara -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Pole Name -->
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                            >

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validacna chyba pre meno  -->
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pole Email -->
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                            >

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validacna chyba pre email  -->
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pole Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                            >

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validacna chyba pre heslo  -->
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Potvrdzovacie tlacidlo -->
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                            >
                        </div>

                        <!-- Vyber role donor/recipient -->
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select
                                name="role"
                                class="form-select @error('role') is-invalid @enderror"
                            >
                                <option value="">Select role</option>
                                <option value="donor">Donor</option>
                                <option value="recipient">Recipient</option>
                            </select>

                            <!-- Blade direktiva kontroluje ci existuje po odolsani validaacna chyba pre rolu  -->
                            @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn btn-success w-100">Register</button>


                        <div class="text-center mt-3">
                            <a href="{{ route('login.show') }}">Already have an account?</a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
