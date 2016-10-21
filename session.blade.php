@extends('documents.laravel53.layout')

@section('content')
<article>
		<h1>HTTP Session</h1>
<ul>
<li><a href="#introduction">Giới thiệu</a>
<ul>
<li><a href="#configuration">Caais hình</a></li>
<li><a href="#driver-prerequisites">Driver Prerequisites</a></li>
</ul></li>
<li><a href="#using-the-session">Sử dụng Session</a>
<ul>
<li><a href="#retrieving-data">Nhận dữ liệu</a></li>
<li><a href="#storing-data">Lưu dữ liệu</a></li>
<li><a href="#flash-data">Flash dữ liệu</a></li>
<li><a href="#deleting-data">Xóa dữ liệu</a></li>
<li><a href="#regenerating-the-session-id">Regenerating The Session ID</a></li>
</ul></li>
<li><a href="#adding-custom-session-drivers">Thêm tùy biến Session Drivers</a>
<ul>
<li><a href="#implementing-the-driver">Implementing The Driver</a></li>
<li><a href="#registering-the-driver">Đăng ký The Driver</a></li>
</ul></li>
</ul>
<p><a name="introduction"></a></p>
<h2><a href="#introduction">Giới thiệu</a></h2>
<p>Khi hệ thống HTTP không có chỗ lưu trữ, sessions cung cấp một cách để lưu thông tin từ các yêu cầu của người dùng. Laravel cung cấp đầy đủ session backends thông qua API để hỗ trợ việc này. Hỗ trợ các backend như <a href="http://memcached.org">Memcached</a>, <a href="http://redis.io">Redis</a>, và cơ sở dữ liệu đã có sẵn.</p>
<p><a name="configuration"></a></p>
<h3>Cấu hình</h3>
<p>File cấu hình session lưu ở <code class=" language-php">config<span class="token operator">/</span>session<span class="token punctuation">.</span>php</code>. Hãy chắc rằng bạn nắm rõ tất cả các thông tin cấu hình của session trước khi tùy chỉnh lại tệp tin này. Mặc định, Laravel sẽ cấu hình sử dụng <code class=" language-php">file</code> session driver, nó sẽ hoạt động tốt cho nhiều ứng dụng. Đối với production, bạn có thể cân nhắc sử dụng <code class=" language-php">memcached</code> hoặc <code class=" language-php">redis</code> drivers để cho hiệu năng của session tốt hơn.</p>
<p>Các session <code class=" language-php">driver</code> được định nghĩa là nơi lưu trữ dữ liệu session qua các request. Laravel đã tích hợp sẵn một số session driver sau:</p>
<div class="content-list">
<ul>
<li><code class=" language-php">file</code> - sessions sẽ lưu tại <code class=" language-php">storage<span class="token operator">/</span>framework<span class="token operator">/</span>sessions</code>.</li>
<li><code class=" language-php">cookie</code> - sessions sẽ lưu có bảo mật, mã hóa cookies.</li>
<li><code class=" language-php">database</code> - sessions sẽ lưu trong cơ sở dữ liệu được dùng trong ứng dụng của bạn.</li>
<li><code class=" language-php">memcached</code> / <code class=" language-php">redis</code> - sessions sẽ lưu và truy suất nhanh hơn, dựa trên cache.</li>
<li><code class=" language-php"><span class="token keyword">array</span></code> - sessions sẽ được lưu trong mảng PHP và sẽ tồn tại lâu.</li>
</ul>
</div>
<blockquote class="has-icon tip">
<p><div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span></div> Với array driver chỉ nên sử dụng khi chạy <a href="{{URL::asset('')}}docs/5.3/testing">testing</a> để có các dữ liệu tồn tại trong thời gian dài.</p>
</blockquote>
<p><a name="driver-prerequisites"></a></p>
<h3>Driver Prerequisites</h3>
<h4>Cơ sở dữ liệu</h4>
<p>Khi sử dụng <code class=" language-php">database</code> session driver, bạn cần phải tạo bảng chứa dữ liệu session trong cơ sở dữ liệu. Bên dưới là một ví dụ <code class=" language-php">Schema</code> dùng tạo bảng:</p>
<pre class=" language-php"><code class=" language-php"><span class="token scope">Schema<span class="token punctuation">::</span></span><span class="token function">create<span class="token punctuation">(</span></span><span class="token string">'sessions'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$table</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'id'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unique<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">integer<span class="token punctuation">(</span></span><span class="token string">'user_id'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'ip_address'</span><span class="token punctuation">,</span> <span class="token number">45</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">text<span class="token punctuation">(</span></span><span class="token string">'user_agent'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">text<span class="token punctuation">(</span></span><span class="token string">'payload'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">integer<span class="token punctuation">(</span></span><span class="token string">'last_activity'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<p>Bạn có thể sử dụng <code class=" language-php">session<span class="token punctuation">:</span>table</code> trong Artisan command để tự động tạo migration:</p>
<pre class=" language-php"><code class=" language-php">php artisan session<span class="token punctuation">:</span>table

php artisan migrate</code></pre>
<h4>Redis</h4>
<p>Trước khi sử dụng Redis sessions với Laravel, bạn cần cài đặt gói <code class=" language-php">predis<span class="token operator">/</span>predis</code> package (~1.0) qua Composer. Bạn cấu hình  Redis của bạn kết nối trong file cấu hình <code class=" language-php">database</code>. Trong file cấu hình <code class=" language-php">session</code>, thuộc tính <code class=" language-php">connection</code> có thể được sử dụng để xác định kết nối với Redis là sử dụng session.</p>
<p><a name="using-the-session"></a></p>
<h2><a href="#using-the-session">Sử dụng Session</a></h2>
<p><a name="retrieving-data"></a></p>
<h3>Nhận dữ liệu</h3>
<p>Có hai cách chính để làm việc với dữ liệu session data trong Laravel: phương thức global <code class=" language-php">session</code> và qua thể hiện <code class=" language-php">Request</code>. Đầu tiên, Chúng ta nhìn cách truy cập session qua thể hiện <code class=" language-php">Request</code>, có thể được type-hinted trong phương thức controller. Nhớ rằng, phương thức controller dependencies tự động injected qua Laravel <a href="{{URL::asset('')}}docs/5.3/container">service container</a>:</p>
<pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Show the profile for the given user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">show<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
<p>Khi bạn nhận giá trị từ session, bạn cũng có thể truyền giá trị mặc định qua tham số thứ hai của phương thức <code class=" language-php">get</code>. Giá trị mặc định sẽ được trả về nếu key không tồn tại trong session. Nếu bạn truyền vào một <code class=" language-php">Closure</code> là giá trị mặc định của phương thức <code class=" language-php">get</code> và requested key không tồn tại, thì <code class=" language-php">Closure</code> sẽ được thực thi và trả về giá trị return:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'default'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token string">'default'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<h4>Phương thức Global Session</h4>
<p>Bạn cũng có thể sử dụng hàm global <code class=" language-php">session</code> của PHP và lưu dữ liệu trong session. Khi hàm <code class=" language-php">session</code>được gọi, chuỗi tham số, nó sẽ trà về giá trị của key session. Khi hàm được gọi với một cặp giá trị key / value, giá trị sẽ lưu trong session:</p>
<pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'home'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Retrieve a piece of data from the session...
</span>    <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">session<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> // Specifying a default value...
</span>    <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">session<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'default'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> // Store a piece of data in the session...
</span>    <span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'value'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<blockquote class="has-icon tip">
<p><div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span></div> Có rất ít sự khác biệt giữa sử dụng session qua HTTP request và sử dụng hàm global <code class=" language-php">session</code>. Cả hai phương thức là <a href="{{URL::asset('')}}docs/5.3/testing">testable</a> qua phương thức <code class=" language-php">assertSessionHas</code> nó tồn tại trong tất cả các test cases của bạn.</p>
</blockquote>
<h4>Nhận tất cả dữ liệu Session</h4>
<p>Nếu bạn muốn nhận tất cả dữ liệu của session, bạn có thể sử dụng phương thức <code class=" language-php">all</code>:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$data</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<h4>Kiểm tra sự tồn tại của Session</h4>
<p>Để xác sự tồn tại session, bạn có thể sử dụng phương thức <code class=" language-php">has</code>. Phương thức sẽ trả về <code class=" language-php">has</code> <code class=" language-php"><span class="token boolean">true</span></code>, nếu giá trị của session không bằng <code class=" language-php"><span class="token keyword">null</span></code>:</p>
<pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">has<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
<p>Để xác sự tồn tại session, ngay cả giá trị của nó bằng <code class=" language-php"><span class="token keyword">null</span></code>, bạn có thể sử dụng phương thức <code class=" language-php">exists</code>. Phương thức <code class=" language-php">exists</code> trả về <code class=" language-php"><span class="token boolean">true</span></code> nếu giá trị tồn tại:</p>
<pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">exists<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
<p><a name="storing-data"></a></p>
<h3>Lưu dữ liệu</h3>
<p>Để lưu dữ liệu trong session, bạn sẽ thường sử dụng phương thức <code class=" language-php">put</code> hoặc hàm<code class=" language-php">session</code>:</p>
<pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Via a request instance...
</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Via the global helper...
</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'value'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<h4>Đẩy giá trị vào mảng Session</h4>
<p>Phương thức <code class=" language-php">push</code> có thể sử dụng để đẩy một giá trị vào một biến mảng session. Ví dụ, nếu trong <code class=" language-php">user<span class="token punctuation">.</span>teams</code> là một mảng chứa tên nhóm, bạn có thể đẩy tên nhóm mới vào mảng theo cách sau:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">push<span class="token punctuation">(</span></span><span class="token string">'user.teams'</span><span class="token punctuation">,</span> <span class="token string">'developers'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<h4>Nhận &amp; xóa một item</h4>
<p>Phương thức <code class=" language-php">pull</code> sẽ nhận và xóa một item từ session trong một lệnh:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">pull<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'default'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<p><a name="flash-data"></a></p>
<h3>Flash Data</h3>
<p>Thỉnh thoảng bạn có một vài dữ liệu mà chỉ muốn nó lưu tại lần truy xuất tiếp theo. Bạn có thể dùng phương thức <code class=" language-php">flash</code>. Dữ liệu lưu trong session sử dụng phương thức trên chỉ tồn tại duy nhất trong lần HTTP request tiếp theo, sau đó sẽ tự động được xóa. Flash data thường dùng để biểu thị các trạng thái, thông báo, tin nhắn:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flash<span class="token punctuation">(</span></span><span class="token string">'status'</span><span class="token punctuation">,</span> <span class="token string">'Task was successful!'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<p>Nếu bạn muốn giữa dữ liệu trong nhiều lần request, bạn có thể sử dụng phương thức <code class=" language-php">reflash</code>, nó sẽ dữ lại tất cả các dữ liệu flash thêm vào request. Nếu bạn muốn dữ nội dung flash cụ thể, bạn có thể dung phương thức <code class=" language-php">keep</code>:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">reflash<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">keep<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'username'</span><span class="token punctuation">,</span> <span class="token string">'email'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<p><a name="deleting-data"></a></p>
<h3>Xóa Data</h3>
<p>Phương thức <code class=" language-php">forget</code> sẽ xóa tưng phần dữ liệu từ session. Nếu bạn muốn xóa tất cả dữ liệu session, bạn có thể sử dụng phương thức<code class=" language-php">flush</code>:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">forget<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flush<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<p><a name="regenerating-the-session-id"></a></p>
<h3>Regenerating The Session ID</h3>
<p>Regenerating the session ID thường gặp khi ngăn một mã độc từ người dùng khai thác một <a href="https://en.wikipedia.org/wiki/Session_fixation">session fixation</a> tấn công ứng dụng của bạn.</p>
<p>Laravel tự động regenerates the session ID khi xác thực nếu bạn sử dụng built-in <code class=" language-php">LoginController</code>; tuy nhiên, nếu bạn cần tự tay regenerate the session ID, bạn có thể sử dụng phương thức <code class=" language-php">regenerate</code>.</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">regenerate<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<p><a name="adding-custom-session-drivers"></a></p>
<h2><a href="#adding-custom-session-drivers">Adding Custom Session Drivers</a></h2>
<p><a name="implementing-the-driver"></a></p>
<h4>Implementing The Driver</h4>
<p>Tùy biến session driver của bạn nên thực hiện trong <code class=" language-php">SessionHandlerInterface</code>. Nó chứa một vài phương thức chúng ta cần để thực thi. Một stubbed MongoDB thực hiện giống như bên dưới:</p>
<pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Extensions</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">MongoHandler</span> <span class="token keyword">implements</span> <span class="token class-name">SessionHandlerInterface</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">open<span class="token punctuation">(</span></span><span class="token variable">$savePath</span><span class="token punctuation">,</span> <span class="token variable">$sessionName</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">close<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">read<span class="token punctuation">(</span></span><span class="token variable">$sessionId</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">write<span class="token punctuation">(</span></span><span class="token variable">$sessionId</span><span class="token punctuation">,</span> <span class="token variable">$data</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">destroy<span class="token punctuation">(</span></span><span class="token variable">$sessionId</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">gc<span class="token punctuation">(</span></span><span class="token variable">$lifetime</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
<blockquote class="has-icon tip">
<p><div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span></div> Laravel không cung cấp đường dẫn chứa extensions của bạn. bạn có thể thoải mái đặt ở đâu bạn thích. Trong ví dụ trên, chúng ta sẽ tạo một đường dẫn <code class=" language-php">Extensions</code> chứa <code class=" language-php">MongoHandler</code>.</p>
</blockquote>
<p>Mục đích của những phương thức này không thật sự khó hiểu, chúng ta sẽ tìm hiểu sơ về những phương thức đó:</p>
<div class="content-list">
<ul>
<li>Phương thức <code class=" language-php">open</code> thường được sử dụng trong các fiel. Từ khi Laravel cung cấp một <code class=" language-php">file</code> session driver, Bạn sẽ hầu như không cần dùng phương thức này. Bạn có thể để nó như 1 emptry stub. Nó chỉ đơn giản là thực tế của giao diện kém (chúng ta sẽ tìm hiểu nó sau) mà PHP yêu cầu thực hiện phương thức này.</li>
<li>Phương thức <code class=" language-php">close</code> , giống như phương thức <code class=" language-php">open</code> , cũng có thể thường bỏ qua. hầu hết các drivers, nó không cần thiết.</li>
<li>Phương thức <code class=" language-php">read</code> sẽ trả về chuỗi các dữ liệu session liên quan đến kiểm soát của  <code class=" language-php"><span class="token variable">$sessionId</span></code>. Ở đây không phải làm bất kỳ serialization hoặc encoding khi nhận hoặc lưu dữ liệu session trong driver, Laravel sẽ làm serialization cho bạn.</li>
<li>Phương thức <code class=" language-php">write</code> sẽ viết các giá trị chuỗi <code class=" language-php"><span class="token variable">$data</span></code> liên quan tới <code class=" language-php"><span class="token variable">$sessionId</span></code> đến một vài hệ thống persistent storage như MongoDB, Dynamo, etc.  Một lần nữa, bạn không cần phải serialization - Laravel đã xử lý việc đó cho bạn.</li>
<li>Phương thức <code class=" language-php">destroy</code> sẽ xóa dữ liệu session liên quan tới <code class=" language-php"><span class="token variable">$sessionId</span></code> từ persistent storage.</li>
<li>Phương thức <code class=" language-php">gc</code>sẽ xóa tất cả dữ liệu session cũ hơn giá trị mới <code class=" language-php"><span class="token variable">$lifetime</span></code>, bằng doạn UNIX timestamp. Đối với hệ thống tự hết hạn như Memcached và Redis, phương thức này có thể được bỏ trống.</li>
</ul>
</div>
<p><a name="registering-the-driver"></a></p>
<h4>Đăng ký The Driver</h4>
<p>Khi drivẻ của bạn được thực hiện, bạn đã sẵn sàng đăng ký nó với framework. Bổ sung thêm drivers vào session backend của Laravel, bạn có thể sử dụng phương thức <code class=" language-php">extend</code> trong <code class=" language-php">Session</code> <a href="{{URL::asset('')}}docs/5.3/facades">facade</a>. Bạn nên gọi phương thức <code class=" language-php">extend</code> từphương thức <code class=" language-php">boot</code> của <a href="{{URL::asset('')}}docs/5.3/providers">service provider</a>. Bạn có thể làm điều này từ <code class=" language-php">AppServiceProvider</code> hoặc tạo mới một provider:</p>
<pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Extensions<span class="token punctuation">\</span>MongoSessionStore</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Session</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">SessionServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Perform post-registration booting of services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Session<span class="token punctuation">::</span></span><span class="token function">extend<span class="token punctuation">(</span></span><span class="token string">'mongo'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // Return implementation of SessionHandlerInterface...
</span>            <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">MongoSessionStore</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Register bindings in the container.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">register<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
<p>Khi session driver đã được đăng ký, bạn có thể sử dụng <code class=" language-php">mongo</code> driver trong file cấu hình <code class=" language-php">config<span class="token operator">/</span>session<span class="token punctuation">.</span>php</code>.</p>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/session">https://laravel.com/docs/5.3/session</a></div>
	</article>
@endsection