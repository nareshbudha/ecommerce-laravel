@php
$Brands = \App\Models\Brand::all();
$categories = \App\Models\Category::all();
$subCategories = \App\Models\SubCategory::all();
$coupons = \App\Models\Coupon::all();
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
            width: 100px;
            height: 100px;
            object-fit: contain;
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

                        <!-- main-content-wrap -->
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Add Product</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index-2.html">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="/dashboard/products">
                                                <div class="text-tiny">Products</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Add product</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- form-add-product -->
                                <form class="tf-section-2 form-add-product" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="wg-box">
                                        <fieldset class="name">
                                            <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                                            </div>
                                            <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="" aria-required="true" id="productName" required="">
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                        </fieldset>


                                        <fieldset class="brand">
                                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span>
                                            </div>
                                            <select name="brand_id" required>
                                                <option>--Choose Brand--</option>
                                                @foreach ($Brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                        <div class="gap22 cols">
                                            <fieldset class="category">
                                                <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                                                </div>
                                                <select name="category_id" id="category_id" required onchange="getSubCategories()">
                                                    <option value="">--Choose category--</option>
                                                    @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </fieldset>

                                            <fieldset class="category">
                                                <div class="body-title mb-10">Sub Category <span class="tf-color-1">*</span> </div>
                                                <select name="sub_category_id" id="sub_category_id">
                                                    <option value="">--Choose subcategory--</option>

                                                </select>
                                            </fieldset>
                                        </div>



                                        <fieldset class="shortdescription">
                                            <div class="body-title mb-10">Short Description </div>
                                            <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true" required=""></textarea>
                                            @error('short_description')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                        </fieldset>

                                        <fieldset class="description">
                                            <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                                            </div>
                                            <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required=""></textarea>
                                            @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                    </div>
                                    <div class="wg-box">
                                        <fieldset>
                                            <div class="body-title  mb-16">Upload images <span class="tf-color-1">*</span>
                                            </div>
                                            <div class="upload-image flex-grow">
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
                                        <fieldset class="shortdescription">
                                               <hr style="margin:20px 0; border: 1px solid:red; color:red;">
                                            <div class="body-title mb-10">Variant <span class="tf-color-1">*</span></div>
                                            <div id="variants-container">
                                                <!-- First Variant Row -->
                                                <div class="variant-row" data-index="0">
                                                    <div class="cols gap22">
                                                        <div class="body-title mb-10">Size <span class="tf-color-1">*</span>
                                                            <input type="text" name="variants[0][size]" placeholder="Size">
                                                        </div>
                                                        <div class="body-title mb-10">Color <span class="tf-color-1">*</span>
                                                            <input type="text" name="variants[0][color]" placeholder="Color">
                                                        </div>
                                                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                                                            <input type="number" name="variants[0][quantity]" placeholder="Quantity">
                                                        </div>
                                                    </div>

                                                    <fieldset>
                                                        <div class="body-title mb-10">Upload Variant Images <span class="tf-color-1">*</span></div>
                                                        <div class="upload-image mb-16">
                                                            <div class="item up-load">
                                                                <label class="uploadfile">
                                                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                                                      <div class="variant-preview" id="preview-0"></div>
                                                                    <span class="text-tiny"> <span class="tf-color">click to browse</span></span>
                                                                    <input type="file" name="variants[0][images][]" accept="image/*" multiple class="variant-images">
                                                                </label>
                                                            </div>
                                                        </div>
                                                      
                                                    </fieldset>
                                                </div>
                                            </div>

                                            <button type="button" id="add-variant" class="tf-button w208">Add Variant</button>
                                        </fieldset>







                                        <div class="cols gap22">
                                            <fieldset class="name">
                                                <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                                                <input class="mb-10" type="text" placeholder="Enter regular price" name="regular_price" tabindex="0" value="" aria-required="true" required="">
                                                @error('regular_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </fieldset>
                                            <fieldset class="name">
                                                <div class="body-title mb-10">Sale Price </div>
                                                <input class="mb-10" type="text" placeholder="Enter sale price" name="sale_price" tabindex="0" value="">
                                                @error('sale_price')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </fieldset>

                                            <fieldset class="Discount Coupon">
                                                <div class="body-title mb-10">Discount Coupon
                                                </div>
                                                <select name="coupon_id" id="coupon_id">
                                                    <option value="">--Choose Coupon--</option>
                                                    @foreach ($coupons as $coupon)
                                                    <option value="{{ $coupon->id }}">{{ $coupon->code }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>


                                        <div class="cols gap22">
                                            <fieldset class="name">
                                                <div class="body-title mb-10">SKU
                                                </div>
                                                <input class="mb-10" type="text" placeholder="Enter SKU" name="sku" tabindex="0" value="" aria-required="true">
                                                @error('sku')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </fieldset>
                             
                                    </div>

                                    <div class="cols gap22">
                                        <fieldset class="name">
                                            <div class="body-title mb-10">Stock</div>
                                            <div class="select mb-10">
                                                <select class="" name="stock">
                                                    <option value="1">InStock</option>
                                                    <option value="0">Out of Stock</option>
                                                </select>
                                            </div>
                                            @error('stock')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>
                                        <fieldset class="name">
                                            <div class="body-title mb-10">Featured</div>
                                            <div class="select mb-10">
                                                <select class="" name="featured">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            @error('featured')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>
                                        <fieldset class="name">
                                            <div class="body-title mb-10">New Arrivals</div>
                                            <div class="select mb-10">
                                                <select class="" name="new_arrivals">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            @error('new_arrivals')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>
                                        <fieldset class="name">
                                            <div class="body-title mb-10">Hot Deal</div>
                                            <div class="select mb-10">
                                                <select class="" name="hot_deals">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                            @error('hot_deals')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>
                                    </div>
                                    <div class="bot">
                                        <div></div>
                                        <button class="tf-button w208" type="submit">Save</button>
                                    </div>
                            </div>
                            </form>
                            <!-- /form-add-product -->
                        </div>
                        <!-- /main-content-wrap -->
                    </div>
                    <!-- /main-content-wrap -->

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
        let variantIndex = 1; // Next variant index

        // Function to handle image preview for any variant
        function handleVariantPreview(inputElement, previewContainer) {
            inputElement.addEventListener('change', function() {
                previewContainer.innerHTML = '';
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgDiv = document.createElement('div');
                        imgDiv.classList.add('preview-image-container');

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('preview-image');

                        const removeBtn = document.createElement('span');
                        removeBtn.classList.add('remove-btn');
                        removeBtn.innerHTML = '&times;';
                        removeBtn.onclick = () => imgDiv.remove();

                        imgDiv.appendChild(img);
                        imgDiv.appendChild(removeBtn);
                        previewContainer.appendChild(imgDiv);
                    };
                    reader.readAsDataURL(file);
                });
            });
        }

        // Attach preview for the default first variant (index 0)
        const defaultVariantInput = document.querySelector('.variant-row[data-index="0"] .variant-images');
        const defaultPreviewContainer = document.getElementById('preview-0');
        handleVariantPreview(defaultVariantInput, defaultPreviewContainer);

        // Add new variants dynamically
        document.getElementById('add-variant').addEventListener('click', function() {
            const container = document.getElementById('variants-container');
            const row = document.createElement('div');
            row.classList.add('variant-row');
            row.dataset.index = variantIndex;

            row.innerHTML = `

                 <div class="body-title mb-10">Additional Variant </div>
                      <hr style="margin:20px 0; border: 1px solid:red; color:red;">
        <div class="cols gap22">

            <div class="body-title mb-10">Size <span class="tf-color-1">*</span>
                <input type="text" name="variants[${variantIndex}][size]" placeholder="Size">
            </div>
            <div class="body-title mb-10">Color <span class="tf-color-1">*</span>
                <input type="text" name="variants[${variantIndex}][color]" placeholder="Color">
            </div>
            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span>
                <input type="number" name="variants[${variantIndex}][quantity]" placeholder="Quantity">
            </div>
        </div>
        <fieldset>
            <div class="body-title mb-10">Upload Variant Images <span class="tf-color-1">*</span></div>
            <div class="upload-image mb-16">
                <div class="item up-load">
                    <label class="uploadfile">
                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                        <span class="text-tiny">Drop your images here or <span class="tf-color">click to browse</span></span>
                          <div class="variant-preview" id="preview-${variantIndex}"></div>
                        <input type="file" name="variants[${variantIndex}][images][]" accept="image/*" multiple class="variant-images">
                    </label>
                </div>
            </div>
          
        </fieldset>
        <div style="display: flex; justify-content: flex-end;">
            <button type="button" class="remove-variant tf-button w208">Remove</button>
        </div>
    `;

            container.appendChild(row);

            // Attach preview for this new variant
            const newVariantInput = row.querySelector('.variant-images');
            const newPreviewContainer = row.querySelector('.variant-preview');
            handleVariantPreview(newVariantInput, newPreviewContainer);

            // Remove variant row when clicking remove
            row.querySelector('.remove-variant').addEventListener('click', () => row.remove());

            variantIndex++;
        });


        function getSubCategories() {
            const categoryId = document.getElementById('category_id').value;
            const subCategorySelect = document.getElementById('sub_category_id');
            subCategorySelect.innerHTML = '<option value="">--Choose subcategory--</option>';

            if (!categoryId) return;

            fetch(`/get-subcategories/${categoryId}`)
                .then(response => {
                    if (!response.ok) throw new Error("Network response was not ok");
                    return response.json();
                })
                .then(data => {
                    console.log("Loaded subcategories:", data); // Add this
                    if (data.length === 0) {
                        subCategorySelect.innerHTML = '<option value="">No subcategories found</option>';
                        return;
                    }
                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subCategorySelect.appendChild(option);
                    });
                })
                .catch(err => console.error("Error loading subcategories:", err));
        }




        document.getElementById('myFile').addEventListener('change', function(event) {
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
    <script>
        function previewImages() {
            var previewContainer = document.getElementById('preview-container');
            var galUpload = document.getElementById('galUpload'); // Upload section to hide

            previewContainer.innerHTML = ''; // Clear any existing previews

            var files = document.getElementById('gFile').files;

            if (files.length > 0) {
                // Hide the upload section after files are selected
                galUpload.style.display = 'none';
            }

            // Loop through each selected file
            for (var i = 0; i < files.length; i++) {
                var file = files[i];

                // Only process image files
                if (!file.type.startsWith('image/')) {
                    continue;
                }

                var reader = new FileReader();

                reader.onload = (function(file) {
                    return function(e) {
                        var imgElement = document.createElement('div');
                        imgElement.classList.add('preview-image-container');

                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('preview-image');

                        // Create the remove button (cross)
                        var removeButton = document.createElement('span');
                        removeButton.classList.add('remove-btn');
                        removeButton.innerHTML = '&times;'; // Cross symbol

                        // Add click event to remove image
                        removeButton.onclick = function() {
                            imgElement.remove(); // Remove the image container
                            checkIfEmpty(); // Check if the preview container is empty
                        };

                        // Append the image and remove button to the container
                        imgElement.appendChild(img);
                        imgElement.appendChild(removeButton);

                        // Add the image container to the preview container
                        previewContainer.appendChild(imgElement);
                    };
                })(file);

                reader.readAsDataURL(file);
            }
        }

        // Function to check if preview container is empty and show upload section
        function checkIfEmpty() {
            var previewContainer = document.getElementById('preview-container');
            var galUpload = document.getElementById('galUpload');
            if (previewContainer.children.length === 0) {
                galUpload.style.display = 'block'; // Show the upload section again if no images
            }
        }

    </script>

    <style>
        .preview-image-container {
            display: inline-block;
            position: relative;
            margin: 5px;
        }

        .preview-image {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .remove-btn {
            position: absolute;
            top: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }

    </style>


</body>

</html>
