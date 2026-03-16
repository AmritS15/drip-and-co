@extends('layouts.admin')
@section('content')
@push('styles')
<style>
    .slide-form { max-width: 720px; display: flex; flex-direction: column; gap: 0; }
    .slide-form .slide-form__row { margin-bottom: 1.25rem; }
    .slide-form .slide-form__section { margin-bottom: 1.75rem; }
    .slide-form .slide-form__section-title { font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #555; margin-bottom: 0.75rem; padding-bottom: 0.35rem; border-bottom: 1px solid #e0e0e0; }
    .slide-form .body-title { font-size: 0.9rem; margin-bottom: 0.35rem; }
    .slide-form input[type="text"], .slide-form select { width: 100%; max-width: 100%; }
    .slide-form .slide-form__grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    @media (max-width: 640px) { .slide-form .slide-form__grid-2 { grid-template-columns: 1fr; } }
    .slide-form .upload-image { width: 100%; }
    .slide-form .upload-image .item img { max-height: 140px; object-fit: cover; }
    .slide-form .bot { margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #e0e0e0; }
</style>
@endpush
     <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Slide</h3>
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
                        <a href="{{ route('admin.slides') }}">
                            <div class="text-tiny">Slides</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Slide</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                @if(session('error'))
                    <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                @endif
                <form class="form-new-product form-style-1 slide-form" id="slideForm" action="{{ route('admin.slide.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $slide->id }}">
                    <div class="slide-form__row slide-form__section">
                        <div class="body-title">Slide type <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="type" id="slideType" required>
                                <option value="standard" {{ old('type', $slide->type) === 'standard' ? 'selected' : '' }}>Standard slide (single image + text)</option>
                                <option value="hero" {{ old('type', $slide->type) === 'hero' ? 'selected' : '' }}>Home hero (two images + overlay text)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Hero type fields -->
                    <div id="heroFields" class="slide-type-panel" style="{{ old('type', $slide->type) === 'hero' ? '' : 'display:none;' }}">
                        <div class="slide-form__section">
                            <div class="slide-form__section-title">Text</div>
                            <div class="slide-form__row">
                                <div class="body-title">Kicker (small text above title) <span class="tf-color-1">*</span></div>
                                <input type="text" placeholder="e.g. SHOP BY CATEGORY" name="tagline" value="{{ old('tagline', $slide->tagline) }}">
                            </div>
                            @error('tagline') <span class="alert alert-danger">{{ $message }}</span> @enderror
                            <div class="slide-form__row">
                                <div class="body-title">Title <span class="tf-color-1">*</span></div>
                                <input type="text" placeholder="e.g. Shop the Hoodies Collection" name="title" value="{{ old('title', $slide->title) }}">
                            </div>
                            @error('title') <span class="alert alert-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="slide-form__section">
                            <div class="slide-form__section-title">Images</div>
                            <div class="slide-form__grid-2">
                                <div class="slide-form__row">
                                    <div class="body-title">Left image <span class="tf-color-1">*</span></div>
                                    <div class="upload-image">
                                        @if($slide->image)
                                        <div class="item" id="imgpreviewLeft">
                                            <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}" class="effect8" alt=""/>
                                        </div>
                                        @endif
                                        <div class="item up-load">
                                            <label class="uploadfile" for="myFile">
                                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                                <span class="body-text">Drop image or <span class="tf-color">browse</span></span>
                                                <input type="file" id="myFile" name="image" accept="image/png,image/jpeg,image/jpg">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-form__row">
                                    <div class="body-title">Right image <span class="tf-color-1">*</span></div>
                                    <div class="upload-image">
                                        @if($slide->image_right ?? null)
                                        <div class="item" id="imgpreviewRight">
                                            <img src="{{ asset('uploads/slides') }}/{{ $slide->image_right }}" class="effect8" alt=""/>
                                        </div>
                                        @else
                                        <div class="item" id="imgpreviewRight" style="display:none;">
                                            <img src="" class="effect8" alt=""/>
                                        </div>
                                        @endif
                                        <div class="item up-load">
                                            <label class="uploadfile" for="myFileRight">
                                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                                <span class="body-text">Drop image or <span class="tf-color">browse</span></span>
                                                <input type="file" id="myFileRight" name="image_right" accept="image/png,image/jpeg,image/jpg">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('image') <span class="alert alert-danger">{{ $message }}</span> @enderror
                            @error('image_right') <span class="alert alert-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="slide-form__section">
                            <div class="slide-form__section-title">Links (optional)</div>
                            <div class="slide-form__grid-2">
                                <div class="slide-form__row">
                                    <div class="body-title">Left link text</div>
                                    <input type="text" placeholder="e.g. WOMEN" name="link_left_text" value="{{ old('link_left_text', $slide->link_left_text) }}">
                                </div>
                                <div class="slide-form__row">
                                    <div class="body-title">Right link text</div>
                                    <input type="text" placeholder="e.g. MEN" name="link_right_text" value="{{ old('link_right_text', $slide->link_right_text) }}">
                                </div>
                            </div>
                            <div class="slide-form__grid-2">
                                <div class="slide-form__row">
                                    <div class="body-title">Left link URL</div>
                                    <input type="text" placeholder="/shop or full URL" name="link" value="{{ old('link', $slide->link) }}">
                                </div>
                                <div class="slide-form__row">
                                    <div class="body-title">Right link URL</div>
                                    <input type="text" placeholder="/shop or full URL" name="link_right" value="{{ old('link_right', $slide->link_right) }}">
                                </div>
                            </div>
                            @error('link') <span class="alert alert-danger">{{ $message }}</span> @enderror
                            @error('link_right') <span class="alert alert-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Standard type fields -->
                    <div id="standardFields" class="slide-type-panel" style="{{ old('type', $slide->type) === 'standard' ? '' : 'display:none;' }}">
                        <div class="slide-form__section">
                            <div class="slide-form__section-title">Text</div>
                            <div class="slide-form__row">
                                <div class="body-title">Tagline <span class="tf-color-1">*</span></div>
                                <input type="text" placeholder="tagline" name="tagline_std" value="{{ old('tagline_std', $slide->tagline) }}">
                            </div>
                            <div class="slide-form__row">
                                <div class="body-title">Title <span class="tf-color-1">*</span></div>
                                <input type="text" placeholder="title" name="title_std" value="{{ old('title_std', $slide->title) }}">
                            </div>
                            <div class="slide-form__row">
                                <div class="body-title">Subtitle <span class="tf-color-1">*</span></div>
                                <input type="text" placeholder="subtitle" name="subtitle" value="{{ old('subtitle', $slide->subtitle) }}">
                            </div>
                            @error('subtitle') <span class="alert alert-danger">{{ $message }}</span> @enderror
                            <div class="slide-form__row">
                                <div class="body-title">Link <span class="tf-color-1">*</span></div>
                                <input type="text" placeholder="link" name="link_std" value="{{ old('link_std', $slide->link) }}">
                            </div>
                        </div>
                        <div class="slide-form__section">
                            <div class="slide-form__section-title">Image</div>
                            <div class="slide-form__row">
                                <div class="upload-image">
                                    @if($slide->image)
                                    <div class="item" id="imgpreviewStd">
                                        <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}" class="effect8" alt=""/>
                                    </div>
                                    @else
                                    <div class="item" id="imgpreviewStd" style="display:none;">
                                        <img src="" class="effect8" alt=""/>
                                    </div>
                                    @endif
                                    <div class="item up-load">
                                        <label class="uploadfile" for="myFileStd">
                                            <span class="icon"><i class="icon-upload-cloud"></i></span>
                                            <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span></span>
                                            <input type="file" id="myFileStd" name="image_std" accept="image/png,image/jpeg,image/jpg">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="slide-form__section">
                        <div class="body-title">Status</div>
                        <div class="select">
                            <select name="status">
                                <option value="1" @if(old('status', $slide->status)=="1") selected @endif>Active</option>
                                <option value="0" @if(old('status', $slide->status)=="0") selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                    @error('status') <span class="alert alert-danger">{{ $message }}</span> @enderror
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            var $form = $('#slideForm');
            var $type = $('#slideType');
            var $hero = $('#heroFields');
            var $standard = $('#standardFields');

            function togglePanels() {
                var isHero = $type.val() === 'hero';
                $hero.toggle(isHero);
                $standard.toggle(!isHero);
                $hero.find('input, select').prop('disabled', !isHero);
                $standard.find('input, select').prop('disabled', isHero);
                if (isHero) {
                    $standard.find('input[type="file"]').prop('disabled', true);
                } else {
                    $hero.find('input[type="file"]').prop('disabled', true);
                }
            }

            $type.on('change', togglePanels);
            togglePanels();

            $("#myFile").on("change", function() {
                var file = this.files[0];
                if (file) {
                    $("#imgpreviewLeft img").attr('src', URL.createObjectURL(file));
                    $("#imgpreviewLeft").show();
                }
            });
            $("#myFileRight").on("change", function() {
                var file = this.files[0];
                if (file) {
                    $("#imgpreviewRight img").attr('src', URL.createObjectURL(file));
                    $("#imgpreviewRight").show();
                }
            });
            $("#myFileStd").on("change", function() {
                var file = this.files[0];
                if (file) {
                    $("#imgpreviewStd img").attr('src', URL.createObjectURL(file));
                    $("#imgpreviewStd").show();
                }
            });
        });
    </script>
@endpush
