<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
    <title>Edit Shipping Details - Spell E-Commerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
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
                                    <h3>Edit Shipping Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li><a href="/dashboard">
                                                <div class="text-tiny">Dashboard</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="{{ route('tax.index') }}">
                                                <div class="text-tiny">Tax</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">Edit Tax</div>
                                        </li>
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
                                    <form class="form-new-product form-style-1"
                                        action="{{ route('tax.update', $tax->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Location -->
                                        <fieldset>
                                            <div class="body-title">Name </div>
                                            <input class="flex-grow" type="text" placeholder="Name" id="name"
                                                name="name" value="{{ old('name', $tax->name) }}">
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <!-- Rate -->
                                        <fieldset>
                                            <div class="body-title">Value</div>
                                            <input class="flex-grow" type="text" placeholder="30%" id="value"
                                                name="value" value="{{ old('value', $tax->value) }}">
                                            @error('value')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <!-- Method -->
                                        <fieldset>
                                            <div class="body-title">Is Active </div>
                                            <select class="flex-grow" id="is_active" name="is_active">
                                                <option value="">-- Select is_active --</option>
                                                <option value="1" {{ old('is_active', $tax->is_active)=='1' ? 'selected'
                                                    : '' }}>Yes</option>
                                                <option value="0" {{ old('is_active', $tax->is_active)=='0' ? 'selected'
                                                    : '' }}>No</option>

                                            </select>
                                            @error('is_active')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>



                                        <!-- Submit -->
                                        <div class="bot">
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
</body>

</html>
