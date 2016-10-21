@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Middleware</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#defining-middleware">Tạo Middleware</a>
        </li>
        <li><a href="#registering-middleware">Đăng ký Middleware</a>
            <ul>
                <li><a href="#global-middleware">Global Middleware</a>
                </li>
                <li><a href="#assigning-middleware-to-routes">Gán Middleware vào Routes</a>
                </li>
                <li><a href="#middleware-groups">Nhóm Middleware</a>
                </li>
            </ul>
        </li>
        <li><a href="#middleware-parameters">Tham số Middleware</a>
        </li>
        <li><a href="#terminable-middleware">Terminable Middleware</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Middleware cung cấp một giải pháp khá tiện ích cho việc filtering HTTP các requests vào ứng dụng. Ví dụ, Laravel có chứa một middleware xác thực người dùng đăng nhập vào hệ thống. Nếu user chưa đăng nhập, middleware sẽ chuyển hướng user tới màn hình đăng nhập. Tuy nhiên, nếu user đã đăng nhập rồi, thì middleware sẽ cho phép request được thực hiện tiếp tiến trình xử lý vào ứng dụng.</p>
    <p>Tất nhiên, bạn có thể viết thêm middleware để thực hiện nhiều tác vụ nữa ngoài kiểm tra đăng nhập vào hệ thống. Một CORS middleware có trách nhiệm cho việc thêm các header hợp lý vào trong tất cả các response gửi ra ngoài. Một logging middleware có thể ghi log cho tất cả các request tới ứng dụng.</p>
    <p>Có vài middleware đã có sẵn trong Laravel framework, bao gồm middlware xác thực, CSRF protection. Tất cả được nằm trong thư mục <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Middleware</code>.</p>
    <p>
        <a name="defining-middleware"></a>
    </p>
    <h2><a href="#defining-middleware">Tạo Middleware</a></h2>
    <p>Để tạo mới một middleware, sử dụng lệnh <code class=" language-php">make<span class="token punctuation">:</span>middleware</code> Artisan:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>middleware CheckAge</code></pre>
    <p>Câu lệnh này sẽ tạo ra class <code class=" language-php">CheckAge</code> bên trong thư mục <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Middleware</code>. Trong middleware này, chúng ta chỉ cho phép truy cập vào route nếu giá trị <code class=" language-php">age</code> lớn hơn 200. Ngược lại, chúng ta sẽ chuyển hướng request lại trang <code class=" language-php">home</code> URI.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Closure</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">CheckAge</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> Closure <span class="token variable">$next</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">age</span> <span class="token operator">&lt;=</span> <span class="token number">200</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'home'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>

        <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

<span class="token punctuation">}</span></code></pre>
    <p>Như bạn thấy, nếu biến <code class=" language-php">age</code> nhỏ hơn hoặc bằng <code class=" language-php"><span class="token number">200</span></code>, middleware sẽ trả về một  HTTP tới client; ngược lại, request sẽ được gửi tiếp để xử lý. Để truyền request vào sâu hơn trong ứng dụng (cho phép middleware "vượt qua"), đơn giản chỉ cần gọi callback <code class=" language-php"><span class="token variable">$next</span></code> với <code class=" language-php"><span class="token variable">$request</span></code>.</p>
    <p>Tốt nhất hãy hình dung như là một chuỗi các "lớp" trên HTTP requests cần phải đi qua trước khi nó vào ứng dụng. Mỗi lớp sẽ được kiểm tra request và thậm chí có thể hủy từ chối request hoàn toàn.</p>
    <h3>Trước &amp; Sau Middleware</h3>
    <p>Việc middleware chạy trước hay chạy sau một request phụ thuộc vào chính nó. Ví dụ, middleware dưới đây sẽ làm một vào tác vụ <strong>trước khi</strong>  request được chương trình xử lý:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Closure</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">BeforeMiddleware</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> Closure <span class="token variable">$next</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Perform action
</span>
        <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Tất nhiên, middleware này sẽ thực hiện việc của nó <strong>sau khi</strong> request được xử lý bởi ứng dụng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Closure</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AfterMiddleware</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> Closure <span class="token variable">$next</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Perform action
</span>
        <span class="token keyword">return</span> <span class="token variable">$response</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="registering-middleware"></a>
    </p>
    <h2><a href="#registering-middleware">Đăng ký Middleware</a></h2>
    <p>
        <a name="global-middleware"></a>
    </p>
    <h3>Global Middleware</h3>
    <p>Nếu bạn muốn một middleware có thể thực thi trong mọi HTTP request tới ứng dụng của bạn, đơn giản chỉ cần thêm tên class của middleware trong thuộc tính <code class=" language-php"><span class="token variable">$middleware</span></code> của class <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Kernel<span class="token punctuation">.</span>php</code>.</p>
    <p>
        <a name="assigning-middleware-to-routes"></a>
    </p>
    <h3>Gán Middleware vào Routes</h3>
    <p>Nếu bạn muốn gán middleware cho route cụ thể, đầu tiên bạn cần thêm middleware đấy vào trong file <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Kernel<span class="token punctuation">.</span>php</code>. Mặc định, thuộc tính <code class=" language-php"><span class="token variable">$routeMiddleware</span></code> sẽ chứa một số class thuộc middleware của framework Laravel. Để thêm middleware của bạn, đơn giản chỉ là thêm nó vào dach sách và gán từ khóa bạn chọn. Ví dụ:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Within App\Http\Kernel Class...
</span>
<span class="token keyword">protected</span> <span class="token variable">$routeMiddleware</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'auth'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> \<span class="token scope">Illuminate<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>Authenticate<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token string">'auth.basic'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> \<span class="token scope">Illuminate<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>AuthenticateWithBasicAuth<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token string">'bindings'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> \<span class="token scope">Illuminate<span class="token punctuation">\</span>Routing<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>SubstituteBindings<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token string">'can'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> \<span class="token scope">Illuminate<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>Authorize<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token string">'guest'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> \<span class="token scope">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>RedirectIfAuthenticated<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token string">'throttle'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> \<span class="token scope">Illuminate<span class="token punctuation">\</span>Routing<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>ThrottleRequests<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <p>Khi middleware đã được định nghĩa trong HTTP kernel, bạn có thể sử dụng phương thức <code class=" language-php">middleware</code> gán cho một route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'admin/profile'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Ngoài ra bạn cũng có thể gán nhiều middleware cho một route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'first'</span><span class="token punctuation">,</span> <span class="token string">'second'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Khi đã gán middleware, bạn cũng có thể sử dụng tên đầy đủ của middleware:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>CheckAge</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'admin/profile'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token scope">CheckAge<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="middleware-groups"></a>
    </p>
    <h3>Nhóm Middleware</h3>
    <p>Thỉnh thoảng bạn muốn nhóm một vài middleware lại trong một khóa để thực hiện gán vào route dễ dàng hơn. Bạn có thể sử dụng thuộc tính <code class=" language-php"><span class="token variable">$middlewareGroups</span></code> của HTTP kernel.</p>
    <p>Mặc định, Laravel cung cấp sắp 2 nhóm middleware <code class=" language-php">web</code> và <code class=" language-php">api</code> chứa những middleware thường sử dụng mà bạn có thể muốn áp dụng cho web UI và API routes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * The application's route middleware groups.
 *
 * @var array
 */</span>
<span class="token keyword">protected</span> <span class="token variable">$middlewareGroups</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'web'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        \<span class="token scope">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>EncryptCookies<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
        \<span class="token scope">Illuminate<span class="token punctuation">\</span>Cookie<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>AddQueuedCookiesToResponse<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
        \<span class="token scope">Illuminate<span class="token punctuation">\</span>Session<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>StartSession<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
        \<span class="token scope">Illuminate<span class="token punctuation">\</span>View<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>ShareErrorsFromSession<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
        \<span class="token scope">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>VerifyCsrfToken<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
        \<span class="token scope">Illuminate<span class="token punctuation">\</span>Routing<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>SubstituteBindings<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'api'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'throttle:60,1'</span><span class="token punctuation">,</span>
        <span class="token string">'auth:api'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <p>Nhóm middleware được gán vào routes và controller sử dụng cú pháp tương tự như với từng middleware. Một lần nữa, nhóm middleware làm đơn giản trong việc gán các middleware vào trong một route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'web'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">group<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'middleware'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'web'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Chú ý, Nhóm <code class=" language-php">web</code> middleware được tự động áp dụng trong file <code class=" language-php">routes<span class="token operator">/</span>web<span class="token punctuation">.</span>php</code> qua <code class=" language-php">RouteServiceProvider</code>.</p>
    </blockquote>
    <p>
        <a name="middleware-parameters"></a>
    </p>
    <h2><a href="#middleware-parameters">Tham số middleware</a></h2>
    <p>Middleware cũng có thể nhận thêm các tham số truyền vào. Ví dụ, nếu ứng dụng của bạn cần xác thực có "role" cụ thể trước khi thực hiện một thao tác nào đó, bạn có thể tạo một <code class=" language-php">CheckRole</code> middleware để nhận tên của role như một tham số.</p>
    <p>Thêm các tham số middleware sẽ dược truyền vào middleware ngay sau tham số <code class=" language-php"><span class="token variable">$next</span></code> của hàm handle:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Closure</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">CheckRole</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> Closure <span class="token variable">$next</span><span class="token punctuation">,</span> <span class="token variable">$role</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token operator">!</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasRole<span class="token punctuation">(</span></span><span class="token variable">$role</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // Redirect...
</span>        <span class="token punctuation">}</span>

        <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

<span class="token punctuation">}</span></code></pre>
    <p>Tham số middleware có thể được khai báo trên route bằng cách phân chia tên middleware và tham số bởi dấu <code class=" language-php"><span class="token punctuation">:</span></code>. nhiều thao số thì phân chia bởi dấy phẩy:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'post/{id}'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'role:editor'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="terminable-middleware"></a>
    </p>
    <h2><a href="#terminable-middleware">Terminable Middleware</a></h2>
    <p>Thỉnh thoảng một middleware có thể cần thực hiện sau khi HTTP response đã được gửi xong cho trình duyệt. Ví dụ, "session" middleware đi kèm với Laravel cung cấp dữ liệu session cho storage sau khi response được gửi tới trình duyệt. Nếu bạn định nghĩa một <code class=" language-php">terminate</code> vào trong middleware, nó sẽ tự động được gọi sau khi response được gửi tới trình duyệt.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Session<span class="token punctuation">\</span>Middleware</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Closure</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">StartSession</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> Closure <span class="token variable">$next</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">terminate<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$response</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Store the session data...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Hàm <code class=" language-php">terminate</code> sẽ nhận cả request và response. Khi bạn đã định nghĩa terminable middleware, bạ phải thêm nó vào trong danh sách global middleware trong HTTP kernel.</p>
    <p>Khi gọi hàm <code class=" language-php">terminate</code> trong middleware, Laravel sẽ thực hiện giải quyết trường hợp mới cho middleware từ  <a href="/docs/5.3/container">service container</a>. Nếu bạn muốn sử dụng cùng một trường hợp khi mà hàm <code class=" language-php">handle</code> và hàm <code class=" language-php">terminate</code> dduwcoj gọi, đăng ký middleware vào trong container sử dụng hàm <code class=" language-php">singleton</code>.</p>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/middleware">https://laravel.com/docs/5.3/middleware</a></div>
</article>
@endsection