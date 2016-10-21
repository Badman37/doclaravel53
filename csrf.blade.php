@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Bảo mật CSRF</h1>
    <ul>
        <li><a href="#csrf-introduction">Giới thiệu</a>
        </li>
        <li><a href="#csrf-excluding-uris">Loại bỏ URIs</a>
        </li>
        <li><a href="#csrf-x-csrf-token">X-CSRF-Token</a>
        </li>
        <li><a href="#csrf-x-xsrf-token">X-XSRF-Token</a>
        </li>
    </ul>
    <p>
        <a name="csrf-introduction"></a>
    </p>
    <h2><a href="#csrf-introduction">Giới thiệu</a></h2>
    <p>Laravel rất dễ dàng để bảo vệ các ứng dụng của bạn từ tấn công giả mạo <a href="http://en.wikipedia.org/wiki/Cross-site_request_forgery">cross-site request forgery</a> (CSRF). Cross-site request forgery là một loại mã độc, theo đó các lệnh trái phép được thực hiện thay cho một người dùng đã xác thực.</p>
    <p>Laravel tự động tạo ra một CSRF "token" cho mỗi người dùng hoạt động quản lý bởi ứng dụng. Mã này dùng để xác minh rằng người dùng là một trong những người dùng thực sự gửi yêu cầu đến ứng dụng.</p>
    <p>Bất cứ khi nào bạn tạo mộ HTML form trong ứng dụng, bạn phải thêm trường CSRF token vào trong form để bảo mật CSRF middleware có thể xác nhận request. Bạn có thể sử dụng <code class=" language-php">csrf_field</code> để sinh ra trường đấy:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>form</span> <span class="token attr-name">method</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>POST<span class="token punctuation">"</span></span> <span class="token attr-name">action</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>/profile<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
    <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">csrf_field<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
    <span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>form</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>Class <code class=" language-php">VerifyCsrfToken</code> <a href="/docs/5.3/middleware">middleware</a>, bao gồm nhóm <code class=" language-php">web</code> middleware , sẽ tự động xác minh token từ request input giống với token lưu trong session.</p>
    <p>
        <a name="csrf-excluding-uris"></a>
    </p>
    <h2><a href="#csrf-excluding-uris">Loại bỏ URIs khỏi bảo mật CSRF</a></h2>
    <p>Thỉnh thoảng bạn muốn loại bỏ URIs khỏi bảo mật CSRF. Ví dụ, nếu bạn sử dụng <a href="https://stripe.com">Stripe</a> để xử lý thanh toán và được sử dụng hệ thống webhook của họ, bạn sẽ cần loại bỏ các xử lý route từ bảo mật CSRRF của Stripe webhook, khi đấy Stripe sẽ không biết CSRF token gửi từ route của bạn.</p>
    <p>Thông thường, bạn nên loại bỏ các loại routes từ bên ngoài nhóm middleware <code class=" language-php">web</code> mà <code class=" language-php">RouteServiceProvider</code> áp dụng cho tất cả các route trong <code class=" language-php">routes<span class="token operator">/</span>web<span class="token punctuation">.</span>php</code> file. Tuy nhiên, bạn có thể loại bỏ route bằng cách thêm URIs vào thuộc tính <code class=" language-php"><span class="token variable">$except</span></code> trong middleware <code class=" language-php">VerifyCsrfToken</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>VerifyCsrfToken</span> <span class="token keyword">as</span> BaseVerifier<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">VerifyCsrfToken</span> <span class="token keyword">extends</span> <span class="token class-name">BaseVerifier</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$except</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
        <span class="token string">'stripe/*'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="csrf-x-csrf-token"></a>
    </p>
    <h2><a href="#csrf-x-csrf-token">X-CSRF-TOKEN</a></h2>
    <p>Ngoài việc kiểm tra CSRF token như 1 tham số POST, middleware <code class=" language-php">VerifyCsrfToken</code> ngoài ra cũng kiểm tra các yêu cầu <code class=" language-php">X<span class="token operator">-</span><span class="token constant">CSRF</span><span class="token operator">-</span><span class="token constant">TOKEN</span></code> request header. Bạn có thể, ví dụ, lưu token trong thẻ <code class=" language-php">meta</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>meta</span> <span class="token attr-name">name</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>csrf-token<span class="token punctuation">"</span></span> <span class="token attr-name">content</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>{{ csrf_token() }}<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>Sau đó, khi bạn đã tạo ra thẻ <code class=" language-php">meta</code>, bạn có thể chỉ định một thư viên như jQuery để tự động thêm tất cả request header. Điều này rất đơn giản, thuận tiện để bảo mật CSRF các ứng dụng AJAX của bạn:</p>
    <pre class=" language-php"><code class=" language-php">$<span class="token punctuation">.</span><span class="token function">ajaxSetup<span class="token punctuation">(</span></span><span class="token punctuation">{</span>
    headers<span class="token punctuation">:</span> <span class="token punctuation">{</span>
        <span class="token string">'X-CSRF-TOKEN'</span><span class="token punctuation">:</span> $<span class="token punctuation">(</span><span class="token string">'meta[name="csrf-token"]'</span><span class="token punctuation">)</span><span class="token punctuation">.</span><span class="token function">attr<span class="token punctuation">(</span></span><span class="token string">'content'</span><span class="token punctuation">)</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="csrf-x-xsrf-token"></a>
    </p>
    <h2><a href="#csrf-x-xsrf-token">X-XSRF-TOKEN</a></h2>
    <p>Laravel lưu CSRF token hiện tại trong <code class=" language-php"><span class="token constant">XSRF</span><span class="token operator">-</span><span class="token constant">TOKEN</span></code> cookie mỗi khi có response tạo ra bởi framework. Bạn có thể sử dụng cookie để đặt giá trị  các yêu cầu<code class=" language-php">X<span class="token operator">-</span><span class="token constant">XSRF</span><span class="token operator">-</span><span class="token constant">TOKEN</span></code> request header.</p>
    <p>Cookie này chủ yếu gửi như một tiện nghi, kể từ khi có JavaScript frameworks, như Angular, nó tự động thêm giá trị vào <code class=" language-php">X<span class="token operator">-</span><span class="token constant">XSRF</span><span class="token operator">-</span><span class="token constant">TOKEN</span></code> header.</p>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/csrf">https://laravel.com/docs/5.3/csrf</a></div>
</article>
@endsection