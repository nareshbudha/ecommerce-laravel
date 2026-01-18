<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <title>Add Brand - Spell E-Commerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <style>
        /* Image preview styling */
        #previewImage {
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
            border-radius: 10px;
        }

        /* Cross icon for removing image */
        .remove-image {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }

        /* Image container for preview */
        .image-container {
            position: relative;
            display: inline-block;
        }

        /* Highlight upload area on drag */
        .upload-file.dragging {
            border: 2px dashed #007bff;
        }

        /* Highlight error */
        .has-error input,
        .has-error label {
            border-color: #e3342f;
        }
    </style>
</head>

<body class="body">
    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap">
                @include('dashboard.components.sidebar')

                <div class="section-content-right">
                    <div class="header-dashboard">
                        @include('dashboard.components.navbar')
                    </div>

                    <div class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Add Brand Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li><a href="/dashboard"><div class="text-tiny">Dashboard</div></a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="/dashboard/brands"><div class="text-tiny">Brands</div></a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><div class="text-tiny">New Brand</div></li>
                                    </ul>
                                </div>

                                <!-- Success Message -->
                                @if(session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <!-- Form Section -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Brand Name -->
                                        <fieldset class="name">
                                            <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Brand name" name="name" id="brandName" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <!-- Upload Image -->
                                        <fieldset>
                                            <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                                            <div class="upload-image flex-grow {{ $errors->has('image') ? 'has-error' : '' }}">
                                                <div class="item" id="imgpreview" style="display:none;">
                                                    <div class="image-container">
                                                        <img src="" alt="Image Preview" id="previewImage" class="effect8">
                                                        <span class="remove-image" id="removeImage" onclick="removeImage()">X</span>
                                                    </div>
                                                </div>
                                                <div id="upload-file" class="item up-load">
                                                    <label class="uploadfile" for="myFile">
                                                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                                                        <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span></span>
                                                        <input type="file" id="myFile" name="image" accept="image/*" required>
                                                    </label>
                                                </div>
                                            </div>
                                            @error('image')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <!-- Submit Button -->
                                        <div class="bot">
                                            <div></div>
                                            <button class="tf-button w208" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap-select.min.js"></script>
    <script src="/assets/js/apexcharts/apexcharts.js"></script>
    <script src="/assets/js/main.js"></script>

    <script>
        document.getElementById('myFile').addEventListener('change', function (event) {
            try {
                const file = event.target.files[0];
                const imgPreviewDiv = document.getElementById('imgpreview');
                const previewImage = document.getElementById('previewImage');
                const uploadField = document.getElementById('upload-file');

                // Validate file type and size
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
                const maxSize = 2 * 1024 * 1024; // 2 MB
                if (!allowedTypes.includes(file.type)) {
                    alert('Invalid file type. Please upload an image.');
                    return;
                }
                if (file.size > maxSize) {
                    alert('File size exceeds 2MB. Please upload a smaller image.');
                    return;
                }

                // Show preview
                const src = URL.createObjectURL(file);
                previewImage.src = src;
                imgPreviewDiv.style.display = 'block';
                uploadField.style.display = 'none';
            } catch (error) {
                console.error('Error handling file change:', error);
            }
        });

        function removeImage() {
            try {
                const imgPreviewDiv = document.getElementById('imgpreview');
                const uploadField = document.getElementById('upload-file');
                const previewImage = document.getElementById('previewImage');
                previewImage.src = ''; // Clear the image source
                imgPreviewDiv.style.display = 'none';
                uploadField.style.display = 'block';
            } catch (error) {
                console.error('Error removing image:', error);
            }
        }

        document.getElementById('upload-file').addEventListener('dragover', function(event) {
            event.preventDefault();
            this.classList.add('dragging');
        });

        document.getElementById('upload-file').addEventListener('dragleave', function(event) {
            this.classList.remove('dragging');
        });

        document.getElementById('upload-file').addEventListener('drop', function(event) {
            event.preventDefault();
            this.classList.remove('dragging');
            try {
                const file = event.dataTransfer.files[0];
                const fileInput = document.getElementById('myFile');
                fileInput.files = event.dataTransfer.files; // Sync files with input
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('previewImage');
                    const imgPreview = document.getElementById('imgpreview');
                    previewImage.src = e.target.result;
                    imgPreview.style.display = 'block';
                    document.getElementById('upload-file').style.display = 'none';
                };
                reader.readAsDataURL(file);
            } catch (error) {
                console.error('Error handling file drop:', error);
            }
        });
    </script>
</body>

</html>
