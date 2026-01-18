<!DOCTYPE html>

<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Add Shipping Detail - Spell E-Commerce</title>
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="/assets/css/bootstrap.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/assets/font/fonts.css">
    <link rel="stylesheet" href="/assets/icon/style.css">
</head>

<body class="body">
    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap">
                @include('dashboard.components.sidebar')

                ```
                <div class="section-content-right">
                    <div class="header-dashboard">
                        @include('dashboard.components.navbar')
                    </div>

                    <div class="main-content">
                        <div class="main-content-inner">
                            <div class="main-content-wrap">

                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Add Shipping Details</h3>
                                    <ul class="breadcrumbs flex items-center gap10">
                                        <li><a href="/dashboard">
                                                <div class="text-tiny">Dashboard</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li><a href="{{ route('shipping.index') }}">
                                                <div class="text-tiny">Shipping</div>
                                            </a></li>
                                        <li><i class="icon-chevron-right"></i></li>
                                        <li>
                                            <div class="text-tiny">New Shipping</div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Success Message -->
                                @if(session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                <!-- Form Section -->
                                <div class="wg-box">
                                    <form class="form-new-product form-style-1" action="{{ route('shipping.store') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <fieldset>
                                            <div class="body-title">Province *</div>
                                            <select id="province" name="province" required>
                                                <option value="">----Select Province----</option>
                                            </select>
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">District *</div>
                                            <select id="district" name="district" required>
                                                <option value="">----Select District----</option>
                                            </select>
                                        </fieldset>

                                        <fieldset class="shortdescription">

                                            <div class="body-title mb-10">Local Level <span class="tf-color-1">*</span>
                                            </div>
                                            <div id="variants-container">
                                                <div class="variant-row" data-index="0">
                                                    <div class="cols gap22">
                                                        <div class="variant-row" data-index="0">
                                                            <div class="cols gap22">
                                                                <div class="body-title mb-10">
                                                                    Local Level <span class="tf-color-1">*</span>
                                                                    <select class="local_level_select"
                                                                        name="local_level" required>
                                                                        <option value="">----Select Local Level----
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="body-title mb-10">
                                                                    Local level Type <span class="tf-color-1">*</span>
                                                                    <input type="text"
                                                                        class="local_level_type_input form-control"
                                                                        name="local_level_type" value="" required>
                                                                </div>
                                                                <div class="body-title mb-10">
                                                                    Rate <span class="tf-color-1">*</span>
                                                                    <input type="number" name="[0][rate]"
                                                                        placeholder="Rate">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" id="add-variant" class="tf-button w208">Add Local
                                                Level</button>
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Method</div>
                                            <select class="flex-grow" id="method" name="method">
                                                <option value="">-- Select Method --</option>
                                                <option value="standard" {{ old('method')=='standard' ? 'selected' : ''
                                                    }}>Standard</option>
                                                <option value="express" {{ old('method')=='express' ? 'selected' : ''
                                                    }}>Express</option>
                                                <option value="urgent" {{ old('method')=='urgent' ? 'selected' : '' }}>
                                                    Urgent</option>
                                            </select>
                                            @error('method') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Estimated Delivery</div>
                                            <input class="flex-grow" type="date" placeholder="Estimated Delivery"
                                                id="estimated_delivery" name="estimated_delivery"
                                                value="{{ old('estimated_delivery') }}">
                                            @error('estimated_delivery') <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Notes</div>
                                            <input class="flex-grow" type="text" placeholder="Say Something" id="notes"
                                                name="notes" value="{{ old('notes') }}">
                                            @error('notes') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>

                                        <div class="bot">
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

<script>$(document).ready(function() {
    let provinces = [], districts = [], local_levels = [], local_level_types = [];

    const oldProvince = "{{ old('province', $address->province ?? '') }}";
    const oldDistrict = "{{ old('district', $address->district ?? '') }}";
    const oldLocalLevel = "{{ old('local_level', $address->local_level ?? '') }}";

    $.getJSON('/assets/data/provinces.json', data => { provinces = data; populateProvinces(); });
    $.getJSON('/assets/data/districts.json', data => { districts = data; });
    $.getJSON('/assets/data/local_levels.json', data => { local_levels = data; });
    $.getJSON('/assets/data/local_level_type.json', data => { local_level_types = data; });

    function populateProvinces() {
        $('#province').html('<option value="">----Select Province----</option>');
        provinces.forEach(p => {
            const selected = p.name === oldProvince ? 'selected' : '';
            $('#province').append(`<option value="${p.name}" ${selected}>${p.name}</option>`);
        });
        if (oldProvince) populateDistricts(oldProvince);
    }

    function populateDistricts(province_name) {
        $('#district').html('<option value="">----Select District----</option>');
        districts.filter(d => provinces.find(p => p.province_id === d.province_id).name === province_name)
                 .forEach(d => {
                     const selected = d.name === oldDistrict ? 'selected' : '';
                     $('#district').append(`<option value="${d.name}" ${selected}>${d.name}</option>`);
                 });
        if (oldDistrict) populateLocalLevels(oldDistrict);
    }

    function populateLocalLevels(district_name) {
        $('.local_level_select').each(function() {
            const $select = $(this);
            const oldVal = oldLocalLevel;
            $select.html('<option value="">----Select Local Level----</option>');
            local_levels.filter(l => districts.find(d => d.district_id === l.district_id).name === district_name)
                        .forEach(l => {
                            const selected = l.name === oldVal ? 'selected' : '';
                            $select.append(`<option value="${l.name}" data-type-id="${l.local_level_type_id}" ${selected}>${l.name}</option>`);
                        });
            const selectedTypeId = $select.find('option:selected').data('type-id');
            const typeName = selectedTypeId ? local_level_types.find(t => t.local_level_type_id == selectedTypeId).name : '';
            $select.closest('.variant-row').find('.local_level_type_input').val(typeName);
        });
    }

    $('#variants-container').on('change', '.local_level_select', function() {
        const selectedTypeId = $(this).find('option:selected').data('type-id');
        const typeName = selectedTypeId ? local_level_types.find(t => t.local_level_type_id == selectedTypeId).name : '';
        $(this).closest('.variant-row').find('.local_level_type_input').val(typeName);
    });

    $('#province').change(function() {
        const province_name = $(this).val();
        if (province_name) populateDistricts(province_name);
        else {
            $('#district').html('<option value="">----Select District----</option>');
            $('.local_level_select').html('<option value="">----Select Local Level----</option>');
            $('.local_level_type_input').val('');
        }
    });

    $('#district').change(function() {
        const district_name = $(this).val();
        if (district_name) populateLocalLevels(district_name);
        else {
            $('.local_level_select').html('<option value="">----Select Local Level----</option>');
            $('.local_level_type_input').val('');
        }
    });

    $('#add-variant').click(function() {
        const newRow = $('.variant-row:first').clone();
        const variantIndex = $('.variant-row').length;
        newRow.attr('data-index', variantIndex);
        newRow.find('select').val('');
        newRow.find('input[type="text"], input[type="number"]').val('');
        newRow.find('input[name^="[0][rate]"]').attr('name', `[${variantIndex}][rate]`);
        $('#variants-container').append(newRow);
    });

    // **Serialize local levels to JSON on submit**
    $('form').submit(function(e) {
        const localLevelsData = [];

        $('.variant-row').each(function() {
            const name = $(this).find('.local_level_select').val();
            const type = $(this).find('.local_level_type_input').val();
            const rate = $(this).find(`input[name^="[${$(this).data('index')}][rate]"]`).val();

            if (name && type && rate) {
                localLevelsData.push({ name, type, rate });
            }
        });

        // Remove existing select to avoid conflict
        $('.local_level_select').remove();

        // Append hidden input with JSON string
        $('<input>').attr({
            type: 'hidden',
            name: 'local_level',
            value: JSON.stringify(localLevelsData)
        }).appendTo('form');
    });
});
</script>


</body>

</html>
