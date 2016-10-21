@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Errors &amp; Logging</h1>
    <ul>
        <li><a href="#introduction">Gới thiệu</a>
        </li>
        <li><a href="#configuration">Cấu hình</a>
            <ul>
                <li><a href="#error-detail">Chi tiết Error</a>
                </li>
                <li><a href="#log-storage">Lưu trữ Log</a>
                </li>
                <li><a href="#log-severity-levels">Các mức độ của Log</a>
                </li>
                <li><a href="#custom-monolog-configuration">Tùy biến cấu hình Monolog</a>
                </li>
            </ul>
        </li>
        <li><a href="#the-exception-handler">The Exception Handler</a>
            <ul>
                <li><a href="#report-method">Phương thức Report</a>
                </li>
                <li><a href="#render-method">Phương thức Render</a>
                </li>
            </ul>
        </li>
        <li><a href="#http-exceptions">HTTP Exceptions</a>
            <ul>
                <li><a href="#custom-http-error-pages">Tùy biến HTTP Error Pages</a>
                </li>
            </ul>
        </li>
        <li><a href="#logging">Logging</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Khi bạn bắt đâu với một project mới, việc xử lý về error và exception đã được cấu hình cho bạn rồi. Class <code class=" language-php">App\<span class="token package">Exceptions<span class="token punctuation">\</span>Handler</span></code>  là nơi mà tất cả đã được trigger ứng dụng của bạn đang đăng nhập và trả lại cho người dùng. Chúng ta sẽ tìm hiểu sâu hơn về nó trong suốt tài liệu này.</p>
    <p>Đối với logging, Laravel tích hợp thư viện <a href="https://github.com/Seldaek/monolog">Monolog</a>, nó cung cấp rất một loạt các xử lý rất hay. Laravel cấu hình một vài sử lý đó cho bạn, cho phép bạn chọn giữa một hoặc nhiều file log, hoặc viết thông tin error vào hệ thống log.</p>
    <p>
        <a name="configuration"></a>
    </p>
    <h2><a href="#configuration">Cấu hình</a></h2>
    <p>
        <a name="error-detail"></a>
    </p>
    <h3>Chi tiết Error</h3>
    <p>Lựa chọn <code class=" language-php">debug</code> bên trong <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> cho phép thông tin về error thực sự hiển thị cho người dùng. Mặc định, cấu hình này thiết lập dựa trên biến môi trường <code class=" language-php"><span class="token constant">APP_DEBUG</span></code>, lưu trong file <code class=" language-php"><span class="token punctuation">.</span>env</code>.</p>
    <p>Trong môi trường phát triển local, bạn nên đặt giá trị biến <code class=" language-php"><span class="token constant">APP_DEBUG</span></code>  thành <code class=" language-php"><span class="token boolean">true</span></code>. Đối với môi trường production, giá trị này phải luôn luôn là <code class=" language-php"><span class="token boolean">false</span></code>. Nếu giá trị này là <code class=" language-php"><span class="token boolean">true</span></code> trên môi trường production, người dùng có thể sẽ thấy được các giá trị cấu hình ứng dụng của bạn.</p>
    <p>
        <a name="log-storage"></a>
    </p>
    <h3>Lưu trữ Log</h3>
    <p>Cơ bản, Laravel hỗ trợ các chế độ <code class=" language-php">single</code> files, <code class=" language-php">daily</code> files, the <code class=" language-php">syslog</code>, và <code class=" language-php">errorlog</code>. Để cấu hình cơ chế lưu trữ log của Laravel, bạn có thể chỉnh <code class=" language-php">log</code> trong file <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code>. Ví dụ, nếu bạn muốn sử dụng log file hàng ngày thay vì log một file, bạn có thể đặt <code class=" language-php">log</code> trong file <code class=" language-php">app</code> thành <code class=" language-php">daily</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'log'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'daily'</span></code></pre>
    <h4>Giới hạn thời gian file Daily Log</h4>
    <p>Khi bạn sử dụng chế độ <code class=" language-php">daily</code> log, mặc định Laravel chỉ để lại files log năm ngày gần nhất. Nếu bạn muốn thay đổi số ngày đó, bạn cần thêm 1 dòng <code class=" language-php">log_max_files</code> vào trong file <code class=" language-php">app</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'log_max_files'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">30</span></code></pre>
    <p>
        <a name="log-severity-levels"></a>
    </p>
    <h3>Các mức độ của Log</h3>
    <p>Khi sử dụng Monolog, nội dung tin nhắn log có thể khác cấp độ với nhau. mặc định, Laravel viết tất cả các cấp độ log được lưu trữ lại. Tuy nhiên, trong môi trường production, bạn có thể giới hạn cấp độ bằng cách thêm <code class=" language-php">log_level</code> trong file <code class=" language-php">app<span class="token punctuation">.</span>php</code>.</p>
    <p>Khi tùy biến đã được cấu hình, Laravel sẽ log tất cả những cấp độ cao hơn hoặc bằng cấp độ tùy biến. Ví dụ, mặc định <code class=" language-php">log_level</code> của <code class=" language-php">error</code> sẽ log nội dung <strong>error</strong>, <strong>critical</strong>, <strong>alert</strong>, and <strong>emergency</strong>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'log_level'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'APP_LOG_LEVEL'</span><span class="token punctuation">,</span> <span class="token string">'error'</span><span class="token punctuation">)</span><span class="token punctuation">,</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Monolog quy định mức độ theo thứ tự từ nhỏ đến theo theo thứ tự sau: <code class=" language-php">debug</code>, <code class=" language-php">info</code>, <code class=" language-php">notice</code>, <code class=" language-php">warning</code>, <code class=" language-php">error</code>, <code class=" language-php">critical</code>, <code class=" language-php">alert</code>, <code class=" language-php">emergency</code>.</p>
    </blockquote>
    <p>
        <a name="custom-monolog-configuration"></a>
    </p>
    <h3>Tùy biến cấu hình Monolog</h3>
    <p>Nếu bạn muốn điều chỉnh toàn bộ quy trình  Monolog trong ứng dụng của bạn, bạn có thể sử dụng phương thức <code class=" language-php">configureMonologUsing</code> method. Bạn nên gọi phương thức xử lý này trong file <code class=" language-php">bootstrap<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> ngay trước biến <code class=" language-php"><span class="token variable">$app</span></code> được trả về:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">configureMonologUsing<span class="token punctuation">(</span></span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$monolog</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$monolog</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">pushHandler<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token variable">$app</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="the-exception-handler"></a>
    </p>
    <h2><a href="#the-exception-handler">The Exception Handler</a></h2>
    <p>
        <a name="report-method"></a>
    </p>
    <h3>Phương thức report</h3>
    <p>Tất cả các exception được xử lý bởi class <code class=" language-php">App\<span class="token package">Exceptions<span class="token punctuation">\</span>Handler</span></code>. Class này chứa 2 phương thức: <code class=" language-php">report</code> và <code class=" language-php">render</code>. Chúng ta sẽ xem xét chi tiết hai phương thức này. Phương thức <code class=" language-php">report</code> được sử dụng để log các exception hoặc gửi chúng tới các dịch vụ ngoài như <a href="https://bugsnag.com">Bugsnag</a> hoặc <a href="https://github.com/getsentry/sentry-laravel">Sentry</a>. Mặc định, Phương thức <code class=" language-php">report</code> đơn giải chỉ đấy các exception về class nơi mà exception được log lại. Tuy nhiên, bạn có thể hoàn toàn tùy biến theo ý bạn muốn.</p>
    <p>Ví dụ, nếu bạn cần report nhiều kiểu exception theo nhiều cách khác nhau, bạn có thể sử dụng toán tử kiểm tra của PHP <code class=" language-php"><span class="token keyword">instanceof</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Report or log an exception.
 *
 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
 *
 * @param  \Exception  $exception
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">report<span class="token punctuation">(</span></span>Exception <span class="token variable">$exception</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$exception</span> <span class="token keyword">instanceof</span> <span class="token class-name">CustomException</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>

    <span class="token keyword">return</span> <span class="token scope"><span class="token keyword">parent</span><span class="token punctuation">::</span></span><span class="token function">report<span class="token punctuation">(</span></span><span class="token variable">$exception</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Loại bỏ exception theo kiểu</h4>
    <p>Thuộc tính <code class=" language-php"><span class="token variable">$dontReport</span></code> của handler chứa một mảng các kiểu exception sẽ không cần log. Ví dụ, exceptions của lỗi 404, cũng như mội vài kểu lỗi khác, sẽ không được lưu vào file log. Bạn có thể thêm kểu exception khác vào mảng nếu cần thiết:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * A list of the exception types that should not be reported.
 *
 * @var array
 */</span>
<span class="token keyword">protected</span> <span class="token variable">$dontReport</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    \<span class="token scope">Illuminate<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>AuthenticationException<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    \<span class="token scope">Illuminate<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>Access<span class="token punctuation">\</span>AuthorizationException<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    \<span class="token scope">Symfony<span class="token punctuation">\</span>Component<span class="token punctuation">\</span>HttpKernel<span class="token punctuation">\</span>Exception<span class="token punctuation">\</span>HttpException<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    \<span class="token scope">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>ModelNotFoundException<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    \<span class="token scope">Illuminate<span class="token punctuation">\</span>Validation<span class="token punctuation">\</span>ValidationException<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="render-method"></a>
    </p>
    <h3>Phương thức Render </h3>
    <p>Phương thức <code class=" language-php">render</code> có tránh nhiệm chuyển đổi một exception thành một HTTP response để trả lại cho trình duyệt. Mặc định, exception được đẩy tới class cơ sở để tạo một response cho bạn. Tuy nhiên, bạn có thể thoải mái trong việc kiểm tra kiểu exception và trả về response tùy biến theo ý của bạn:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Render an exception into an HTTP response.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Exception  $exception
 * @return \Illuminate\Http\Response
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">render<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> Exception <span class="token variable">$exception</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$exception</span> <span class="token keyword">instanceof</span> <span class="token class-name">CustomException</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'errors.custom'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token number">500</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">return</span> <span class="token scope"><span class="token keyword">parent</span><span class="token punctuation">::</span></span><span class="token function">render<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$exception</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="http-exceptions"></a>
    </p>
    <h2><a href="#http-exceptions">HTTP Exceptions</a></h2>
    <p>Một số exceptions miêu tả mã HTTP từ server. Ví dụ, đây có thể là một lỗi "page not found" (404), một lỗi "unauthorized error" (401) hoặc lỗi 500. Để tạo ra response tương ứng với mã lỗi ở bất kỳ đâu trong ứng dụng, bạn có thể sử dụng phương thức <code class=" language-php">abort</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">abort<span class="token punctuation">(</span></span><span class="token number">404</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Phương thức <code class=" language-php">abort</code> sẽ lập tức đẩy ra một exception sẽ được render bởi exception handler. Bạn cũng có thể tùy chọn cung cấp thêm nội dung response:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">abort<span class="token punctuation">(</span></span><span class="token number">403</span><span class="token punctuation">,</span> <span class="token string">'Unauthorized action.'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="custom-http-error-pages"></a>
    </p>
    <h3>Tùy biến HTTP Error Pages</h3>
    <p>Laravel làm việc trả về trang lỗi tùy biến tương ứng với mã HTTP status rất dễ dàng. Ví dụ, nếu bạn chỉnh sửa trang lỗi tương ứng với mã 404 HTTP status, chỉ việc tạo một file <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>errors<span class="token operator">/</span><span class="token number">404</span><span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code>. File này sẽ được gọi ra khi có lỗi 404 HTTP status được sinh ra trong ứng dụng của bạn. Các view nằm trong thư mục này phải trùng với mã lỗi HTTP status. <code class=" language-php">HttpException</code> có hàm <code class=" language-php">abort</code> nó sẽ được xem như là một biến <code class=" language-php"><span class="token variable">$exception</span></code>.</p>
    <p>
        <a name="logging"></a>
    </p>
    <h2><a href="#logging">Logging</a></h2>
    <p>Laravel cung cấp một lớp abstraction đơn giản ở trên thư viện <a href="http://github.com/seldaek/monolog">Monolog</a>. Mặc định, Laravel cấu hình tạo ra file log cho ứng dụng cuản bạn trong thư mục <code class=" language-php">storage<span class="token operator">/</span>logs</code>. Bạn có thể viết thêm nội dung vào trong logs sử dụng <code class=" language-php">Log</code> <a href="/docs/5.3/facades">facade</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Log</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">showProfile<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">info<span class="token punctuation">(</span></span><span class="token string">'Showing user profile for user: '</span><span class="token punctuation">.</span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'user.profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'user'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">findOrFail<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Logger cung cấp 8 cấp độ cơ bản theo định nghĩa <a href="http://tools.ietf.org/html/rfc5424">RFC 5424</a>: <strong>emergency</strong>, <strong>alert</strong>, <strong>critical</strong>, <strong>error</strong>, <strong>warning</strong>, <strong>notice</strong>, <strong>info</strong> and <strong>debug</strong>.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">emergency<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">alert<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">critical<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">error<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">warning<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">notice<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">info<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">debug<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Thông tin theo ngữ cảnh</h4>
    <p>Một mảng dữ liệu theo ngữ cảnh có thể được truyền vào trong phương thức Log. Các dữ liệu này sẽ được format và hiển thị cùng với nội dung log:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">info<span class="token punctuation">(</span></span><span class="token string">'User failed to login.'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Truy cập vào đối tượng phía dưới Monolog</h4>
    <p>Monolog có một số hander bổ sung mà bạn có thể sử dụng nó cho việc log. Nếu cần thiết, bạn có thể truy cập vào đối tường phía dưới của Monolog bằng cách:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$monolog</span> <span class="token operator">=</span> <span class="token scope">Log<span class="token punctuation">::</span></span><span class="token function">getMonolog<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/errors">https://laravel.com/docs/5.3/errors</a> </div>
</article>
@endsection