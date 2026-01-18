<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <!-- Head Section: Meta information, styles, and favicon -->
    <title>Edit Slider</title>
    <meta charset="utf-8">
    <meta name="author" content="themesflat.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/assets/images/favicon.ico">
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
        <div id="page" class="">
            <div class="layout-wrap">
                <!-- Sidebar Section -->
                @include('dashboard.components.sidebar')

                <!-- Main Content Area -->
                <div class="section-content-right">
                    <div class="header-dashboard">
                        @include('dashboard.components.navbar')
                    </div>

                    <!-- Main Content Section -->
                    <div class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Edit Slider</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li><a href="/"> <div class="text-tiny">Dashboard</div> </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="/slider"> <div class="text-tiny">Slider</div> </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><div class="text-tiny">Edit Slide</div></li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <form class="form-style-1" action="{{ route('slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <fieldset>
                                            <div class="body-title">Tagline </div>
                                            <input class="flex-grow" type="text" placeholder="Tagline" name="tagline"
                                                value="{{ old('tagline', $slider->tagline) }}" >
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Title</div>
                                            <input class="flex-grow" type="text" placeholder="Title" name="title"
                                                value="{{ old('title', $slider->title) }}" >
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Subtitle </div>
                                            <input class="flex-grow" type="text" placeholder="Subtitle" name="subtitle"
                                                value="{{ old('subtitle', $slider->subtitle) }}" >
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Link</div>
                                            <input class="flex-grow" type="text" placeholder="Link" name="link"
                                                value="{{ old('link', $slider->link) }}">
                                        </fieldset>

                                          <fieldset>
                                            <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                                            <div class="upload-image flex-grow">
                                                <!-- Preview Section -->
                                                <div class="item" id="imgpreview" style="{{  $slider->image ? '' : 'display:none;' }}">
                                                    <div class="image-container">
                                                        <img src="{{ asset('storage/' .  $slider->image) }}"
                                                             alt="Image Preview for {{ $slider->name }}"
                                                             id="previewImage"
                                                             style="height: 200px; padding: 20px; object-fit: contain;"
                                                             class="effect8">
                                                        <span class="remove-image" id="removeImage" onclick="removeImage()">X</span>
                                                    </div>
                                                </div>

                                                <!-- Upload Section -->
                                                <div id="upload-file" class="item up-load"
                                                    style="{{  $slider->image ? 'display:none;' : '' }}">
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

                                        <fieldset>
                                            <div class="body-title">Status</div>
                                            <div class="select flex-grow">
                                                <select name="status">
                                                    <option value="1" @if($slider->status == 1) selected @endif>Active</option>
                                                    <option value="0" @if($slider->status == 0) selected @endif>Inactive</option>
                                                </select>
                                            </div>
                                        </fieldset>

                                        <div class="bot">
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

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
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
