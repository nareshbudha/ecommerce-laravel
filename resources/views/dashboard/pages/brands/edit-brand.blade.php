<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <title>Edit Brand - Spell E-Commerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <style>
        /* Add rounded shape to the image */
        #previewImage {
            border-radius: 50%;
            max-width: 150px;
            max-height: 150px;
        }

        /* Style for the cross icon to remove the image */
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

        /* Positioning the image container */
        .image-container {
            position: relative;
            display: inline-block;
        }
    </style>
</head>

<body class="body">
    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap">
                <!-- Sidebar -->
                @include('dashboard.components.sidebar')

                <!-- Main Content -->
                <div class="section-content-right">
                    <div class="header-dashboard">
                        @include('dashboard.components.navbar')
                    </div>

                    <div class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Edit Brand Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li><a href="/dashboard">
                                                <div class="text-tiny">Dashboard</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="/dashboard/brands">
                                                <div class="text-tiny">Brands</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">Edit Brand</div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Form Section -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1"
                                        action="{{ route('brands.update', $brand->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Brand Name -->
                                        <fieldset class="name">
                                            <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Brand name" name="name"
                                                id="brandName" value="{{ old('name', $brand->name) }}" required>
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>



                                        <!-- Upload Image -->
                                        <fieldset>
                                            <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                                            <div class="upload-image flex-grow">
                                                <!-- Preview Section -->
                                                <div class="item" id="imgpreview"
                                                    style="{{ $brand->image ? '' : 'display:none;' }}">
                                                    <div class="image-container">
                                                        <img src="{{ asset('storage/' . $brand->image) }}"
                                                            alt="Image Preview for {{ $brand->name }}" id="previewImage"
                                                            style="height: 200px; padding: 20px; object-fit: contain;"
                                                            class="effect8">
                                                        <span class="remove-image" id="removeImage"
                                                            onclick="removeImage()">X</span>
                                                    </div>
                                                </div>

                                                <!-- Upload Section -->
                                                <div id="upload-file" class="item up-load"
                                                    style="{{ $brand->image ? 'display:none;' : '' }}">
                                                    <label class="uploadfile" for="myFile">
                                                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                                                        <span class="body-text">Drop your image here or <span
                                                                class="tf-color">click to browse</span></span>
                                                        <input type="file" id="myFile" name="image" accept="image/*">
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
                                            <button class="tf-button w208" type="submit">Update</button>
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
                const imgPreviewDiv = document.getElementById('imgpreview');
                const previewImage = document.getElementById('previewImage');
                const uploadField = document.getElementById('upload-file');

                if (event.target.files.length > 0) {
                    const src = URL.createObjectURL(event.target.files[0]);
                    previewImage.src = src;
                    imgPreviewDiv.style.display = 'block';
                    uploadField.style.display = 'none';
                }
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

        try {
            const uploadFile = document.getElementById('upload-file');

            uploadFile.addEventListener('dragover', function(event) {
                event.preventDefault();
                uploadFile.classList.add('dragging');
            });

            uploadFile.addEventListener('dragleave', function(event) {
                uploadFile.classList.remove('dragging');
            });

            uploadFile.addEventListener('drop', function(event) {
                event.preventDefault();
                uploadFile.classList.remove('dragging');
                try {
                    const file = event.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const previewImage = document.getElementById('previewImage');
                            const imgPreview = document.getElementById('imgpreview');
                            previewImage.src = e.target.result;
                            imgPreview.style.display = 'block';
                            uploadFile.style.display = 'none';
                        };
                        reader.readAsDataURL(file);
                    }
                } catch (error) {
                    console.error('Error handling file drop:', error);
                }
            });
        } catch (error) {
            console.error('Error setting up drag-and-drop listeners:', error);
        }
    </script>
</body>

</html>
