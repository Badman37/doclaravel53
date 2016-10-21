@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Cấu hình</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#accessing-configuration-values">Truy cập các giá trị cấu hình</a>
        </li>
        <li><a href="#environment-configuration">Cấu hình môi trường</a>
            <ul>
                <li><a href="#determining-the-current-environment">Xác định môi trường hiện tại</a>
                </li>
            </ul>
        </li>
        <li><a href="#configuration-caching">Cấu hình Caching</a>
        </li>
        <li><a href="#maintenance-mode">Chế độ bảo trì</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Tất cả các files cấu hình của Laravel framework nó sẽ được đặt trong thư mục <code class=" language-php">config</code>. Với mỗi file trong thư mục đó, bạn có thể chỉnh sửa cấu hình theo ý bạn muốn.</p>
    <p>
        <a name="accessing-configuration-values"></a>
    </p>
    <h2><a href="#accessing-configuration-values">Truy cập các giá trị cấu hình</a></h2>
    <p>Bạn có thể sễ dàng lấy được giá trị cấu hình ở bất cứ đâu trong ứng dụng của bạn bằng cách sử dụng hàm toàn cục <code class=" language-php">config</code>. Để lấy giá trị cấu hình bạn sử dụng "dấu chấm", bắt đầu bằng tên của file và giá trị bạn muốn lấy. Giá trị mặc định có thể được trả vè nếu thông số về biến cấu hình đó không tồn tại:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'app.timezone'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Để thiết lập giá trị cấu hình lúc thực thi, bạn truyền vào một mảng <code class=" language-php">config</code> như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">config<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'app.timezone'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'America/Chicago'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="environment-configuration"></a>
    </p>
    <h2><a href="#environment-configuration">Cấu hình môi trường</a></h2>
    <p>Thông thường, nó khá là hữu ích khi ứng dụng của bạn có giá trị cấu hình khác nhau trên các môi trường khác nhau. Giả sử, bạn cấu hình giá trị cache trên local của bạn và trên production của bạn khác nhau.</p>
    <p>Để làm việc đó, Laravel tận dụng thư viện PHP <a href="https://github.com/vlucas/phpdotenv">DotEnv</a> được phát triển bởi Vance Lucas. Khi một ứng dụng mới được cài đặt, tại thư mục gốc sẽ có file <code class=" language-php"><span class="token punctuation">.</span>env<span class="token punctuation">.</span>example</code> file. Nếu bạn cài bằng Laravel Composer, file đấy sẽ tự động đổi tên thành <code class=" language-php"><span class="token punctuation">.</span>env</code>. Nếu không thì bạn cần đổi tên file.</p>
    <h4>Lấy lại cấu hình môi trường</h4>
    <p>Tất cả các biến cấu hình sẽ được nạp bởi hàm PHP toàn cục <code class=" language-php"><span class="token global">$_ENV</span></code> khi ứng dụng của bạn nhận request. Tuy nhiên, bạn có thể sử dụng hàm <code class=" language-php">env</code> để nhận giá trị cấu hình của bạn. Thực tế, nếu bạn xem lại các file cấu hình, bạn sẽ thấy một vài biến đã được sử dụng nó rồi:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'debug'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'APP_DEBUG'</span><span class="token punctuation">,</span> <span class="token boolean">false</span><span class="token punctuation">)</span><span class="token punctuation">,</span></code></pre>
    <p>Giá trị thứ 2 truyền vào hàm <code class=" language-php">env</code> là  "giá trị mặc định". Giá trị truyền vào sẽ được sử dụng nếu không có biến môi trường nào ứng với key đó.</p>
    <p>File <code class=" language-php"><span class="token punctuation">.</span>env</code> không nên đẩy lên source code ứng dụng của bạn, mỗi một developer / server sử dụng ứng dụng của bạn có thể có các cấu hình khác nhau.</p>
    <p>Nếu ứng dụng của bạn phát triển bởi 1 nhóm, bạn có thể tiếp tục lưu lại file <code class=" language-php"><span class="token punctuation">.</span>env<span class="token punctuation">.</span>example</code> trong ứng dụng. Bằng cách đặt các giá trị vào file này, các thành viên khác của nhóm có thể nhìn thấy được các biến môi trường cần thiết để chạy ứng dụng của bạn.</p>
    <p>
        <a name="determining-the-current-environment"></a>
    </p>
    <h3>Xác định môi trường hiện tại</h3>
    <p>Môi trường hiện tại được xác định thông qua biến<code class=" language-php"><span class="token constant">APP_ENV</span></code> trong file <code class=" language-php"><span class="token punctuation">.</span>env</code>. Bạn có thể lấy biến này thông qua hàm <code class=" language-php">environment</code> trong <code class=" language-php">App</code> <a href="#">facade</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$environment</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">::</span></span><span class="token function">environment<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Ngoài ra bạn có thể truyền tham số vào hàm <code class=" language-php">environment</code> để kiểm tra xem môi trường có giống hay không. Hàm này sẽ trả về <code class=" language-php"><span class="token boolean">true</span></code> nếu tham số truyền vào giống với biến môi trường:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">App<span class="token punctuation">::</span></span><span class="token function">environment<span class="token punctuation">(</span></span><span class="token string">'local'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Môi trường local
</span><span class="token punctuation">}</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">App<span class="token punctuation">::</span></span><span class="token function">environment<span class="token punctuation">(</span></span><span class="token string">'local'</span><span class="token punctuation">,</span> <span class="token string">'staging'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Môi trường là  local hoặc staging...
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="configuration-caching"></a>
    </p>
    <h2><a href="#configuration-caching">Cấu hình Caching</a></h2>
    <p>Để tăng hiệu năng cho ứng dụng của bạn, bạn nên cache tất cả các file cấu hình bằng cách sử dụng lệnh <code class=" language-php">config<span class="token punctuation">:</span>cache</code> Artisan command. Lệnh này sẽ gộp tất cả các file cấu hình trong ứng dụng của bạn thành một file duy nhất để tăng tốc độ tải của framework.</p>
    <p>Bạn nên chạy lệnh <code class=" language-php">php artisan config<span class="token punctuation">:</span>cache</code> trên con production của ứng dụng của bạn. Bạn không nên chạy nó ở môi trường phát triển nó vì các thông số cấu hình liên tục thay đổi khi phát triển ứng dụng.</p>
    <p>
        <a name="maintenance-mode"></a>
    </p>
    <h2><a href="#maintenance-mode">Chế độ bảo trì</a></h2>
    <p>Khi ứng dụng của bạn ở chế độ bảo trì, một dao diện sẽ được hiển thị cho tất cả request vào ứng dụng của bạn. Thật dễ để "vô hiệu hóa" ứng dụng của bạn trong khi đang cập nhật hoặc bảo trì. Việc bảo trì nằm trong stack middleware cho ứng dụng của bạn. Nếu ứng dụng của bạn ở chế độ bảo trì, <code class=" language-php">MaintenanceModeException</code> sẽ bắn ra một status code là 503.</p>
    <p>Để bật chế độ bảo trì, bạn chỉ cần thực thi lệnh <code class=" language-php">down</code>:</p>
    <pre class=" language-php"><code class=" language-php">php artisan down</code></pre>
    <p>Ngoài ra bạn có thể cung cấp các lựa trọn <code class=" language-php">message</code> và <code class=" language-php">retry</code> khi thực hiện lệnh <code class=" language-php">down</code>. Nội dung <code class=" language-php">message</code> được dùng để hiển thị hoặc tạo một thông báo, trong khi giá trị <code class=" language-php">retry</code> sẽ được thiết lập như là giá trị <code class=" language-php">Retry<span class="token operator">-</span>After</code> HTTP header's.</p>
    <pre class=" language-php"><code class=" language-php">php artisan down <span class="token operator">--</span>message<span class="token operator">=</span><span class="token string">'Upgrading Database'</span> <span class="token operator">--</span>retry<span class="token operator">=</span><span class="token number">60</span></code></pre>
    <p>Để vô hiệu hóa chế độ bảo trì, sử dụng lệnh <code class=" language-php">up</code>:</p>
    <pre class=" language-php"><code class=" language-php">php artisan up</code></pre>
    <h4>Template chế độ bảo trì</h4>
    <p>Mặc định template chế độ bảo trì nằm tại <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>errors<span class="token operator">/</span><span class="token number">503</span><span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code>. Bạn có thể thay đổi dao diện sao cho phù hợp với ứng dụng của bạn.</p>
    <h4>Chế độ bảo trì &amp; Queues</h4>
    <p>Khi ứng dụng của bạn đang ở chế độ bảo trì, không có <a href="/docs/5.3/queues">queued jobs</a> nào được xử lý. Các jobs sẽ tiếp tục xử lý khi ứng dụng của bạn vô hiệu hóa chế độ bảo trì.</p>
    <h4>Giải pháp khác cho chế độ bảo trì</h4>
    <p>Vì chế độ bảo trì yêu cầu ứng dụng của bạn bị down trong vài giây, bạn có thể cân nhắc việc sử dụng cách khác như <a href="https://envoyer.io">Envoyer</a> không có thời gian down khi triển khai với Laravel.</p>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/configuration">https://laravel.com/docs/5.3/configuration</a></div>
    
</article>
@endsection