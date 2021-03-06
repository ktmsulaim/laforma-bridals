@extends('layouts.admin.base', ['title' => 'Settings'])

@push('libs_css')
    <link rel="stylesheet" href="{{ asset('assets/app/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/app/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}">
@endpush

@push('libs_js')
    <script src="{{ asset('assets/app/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/app/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script>
        $(function(){
            $('.timepicker').timepicker({
                icons: {
                    up:"mdi mdi-chevron-up",
                    down:"mdi mdi-chevron-down"
                }
            })

            let multipleDates = $('.multiple-dates').datepicker({
                format:{
                    toDisplay: function (date, format, language) {
                        return moment(date, 'DD/MM/YYYY').format('DD/MM/YYYY')
                    },
                    toValue: function (date, format, language) {
                        // console.log(date, format, language);
                        return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD')
                    }
                },
                clearBtn: !0,
                multidate: !0,
                multidateSeparator:",",
                zIndexOffset: 9999,
            })
            
            @if (setting('holidays')) 
                $('.multiple-dates').datepicker('setDates', "{{ setting('holidays') }}".split(',').map(date => {
                    let parsed = moment(date, 'DD/MM/YYYY')

                    return parsed.toDate();
                }))
            @endif

        })
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#general" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="fa fa-circle"></i></span>
                                <span class="d-none d-sm-block">General</span>            
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#payment-methods" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="fa fa-circle"></i></span>
                                <span class="d-none d-sm-block">Payment methods</span> 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#bookings" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="fa fa-circle"></i></span>
                                <span class="d-none d-sm-block">Bookings</span> 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#notifications" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="fa fa-circle"></i></span>
                                <span class="d-none d-sm-block">Notifications</span> 
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#home-page" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="fa fa-circle"></i></span>
                                <span class="d-none d-sm-block">Home page</span> 
                            </a>
                        </li>
                    </ul>
        
                    <form id="settingsForm" action="{{ route('admin.settings.save') }}" method="post">
                        @csrf
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="general">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="store_name">Store name</label>
                                            <input type="text" class="form-control" id="store_name" value="{{ setting('store_name') }}" name="store_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="store_location">Store location</label>
                                            <input type="text" class="form-control" id="store_location" value="{{ setting('store_location') }}" name="store_location">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="primary_contact_number">Primary contact number</label>
                                            <input type="tel" class="form-control" id="primary_contact_number" value="{{ setting('primary_contact_number') ?? '+91' }}" name="primary_contact_number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="secondary_contact_number">Secondary contact number</label>
                                            <input type="tel" class="form-control" id="secondary_contact_number" value="{{ setting('secondary_contact_number') ?? '+91' }}" name="secondary_contact_number">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" value="{{ setting('email') }}" name="email">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea type="tel" class="form-control" id="address" name="address" rows="3">{{ setting('address') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4>Pages</h4>
                                <div class="row form-group">
                                    <div class="col-lg-3 col-md-4">
                                        <label for="about_page">About page</label>
                                        <pages-selector name="about_page" value="{{ setting('about_page') }}" :pages='@json($pages)'></pages-selector>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <label for="privacy_policy_page">Privcy policy</label>
                                        <pages-selector name="privacy_policy_page" value="{{ setting('privacy_policy_page') }}" :pages='@json($pages)'></pages-selector>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <label for="terms_of_use_page">Terms of use</label>
                                        <pages-selector name="terms_of_use_page" value="{{ setting('terms_of_use_page') }}" :pages='@json($pages)'></pages-selector>
                                    </div>
                                    <div class="col-lg-3 col-md-4">
                                        <label for="refund_policy_page">Refund policy</label>
                                        <pages-selector name="refund_policy_page" value="{{ setting('refund_policy_page') }}" :pages='@json($pages)'></pages-selector>
                                    </div>
                                </div>
                                <hr>
                                <h4>Social Links</h4>
                                <div class="row form-group">
                                    <div class="col-lg-6 col-md-6">
                                        <label for="twitter_link">Twitter</label>
                                        <input type="url" name="twitter_link" value="{{ old('twitter_link', setting('twitter_link')) }}" id="twitter_link" class="form-control">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label for="facebook_link">Facebook</label>
                                        <input type="url" name="facebook_link" value="{{ old('facebook_link', setting('facebook_link')) }}" id="facebook_link" class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-lg-6 col-md-6">
                                        <label for="instagram_link">Instagram</label>
                                        <input type="url" name="instagram_link" value="{{ old('instagram_link', setting('instagram_link')) }}" id="instagram_link" class="form-control">
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label for="youtube_link">Youtube</label>
                                        <input type="url" name="youtube_link" value="{{ old('youtube_link', setting('youtube_link')) }}" id="youtube_link" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="payment-methods">
                                <p class="mb-0">
                                    <div class="row">
                                        <div class="col">
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="enable_cash_on_delivery" value="{{ setting("enable_cash_on_delivery") }}">
                                                <input type="checkbox" class="custom-control-input" id="enable_cash_on_delivery"  {{ setting('enable_cash_on_delivery') && setting('enable_cash_on_delivery') === 'enable' ? 'checked' : null }}>
                                                <label class="custom-control-label" for="enable_cash_on_delivery">Enable Cash On Delivery (COD)</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row my-2">
                                        <div class="col">
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="enable_razorpay" value="{{ setting('enable_razorpay') }}">
                                                <input type="checkbox" class="custom-control-input" id="enable_razorpay" value="{{ setting('enable_razorpay') }}" {{ setting('enable_razorpay') && setting('enable_razorpay') === 'enable' ? 'checked' : null }}>
                                                <label class="custom-control-label" for="enable_razorpay">Enable Razorpay</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="razorpay_key">Razorpay Key</label>
                                                <input type="text" class="form-control" name="razorpay_key" id="razorpay_key" value="{{ setting('razorpay_key') }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="razorpay_secret">Razorpay Secret</label>
                                                <input type="text" class="form-control" name="razorpay_secret" id="razorpay_secret" value="{{ setting('razorpay_secret') }}">
                                            </div>
                                        </div>
                                    </div>
                                </p>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="bookings">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label for="opening_hour">Opening hour</label>
                                            <input type="text" class="form-control timepicker" id="opening_hour" name="opening_hour" value="{{ setting('opening_hour') }}">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label for="closing_hour">Closing hour</label>
                                            <input type="text" class="form-control timepicker" id="closing_hour" name="closing_hour" value="{{ setting('closing_hour') }}">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-12">
                                            <label for="working_hours">Working hours</label>
                                            <input type="number" name="working_hours" id="working_hours" class="form-control" min="1" step="0.1" value="{{ setting('working_hours') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <label for="holidays">Holidays</label>
                                            <input type="hidden" class="holidays-values" value="{{ setting('holidays') }}"> 
                                            <input type="text" class="form-control multiple-dates" name="holidays">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12"></div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="notifications">
                                <p class="mb-0">
                                    @include('components.admin.settings.switch', ['name' => 'email_notification', 'text' => 'Email notification'])
                                    
                                    <h4>Notifications</h4>

                                    @include('components.admin.settings.switch', ['name' => 'welcome_mail', 'text' => 'Send welcome mail to new customers'])
                                    @include('components.admin.settings.switch', ['name' => 'order_summary_mail', 'text' => 'Send order summary to the customers'])
                                    @include('components.admin.settings.switch', ['name' => 'order_status_mail', 'text' => 'Send order status notification when changed'])
                                    @include('components.admin.settings.switch', ['name' => 'booking_confirmation_mail', 'text' => 'Send booking confirmation to the customers'])
                                    @include('components.admin.settings.switch', ['name' => 'booking_status_mail', 'text' => 'Send booking status notification when changed'])
                                    @include('components.admin.settings.switch', ['name' => 'booking_progress_mail', 'text' => 'Send booking progress notification when changed'])
                                    
                                </p>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="home-page">
                                <p class="mb-0">
                                    <h4>Featured product</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="featured_product_id">Product</label>
                                            <select-featured-product :image='@json($image)' value="{{ old('featured_product_id', setting('featured_product_id')) }}"></select-featured-product>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tag">Tagline</label>
                                                <input type="text" name="featured_product_tag" id="featured_product_tag" class="form-control" value="{{ old('featured_product_tag', setting('featured_product_tag')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <h4>Brands</h4>
                                    <select-brands :brands='@json($brands)'></select-brands>
                                </p>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection