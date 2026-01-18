@extends('layouts.app')

@section('container')
<main class="pt-90">
    <style>
        img {
            max-width: 20%;
            object-fit: contain;
            vertical-align: top;
            border-radius: 100%;
        }
        .remove-image {
            cursor: pointer;
        }
        .toggle-password {
            cursor: pointer;
        }
    </style>

    <div class="mb-4 pb-4"></div>

    <section class="login-register container">
        <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link nav-link_underscore active" id="register-tab" data-bs-toggle="tab" href="#tab-item-register" role="tab" aria-controls="tab-item-register" aria-selected="true">Register</a>
            </li>
        </ul>

        <div class="tab-content pt-2" id="login_register_tab_content">
            <div class="tab-pane fade show active" id="tab-item-register" role="tabpanel" aria-labelledby="register-tab">
                <div class="register-form">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf

                        <!-- Name Field -->
                        <div class="form-floating mb-3">
                            <input id="name" type="text" class="form-control form-control_gray @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <label for="name">Name</label>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="form-floating mb-3">
                            <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                            <div class="upload-image flex-grow">
                                <div class="item" id="imgpreview" style="display:none;">
                                    <div class="image-container">
                                        <img src="" alt="Image Preview" id="previewImage" class="effect8">
                                        <span class="remove-image" onclick="removeImage()">X</span>
                                    </div>
                                </div>
                                <div id="upload-file" class="item up-load">
                                    <label class="uploadfile" for="myFile">
                                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                                        <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span></span>
                                        <input type="file" id="myFile" name="image" accept="image/*" class="@error('image') is-invalid @enderror">
                                    </label>
                                </div>
                            </div>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control form-control_gray @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            <label for="email">Email Address *</label>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Mobile Number Field -->
                        <div class="form-floating mb-3">
                            <input id="mobile_num" type="number" class="form-control form-control_gray @error('mobile_num') is-invalid @enderror" name="mobile_num" value="{{ old('mobile_num') }}" required>
                            <label for="mobile_num">Mobile *</label>
                            @error('mobile_num')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-floating mb-3 position-relative">
                            <input id="password" type="password" class="form-control form-control_gray @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <label for="password">Password *</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" onclick="togglePassword('password', 'togglePasswordIcon')">
                                <i class="fas fa-eye" id="togglePasswordIcon"></i>
                            </span>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-floating mb-3 position-relative">
                            <input id="password-confirm" type="password" class="form-control form-control_gray" name="password_confirmation" required autocomplete="new-password">
                            <label for="password-confirm">Confirm Password *</label>
                            <span class="position-absolute top-50 end-0 translate-middle-y me-3 toggle-password" onclick="togglePassword('password-confirm', 'toggleConfirmPasswordIcon')">
                                <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                            </span>
                        </div>

                        <!-- Privacy Policy -->
                        <div class="d-flex align-items-center mb-3 pb-2">
                            <p class="m-0">Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.</p>
                        </div>

                        <!-- Submit Button -->
                        <button class="btn btn-primary w-100 text-uppercase" type="submit">Register</button>

                        <!-- Login Link -->
                        <div class="customer-option mt-4 text-center">
                            <span class="text-secondary">Have an account?</span>
                            <a href="/login" class="btn-text js-show-register">Login to your Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- Scripts --}}
<script>
    // Preview Image
    document.getElementById('myFile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        const maxSize = 2 * 1024 * 1024;

        if (!allowedTypes.includes(file.type)) {
            alert('Invalid file type. Please upload an image.');
            return;
        }
        if (file.size > maxSize) {
            alert('File size exceeds 2MB. Please upload a smaller image.');
            return;
        }

        const src = URL.createObjectURL(file);
        document.getElementById('previewImage').src = src;
        document.getElementById('imgpreview').style.display = 'block';
        document.getElementById('upload-file').style.display = 'none';
    });

    function removeImage() {
        document.getElementById('previewImage').src = '';
        document.getElementById('imgpreview').style.display = 'none';
        document.getElementById('upload-file').style.display = 'block';
        document.getElementById('myFile').value = '';
    }

    // Toggle Password Visibility
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection
