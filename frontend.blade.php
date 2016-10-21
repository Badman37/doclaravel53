@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>JavaScript &amp; CSS</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#writing-css">Viết CSS</a>
        </li>
        <li><a href="#writing-javascript">Viết JavaScript</a>
            <ul>
                <li><a href="#writing-vue-components">Viết Vue Components</a>
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Laravel không bắt buộc bạn phải dùng JavaScript hoặc CSS pre-processors, nó cung cấp <a href="http://getbootstrap.com">Bootstrap</a> và <a href="https://vuejs.org">Vue</a> sẽ rất hữu ích cho ứng dụng của bạn. Mặc định, Laravel sử dụng <a href="https://npmjs.org">NPM</a> để cài đặt cả hai package đó.</p>
    <h4>CSS</h4>
    <p><a href="{{URL::asset('')}}docs/5.3/elixir">Laravel Elixir</a> khá rõ ràng, nó dùng để biên dịch SASS hoặc Less, nó là những plain CSS mà bạn có thể thêm biến, mixins, và một số tích năng khác khi làm việc với CSS mà bạn sẽ rất thích.</p>
    <p>Trong tài liệu này, nói chung chúng ta sẽ bàn luận về biên soạn CSS; tuy nhiên, bạn nên tham khảo <a href="{{URL::asset('')}}docs/5.3/elixir">Laravel Elixir documentation</a> để biết thêm thông tin biên dịch SASS hoặc Less.</p>
    <h4>JavaScript</h4>
    <p>Laravel không bắt buộc bạn phải sử dụng JavaScript framework nào hoặc thư viện để xây dựng ứng dụng. Thực tế, bạn sẽ không phải tất cả đều sử dụng JavaScript. Tuy nhiên, Laravel thêm một số scaffolding để bắt đầu dễ dàng hơn cho việc viết một JavaScript sử dụng thư viện <a href="https://vuejs.org">Vue</a>. Vue cung cấp một expressive API cho việc xây dựng JavaScript applications sử dụng components.</p>
    <p>
        <a name="writing-css"></a>
    </p>
    <h2><a href="#writing-css">Viết CSS</a></h2>
    <p>File <code class=" language-php">package<span class="token punctuation">.</span>json</code> của Laravel gồm <code class=" language-php">bootstrap<span class="token operator">-</span>sass</code> package để cho bạn bắt đầu xây dựng thuộc tính frondend ứng dụng của bạn sử dụng Bootstrap. Tuy nhiên, feel bạn có thể thoải mái thêm hoặc xóa packages from từ file <code class=" language-php">package<span class="token punctuation">.</span>json</code> fnếu cần thiết cho ứng dụng. Bạn không cần phải sử dụng Bootstrap framework để xây dựng ứng dụng của bạn - nó đơn giản chỉ là cung cấp cho bạn một khởi đầu tối để cho những người cần sử dụng nó.</p>
    <p>Trước khi biên soạn CSS, bạn cần phải cài frontend dependencies sử dụng NPM:</p>
    <pre class=" language-php"><code class=" language-php">npm install</code></pre>
    <p>Khi dependencies đã được cài đặt, sử dụng <code class=" language-php">npm install</code>, bạn có thể biên dịch file SASS sang plain CSS bằng cách <a href="http://gulpjs.com/">Gulp</a>. Lệnh <code class=" language-php">gulp</code> command sẽ thực hiện hướng dẫn trong file <code class=" language-php">gulpfile<span class="token punctuation">.</span>js</code>. Thông thường, file CSS dã được biên dịch sẽ nằm trong thư mục <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>css</code>:</p>
    <pre class=" language-php"><code class=" language-php">gulp</code></pre>
    <p>Mặc định file <code class=" language-php">gulpfile<span class="token punctuation">.</span>js</code> và Laravel đã biên dịch file <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>sass<span class="token operator">/</span>app<span class="token punctuation">.</span>scss</code> SASS. File <code class=" language-php">app<span class="token punctuation">.</span>scss</code> thêm một file SASS variables và tải Bootstrap, nó cung cấp một điểm bắt đầu tốt cho phát triển ứng dụng. Bạn có thể thoải mái tùy biến file <code class=" language-php">app<span class="token punctuation">.</span>scss</code> tuy nhiên nếu bạn muốn, bạn có thể sử dụng một pre-processor khác bởi <a href="{{URL::asset('')}}docs/5.3/elixir">cấu hình Laravel Elixir</a>.</p>
    <p>
        <a name="writing-javascript"></a>
    </p>
    <h2><a href="#writing-javascript">Viết JavaScript</a></h2>
    <p>Tất cả các yêu cầu JavaScript dependencies của bạn có thể tìm thấy ở trong file <code class=" language-php">package<span class="token punctuation">.</span>json</code> trong thư mục gốc của project. File này giống với file <code class=" language-php">composer<span class="token punctuation">.</span>json</code> ngoại trừ nó chỉ JavaScript dependencies thay thế các PHP dependencies. Bạn có thể cài đặt dependencies bằng cách sử dụng <a href="https://npmjs.org">Node package manager (NPM)</a>:</p>
    <pre class=" language-php"><code class=" language-php">npm install</code></pre>
    <p>Mặc định, File <code class=" language-php">package<span class="token punctuation">.</span>json</code> của Laravel bao gồm một số package như <code class=" language-php">vue</code> và <code class=" language-php">vue<span class="token operator">-</span>resource</code> giúp bạn bắt đầu xây dựng ứng dụng JavaScript application. Bạn có thể thoải mái thêm hoặc xóa từ file <code class=" language-php">package<span class="token punctuation">.</span>json</code> nếu cần cho ứng dụng của bạn.</p>
    <p>Khi packages đã được cài đặt, bạn có thể sử dụng lệnh <code class=" language-php">gulp</code> để <a href="{{URL::asset('')}}docs/5.3/elixir"> biên dịch file</a>. Gulp là một command-line xây dựng hệ thống JavaScript. Khi bạn chạy lệnh <code class=" language-php">gulp</code>, Gulp sẽ thực thi theo hướng dẫn của file <code class=" language-php">gulpfile<span class="token punctuation">.</span>js</code>:</p>
    <pre class=" language-php"><code class=" language-php">gulp</code></pre>
    <p>Mặc định, File <code class=" language-php">gulpfile<span class="token punctuation">.</span>js</code> của Laravel biên dịch file SASS và file <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js<span class="token operator">/</span>app<span class="token punctuation">.</span>js</code>. Bên trong file <code class=" language-php">app<span class="token punctuation">.</span>js</code> bạn có thể đăng ký Vue components hoặc, nếu bạn thích framework khác, bạn có thể cấu hình JavaScript. File biên dịch JavaScript thương sẽ được lưu ở trong thư mục <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>js</code>.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> File <code class=" language-php">app<span class="token punctuation">.</span>js</code> sẻ chứa file <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js<span class="token operator">/</span>bootstrap<span class="token punctuation">.</span>js</code> gồm bootstraps và cấu hình Vue, Vue Resource, jQuery, và tất cả những JavaScript dependencies. Nếu bạn muốn thêm JavaScript dependencies vào cấu hình, bạn có thể thêm nó ở trong file này.</p>
    </blockquote>
    <p>
        <a name="writing-vue-components"></a>
    </p>
    <h3>Viết Vue Components</h3>
    <p>Mặc định, ứng dụng Laravel chứa một <code class=" language-php">Example<span class="token punctuation">.</span>vue</code> Vue component trong thư mục <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js<span class="token operator">/</span>components</code>. File <code class=" language-php">Example<span class="token punctuation">.</span>vue</code> là một ví dụ về <a href="http://vuejs.org/guide/single-file-components.html">single file Vue component</a> nó định nghĩa JavaScript và HTML template trong the same file. Single file components cung cấp 1 cách tiện lợi cho việc tiếp cận và xây dựng ứng dụng JavaScript. Ví dụ component đã được đăng ký trong file <code class=" language-php">app<span class="token punctuation">.</span>js</code>:</p>
    <pre class=" language-php"><code class=" language-php">Vue<span class="token punctuation">.</span><span class="token function">component<span class="token punctuation">(</span></span><span class="token string">'example'</span><span class="token punctuation">,</span> <span class="token keyword">require</span><span class="token punctuation">(</span><span class="token string">'./components/Example.vue'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Để sử dụng component trong ứng dụng của bạn, bạn có thể để nói trong 1 file HTML templates. Ví dụ, sau khi chạy lệnh <code class=" language-php">make<span class="token punctuation">:</span>auth</code> Artisan của scaffold để tạo chức năng đăng nhập và đăng ký cho ứng dụng của bạn, bạn có thể vứt component trong <code class=" language-php">home<span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code> Blade template:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">extends</span><span class="token punctuation">(</span><span class="token string">'layouts.app'</span><span class="token punctuation">)</span>

@<span class="token function">section<span class="token punctuation">(</span></span><span class="token string">'content'</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>example</span><span class="token punctuation">&gt;</span></span></span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>example</span><span class="token punctuation">&gt;</span></span></span>
@@endsection</code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Nhớ rằng, bạn nên chạy lệnh<code class=" language-php">gulp</code> command mỗi khi bạn thay đổi một Vue component. Hoặc, bạn có thể chạy lệnh <code class=" language-php">gulp watch</code> trong terminal và nó sẽ tự động biên dịch compnents cho bạn mỗi khi chúng được thay đổi.</p>
    </blockquote>
    <p>Tất nhiên, nếu bạn hứng thú trong việc học Vue components, bạn có thể đọc nó tại <a href="http://vuejs.org/guide/">Vue documentation</a>, nó là tài liệu rất tốt, dễ có cái nhìn tổng quan về Vue framework.</p>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/frontend">https://laravel.com/docs/5.3/frontend</a></div>
</article>
@endsection