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
            width: 150px;
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
                                <h3>Edit Product</h3>
                                <ul class="breadcrumbs flex items-center gap10">
                                    <li><a href="/dashboard">
                                            <div class="text-tiny">Dashboard</div>
                                        </a></li>
                                    <li><i class="icon-chevron-right"></i></li>
                                    <li><a href="/dashboard/products">
                                            <div class="text-tiny">Products</div>
                                        </a></li>
                                    <li><i class="icon-chevron-right"></i></li>
                                    <li>
                                        <div class="text-tiny">Edit Product</div>
                                    </li>
                                </ul>
                            </div>

                            <form class="tf-section-2 form-add-product"
                                action="{{ route('products.update', $product->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="wg-box">
                                    <!-- Product Name -->
                                    <fieldset class="name">
                                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                                        </div>
                                        <input type="text" name="name" id="productName"
                                            value="{{ old('name', $product->name) }}" placeholder="Enter product name"
                                            required>
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </fieldset>

                                    <!-- Brand -->
                                    <fieldset class="brand">
                                        <div class="body-title mb-10">Brand</div>
                                        <select name="brand_id" required>
                                            <option value="">--Choose Brand--</option>
                                            @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ?
                                                'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </fieldset>

                                    <!-- Category -->
                                    <div class="cols gap22">
                                        <fieldset class="category">
                                            <div class="body-title mb-10">Category</div>
                                            <select name="category_id" id="category_id" required
                                                onchange="getSubCategories()">
                                                <option value="">--Choose category--</option>
                                                @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id ==
                                                    $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </fieldset>


                                        <fieldset class="category">
                                            <div class="body-title mb-10">Sub Category </div>
                                            <select name="sub_category_id" id="sub_category_id">
                                                <option value="">--Choose subcategory--</option>

                                            </select>
                                        </fieldset>
                                    </div>

                                    <!-- Short Description -->
                                    <fieldset class="shortdescription">
                                        <div class="body-title mb-10">Short Description</div>
                                        <textarea name="short_description"
                                            required>{{ old('short_description', $product->short_description) }}</textarea>
                                    </fieldset>

                                    <!-- Description -->
                                    <fieldset class="description">
                                        <div class="body-title mb-10">Description</div>
                                        <textarea name="description"
                                            required>{{ old('description', $product->description) }}</textarea>
                                    </fieldset>
                                </div>

                                <div class="wg-box">
                                    <!-- Main Image -->
                                    <fieldset>
                                        <div class="body-title mb-10">Main Image</div>
                                        <div class="upload-image flex-grow">
                                            <div id="imgpreview" class="item"
                                                style="{{ $product->image ? 'display:block;' : 'display:none;' }}">
                                                <div class="image-container">
                                                    <img id="previewImage"
                                                        src="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                                                        alt="Image Preview"
                                                        style="width:200px;height:200px;object-fit:cover;border-radius:4px;">
                                                    <span class="remove-image" onclick="removeImage()">X</span>
                                                </div>
                                            </div>

                                            <div id="upload-file" class="item up-load"
                                                style="{{ $product->image ? 'display:none;' : 'display:block;' }}">
                                                <label class="uploadfile" for="myFile">
                                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                                    <span class="body-text">Drop your image here or <span
                                                            class="tf-color">click to browse</span></span>
                                                    <input type="file" id="myFile" name="image" accept="image/*">
                                                </label>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- Variants -->
                                    <!-- Variants -->
                                    <fieldset class="shortdescription">
                                        <div class="body-title mb-10">Variants</div>
                                        <div id="variants-container">

                                            @if ($product->variants)
                                            @foreach ($product->variants as $index => $variant)
                                            <hr style="margin:20px 0; border: 1px solid #ccc;">
                                            <!-- Top line between variants -->
                                            <div class="variant-row" data-index="{{ $index }}">
                                                <div class="cols gap22">
                                                    <div class="body-title mb-10">Size
                                                        <input type="text" name="variants[{{ $index }}][size]"
                                                            value="{{ $variant['size'] ?? '' }}">
                                                    </div>
                                                    <div class="body-title mb-10">Color
                                                        <input type="text" name="variants[{{ $index }}][color]"
                                                            value="{{ $variant['color'] ?? '' }}">
                                                    </div>
                                                    <div class="body-title mb-10">Quantity
                                                        <input type="number" name="variants[{{ $index }}][quantity]"
                                                            value="{{ $variant['quantity'] ?? 0 }}">
                                                    </div>
                                                </div>



                                                <fieldset>
                                                    <div class="body-title mb-10">Upload New Variant Images
                                                    </div>
                                                    <div class="upload-image mb-16">
                                                        <div class="item up-load">
                                                            <label class="uploadfile">
                                                                @if (isset($variant['images']))
                                                                <div class="variant-preview">
                                                                    @foreach ($variant['images'] as $img)
                                                                    <div class="image-container">
                                                                        <img src="{{ asset('storage/' . $img) }}"
                                                                            style="width:200px;height:200px;object-fit:cover;border-radius:4px;">
                                                                        <span class="remove-image"
                                                                            onclick="this.parentElement.remove()">&times;</span>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                @endif
                                                                <span class="icon"><i
                                                                        class="icon-upload-cloud"></i></span>
                                                                <span class="text-tiny">Click Here to Browse
                                                                    Image</span>
                                                                <input type="file"
                                                                    name="variants[{{ $index }}][images][]"
                                                                    accept="image/*" multiple
                                                                    class="variant-image-input">
                                                            </label>
                                                        </div>
                                                    </div>
                                                </fieldset>

                                                <div style="display: flex; justify-content: flex-end;">
                                                    <button type="button" class="remove-variant tf-button w208"
                                                        style="background:#e74c3c;">
                                                        Remove Variant
                                                    </button>
                                                </div>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>

                                        <button type="button" id="add-variant" class="tf-button w208"
                                            style="margin-top:20px;">
                                            Add Variant
                                        </button>
                                    </fieldset>


                                    <!-- Pricing and Options -->
                                    <div class="cols gap22">
                                        <fieldset>
                                            <div class="body-title mb-10">Regular Price</div>
                                            <input type="text" name="regular_price"
                                                value="{{ old('regular_price', $product->regular_price) }}" required>
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title mb-10">Sale Price</div>
                                            <input type="text" name="sale_price"
                                                value="{{ old('sale_price', $product->sale_price) }}">
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title mb-10">Coupon</div>
                                            <select name="coupon_id">
                                                <option value="">--Choose Coupon--</option>
                                                @foreach ($coupons as $coupon)
                                                <option value="{{ $coupon->id }}" {{ $product->coupon_id == $coupon->id
                                                    ? 'selected' : '' }}>
                                                    {{ $coupon->code }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </fieldset>
                                    </div>

                                    <!-- Other Info -->
                                    <div class="cols gap22">
                                        <fieldset>
                                            <div class="body-title mb-10">SKU</div>
                                            <input type="text" name="sku" value="{{ $product->sku }}">
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title mb-10">Stock</div>
                                            <select name="stock">
                                                <option value="1" {{ $product->stock ? 'selected' : '' }}>In
                                                    Stock
                                                </option>
                                                <option value="0" {{ !$product->stock ? 'selected' : '' }}>Out of
                                                    Stock
                                                </option>
                                            </select>
                                        </fieldset>
                                        <fieldset>
                                            <div class="body-title mb-10">Featured</div>
                                            <select name="featured">
                                                <option value="0" {{ !$product->featured ? 'selected' : '' }}>No
                                                </option>
                                                <option value="1" {{ $product->featured ? 'selected' : '' }}>Yes
                                                </option>
                                            </select>
                                        </fieldset>
                                        <fieldset>
                                            <fieldset>
                                                <div class="body-title mb-10">New Arrivals</div>
                                                <select name="new_arrivals">
                                                    <option value="0" {{ !$product->new_arrivals ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="1" {{ $product->new_arrivals ? 'selected' : '' }}>Yes
                                                    </option>
                                                </select>
                                            </fieldset>
                                            <fieldset>
                                                <div class="body-title mb-10">Hot Deals</div>
                                                <select name="hot_deals">
                                                    <option value="0" {{ !$product->hot_deals ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="1" {{ $product->hot_deals ? 'selected' : '' }}>Yes
                                                    </option>
                                                </select>
                                            </fieldset>
                                    </div>

                                    <!-- Submit -->
                                    <div class="bot">
                                        <div></div>
                                        <button type="submit" class="tf-button w208">Update Product</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="bottom-page">
                        <div class="body-text">Copyright © 2024 Spell E-Commerce</div>
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
        /* ============================
               MAIN IMAGE PREVIEW & REMOVE
               ============================ */
        const mainInput = document.getElementById('myFile');
        const mainPreviewDiv = document.getElementById('imgpreview');
        const mainPreviewImg = document.getElementById('previewImage');
        const mainUploadDiv = document.getElementById('upload-file');

        mainInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    mainPreviewImg.src = event.target.result;
                    mainPreviewDiv.style.display = 'block';
                    mainUploadDiv.style.display = 'none';
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        function removeMainImage() {
            mainPreviewImg.src = '';
            mainPreviewDiv.style.display = 'none';
            mainUploadDiv.style.display = 'block';
            mainInput.value = '';
        }

        document.querySelector('.remove-image')?.addEventListener('click', removeMainImage);


        /* ============================
           VARIANT IMAGE PREVIEW + REMOVE
           ============================ */
        function setupVariantPreview(input) {
            input.addEventListener('change', function(e) {
                const files = e.target.files;
                if (!files || files.length === 0) return;

                const row = input.closest('.variant-row');
                let previewDiv = row.querySelector('.variant-preview');
                if (!previewDiv) {
                    previewDiv = document.createElement('div');
                    previewDiv.classList.add('variant-preview');
                    input.closest('fieldset').appendChild(previewDiv);
                }

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const container = document.createElement('div');
                        container.classList.add('image-container');

                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.style.width = '200px';
                        img.style.height = '200px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '4px';

                        const removeBtn = document.createElement('span');
                        removeBtn.classList.add('remove-image');
                        removeBtn.innerHTML = '&times;';
                        removeBtn.onclick = () => container.remove();

                        container.appendChild(img);
                        container.appendChild(removeBtn);
                        previewDiv.appendChild(container);
                    };
                    reader.readAsDataURL(file);
                });
            });
        }

        // Attach preview logic to all existing variant image inputs
        document.querySelectorAll('.variant-image-input').forEach(input => {
            setupVariantPreview(input);
        });


        /* ============================
           VARIANT ADD / REMOVE LOGIC
           ============================ */
        const addVariantBtn = document.getElementById('add-variant');
        const variantsContainer = document.getElementById('variants-container');
        let variantIndex = {{ count($product->variants) }};

        // Add a new variant
        addVariantBtn.addEventListener('click', function() {
            const row = document.createElement('div');
            row.classList.add('variant-row');
            row.dataset.index = variantIndex;

            row.innerHTML = `
        <hr style="margin:20px 0; border: 1px solid #ccc;">
        <div class="cols gap22">
            <div class="body-title mb-10">Size
                <input type="text" name="variants[${variantIndex}][size]">
            </div>
            <div class="body-title mb-10">Color
                <input type="text" name="variants[${variantIndex}][color]">
            </div>
            <div class="body-title mb-10">Quantity
                <input type="number" name="variants[${variantIndex}][quantity]" value="0">
            </div>
        </div>

        <fieldset>
            <div class="body-title mb-10">Upload Variant Images</div>
            <div class="upload-image mb-16">
                <div class="item up-load">
                    <label class="uploadfile">
                        <span class="icon"><i class="icon-upload-cloud"></i></span>
                        <span class="text-tiny">Drop your images here or click to browse</span>
                           <div class="variant-preview"></div>
                        <input type="file" name="variants[${variantIndex}][images][]"
                               accept="image/*" multiple class="variant-image-input">
                    </label>
                </div>
            </div>
        </fieldset>
        <div style="display: flex; justify-content: flex-end;">
            <button type="button" class="remove-variant tf-button w208" style="background:#e74c3c;">
                Remove Variant
            </button>
        </div>
    `;

            variantsContainer.appendChild(row);

            // Set up preview and remove instantly
            setupVariantPreview(row.querySelector('.variant-image-input'));
            row.querySelector('.remove-variant').addEventListener('click', () => row.remove());

            variantIndex++;
        });

        // Enable instant remove for existing variants
        document.querySelectorAll('.remove-variant').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.variant-row').remove();
            });
        });


        /* ============================
           CATEGORY → SUBCATEGORY AUTO-LOAD
           ============================ */
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            const subCategorySelect = document.getElementById('sub_category_id');
            const selectedSubCategory = "{{ old('sub_category_id', $product->sub_category_id) }}";

            function loadSubCategories(categoryId, preselectedId = null) {
                if (!categoryId) return;
                fetch(`/get-subcategories/${categoryId}`)
                    .then(res => res.json())
                    .then(data => {
                        subCategorySelect.innerHTML = '<option value="">--Choose subcategory--</option>';
                        data.forEach(sub => {
                            const option = document.createElement('option');
                            option.value = sub.id;
                            option.textContent = sub.name;
                            if (preselectedId && sub.id == preselectedId) option.selected = true;
                            subCategorySelect.appendChild(option);
                        });
                    })
                    .catch(err => console.error("Error loading subcategories:", err));
            }

            // Load subcategories for the current category on load
            loadSubCategories(categorySelect.value, selectedSubCategory);

            // Reload when category changes
            categorySelect.addEventListener('change', function() {
                loadSubCategories(this.value);
            });
        });
    </script>


</html>
