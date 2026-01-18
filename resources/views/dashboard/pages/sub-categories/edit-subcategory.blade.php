@php
    $categories = \App\Models\Category::all();
@endphp
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <!-- Head Section: Meta information, styles, and favicon -->
    <title>Spell E-Commerce</title>
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="/assets/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/animation.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/assets/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
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
        <!-- Page Wrapper -->
        <div id="page" class="">
            <div class="layout-wrap">
                <!-- Sidebar Section -->
                @include('dashboard.components.sidebar')

                <!-- Main Content Area -->
                <div class="section-content-right">
                    <!-- Header Section -->
                    <div class="header-dashboard">
                       @include('dashboard.components.navbar')
                    </div>

                    <!-- Main Content Section -->
                    <div class="main-content">
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Edit Sub Category </h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="#">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="text-tiny">Categories</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Edit SubCategory</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" action="{{ route('sub-categories.update', $sub_category->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <fieldset class="name">
                                            <div class="body-title">Sub Category Name <span class="tf-color-1">*</span></div>
                                            <input class="flex-grow" type="text" placeholder="Sub Category Name" id="subcategoryname" value="{{ old('name', $sub_category->name) }}" name="name" required>
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>
                                        <fieldset class="name">
                                            <div class="body-title">Category Name <span class="tf-color-1">*</span></div>

                                            <select class="flex-grow" name="category_id" required>
                                                <option value="" disabled selected>Select a Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $sub_category->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>
                                        <fieldset class="name">
                                            <div class="body-title">Sub Category Slug <span class="tf-color-1">*</span>
                                            </div>
                                            <input class="flex-grow" type="text" placeholder="Sub Category Slug" name="slug" id="subcategorySlug"
                                                tabindex="0" value="{{ old('slug', $sub_category->slug) }}" aria-required="true" required="">
                                                @error('slug')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                                            <div class="upload-image flex-grow">
                                                <!-- Preview Section -->
                                                <div class="item" id="imgpreview" style="{{ $sub_category->image ? '' : 'display:none;' }}">
                                                    <div class="image-container">
                                                        <img src="{{ asset('storage/' . $sub_category->image) }}"
                                                             alt="Image Preview for {{ $sub_category->name }}"
                                                             id="previewImage"
                                                             style="height: 200px; padding: 20px; object-fit: contain;"
                                                             class="effect8">
                                                        <span class="remove-image" id="removeImage" onclick="removeImage()">X</span>
                                                    </div>
                                                </div>

                                                <!-- Upload Section -->
                                                <div id="upload-file" class="item up-load"
                                                    style="{{ !$sub_category->image ? 'display:none;' : '' }}">
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
                                        <div class="bot">
                                            <div></div>
                                            <button class="tf-button w208" type="submit">Update</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div class="bottom-page">
                            <div class="body-text">Copyright © 2024 Spell E-Commerce</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

     <!-- Scripts Section -->
     <script src="/assets/js/jquery.min.js"></script>
     <script src="/assets/js/bootstrap.min.js"></script>
     <script src="/assets/js/bootstrap-select.min.js"></script>
     <script src="/assets/js/apexcharts/apexcharts.js"></script>
     <script src="/assets/js/main.js"></script>
     <script>
         document.getElementById('subcategoryname').addEventListener('input', function () {
             let slug = this.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
             document.getElementById('subcategorySlug').value = slug;
         });

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
