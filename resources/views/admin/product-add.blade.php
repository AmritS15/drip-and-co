@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.products') }}">
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
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.store') }}">
                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span>
                        </div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0"
                            value="{{ old('name') }}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the
                            product name.</div>
                    </fieldset>
                    @error('name')
                        <sapn class="alert alert-danger text-center">{{ $message }}
                        @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter product slug" name="slug"
                                tabindex="0" value="{{ old('slug') }}" aria-required="true" required="">
                            <div class="text-tiny">Do not exceed 100 characters when entering the
                                product name.</div>
                        </fieldset>
                        @error('slug')
                            <sapn class="alert alert-danger text-center">{{ $message }}
                            @enderror

                            <div class="gap22 cols">
                                <fieldset class="category">
                                    <div class="body-title mb-10">Category <span class="tf-color-1">*</span>
                                    </div>
                                    <div class="select">
                                        <select class="" name="category_id">
                                            <option>Choose category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </fieldset>
                                @error('category_id')
                                    <sapn class="alert alert-danger text-center">{{ $message }}
                                    @enderror
                                    <fieldset class="brand">
                                        <div class="body-title mb-10">Collection <span class="tf-color-1">*</span>
                                        </div>
                                        <div class="select">
                                            <select class="" name="brand_id">
                                                <option>Choose Collection</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </fieldset>
                                    @error('brand_id')
                                        <sapn class="alert alert-danger text-center">{{ $message }}
                                        @enderror
                            </div>

                            <fieldset class="shortdescription">
                                    <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                                    <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0"
                                        aria-required="true" required="{{ old('short_description') }}"></textarea>
                                    <div class="text-tiny">Do not exceed 100 characters when entering the
                                        product name.</div>
                                </fieldset>
                                @error('short_description')
                                    <sapn class="alert alert-danger text-center">{{ $message }}
                                    @enderror

                                    <fieldset class="description">
                                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span>
                                        </div>
                                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true"
                                            required="{{ old('description') }}"></textarea>
                                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.
                                        </div>
                                    </fieldset>
                                    @error('description')
                                        <sapn class="alert alert-danger text-center">{{ $message }}
                                        @enderror
                            </div>
                            <div class="wg-box">
                                        <!-- variant manager: size, color, sku, qty, main image, gallery -->
                                        <fieldset class="variants">
                                            <div class="body-title mb-10">Variants (size / color / SKU / qty / main image / gallery)</div>
                                            @foreach(array_filter(array_keys($errors->toArray()), fn($k) => str_starts_with($k ?? '', 'variants.') && str_contains($k ?? '', 'main_image')) as $errKey)
                                                <div class="alert alert-danger py-2">{{ $errors->first($errKey) }}</div>
                                            @endforeach
                                            <p class="text-tiny text-secondary mb-2">Add at least one variant per size+colour combination. Each variant has its own SKU, quantity, main image, and optional gallery images.</p>
                                            <p class="text-tiny mb-2"><strong>Total quantity (from variants):</strong> <span id="variantTotalQty">0</span></p>
                                            <table class="table table-bordered" id="variantTable">
                                                <thead>
                                                    <tr>
                                                        <th>Size</th>
                                                        <th>Color</th>
                                                        <th>SKU</th>
                                                        <th>Qty</th>
                                                        <th>Main Image</th>
                                                        <th>Gallery</th>
                                                        <th><button type="button" class="btn btn-sm btn-success" id="addVariant">+</button></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $oldVariants = old('variants', []); @endphp
                                                    @foreach($oldVariants as $i => $v)
                                                        @if(isset($v['quantity']))
                                                        <tr>
                                                            <td><select name="variants[{{ $i }}][size]" class="form-select form-select-sm">
                                                                <option value="">—</option>
                                                                @foreach(['S','M','L','XL'] as $s)
                                                                    <option value="{{ $s }}" {{ ($v['size'] ?? '') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td><select name="variants[{{ $i }}][color]" class="form-select form-select-sm">
                                                                <option value="">—</option>
                                                                @foreach(['White','Black','Grey','Green','Pink'] as $c)
                                                                    <option value="{{ $c }}" {{ ($v['color'] ?? '') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                                                @endforeach
                                                            </select></td>
                                                            <td><input type="text" name="variants[{{ $i }}][SKU]" value="{{ $v['SKU'] ?? '' }}" class="form-control form-control-sm" placeholder="SKU" /></td>
                                                            <td><input type="number" name="variants[{{ $i }}][quantity]" value="{{ $v['quantity'] ?? '' }}" class="form-control form-control-sm" min="0" /></td>
                                                            <td class="variant-main-image-cell">
                                                                <input type="hidden" name="variants[{{ $i }}][main_image_filename]" value="{{ $v['main_image_filename'] ?? '' }}" class="variant-main-image-filename" />
                                                                <div class="variant-main-image-preview mb-2" style="min-height: 52px;">
                                                                    @if(!empty($v['main_image_filename']))
                                                                        <img src="{{ asset('uploads/products/thumbnails/' . $v['main_image_filename']) }}" alt="" width="52" height="52" class="rounded border" style="object-fit: cover;" />
                                                                    @else
                                                                        <img src="" alt="" width="52" height="52" class="rounded border" style="display: none;" />
                                                                        <div class="text-danger text-tiny">Main image required</div>
                                                                    @endif
                                                                </div>
                                                                <input type="file" name="variants[{{ $i }}][main_image]" accept="image/*" class="form-control form-control-sm variant-main-image-upload" data-index="{{ $i }}" />
                                                            </td>
                                                            <td class="variant-gallery-cell">
                                                                <input type="hidden" name="variants[{{ $i }}][gallery_filenames]" value="{{ $v['gallery_filenames'] ?? '' }}" class="variant-gallery-filenames" />
                                                                <div class="variant-gallery-thumbs mb-2 d-flex flex-wrap gap-1" style="min-height: 52px;">
                                                                    @foreach(array_filter(explode(',', $v['gallery_filenames'] ?? '')) as $gimg)
                                                                        @php $gimg = trim($gimg); @endphp
                                                                        @if($gimg)
                                                                            <span class="variant-gallery-thumb-wrap position-relative d-inline-block"><img data-filename="{{ $gimg }}" src="{{ asset('uploads/products/thumbnails/' . $gimg) }}" alt="" width="52" height="52" class="rounded border" style="object-fit: cover;" /><button type="button" class="variant-gallery-remove btn btn-sm btn-danger position-absolute top-0 end-0" style="padding:0 4px; line-height:1; font-size:10px; transform:translate(50%,-50%);" title="Remove image">×</button></span>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                                <input type="file" name="variants[{{ $i }}][images][]" accept="image/*" multiple class="form-control form-control-sm variant-gallery-upload" data-index="{{ $i }}" />
                                                                <div class="text-tiny text-muted mt-1">Gallery images</div>
                                                            </td>
                                                            <td><button type="button" class="btn btn-sm btn-danger removeVariant">−</button></td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </fieldset>

                                        <div class="cols gap22">
                                            <fieldset class="name">
                                                <div class="body-title mb-10">Regular Price <span
                                                        class="tf-color-1">*</span></div>
                                                <input class="mb-10" type="text" placeholder="Enter regular price"
                                                    name="regular_price" tabindex="0"
                                                    value="{{ old('reqular_price') }}" aria-required="true"
                                                    required="">
                                            </fieldset>
                                            @error('regular_price')
                                                <sapn class="alert alert-danger text-center">{{ $message }}
                                                @enderror
                                                <fieldset class="name">
                                                    <div class="body-title mb-10">Sale Price <span
                                                            class="tf-color-1">*</span></div>
                                                    <input class="mb-10" type="text" placeholder="Enter sale price"
                                                        name="sale_price" tabindex="0" value="{{ old('sale_price') }}"
                                                        aria-required="true" required="">
                                                </fieldset>
                                                @error('sale_price')
                                                    <sapn class="alert alert-danger text-center">{{ $message }}
                                                    @enderror
                                        </div>

                                        <div class="cols gap22">
                                            <fieldset class="name">
                                                <div class="body-title mb-10">Stock</div>
                                                <div class="select mb-10">
                                                    <select class="" name="stock_status">
                                                        <option value="instock">InStock</option>
                                                        <option value="outofstock">Out of Stock</option>
                                                    </select>
                                                </div>
                                            </fieldset>
                                            @error('stock_status')
                                                <sapn class="alert alert-danger text-center">{{ $message }}
                                                @enderror
                                                <fieldset class="name">
                                                    <div class="body-title mb-10">Featured</div>
                                                    <div class="select mb-10">
                                                        <select class="" name="featured">
                                                            <option value="0">No</option>
                                                            <option value="1">Yes</option>
                                                        </select>
                                                    </div>
                                                </fieldset>
                                                @error('featured')
                                                    <sapn class="alert alert-danger text-center">{{ $message }}
                                                    @enderror
                                        </div>
                                        <div class="cols gap10">
                                            <button class="tf-button w-full" type="submit">Add product</button>
                                        </div>
                            </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection

@push('scripts')
    <script>
        window.uploadVariantGalleryUrl = "{{ route('admin.product.upload.variant.gallery') }}";
        window.csrfToken = "{{ csrf_token() }}";
        $(function() {
            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
            updateVariantTotalQty();
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }
        /* variant table helper: size, color, SKU, qty, image, gallery */
        function addVariantRow(data = {}) {
            const index = $('#variantTable tbody tr').length;
            const thumbBase = "{{ asset('uploads/products/thumbnails') }}".replace(/\/?$/, '') + '/';
            const row = `<tr>
                        <td><select name="variants[${index}][size]" class="form-select form-select-sm">
                                <option value="">—</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select></td>
                            <td><select name="variants[${index}][color]" class="form-select form-select-sm">
                                <option value="">—</option>
                                <option value="White">White</option>
                                <option value="Black">Black</option>
                                <option value="Grey">Grey</option>
                                <option value="Green">Green</option>
                                <option value="Pink">Pink</option>
                            </select></td>
                        <td><input type="text" name="variants[${index}][SKU]" value="${data.SKU||''}" class="form-control form-control-sm" placeholder="SKU" /></td>
                        <td><input type="number" name="variants[${index}][quantity]" value="${data.quantity!==undefined?data.quantity:''}" class="form-control form-control-sm" min="0" placeholder="0" /></td>
                        <td class="variant-main-image-cell"><input type="hidden" name="variants[${index}][main_image_filename]" value="${data.main_image_filename||''}" class="variant-main-image-filename" /><div class="variant-main-image-preview mb-2" style="min-height: 52px;"><img src="${data.main_image_filename ? thumbBase + data.main_image_filename : ''}" alt="" width="52" height="52" class="rounded border" style="object-fit: cover; display: ${data.main_image_filename ? 'inline-block' : 'none'};" /></div><input type="file" name="variants[${index}][main_image]" accept="image/*" class="form-control form-control-sm variant-main-image-upload" data-index="${index}" /></td>
                        <td class="variant-gallery-cell"><input type="hidden" name="variants[${index}][gallery_filenames]" value="${data.gallery_filenames||''}" class="variant-gallery-filenames" /><div class="variant-gallery-thumbs mb-2 d-flex flex-wrap gap-1" style="min-height: 52px;"></div><input type="file" name="variants[${index}][images][]" accept="image/*" multiple class="form-control form-control-sm variant-gallery-upload" data-index="${index}" title="Select one or more images; they upload immediately" /><div class="text-tiny text-muted mt-1">Gallery images</div></td>
                        <td><button type="button" class="btn btn-sm btn-danger removeVariant">−</button></td>
                    </tr>`;
            $('#variantTable tbody').append(row);
        }

        function updateVariantTotalQty() {
            var total = 0;
            $('#variantTable tbody tr').each(function() {
                var q = parseInt($(this).find('input[name*="[quantity]"]').val(), 10);
                if (!isNaN(q)) total += q;
            });
            $('#variantTotalQty').text(total);
        }

        $(document).on('click', '#addVariant', function() {
            addVariantRow();
            updateVariantTotalQty();
        });

        $(document).on('click', '.removeVariant', function() {
            $(this).closest('tr').remove();
            renumberVariantRows();
            updateVariantTotalQty();
        });

        function renumberVariantRows() {
            $('#variantTable tbody tr').each(function(idx) {
                $(this).find('input, select').filter(function() { return $(this).attr('name') && $(this).attr('name').match(/^variants\[\d+\]/); }).each(function() {
                    var name = $(this).attr('name');
                    $(this).attr('name', name.replace(/^variants\[\d+\]/, 'variants[' + idx + ']'));
                });
                $(this).find('.variant-main-image-upload, .variant-gallery-upload').attr('data-index', idx);
            });
        }

        $(document).on('input', '#variantTable input[name*="[quantity]"]', updateVariantTotalQty);

        $(document).on('change', '.variant-main-image-upload', function() {
            var input = this;
            var file = input.files && input.files[0];
            if (!file) return;
            var $row = $(input).closest('tr');
            var $hidden = $row.find('.variant-main-image-filename');
            var $preview = $row.find('.variant-main-image-preview img');
            var formData = new FormData();
            formData.append('_token', window.csrfToken);
            formData.append('images[]', file);
            $.ajax({
                url: window.uploadVariantGalleryUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.filenames && res.filenames.length) {
                        var fn = res.filenames[0];
                        $hidden.val(fn);
                        var base = "{{ asset('uploads/products/thumbnails') }}".replace(/\/?$/, '') + '/';
                        $preview.attr('src', base + fn).show();
                    }
                    input.value = '';
                },
                error: function(xhr) {
                    var msg = 'Upload failed. Please try again.';
                    if (xhr.status === 413) msg = 'Upload too large. Try smaller image (under 5MB).';
                    else if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    alert(msg);
                    input.value = '';
                }
            });
        });

        $(document).on('click', '.variant-gallery-remove', function() {
            var $wrap = $(this).closest('.variant-gallery-thumb-wrap');
            var fn = $wrap.find('img').data('filename');
            var $cell = $wrap.closest('.variant-gallery-cell');
            var $hidden = $cell.find('.variant-gallery-filenames');
            var cur = ($hidden.val() || '').split(',').map(function(s) { return s.trim(); }).filter(Boolean);
            $hidden.val(cur.filter(function(f) { return f !== fn; }).join(','));
            $wrap.remove();
        });

        $(document).on('change', '.variant-gallery-upload', function() {
            var input = this;
            var files = input.files;
            if (!files || !files.length) return;
            var $row = $(input).closest('tr');
            var $thumbs = $row.find('.variant-gallery-thumbs');
            var $hidden = $row.find('.variant-gallery-filenames');
            var formData = new FormData();
            formData.append('_token', window.csrfToken);
            for (var i = 0; i < files.length; i++) formData.append('images[]', files[i]);
            $.ajax({
                url: window.uploadVariantGalleryUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.filenames && res.filenames.length) {
                        var current = ($hidden.val() || '').trim();
                        var added = res.filenames.join(',');
                        $hidden.val(current ? current + ',' + added : added);
                        var base = "{{ asset('uploads/products/thumbnails') }}".replace(/\/?$/, '') + '/';
                        $.each(res.filenames, function(_, fn) {
                            $thumbs.append('<span class="variant-gallery-thumb-wrap position-relative d-inline-block"><img data-filename="' + fn + '" src="' + base + fn + '" alt="" width="52" height="52" class="rounded border" style="object-fit: cover;" /><button type="button" class="variant-gallery-remove btn btn-sm btn-danger position-absolute top-0 end-0" style="padding:0 4px; line-height:1; font-size:10px; transform:translate(50%,-50%);" title="Remove image">×</button></span>');
                        });
                    }
                    input.value = '';
                },
                error: function(xhr) {
                    var msg = 'Upload failed. Please try again.';
                    if (xhr.status === 413) msg = 'Upload too large. Try fewer or smaller images (e.g. one at a time, or under 2MB each).';
                    else if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var first = Object.values(xhr.responseJSON.errors)[0];
                        if (first && first[0]) msg = first[0];
                    }
                    alert(msg);
                    input.value = '';
                }
            });
        });
    </script>
@endpush
