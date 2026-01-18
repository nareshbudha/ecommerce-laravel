<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Edit Company - Spell E-Commerce</title>
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
    <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
    <style>
        #previewImage { width: 100px; height: 100px; object-fit: contain; }
        .remove-image { position:absolute; top:0; right:0; background:rgba(0,0,0,0.6); color:white; border-radius:50%; padding:5px; cursor:pointer; }
        .image-container { position:relative; display:inline-block; }
        .preview-image-container { display:inline-block; position:relative; margin:5px; }
        .preview-image { width:100px; height:100px; object-fit:cover; }
        .remove-btn { position:absolute; top:0; right:0; background:rgba(0,0,0,0.5); color:white; border-radius:50%; padding:5px; cursor:pointer; }
    </style>
</head>
<body class="body">
<div id="wrapper">
    <div id="page">
        <div class="layout-wrap">
            @include('dashboard.components.sidebar')
            <div class="section-content-right">
                <div class="header-dashboard">@include('dashboard.components.navbar')</div>
                <div class="main-content">
                    <div class="main-content-inner">
                        <div class="main-content-wrap">
                            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                <h3>Edit Company</h3>
                                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                    <li><a href="index-2.html"><div class="text-tiny">Dashboard</div></a></li>
                                    <li><i class="icon-chevron-right"></i></li>
                                    <li><a href="{{ route('company.index') }}"><div class="text-tiny">Company</div></a></li>
                                    <li><i class="icon-chevron-right"></i></li>
                                    <li><div class="text-tiny">Edit Company</div></li>
                                </ul>
                            </div>

                            <form class="tf-section-2 form-edit-company" action="{{ route('company.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="wg-box">
                                    <fieldset class="name">
                                        <div class="body-title mb-10">Company Name <span class="tf-color-1">*</span></div>
                                        <input class="mb-10" type="text" placeholder="Enter Company name" name="name" value="{{ old('name', $company->name) }}">
                                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </fieldset>

                                    <fieldset class="Address">
                                        <div class="body-title mb-10">Company Address <span class="tf-color-1">*</span></div>
                                        <input class="mb-10" type="text" placeholder="Enter Company Address" name="address" value="{{ old('address', $company->address) }}">
                                        @error('address') <div class="text-danger">{{ $message }}</div> @enderror
                                    </fieldset>

                                    <div class="cols gap22">
                                        <fieldset class="Email">
                                            <div class="body-title mb-10">Company Email <span class="tf-color-1">*</span></div>
                                            <input class="mb-10" type="email" placeholder="Enter Company Email" name="email" value="{{ old('email', $company->email) }}">
                                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="Phone">
                                            <div class="body-title mb-10">Company Phone <span class="tf-color-1">*</span></div>
                                            <input class="mb-10" type="text" placeholder="Enter Company Phone" name="phone" value="{{ old('phone', $company->phone) }}">
                                            @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                    </div>

                                    <div class="cols gap22">
                                        <fieldset class="tax_id">
                                            <div class="body-title mb-10">Company Tax Id</div>
                                            <input class="mb-10" type="text" placeholder="Enter Company Tax Id" name="tax_id" value="{{ old('tax_id', $company->tax_id) }}">
                                            @error('tax_id') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="Description">
                                            <div class="body-title mb-10">Company Description <span class="tf-color-1">*</span></div>
                                            <input class="mb-10" type="text" placeholder="Enter Company Description" name="description" value="{{ old('description', $company->description) }}">
                                            @error('description') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                    </div>

                                    <div class="cols gap22">
                                        <fieldset class="Registration Number">
                                            <div class="body-title mb-10">Company Registration Number</div>
                                            <input class="mb-10" type="text" placeholder="Enter Company Registration Number" name="registration_number" value="{{ old('registration_number', $company->registration_number) }}">
                                            @error('registration_number') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="Established Date">
                                            <div class="body-title mb-10">Company Established Date</div>
                                            <input class="mb-10" type="date" placeholder="Enter Company Established Date" name="established_date" value="{{ old('established_date', $company->established_date) }}">
                                            @error('established_date') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                    </div>

                                    <div class="cols gap22">
                                        <fieldset class="tax_id">
                                            <div class="body-title mb-10">Company Facebook</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Facebook" name="facebook" value="{{ old('facebook', $company->facebook) }}">
                                            @error('facebook') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="Instragram">
                                            <div class="body-title mb-10">Company Instagram</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Instagram" name="instagram" value="{{ old('instagram', $company->instagram) }}">
                                            @error('instagram') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="Tiktok">
                                            <div class="body-title mb-10">Company Tiktok</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Tiktok" name="tiktok" value="{{ old('tiktok', $company->tiktok) }}">
                                            @error('tiktok') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                    </div>

                                    <div class="cols gap22">
                                        <fieldset class="website">
                                            <div class="body-title mb-10">Company Youtube</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Youtube" name="youtube" value="{{ old('youtube', $company->youtube) }}">
                                            @error('youtube') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="pinterest">
                                            <div class="body-title mb-10">Company Pinterest</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Pinterest" name="pinterest" value="{{ old('pinterest', $company->pinterest) }}">
                                            @error('pinterest') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="snapchat">
                                            <div class="body-title mb-10">Company Snapchat</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Snapchat" name="snapchat" value="{{ old('snapchat', $company->snapchat) }}">
                                            @error('snapchat') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                    </div>

                                </div>

                                <div class="wg-box">
                                    <div class="cols gap22">
                                        <fieldset class="website">
                                            <div class="body-title mb-10">Company Website</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Web Site" name="website" value="{{ old('website', $company->website) }}">
                                            @error('website') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="github">
                                            <div class="body-title mb-10">Company Github</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Github" name="github" value="{{ old('github', $company->github) }}">
                                            @error('github') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                        <fieldset class="linkedin">
                                            <div class="body-title mb-10">Company Linkedin</div>
                                            <input class="mb-10" type="url" placeholder="Enter Company Linkedin" name="linkedin" value="{{ old('linkedin', $company->linkedin) }}">
                                            @error('linkedin') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>
                                    </div>

                                    <fieldset>
                                        <div class="body-title mb-16">Upload Logo <span class="tf-color-1">*</span></div>
                                        <div class="upload-image flex-grow">
                                            @if($company->logo)
                                            <div class="image-container" id="imgpreview">
                                                <img src="{{ asset('storage/'.$company->logo) }}" alt="Image Preview" id="previewImage" class="effect8">
                                                <span class="remove-image" onclick="removeImage()">X</span>
                                            </div>
                                            @endif
                                            <div id="upload-file" class="item up-load">
                                                <label class="uploadfile" for="logo">
                                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                                    <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span></span>
                                                    <input type="file" id="logo" name="logo" accept="image/*">
                                                </label>
                                            </div>
                                        </div>
                                        @error('logo') <div class="text-danger">{{ $message }}</div> @enderror
                                    </fieldset>

                                    <div class="bot">
                                        <div></div>
                                        <button class="tf-button w208" type="submit">Update</button>
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
</div>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/bootstrap-select.min.js"></script>
<script src="/assets/js/main.js"></script>
<script>
    const logoInput = document.getElementById('logo');
    const preview = document.getElementById('previewImage');
    const previewContainer = document.getElementById('imgpreview');

    logoInput.addEventListener('change', function(e){
        const file = e.target.files[0];
        if(file){
            if(preview) preview.src = URL.createObjectURL(file);
            if(previewContainer) previewContainer.style.display = 'inline-block';
        }
    });

    function removeImage(){
        if(preview) preview.src = '';
        logoInput.value = '';
        if(previewContainer) previewContainer.style.display = 'none';
    }
</script>
</body>
</html>
