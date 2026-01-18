<!DOCTYPE html>

<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Edit Shipping Details - Spell E-Commerce</title>
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
                                    <h3>Edit Shipping Details</h3>
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
                                            <div class="text-tiny">Edit Shipping</div>
                                        </li>
                                    </ul>
                                </div>

                                @if(session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                <div class="wg-box">
                                    <form class="form-new-product form-style-1"
                                        action="{{ route('shipping.update', $shipping->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

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
                                            <div class="body-title mb-10">Local Levels *</div>
                                            <div id="variants-container">
                                                @foreach($localLevels ??
                                                [['name'=>'','type'=>'','rate'=>'','district_id'=>'']] as $index =>
                                                $level)
                                                <div class="variant-row" data-index="{{ $index }}"
                                                    data-district-id="{{ $level['district_id'] ?? '' }}">
                                                    <div class="cols gap22">
                                                        <div class="body-title mb-10">
                                                            Local Level *
                                                            <select class="local_level_select" required></select>
                                                        </div>
                                                        <div class="body-title mb-10">
                                                            Local Level Type *
                                                            <input type="text"
                                                                class="local_level_type_input form-control"
                                                                name="local_level_type"
                                                                value="{{ $level['type'] ?? '' }}" required>
                                                        </div>
                                                        <div class="body-title mb-10">
                                                            Rate *
                                                            <input type="number" name="[{{ $index }}][rate]"
                                                                placeholder="Rate" value="{{ $level['rate'] ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach

                                            </div>
                                            <button type="button" id="add-variant" class="tf-button w208">Add Local
                                                Level</button>
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Method *</div>
                                            <select class="flex-grow" id="method" name="method" required>
                                                <option value="">-- Select Method --</option>
                                                <option value="standard" {{ old('method', $shipping->method)=='standard'
                                                    ? 'selected' : '' }}>Standard</option>
                                                <option value="express" {{ old('method', $shipping->method)=='express' ?
                                                    'selected' : '' }}>Express</option>
                                                <option value="urgent" {{ old('method', $shipping->method)=='urgent' ?
                                                    'selected' : '' }}>Urgent</option>
                                            </select>
                                            @error('method') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Estimated Delivery</div>
                                            <input class="flex-grow" type="date" id="estimated_delivery"
                                                name="estimated_delivery"
                                                value="{{ old('estimated_delivery', $shipping->estimated_delivery) }}">
                                            @error('estimated_delivery') <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </fieldset>

                                        <fieldset>
                                            <div class="body-title">Notes</div>
                                            <input class="flex-grow" type="text" id="notes" name="notes"
                                                value="{{ old('notes', $shipping->notes) }}">
                                            @error('notes') <div class="text-danger">{{ $message }}</div> @enderror
                                        </fieldset>

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
        ```

    </div>

    <script src="/assets/js/jquery.min.js"></script>

    <script src="/assets/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
    let provinces = [], districts = [], local_levels = [], local_level_types = [];
    const oldProvince = "{{ old('province', $shipping->province ?? '') }}";
    const oldDistrict = "{{ old('district', $shipping->district ?? '') }}";
    const oldLocalLevels = @json($localLevels ?? []);

    // Load JSON data
    $.when(
        $.getJSON('/assets/data/provinces.json', data => { provinces = data; }),
        $.getJSON('/assets/data/districts.json', data => { districts = data; }),
        $.getJSON('/assets/data/local_levels.json', data => { local_levels = data; }),
        $.getJSON('/assets/data/local_level_type.json', data => { local_level_types = data; })
    ).done(function() {
        populateProvinces();
        if(oldProvince) populateDistricts(oldProvince, true);
    });

    function populateProvinces() {
        const $province = $('#province');
        $province.html('<option value="">----Select Province----</option>');
        provinces.forEach(p => {
            const selected = (p.name === oldProvince) ? 'selected' : '';
            $province.append(`<option value="${p.name}" data-id="${p.province_id}" ${selected}>${p.name}</option>`);
        });
    }

    function populateDistricts(provinceName, triggerOld=false) {
        const $district = $('#district');
        $district.html('<option value="">----Select District----</option>');
        const province = provinces.find(p => p.name === provinceName);
        if(!province) return;
        const provinceDistricts = districts.filter(d => d.province_id === province.province_id);
        provinceDistricts.forEach(d => {
            const selected = (triggerOld && d.name === oldDistrict) ? 'selected' : '';
            $district.append(`<option value="${d.name}" data-id="${d.district_id}" ${selected}>${d.name}</option>`);
        });
        if(triggerOld && oldDistrict) populateLocalLevels();
    }

function populateLocalLevels() {
    $('.variant-row').each(function(index){
        const $row = $(this);
        let districtId = $row.data('district-id');

        // fallback to selected district
        if(!districtId && $('#district').val()) {
            const selDistrict = districts.find(d => d.name === $('#district').val());
            districtId = selDistrict?.district_id;
            $row.data('district-id', districtId);
        }

        const $select = $row.find('.local_level_select');
        $select.html('<option value="">----Select Local Level----</option>');
        if(!districtId) return;

        const localList = local_levels.filter(l => l.district_id == districtId);
        localList.forEach(l => {
            const selected = oldLocalLevels[index] && oldLocalLevels[index].name === l.name ? 'selected' : '';
            $select.append(`<option value="${l.name}" data-type-id="${l.local_level_type_id}" ${selected}>${l.name}</option>`);

            if(selected) {
                // Use the type from oldLocalLevels instead of JSON
                $row.find('.local_level_type_input').val(oldLocalLevels[index].type || l.type || '');
                $row.find(`input[name^="[${index}][rate]"]`).val(oldLocalLevels[index].rate || '');
            }
        });
    });
}


    $('#province').change(function() {
        const val = $(this).val();
        if(val) populateDistricts(val);
        else $('#district').html('<option value="">----</option>');
        $('.variant-row').data('district-id', '');
        $('.local_level_type_input').val('');
        populateLocalLevels();
    });

    $('#district').change(function() {
        const val = $(this).val();
        const districtId = districts.find(d => d.name === val)?.district_id || '';
        $('.variant-row').data('district-id', districtId);
        populateLocalLevels();
    });

    $('#variants-container').on('change', '.local_level_select', function() {
        const typeId = $(this).find('option:selected').data('type-id');
        const typeName = local_level_types.find(t => t.local_level_type_id == typeId)?.name || '';
        $(this).closest('.variant-row').find('.local_level_type_input').val(typeName);
    });

    $('#add-variant').click(function() {
        const newRow = $('.variant-row:first').clone();
        const idx = $('.variant-row').length;
        newRow.attr('data-index', idx);
        newRow.find('select').val('');
        newRow.find('input[type="text"], input[type="number"]').val('');
        newRow.find('input[name^="[0][rate]"]').attr('name', `[${idx}][rate]`);
        $('#variants-container').append(newRow);
    });

    $('form').submit(function() {
        const data = [];
        $('.variant-row').each(function() {
            const idx = $(this).data('index');
            const name = $(this).find('.local_level_select').val();
            const type = $(this).find('.local_level_type_input').val();
            const rate = $(this).find(`input[name^="[${idx}][rate]"]`).val();
            if(name && type && rate) data.push({name, type, rate});
        });
        $('.local_level_select').remove();
        $('<input>').attr({type:'hidden',name:'local_level',value:JSON.stringify(data)}).appendTo('form');
    });
});
    </script>

</body>

</html>
