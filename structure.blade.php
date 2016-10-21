@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Cấu trúc thư mục</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#the-root-directory">Thư mục gốc</a>
            <ul>
                <li><a href="#the-root-app-directory">Thư mục <code class=" language-php">app</code></a>
                </li>
                <li><a href="#the-bootstrap-directory">Thư mục <code class=" language-php">bootstrap</code></a>
                </li>
                <li><a href="#the-config-directory">Thư mục <code class=" language-php">config</code></a>
                </li>
                <li><a href="#the-database-directory">Thư mục <code class=" language-php">database</code></a>
                </li>
                <li><a href="#the-public-directory">Thư mục <code class=" language-php"><span class="token keyword">public</span></code></a>
                </li>
                <li><a href="#the-resources-directory">Thư mục <code class=" language-php">resources</code></a>
                </li>
                <li><a href="#the-routes-directory">Thư mục <code class=" language-php">routes</code></a>
                </li>
                <li><a href="#the-storage-directory">Thư mục <code class=" language-php">storage</code></a>
                </li>
                <li><a href="#the-tests-directory">Thư mục <code class=" language-php">tests</code></a>
                </li>
                <li><a href="#the-vendor-directory">Thư mục <code class=" language-php">vendor</code></a>
                </li>
            </ul>
        </li>
        <li><a href="#the-app-directory">Thư mục App</a>
            <ul>
                <li><a href="#the-console-directory">Thư mục <code class=" language-php">Console</code></a>
                </li>
                <li><a href="#the-events-directory">Thư mục <code class=" language-php">Events</code></a>
                </li>
                <li><a href="#the-exceptions-directory">Thư mục <code class=" language-php">Exceptions</code></a>
                </li>
                <li><a href="#the-http-directory">Thư mục <code class=" language-php">Http</code></a>
                </li>
                <li><a href="#the-jobs-directory">Thư mục <code class=" language-php">Jobs</code></a>
                </li>
                <li><a href="#the-listeners-directory">Thư mục <code class=" language-php">Listeners</code></a>
                </li>
                <li><a href="#the-mail-directory">Thư mục <code class=" language-php">Mail</code></a>
                </li>
                <li><a href="#the-notifications-directory">Thư mục <code class=" language-php">Notifications</code></a>
                </li>
                <li><a href="#the-policies-directory">Thư mục <code class=" language-php">Policies</code></a>
                </li>
                <li><a href="#the-providers-directory">Thư mục <code class=" language-php">Providers</code></a>
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Mặc định cấu trúc thư mục ứng dụng Laravel được thiết kế để xây dựng cả ứng dụng nhỏ và ứng dụng lớn. Tất nhiên, bạn có thể hoàn toàn tổ trức lại cấu trúc thư mục theo ý bạn muốn. Laravel hầu như không áp đặt những hạn chế về nơi các class nằm ở thư mục nào - miễn là Composer có thể tự động tải được các class.</p>
    <h4>Thư mục Models ở đâu?</h4>
    <p>Khi bắt đầu làm việc với Laravel, rất nhiều developer bị bối rối vì cảm thấy thiếu thiếu một folder<code class=" language-php">models</code>. Tuy nhiên, Laravel đã cố ý không tạo một folder models đó. Chúng ta thấy từ "models" là mơ hồ vì nó có rất nhiều nghĩa khác nhau từ nhiều người khác nhau. Một số developer xem "model" như là toàn bộ logic của ứng dụng, trong khi những sô khác thì xem "models" như là các class có thể tương tác với database.</p>
    <p>Chính vì lý do đấy, Laravel chọn đặt Eloquent model mặc định ở thư mục <code class=" language-php">app</code>, và cho phép các developer có thể đặt chúng ở nơi khác mà họ muốn.</p>
    <p>
        <a name="the-root-directory"></a>
    </p>
    <h2><a href="#the-root-directory">Thư mục gốc</a></h2>
    <p>
        <a name="the-root-app-directory"></a>
    </p>
    <h4>Thư mục App</h4>
    <p>Thư mục <code class=" language-php">app</code>, như bạn mong đợi, nó sẽ chứa tất cả các cốt lõi trong ứng dụng của bạn. Chúng ta sẽ khám phá vhi tiết về nó sớm thôi; tuy nhiên, hầu hết các class trong ứng dụng của bạn đều ở trong đây.</p>
    <p>
        <a name="the-bootstrap-directory"></a>
    </p>
    <h4>Thư mục Bootstrap</h4>
    <p>Thư mục <code class=" language-php">bootstrap</code> chứa những file khởi động của frameword và những file cấu hình autoloading. Ngoài ra nó còn có thư mục <code class=" language-php">cache</code> chứa những file mà framework sinh ra để tăng hiệu năng như route và services cache files.</p>
    <p>
        <a name="the-config-directory"></a>
    </p>
    <h4>Thư mục Config</h4>
    <p>Thư mục <code class=" language-php">config</code>, đúng như cái tên của nó, chứa tất cả những file cấu hình. Thật tuyệt vời khi bạn lướt qua tất cả các file của nó với những cấu hình có sẵn cho bạn.</p>
    <p>
        <a name="the-database-directory"></a>
    </p>
    <h4>Thư mục Database</h4>
    <p>Thư mục <code class=" language-php">database</code> chứa những file database migration và seeds. Nếu bạn muốn, bạn cũng có thể sử dụng nó để tổ chức một cơ sử dữ liệu SQLite.</p>
    <p>
        <a name="the-public-directory"></a>
    </p>
    <h4>Thư mục Public</h4>
    <p>Thư mục <code class=" language-php"><span class="token keyword">public</span></code> chứa file <code class=" language-php">index<span class="token punctuation">.</span>php</code>, đó là điểm mấu chốt cho tất cả các request vào ứng dụng của bạn. Ngoài ra nó còn chứa một số tài nguyên như ảnh, JavaScript, và CSS.</p>
    <p>
        <a name="the-resources-directory"></a>
    </p>
    <h4>Thư mục Resources</h4>
    <p>Thư mục <code class=" language-php">resources</code> chứa những view và raw, những tài nguyên chưa compiled như LESS, SASS, hoặc JavaScript. Nó còn chứa tất cả các file ngôn ngữ trong ứng dụng của bạn.</p>
    <p>
        <a name="the-routes-directory"></a>
    </p>
    <h4>Thư mục Routes</h4>
    <p>Thư mục <code class=" language-php">routes</code> chứa tất cả các định nghĩa route trong ứng dụng của bạn. Mặc định, có ba file route được thêm vào với Laravel: <code class=" language-php">web<span class="token punctuation">.</span>php</code>, <code class=" language-php">api<span class="token punctuation">.</span>php</code>, và <code class=" language-php">console<span class="token punctuation">.</span>php</code>.</p>
    <p>File <code class=" language-php">web<span class="token punctuation">.</span>php</code> chứa những routes là <code class=" language-php">RouteServiceProvider</code> ở trong <code class=" language-php">web</code> nhóm middleware, Nó cung cấp các trạng thái session, CSRF protection, và cookie encryption. Nếu ứng dụng của bạn không có stateless, RESTful API, thì hầu hết các routes bạn định nghĩa nằm ở file <code class=" language-php">web<span class="token punctuation">.</span>php</code>.</p>
    <p>File <code class=" language-php">api<span class="token punctuation">.</span>php</code> chứa những routes là <code class=" language-php">RouteServiceProvider</code> ở trong <code class=" language-php">api</code> nhóm middleware, nó cung cấp rate limiting. Nhữn routes đã được xác định stateless, vì vậy những request gửi đến ứng dụng của bạn thông qua routes sẽ được xác thực bằng tokens và sẽ không có quyền truy cập trạng thái session.</p>
    <p>File <code class=" language-php">console<span class="token punctuation">.</span>php</code> là nơi để bạn định nghĩa tất cả các Closure based console commands. Each Closure is bound to a command instance allowing a simple approach to interacting with each command's IO methods. Mặc dù nó không định nghĩa HTTP routes, nó định nghĩa console based entry points (routes) trong ứng dụng của bạn.</p>
    <p>
        <a name="the-storage-directory"></a>
    </p>
    <h4>Thư mục Storage</h4>
    <p>Thư mục <code class=" language-php">storage</code> chứa các file compiled Blade templates của bạn, file based sessions, file caches, và những file sinh ra từ framework. Bên trong nó bao gồm <code class=" language-php">app</code>, <code class=" language-php">framework</code>, và <code class=" language-php">logs</code>. Thư mục <code class=" language-php">app</code> dùng để chứa những file sinh ra bởi ứng dụng của bạn. Thư mục <code class=" language-php">framework</code> chứa những file sinh ra từ framework và caches. Cuối cùng, thư mục <code class=" language-php">logs</code> chứa những file logs.</p>
    <p>Thư mục <code class=" language-php">storage<span class="token operator">/</span>app<span class="token operator">/</span><span class="token keyword">public</span></code> lưu những file người dùng tạo ra như ảnh đại diện, nó phải được để công khai. Bạn nên tạo một liên kết tại <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>storage</code> đến thư mục này bằng cách sử dụng lệnh <code class=" language-php">php artisan storage<span class="token punctuation">:</span>link</code>.</p>
    <p>
        <a name="the-tests-directory"></a>
    </p>
    <h4>Thư mục Tests</h4>
    <p>Thư mục <code class=" language-php">tests</code> chứa những file tests của bạn. Ví dụ <a href="https://phpunit.de/">PHPUnit</a> nó cung cấp rất đầy đủ. Mỗi một class test nên chứa hậu tố với từ <code class=" language-php">Test</code>. Bạn có thể chạy class test của bạn bằng lệnh <code class=" language-php">phpunit</code> hoặc <code class=" language-php">php vendor<span class="token operator">/</span>bin<span class="token operator">/</span>phpunit</code>.</p>
    <p>
        <a name="the-vendor-directory"></a>
    </p>
    <h4>Thư mục Vendor</h4>
    <p>The <code class=" language-php">vendor</code> chứa các dependencies của <a href="https://getcomposer.org">Composer</a>.</p>
    <p>
        <a name="the-app-directory"></a>
    </p>
    <h2><a href="#the-app-directory">Thư mục App</a></h2>
    <p>Phần lớn các ứng dụng của bạn đặt ở thư mục <code class=" language-php">app</code>. Mặc định, thư mục này có namespaced là <code class=" language-php">App</code> và được load tự động bởi Composer sử dụng <a href="http://www.php-fig.org/psr/psr-4/">PSR-4 autoloading standard</a>.</p>
    <p>Thư mục <code class=" language-php">app</code> chứa một vài thư mục con bên trong như <code class=" language-php">Console</code>, <code class=" language-php">Http</code>, và <code class=" language-php">Providers</code>. Hãy nghĩ về <code class=" language-php">Console</code> và <code class=" language-php">Http</code> là các thư mục cung cấp AP cho phần code lỗi ứng dụng của bạn. Giao thức HTTP và CLI  là hai cơ chế tương tác với ứng dụng của bạn, nhưng nó không thật sự chứa logic của ứng dụng. Bạn có thể hiểu, Chúng ta có hay cách để thực thi lệnh đến ứng dụng của bạn. Thư mục <code class=" language-php">Console</code> chứa tất cả các lệnh Artisan của bạn, trong khi thư mục <code class=" language-php">Http</code> chứa controllers, middleware, và requests.</p>
    <p>Khi bạn sử dụng lệnh <code class=" language-php">make</code> Artisan thì sẽ có một loạt các thư mục sẽ được tạo ra bên trong thư mục <code class=" language-php">app</code>. Ví dụ, thư mục <code class=" language-php">app<span class="token operator">/</span>Jobs</code> sẽ không tồn tại cho đến khi bạn thực thi lệnh <code class=" language-php">make<span class="token punctuation">:</span>job</code> Artisan sinh ra một class job.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Rất nhiều class được sinh ra bên trong thư mục <code class=" language-php">app</code> bằng lệnh Artisan . Bạn có thể xem lại những lệnh nào đang tồn tại bằng lệnh <code class=" language-php">php artisan list make</code> trong terminal.</p>
    </blockquote>
    <p>
        <a name="the-console-directory"></a>
    </p>
    <h4>Thư mục Console</h4>
    <p>Thư mục <code class=" language-php">Console</code> chứa tất cả những file Artisan commands ứng dụng của bạn. Đó là những lệnh được sinh ra bằng lệnh<code class=" language-php">make<span class="token punctuation">:</span>command</code>. Ngoài ra nó còn chứa console kernel của ứng dụng, nó là nơi bạn có thể chỉnh đăng ký Artisan commands và <a href="#">scheduled tasks</a> được định nghĩa.</p>
    <p>
        <a name="the-events-directory"></a>
    </p>
    <h4>Thư mục Events</h4>
    <p>Mặc định thư mục này không tồn tại, nhưng nó sẽ được sinh ra bằng lệnh <code class=" language-php">event<span class="token punctuation">:</span>generate</code> và lệnh <code class=" language-php">make<span class="token punctuation">:</span>event</code>. Thư mục <code class=" language-php">Events</code>, như bạn mong đợi, nó sẽ chứa các <a href="#">event classes</a>. Events có thể được sử dụng để thông báo các phần khác của ứng dụng của bạn mà hạnh động đấy nhất định xảy ra, ngoài ra nó khả năng của nó rất linh hoạt và decoupling.</p>
    <p>
        <a name="the-exceptions-directory"></a>
    </p>
    <h4>Thư mục Exceptions</h4>
    <p>Thư mục <code class=" language-php">Exceptions</code> chứa các xử lý exception trong ứng dụng của bạn ngoài ra nó còn là nơi tốt để bắn ra nhiều exception bởi ứng dụng. Nếu bạn muốn tùy chỉnh những exception hoặc rendered, bạn nên chỉnh lại class <code class=" language-php">Handler</code> bên trong thư mục.</p>
    <p>
        <a name="the-http-directory"></a>
    </p>
    <h4>Thư mục Http</h4>
    <p>Thư mục <code class=" language-php">Http</code> chứa các controllers, middleware, và form requests. Tất cả các logic xử lý requests vào ứng dụng của bạn sẽ nằm ở trong thư mục này.</p>
    <p>
        <a name="the-jobs-directory"></a>
    </p>
    <h4>The Jobs Directory</h4>
    <p>Mặc định thư mục này không tồn tại, nhưng nó sẽ được sinh ra nếu bạn thực thi lệnh <code class=" language-php">make<span class="token punctuation">:</span>job</code> Artisan. Thư mục <code class=" language-php">Jobs</code> chứa các <a href="{{URL::asset('')}}docs/5.3/queues">queueable jobs</a> ứng dụng của bạn. Jobs có thể được xếp hàng bởi ứng dụng hoặc để chạy đồng bộ bên trong vòng đời request hiện tại. Jobs có thể chạy đồng bộ trong khi request hiện tại là một "commands" khi thực hiện trong <a href="https://en.wikipedia.org/wiki/Command_pattern">command pattern</a>.</p>
    <p>
        <a name="the-listeners-directory"></a>
    </p>
    <h4>Thư mục Listeners</h4>
    <p>Mặc định thư mục này không tồn tại, nhưng nó sẽ được sinh ra nếu bạn thực thi lệnh <code class=" language-php">event<span class="token punctuation">:</span>generate</code> hoặc <code class=" language-php">make<span class="token punctuation">:</span>listener</code> Artisan. Thư mục <code class=" language-php">Listeners</code> chứa các class xử lý các <a href="#">events</a>. Event listeners nhận được một thể hiện event và thực hiện logic khi hồi đáp cho sự kiện đã được bắn ra. Ví dụ, một <code class=" language-php">UserRegistered</code> event phải được sử lý bởi một <code class=" language-php">SendWelcomeEmail</code> listener.</p>
    <p>
        <a name="the-mail-directory"></a>
    </p>
    <h4>Thư mục Mail</h4>
    <p>Mặc định thư mục này không tồn tại, nhưng nó sẽ được sinh ra nếu bạn thực thi lệnh <code class=" language-php">make<span class="token punctuation">:</span>mail</code> Artisan. Thư mục <code class=" language-php">Mail</code> chứa tất cả các class đại diện cho mail được gửi bởi ứng dụng của bạn. Mail objects cho phép bạn đóng gói tất cả các logic thành một, một class có thể được gửi bởi lệnh <code class=" language-php"><span class="token scope">Mail<span class="token punctuation">::</span></span>send</code>.</p>
    <p>
        <a name="the-notifications-directory"></a>
    </p>
    <h4>Thư mục Notifications</h4>
    <p>Mặc định thư mục này không tồn tại, nhưng nó sẽ được sinh ra nếu bạn thực thi lệnh <code class=" language-php">make<span class="token punctuation">:</span>notification</code> Artisan. Thư mục <code class=" language-php">Notifications</code> chứa tất cả các "giao dịch" thông báo đã gửi bởi ứng dụng, ví dụ đơn giải là thông báo về event xảy ra trong ứng dụng của bạn. Ngoài ra notifications của Laravel còn có thể thông báo cho email, Slack, SMS, hoặc lưu trong database.</p>
    <p>
        <a name="the-policies-directory"></a>
    </p>
    <h4>Thư mục Policies</h4>
    <p>Mặc định thư mục này không tồn tại, nhưng nó sẽ được sinh ra nếu bạn thực thi lệnh <code class=" language-php">make<span class="token punctuation">:</span>policy</code> Artisan. Thư mục <code class=" language-php">Policies</code> chứa các lớp quy ước cấp quyền ứng dụng của bạn. Các quy ước được dùng để quyết định user có thể thực hiện hành động đối với một tài nguyên nào đó. Để xem chi tiếp, bạn có thể xem tại <a href="#">authorization documentation</a>.</p>
    <p>
        <a name="the-providers-directory"></a>
    </p>
    <h4>Thư mục Providers</h4>
    <p>Thư mục <code class=" language-php">Providers</code> chứa tất cả các <a href="#">service providers</a> ứng dụng của bạn. Service providers khởi động ứng dụng của bạn bằng các services trong service container, đăng ký events, hoặc thực hiện bất kỳ một công việc khác để chuẩn bị cho request đến ứng dụng của bạn.</p>
    <p>Khi bạn mới cài xong project, thư mục đã chứa một số providers. Bạn có thể thoải mái thêm providers của bạn vào nếu cần.</p>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/structure">https://laravel.com/docs/5.3/structure</a>
</article>
@endsection