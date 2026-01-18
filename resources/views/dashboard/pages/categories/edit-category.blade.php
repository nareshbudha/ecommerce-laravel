<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <title>Edit category - Spell E-Commerce</title>
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
                                    <h3>Edit category Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li>
                                            <a href="/dashboard">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <a href="/dashboard/categories">
                                                <div class="text-tiny">Category</div>
                                            </a>
                                        </li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">Edit category</div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Form Section -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Category Name -->
                                        <fieldset class="name">
                                            <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Category name" name="name" id="categoryName" value="{{ old('name', $category->name) }}" required>
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <!-- Category Slug -->
                                        <fieldset class="name">
                                            <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Category slug" name="slug" id="categorySlug" value="{{ old('slug', $category->slug) }}" required>
                                            @error('slug')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <!-- Position in Navbar -->
                                        <fieldset class="position">
                                            <div class="body-title">Position in Navbar</div>
                                            <input class="flex-grow" type="number" placeholder="Enter a number between 1-7" name="position" id="categoryPosition" value="{{ old('position', $category->position) }}" required>
                                            @error('position')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <!-- Upload Image -->
                                        <fieldset>
                                            <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                                            <div class="upload-image flex-grow">
                                                <!-- Preview Section -->
                                                <div class="item" id="imgpreview" style="{{ $category->image ? '' : 'display:none;' }}">
                                                    <div class="image-container">
                                                        <img src="{{ asset('storage/' . $category->image) }}" alt="Image Preview for {{ $category->name }}" id="previewImage" style="height: 200px; padding: 20px; object-fit: contain;" class="effect8">
                                                        <span class="remove-image" id="removeImage" onclick="removeImage()">X</span>
                                                    </div>
                                                </div>

                                                <!-- Upload Section -->
                                                <div id="upload-file" class="item up-load" style="{{ $category->image ? 'display:none;' : '' }}">
                                                    <label class="uploadfile" for="myFile">
                                                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                                                        <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span></span>
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
        // Dynamic slug generation
        document.getElementById('categoryName').addEventListener('input', function () {
            let slug = this.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            document.getElementById('categorySlug').value = slug;
        });

        // Preview Image on File Selection
        document.getElementById('myFile').addEventListener('change', function (event) {
            const imgPreviewDiv = document.getElementById('imgpreview');
            const previewImage = document.getElementById('previewImage');
            const uploadField = document.getElementById('upload-file');

            if (event.target.files.length > 0) {
                const src = URL.createObjectURL(event.target.files[0]);
                previewImage.src = src;
                imgPreviewDiv.style.display = 'block';
                uploadField.style.display = 'none';
            }
        });

        // Remove Image Preview
        function removeImage() {
            const imgPreviewDiv = document.getElementById('imgpreview');
            const uploadField = document.getElementById('upload-file');
            const previewImage = document.getElementById('previewImage');

            previewImage.src = ''; // Clear the image source
            imgPreviewDiv.style.display = 'none';
            uploadField.style.display = 'block';
        }
    </script>
</body>

</html>
