<footer class="revealed">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <h3 data-target="#collapse_1">Quick Links</h3>
                <div class="collapse dont-collapse-sm links" id="collapse_1">
                    <ul>
                        <li><a href="{{ setting('about_page') ? route('page.show', setting('about_page')) : 'javascript:void(0)' }}">About us</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                        <li><a href="{{ route('packages.index') }}">Packages</a></li>
                        <li><a href="{{ route('collections.index') }}">Collections</a></li>
                        <li><a href="{{ route('jobs.index') }}">Jobs</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 data-target="#collapse_2">Categories</h3>
                <div class="collapse dont-collapse-sm links" id="collapse_2">
                    @if ($categories && count($categories))
                        <ul>
                            @foreach ($categories as $category)
                                <li><a href="{{ route('products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    @else
                        <p>No categories!</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 data-target="#collapse_3">Contacts</h3>
                <div class="collapse dont-collapse-sm contacts" id="collapse_3">
                    <ul>
                        <li><i class="ti-home"></i>{!! setting('address', 'Ring Road Tirur, Japan square building<br>1st floor Kotak Mahindra Bank Tirur<br>676101') !!}</li>
                        <li><i class="ti-headphone-alt"></i><a
                                href="tel:{{ str_replace(' ', '', setting('primary_contact_number')) }}">{{ setting('primary_contact_number', '+91 9846 374 743') }}</a>
                        </li>
                        <li><i class="ti-email"></i><a
                                href="mailto:{{ setting('email', 'laformabridals@gmail.com') }}">{{ setting('email', 'laformabridals@gmail.com') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h3 data-target="#collapse_4">Keep in touch</h3>
                <div class="collapse dont-collapse-sm" id="collapse_4">
                    <div id="newsletter">
                        <div class="form-group">
                            <input type="email" name="email_newsletter" id="email_newsletter" class="form-control"
                                placeholder="Your email">
                            <button type="submit" id="submit-newsletter"><i class="ti-angle-double-right"></i></button>
                        </div>
                    </div>
                    <div class="follow_us">
                        <h5>Follow Us</h5>
                        <ul>
                            <li><a target="_blank" href="{{ setting('twitter_link') ?: 'javascript:void(0)' }}"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-src="{{ asset('assets/website/img/twitter_icon.svg') }}" alt=""
                                        class="lazy"></a></li>
                            <li><a target="_blank" href="{{ setting('facebook_link') ?: 'javascript:void(0)' }}"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-src="{{ asset('assets/website/img/facebook_icon.svg') }}" alt=""
                                        class="lazy"></a></li>
                            <li><a target="_blank" href="{{ setting('instagram_link') ?: 'javascript:void(0)' }}"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-src="{{ asset('assets/website/img/instagram_icon.svg') }}" alt=""
                                        class="lazy"></a></li>
                            <li><a target="_blank" href="{{ setting('youtube_link') ?: 'javascript:void(0)' }}"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                        data-src="{{ asset('assets/website/img/youtube_icon.svg') }}" alt=""
                                        class="lazy"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /row-->
        <hr>
        <div class="row add_bottom_25">
            <div class="col-lg-6">
                <ul class="footer-selector clearfix">
                    <li>
                        <div class="styled-select lang-selector">
                            <select>
                                <option value="English" selected>English</option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="styled-select currency-selector">
                            <select>
                                <option value="Indian Rupees" selected>IN Rupees</option>
                            </select>
                        </div>
                    </li>
                    <li><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                            data-src="{{ asset('assets/website/img/cards_all.svg') }}" alt="" width="198" height="30"
                            class="lazy"></li>
                </ul>
            </div>
            <div class="col-lg-6">
                <ul class="additional_links">
                    <li><a href="{{ setting('terms_of_use_page') ? route('page.show', setting('terms_of_use_page')) : 'javascript:void(0)' }}">Terms and conditions</a></li>
                    <li><a href="{{ setting('privacy_policy_page') ? route('page.show', setting('privacy_policy_page')) : 'javascript:void(0)' }}">Privacy Policy</a></li>
                    <li><a href="{{ setting('refund_policy_page') ? route('page.show', setting('refund_policy_page')) : 'javascript:void(0)' }}">Refund Policy</a></li>
                    <li><span>© {{ date('Y') }} La'forma bridals</span></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!--/footer-->
</div>
<!-- page -->

<div id="toTop"></div><!-- Back to top button -->

<!-- COMMON SCRIPTS -->
<script src="{{ asset('assets/website/js/common_scripts.min.js') }}"></script>
<script src="{{ asset('assets/app/libs/ntc/ntc.js') }}"></script>
<script src="{{ asset('assets/website/js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('assets/website/js/website.js') }}"></script>
<script src="{{ asset('assets/website/js/main.js') }}"></script>

<!-- SPECIFIC SCRIPTS -->
<script src="{{ asset('assets/website/js/carousel-home.js') }}"></script>
<script src="{{ asset('assets/website/js/jquery.cookiebar.js') }}"></script>

@stack('js_libs')
<script>
    $(document).ready(function() {
        'use strict';
        $.cookieBar({
            fixed: true
        });
    });
</script>


</body>

</html>
