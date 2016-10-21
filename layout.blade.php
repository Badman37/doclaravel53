<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tài liệu Laravel tiếng việt | giaphiep.com</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="Giáp Hiệp">
    <meta name="description" content=Laravel Việt Nam">
    <meta name="keywords" content="laravel, php, framework, web, artisans, Giáp Hiệp">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--[if lte IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    <link href='https://fonts.googleapis.com/css?family=Miriam+Libre:400,700|Source+Sans+Pro:200,400,700,600,400italic,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{url('css/laravel.css')}}">
    <link rel="apple-touch-icon" href="{{URL::asset('')}}images/logo.png">
    <link rel="icon" href="{{url('images/favicon.png')}}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.26/vue.min.js"></script>
    
    <!-- Facebook Conversion Code for Khách hàng tiềm năng - Giáp Hiệp 2 -->
    <script>(function() {
      var _fbq = window._fbq || (window._fbq = []);
      if (!_fbq.loaded) {
        var fbds = document.createElement('script');
        fbds.async = true;
        fbds.src = 'https://connect.facebook.net/en_US/fbds.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(fbds, s);
        _fbq.loaded = true;
      }
    })();
    window._fbq = window._fbq || [];
    window._fbq.push(['track', '6043383382307', {'value':'0.00','currency':'VND'}]);
    </script>
    <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6043383382307&amp;cd[value]=0.00&amp;cd[currency]=VND&amp;noscript=1" /></noscript>

</head>

<body class="docs language-php">

    <span class="overlay"></span>

    <nav class="main">
        <a href="{{URL::asset('')}}docs/5.3/installation" class="brand nav-block">
                <span>Giáp Hiệp</span>
        </a>

       {{--  <ul class="main-nav">
            <li class="nav-docs"><a href="#">Documentation</a>
            </li>
            <li class="nav-laracasts"><a href="#">Blog</a>
            </li>
        </ul> --}}

       {{--  <div class="switcher">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    5.3
                    <span class="caret"></span>
                </button>
            </div>
        </div> --}}

        <div class="responsive-sidebar-nav">
            <a href="#" class="toggle-slide menu-link btn">&#9776;</a>
        </div>
    </nav>

    <nav id="slide-menu" class="slide-menu" role="navigation">

        <div class="brand">
            <a href="{{URL::asset('')}}">
                <img src="{{URL::asset('')}}images/logo.png" height="50">
            </a>
        </div>

       {{--  <ul class="slide-main-nav">
            <li><a href="{{URL::asset('')}}">Blog</a>
            </li>
            <li class="nav-docs"><a href="{{URL::asset('')}}doc/5.3/installation">Tài liệu</a>
            </li>
        </ul> --}}

        <div class="slide-docs-nav">
            <h2>Tài liệu</h2>
            <ul>
                <li>Mở đầu
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/releases">Release Notes</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/upgrade">Hướng dẫn upgrade</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/contributions">Hướng dẫn đóng góp</a>
                        </li>
                        <li><a href="https://laravel.com/api/5.3/">Tài liệu API</a>
                        </li>
                    </ul>
                </li>
                <li>Bắt đầu
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/installation">Cài đặt</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/configuration">Cấu hình</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/structure">Cấu trúc thư mục</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/errors-logging">Errors &amp; Logging</a>
                        </li>
                    </ul>
                </li>
                <li>Môi trường phát triển
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/homestead">Homestead</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/valet">Valet</a>
                        </li>
                    </ul>
                </li>
                <li>Nền tảng kiến trúc
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/container">Service Container</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/providers">Service Providers</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/facades">Facades</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/contracts">Contracts</a>
                        </li>
                    </ul>
                </li>
                <li>Lớp HTTP 
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/routing">Routing</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/middleware">Middleware</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/csrf">Bảo mật CSRF</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/controllers">Controllers</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/requests">Requests</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/responses">Responses</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/session">Session</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/validation">Validation</a>
                        </li>
                    </ul>
                </li>
                <li>Views &amp; Templates
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/views">Views</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/blade">Blade Templates</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/localization">Localization</a>
                        </li>
                    </ul>
                </li>
                <li>JavaScript &amp; CSS
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/frontend">Bắt đầu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/elixir">Compiling Assets</a>
                        </li>
                    </ul>
                </li>
                <li>Bảo mật
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/authentication">Authentication</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/authorization">Authorization</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/passwords">Khôi phục mật khẩu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/passport">API Authentication</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/encryption">Encryption</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/hashing">Hashing</a>
                        </li>
                    </ul>
                </li>
                <li>Chủ đề phổ biến
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/broadcasting">Broadcasting</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/cache">Cache</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/events">Events</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/filesystem">File Storage</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/mail">Mail</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/notifications">Notifications</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/queues">Queues</a>
                        </li>
                    </ul>
                </li>
                <li>Cơ sở dữ liệu
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/database">Bắt đầu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/queries">Query Builder</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/pagination">Pagination</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/migrations">Migrations</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/seeding">Seeding</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/redis">Redis</a>
                        </li>
                    </ul>
                </li>
                <li>Eloquent ORM
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent">Bắt đầu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent-relationships">Quan hệ</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent-collections">Collections</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent-mutators">Mutators</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent-serialization">Serialization</a>
                        </li>
                    </ul>
                </li>
                <li>Artisan Console
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/artisan">Commands</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/scheduling">Task Scheduling</a>
                        </li>
                    </ul>
                </li>
                <li>Testing
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/testing">Bắt đầu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/application-testing">Application Testing</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/database-testing">Cơ sở dữ liệu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/mocking">Mocking</a>
                        </li>
                    </ul>
                </li>
                <li>Packages chính thức
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/billing">Cashier</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/envoy">Envoy</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/passport">Passport</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/scout">Scout</a>
                        </li>
                        <li><a href="https://github.com/laravel/socialite">Socialite</a>
                        </li>
                    </ul>
                </li>
                <li>Appendix
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/collections">Collections</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/helpers">Helpers</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/packages">Packages</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>

    <div class="docs-wrapper container">

        <section class="sidebar">
            <ul>
                <li>Mở đầu
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/releases">Release Notes</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/upgrade">Hướng dẫn upgrade</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/contributions">Hướng dẫn đóng góp</a>
                        </li>
                        <li><a href="https://laravel.com/api/5.3/">Tài liệu API</a>
                        </li>
                    </ul>
                </li>
                <li>Bắt đầu
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/installation">Cài đặt</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/configuration">Cấu hình</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/structure">Cấu trúc thư mục</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/errors-logging">Errors &amp; Logging</a>
                        </li>
                    </ul>
                </li>
                <li>Môi trường phát triển
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/homestead">Homestead</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/valet">Valet</a>
                        </li>
                    </ul>
                </li>
                <li>Nền tảng kiến trúc
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/container">Service Container</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/providers">Service Providers</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/facades">Facades</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/contracts">Contracts</a>
                        </li>
                    </ul>
                </li>
                <li>Lớp HTTP
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/routing">Routing</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/middleware">Middleware</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/csrf">Bảo mật CSRF</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/controllers">Controllers</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/requests">Requests</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/responses">Responses</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/session">Session</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/validation">Validation</a>
                        </li>
                    </ul>
                </li>
                <li>Views &amp; Templates
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/views">Views</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/blade">Blade Templates</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/localization">Localization</a>
                        </li>
                    </ul>
                </li>
                <li>JavaScript &amp; CSS
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/frontend">Bắt đầu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/elixir">Compiling Assets</a>
                        </li>
                    </ul>
                </li>
                <li>Bảo mật
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/authentication">Authentication</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/authorization">Authorization</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/passwords">Khôi phục mật khẩu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/passport">API Authentication</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/encryption">Encryption</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/hashing">Hashing</a>
                        </li>
                    </ul>
                </li>
                <li>Chủ đề phổ biến
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/broadcasting">Broadcasting</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/cache">Cache</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/events">Events</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/filesystem">File Storage</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/mail">Mail</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/notifications">Notifications</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/queues">Queues</a>
                        </li>
                    </ul>
                </li>
                <li>Cơ sở dữ liệu
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/database">Bắt đầu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/queries">Query Builder</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/pagination">Pagination</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/migrations">Migrations</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/seeding">Seeding</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/redis">Redis</a>
                        </li>
                    </ul>
                </li>
                <li>Eloquent ORM
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent">Bắt đầu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent-relationships">Quan hệ</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent-collections">Collections</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent-mutators">Mutators</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/eloquent-serialization">Serialization</a>
                        </li>
                    </ul>
                </li>
                <li>Artisan Console
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/artisan">Commands</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/scheduling">Task Scheduling</a>
                        </li>
                    </ul>
                </li>
                <li>Testing
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/testing">Bắt đầu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/application-testing">Application Testing</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/database-testing">Cơ sở dữ liệu</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/mocking">Mocking</a>
                        </li>
                    </ul>
                </li>
                <li>Packages chính thức
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/billing">Cashier</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/envoy">Envoy</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/passport">Passport</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/scout">Scout</a>
                        </li>
                        <li><a href="https://github.com/laravel/socialite">Socialite</a>
                        </li>
                    </ul>
                </li>
                <li>Appendix
                    <ul>
                        <li><a href="{{URL::asset('')}}docs/5.3/collections">Collections</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/helpers">Helpers</a>
                        </li>
                        <li><a href="{{URL::asset('')}}docs/5.3/packages">Packages</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>

        @yield('content')

    </div>
    <script>
        var algolia_app_id      = '8BB87I11DE';
        var algolia_search_key  = '8e1d446d61fce359f69cd7c8b86a50de';
        var version             = '5.3';
    </script>

    <script src="{{url('js/laravel.js')}}"></script>
    <script src="{{url('js/viewport-units-buggyfill.js')}}"></script>
    <script>
        window.viewportUnitsBuggyfill.init();
    </script>
</body>

</html>