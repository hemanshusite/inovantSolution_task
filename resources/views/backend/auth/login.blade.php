@extends('backend.layout.applogin')
@section('content')

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary bg-gradient text-white text-center py-4 rounded-4 rounded-bottom-0 border-0">
                <h4 class="mb-0 fw-bold">Welcome</h4>
                <p class="mb-0 mt-2 small opacity-75">Please sign in to continue</p>
            </div>
            
            <div class="card-body p-4">
                <form id="adminLogin" action="{{route('login')}}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="exampleInputEmail1" class="form-label fw-semibold text-secondary">
                            <i class="fa fa-envelope me-2"></i>Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control form-control-lg rounded-3 border-2 @error('email') is-invalid @enderror" 
                            id="exampleInputEmail1" 
                            aria-describedby="emailHelp"
                            required
                            value="{{ old('email') }}"
                            placeholder="Enter your email"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="exampleInputPassword1" class="form-label fw-semibold text-secondary">
                            <i class="fa fa-lock me-2"></i>Password
                        </label>
                        <input
                            type="password" 
                            name="password"
                            required
                            class="form-control form-control-lg rounded-3 border-2 @error('password') is-invalid @enderror" 
                            id="exampleInputPassword1"
                            placeholder="Enter your password"
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-3 btn-lg py-2 fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                    </button>
                </form>

                <div class="col-12 mt-4">
                    @error('msg')
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 py-2 mb-0" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{$message}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
@endsection