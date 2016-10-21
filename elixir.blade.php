@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Compiling Assets (Laravel Elixir)</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#installation">Cài đặt &amp; Thiết lập</a>
        </li>
        <li><a href="#running-elixir">Chạy Elixir</a>
        </li>
        <li><a href="#working-with-stylesheets">Làm việc với Stylesheets</a>
            <ul>
                <li><a href="#less">Less</a>
                </li>
                <li><a href="#sass">Sass</a>
                </li>
                <li><a href="#stylus">Stylus</a>
                </li>
                <li><a href="#plain-css">Plain CSS</a>
                </li>
                <li><a href="#css-source-maps">Source Maps</a>
                </li>
            </ul>
        </li>
        <li><a href="#working-with-scripts">Làm việc với Scripts</a>
            <ul>
                <li><a href="#webpack">Webpack</a>
                </li>
                <li><a href="#rollup">Rollup</a>
                </li>
                <li><a href="#javascript">Scripts</a>
                </li>
            </ul>
        </li>
        <li><a href="#copying-files-and-directories">Copying Files &amp; Directories</a>
        </li>
        <li><a href="#versioning-and-cache-busting">Versioning / Cache Busting</a>
        </li>
        <li><a href="#browser-sync">BrowserSync</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Laravel Elixir cung cấp một API gọn gàng và liền mạch cho việc tạo các <a href="http://gulpjs.com">Gulp</a>  cho các ứng dụng Laravel. Elixir cung cấp một số pre-processor phổ biến cho CSS và Javascript <a href="http://sass-lang.com">Sass</a> và <a href="https://webpack.github.io/">Webpack</a>. Sử dụng móc nối hàm, Elixir cho phép bạn tạo các asset pipeline một cách liền mạch. Ví dụ:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">sass</span><span class="token punctuation">(</span><span class="token string">'app.scss'</span><span class="token punctuation">)</span>
       <span class="token punctuation">.</span><span class="token function">webpack</span><span class="token punctuation">(</span><span class="token string">'app.js'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu bạn từng cảm thấy khó khăn trong việc bắt đầu sử dụng Gulp và đóng gói asset, bạn sẽ yêu thích Laravel Elixir. Tuy nhiên, bạn không cần thiết phải sử dụng nó khi phát triển ứng dụng. Bạn hoàn toàn thoải mái chọn lựa công cụ đóng gói asset nào bạn muốn, hoặc thậm chi không dùng gì cả.</p>
    <p>
        <a name="installation"></a>
    </p>
    <h2><a href="#installation">Cài đặt &amp; Thiết lập</a></h2>
    <h4>Cài đặt Node</h4>
    <p>Trước khi dùng Elixir, bạn phải cài Node.js và NPM vào máy tính của bạn.</p>
    <pre class=" language-php"><code class=" language-php">node <span class="token operator">-</span>v
npm <span class="token operator">-</span>v</code></pre>
    <p>Mặc định, Laravel Homestead đã có sẵn tất cả mọi thứ; tuy nhiên, nếu bạn không sử dụng Vagrant, thì bạn có thể dễ dàng cài Node bằng cách<a href="http://nodejs.org/en/download/">their download page</a>.</p>
    <h4>Gulp</h4>
    <p>Sau đó, bạn sẽ cần cài đặt <a href="http://gulpjs.com">Gulp</a> như là NPM package:</p>
    <pre class=" language-php"><code class=" language-php">npm install <span class="token operator">--</span><span class="token keyword">global</span> gulp<span class="token operator">-</span>cli</code></pre>
    <h4>Laravel Elixir</h4>
    <p>Việc còn lại là chỉ cần cài Laravel Elixir. Bên trong project Laravel, bạn sẽ thấy một file  <code class=" language-php">package<span class="token punctuation">.</span>json</code> trong thư mục gốc. Mặc định, file <code class=" language-php">package<span class="token punctuation">.</span>json</code> chứa Elixir và the Webpack JavaScript module bundler. Bạn hãy nghĩ nó giống như file <code class=" language-php">composer<span class="token punctuation">.</span>json</code>,chỉ khác là nó định nghĩa cho Node dependencies thay vì PHP. Bạn có thể dependencies bằng lệnh:</p>
    <pre class=" language-php"><code class=" language-php">npm install</code></pre>
    <p>Nếu bạn đang phát triển trên hệ điều hành Windows hay bạn đang trong VM trên host là Windows, bạn có thể chạy lệnh <code class=" language-php">npm install</code> với thông số <code class=" language-php"><span class="token operator">--</span>no<span class="token operator">-</span>bin<span class="token operator">-</span>links</code>:</p>
    <pre class=" language-php"><code class=" language-php">npm install <span class="token operator">--</span>no<span class="token operator">-</span>bin<span class="token operator">-</span>links</code></pre>
    <p>
        <a name="running-elixir"></a>
    </p>
    <h2><a href="#running-elixir">Chạy Elixir</a></h2>
    <p>Elixir xây dựng dữa trên <a href="http://gulpjs.com">Gulp</a>, vì thế, để chạy các Elixir task, bạn chỉ cần chạy lệnh gulp <code class=" language-php">gulp</code> trong terminal. Thêm vào cờ <code class=" language-php"><span class="token operator">--</span>production</code> vào câu lệnh để yêu cầu Elixir thực hiện minify CSS và Javascript:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Run all tasks...
</span>gulp
<span class="token comment" spellcheck="true">
// Run all tasks and minify all CSS and JavaScript...
</span>gulp <span class="token operator">--</span>production</code></pre>
    <p>Sau khi chạy lệnh này, chúng ta sẽ thấy một bảng hiển thị tóm tắt vể những thay đổi ở trên terminal.</p>
    <h4>Xem thay đổi của asset</h4>
    <p>Lệnh <code class=" language-php">gulp watch</code> sẽ tiếp tục chạy terminal và xem những thay đổi asset. Gulp sẽ tự động biên dịch lại asset nếu bạn thay đổi bất kỳ asset trong lệnh  <code class=" language-php">watch</code>:</p>
    <pre class=" language-php"><code class=" language-php">gulp watch</code></pre>
    <p>
        <a name="working-with-stylesheets"></a>
    </p>
    <h2><a href="#working-with-stylesheets">Làm việc với Stylesheets</a></h2>
    <p>The <code class=" language-php">gulpfile<span class="token punctuation">.</span>js</code> file in your project's root directory contains all of your Elixir tasks. Elixir tasks can be chained together to define exactly how your assets should be compiled.</p>
    <p>
        <a name="less"></a>
    </p>
    <h3>Less</h3>
    <p>Phương thức <code class=" language-php">less</code> có thể sử dụng để biên dịch <a href="http://lesscss.org/">Less</a> thành CSS. Phương thức <code class=" language-php">less</code> lấy các file trong thư mục <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>less</code>. Mặc định, task sẽ được biên dịch thành CSS trong ví dụ này ở trong thư mục <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>css<span class="token operator">/</span>app<span class="token punctuation">.</span>css</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">less</span><span class="token punctuation">(</span><span class="token string">'app.less'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn cũng có thể biên dịch nhiều file Less thành một file CSS. Một lần nữa, file CSS sẽ được lưu ở thư mục <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>css<span class="token operator">/</span>app<span class="token punctuation">.</span>css</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">less</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
        <span class="token string">'app.less'</span><span class="token punctuation">,</span>
        <span class="token string">'controllers.less'</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn có thể tùy biến vị trí thư mục file CSS, bằng cách truyền thêm tham số thứ hai vào phương thức <code class=" language-php">less</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">less</span><span class="token punctuation">(</span><span class="token string">'app.less'</span><span class="token punctuation">,</span> <span class="token string">'public/stylesheets'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">// Specifying a specific output filename...
</span><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">less</span><span class="token punctuation">(</span><span class="token string">'app.less'</span><span class="token punctuation">,</span> <span class="token string">'public/stylesheets/style.css'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="sass"></a>
    </p>
    <h3>Sass</h3>
    <p>Phương thức <code class=" language-php">sass</code> cho phép bạn biên dịch <a href="http://sass-lang.com/">Sass</a> thành CSS. Giả sử file Sass lưu ở thư mục <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>sass</code>, bạn có thể sử dụng phương thức như sau:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">sass</span><span class="token punctuation">(</span><span class="token string">'app.scss'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Một lần nữa, giống như phương thức <code class=" language-php">less</code>, bạn có thể biên dịch nhiều file Sass thành một file CSS, và tùy biến thư mục của file biên dịch CSS:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">sass</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
        <span class="token string">'app.scss'</span><span class="token punctuation">,</span>
        <span class="token string">'controllers.scss'</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'public/assets/css'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Tùy biến đường dẫn</h4>
    <p>Bạn nên sử dụng thư mục mặc định của Laravel. Tuy nhiên, nếu bạn muốn một thư mục khác, bạn có thể bắt đầu ở bất cứ đâu với <code class=" language-php"><span class="token punctuation">.</span><span class="token operator">/</span></code>. khi đó Elixir sẽ bắt đầu ở thư mục gốc, thay vì sử dụng ở thư mục mặc định.</p>
    <p>Ví dụ, để biên dịch một file ở thư mục <code class=" language-php">app<span class="token operator">/</span>assets<span class="token operator">/</span>sass<span class="token operator">/</span>app<span class="token punctuation">.</span>scss</code> và kết quả ở thư mục <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>css<span class="token operator">/</span>app<span class="token punctuation">.</span>css</code>, bạn có thể làm nó bằng lệnh <code class=" language-php">sass</code> như sau:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">sass</span><span class="token punctuation">(</span><span class="token string">'./app/assets/sass/app.scss'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="stylus"></a>
    </p>
    <h3>Stylus</h3>
    <p>Phương thức <code class=" language-php">stylus</code> có thể sử dụng để biên dịch <a href="http://stylus-lang.com/">Stylus</a> thành CSS. Giả sử file Stylus lưu tại <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>stylus</code>, bạn có thể sử dụng nó như sau:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">stylus</span><span class="token punctuation">(</span><span class="token string">'app.styl'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Cách thức hoạt động của <code class=" language-php">mix<span class="token punctuation">.</span><span class="token function">less<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code> và <code class=" language-php">mix<span class="token punctuation">.</span><span class="token function">sass<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code> đều giống nhau.</p>
    </blockquote>
    <p>
        <a name="plain-css"></a>
    </p>
    <h3>Plain CSS</h3>
    <p>Nếu bạn muốn biên dịch một số file plain CSS stylesheets thành một file, bạn có thể sử dụng phương thức <code class=" language-php">styles</code>. Các đường dẫn truyền vào trong hàm này là tương đối với thư mục <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>css</code> và file cuối cùng CSS sẽ lưu tại <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>css<span class="token operator">/</span>all<span class="token punctuation">.</span>css</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">styles</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
        <span class="token string">'normalize.css'</span><span class="token punctuation">,</span>
        <span class="token string">'main.css'</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Ngoài ra, Elixir cho phép bạn thay đổi thư mục file kết quả bằng cách truyền vào tham số thứ hai của hàm <code class=" language-php">styles</code> :</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">styles</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
        <span class="token string">'normalize.css'</span><span class="token punctuation">,</span>
        <span class="token string">'main.css'</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'public/assets/css/site.css'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="css-source-maps"></a>
    </p>
    <h3>Source Maps</h3>
    <p>Trong Elixir, source maps đã được kích hoạt và cung cấp một số thông tin debug cho các cho bạn khi sử dụng để biên dịch assets. Đối với mỗi file được biên dịch, bạn sẽ tìm thấy một file <code class=" language-php"><span class="token operator">*</span><span class="token punctuation">.</span>css<span class="token punctuation">.</span>map</code> or <code class=" language-php"><span class="token operator">*</span><span class="token punctuation">.</span>js<span class="token punctuation">.</span>map</code> trong cùng thư mục.</p>
    <p>Nếu bạn không muốn sinh ra source maps trong ứng dụng của bạn, có thể bỏ chúng đi bằng cách cấu hình của Elixir<code class=" language-php">sourcemaps</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript">elixir<span class="token punctuation">.</span>config<span class="token punctuation">.</span>sourcemaps <span class="token operator">=</span> <span class="token keyword">false</span><span class="token punctuation">;</span>

<span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">sass</span><span class="token punctuation">(</span><span class="token string">'app.scss'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="working-with-scripts"></a>
    </p>
    <h2><a href="#working-with-scripts">Làm việc với Scripts</a></h2>
    <p>Elixir cung cấp một vài tính năng giúp bạn làm việc với các file JavaScript, như biên dịch ECMAScript 2015, module bundling, nén, hay đơn giản chỉ là nối các files plain JavaScript.</p>
    <p>Khi viết ES2015 với modules, bạn có thể chọn <a href="http://webpack.github.io">Webpack</a> và <a href="http://rollupjs.org/">Rollup</a>. Nếu đấy là những tool bạn chưa dùng bao giờ, đừng lo lắng, Elixir sẽ sử lý tất cả những việc khó khăn nhất cho bạn. Mặc định, Laravel <code class=" language-php">gulpfile</code> uses <code class=" language-php">webpack</code> để biên dịch Javascript, nhưng bạn có thể thoải mái thêm bất kỳ module bundler bạn thích.</p>
    <p>
        <a name="webpack"></a>
    </p>
    <h3>Webpack</h3>
    <p>Phương thức <code class=" language-php">webpack</code> có thể sử dụng để biên dịch và bundle <a href="https://babeljs.io/docs/learn-es2015/">ECMAScript 2015</a> thành plain JavaScript. Hàm này cho phép một đường dẫn tương đối với thư mục <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js</code> và tạo ra một file bundled trong thư mục <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>js</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">webpack</span><span class="token punctuation">(</span><span class="token string">'app.js'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Để chọn một thư mục output khác hoặc thư mục base, đơn giản là chỉ việc thêm <code class=" language-php"><span class="token punctuation">.</span></code> vào trường đường dẫn. Khi đó bạn có thể xác định đường dẫn tương đối với thư mục gốc. Ví dụ, để biên dịch <code class=" language-php">app<span class="token operator">/</span>assets<span class="token operator">/</span>js<span class="token operator">/</span>app<span class="token punctuation">.</span>js</code> thành <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>dist<span class="token operator">/</span>app<span class="token punctuation">.</span>js</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">webpack</span><span class="token punctuation">(</span>
        <span class="token string">'./app/assets/js/app.js'</span><span class="token punctuation">,</span>
        <span class="token string">'./public/dist'</span>
    <span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu bạn muốn tận dụng những tính năng khác của Webpack, Elixir sẽ đọc bất kỳ file <code class=" language-php">webpack<span class="token punctuation">.</span>config<span class="token punctuation">.</span>js</code> ở trong thư mục gốc và <a href="https://webpack.github.io/docs/configuration.html">factor its configuration</a> thành build process.</p>
    <p>
        <a name="rollup"></a>
    </p>
    <h3>Rollup</h3>
    <p>Giống như Webpack, Rollup là thế hệ tiếp theo để bundler với ES2015. Hàm này truyền vào một mảng các đường dẫn file tương đối với <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js</code>, và tạo ra một file ở <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>js</code> directory:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">rollup</span><span class="token punctuation">(</span><span class="token string">'app.js'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Như phương thức <code class=" language-php">webpack</code>, bạn có thể tùy chỉnh đường dẫn input và output cùa file bằng phương thức <code class=" language-php">rollup</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">elixir<span class="token punctuation">(</span></span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">rollup<span class="token punctuation">(</span></span>
        <span class="token string">'./resources/assets/js/app.js'</span><span class="token punctuation">,</span>
        <span class="token string">'./public/dist'</span>
    <span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="javascript"></a>
    </p>
    <h3>Scripts</h3>
    <p>Nếu bạn có nhiều file JavaScript mà bạn muốn biên dịch thành một file, bạn có thể sử dụng phương thức <code class=" language-php">scripts</code>, nó tự động cung cấp source maps, kết nối, và nén.</p>
    <p>Phương thức <code class=" language-php">scripts</code> sẽ coi tất cả các đường dẫn tương đối so với thư mục <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js</code>, và kết quả JavaScript sẽ nằm ở thư mục <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>js<span class="token operator">/</span>all<span class="token punctuation">.</span>js</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">scripts</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
        <span class="token string">'order.js'</span><span class="token punctuation">,</span>
        <span class="token string">'forum.js'</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu bạn cần kết nối nhiều file scripts thành những file khác nhau, bạn có thể gọi nhiều phương thức <code class=" language-php">scripts</code>. Tham số thứ hai của phương thức định nghĩa kết quả của tên file tương ứng với mỗi lần kết nối:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">scripts</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'app.js'</span><span class="token punctuation">,</span> <span class="token string">'controllers.js'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'public/js/app.js'</span><span class="token punctuation">)</span>
       <span class="token punctuation">.</span><span class="token function">scripts</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'forum.js'</span><span class="token punctuation">,</span> <span class="token string">'threads.js'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'public/js/forum.js'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu bạn cần biên dịch tất cả scripts trong một thư mục, bạn có thể sử dụng phương thức <code class=" language-php">scriptsIn</code>. Kết quả JavaScript được thay thế trong <code class=" language-php"><span class="token keyword">public</span><span class="token operator">/</span>js<span class="token operator">/</span>all<span class="token punctuation">.</span>js</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">scriptsIn</span><span class="token punctuation">(</span><span class="token string">'public/js/some/directory'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Nếu bạn có ý định két nôi nhiều thư viện pre-minified vendor, như jQuery, cân nhăc việc sử dụng <code class=" language-php">mix<span class="token punctuation">.</span><span class="token function">combine<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>. Nó sẽ biên dịch các file , nó sẽ bỏ qua việc những bước source map và nén. như vậy, thời gian biên dịch sẽ được cải thiện.</p>
    </blockquote>
    <p>
        <a name="copying-files-and-directories"></a>
    </p>
    <h2><a href="#copying-files-and-directories">Copying Files &amp; Directories</a></h2>
    <p>Phương thức <code class=" language-php">copy</code> được dùng để copy files và thư mục tới các vị trí mới. Tất cả đều ở vị trí relative tới thư mục gốc của project:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">copy</span><span class="token punctuation">(</span><span class="token string">'vendor/foo/bar.css'</span><span class="token punctuation">,</span> <span class="token string">'public/css/bar.css'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="versioning-and-cache-busting"></a>
    </p>
    <h2><a href="#versioning-and-cache-busting">Versioning / Cache Busting</a></h2>
    <p>Rất nhiều lập trinh viên muốn thêm một timestamp vào sau file biên dịch asset hoặc một unique token để trình duyệt tải lại khi nó có thay đổi thay vì vẫn sử dụng bản cũ. Elixir có thể xử lý điều đó giúp bạn bằng phương thức <code class=" language-php">version</code>.</p>
    <p>Phương thức <code class=" language-php">version</code> sẽ truyền vào một đường dẫn tương đối với thư mục <code class=" language-php"><span class="token keyword">public</span></code>, và sẽ thêm một unique hash cho tên filename, cho phép cache-busting. Ví dụ, tên file được sinh sẽ nhìn giống như: <code class=" language-php">all<span class="token operator">-</span>16d570a7<span class="token punctuation">.</span>css</code>:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">version</span><span class="token punctuation">(</span><span class="token string">'css/all.css'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Sau khi sinh ra version file, bạn có thể sử dụng phương thức global <code class=" language-php">elixir</code> của Laravel trong <a href="/docs/5.3/views">views</a> để tải hashed asset. Phương thức <code class=" language-php">elixir</code> sẽ tự động định nghĩa tên hiện tại của hashed file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>link</span> <span class="token attr-name">rel</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>stylesheet<span class="token punctuation">"</span></span> <span class="token attr-name">href</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>@{{ elixir('css/all.css') }}<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <h4>Đánh version cho nhiều file</h4>
    <p>Bạn có thể truyền vào một mảng file của phương thức <code class=" language-php">version</code> sinh ra version cho nhiều file:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">version</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'css/all.css'</span><span class="token punctuation">,</span> <span class="token string">'js/app.js'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Khi các version file đã được tạo ra, bạn có thể sử dụng phương thức<code class=" language-php">elixir</code> để tạo link đến hashed file. Nhớ rằng, bạn chỉ cần truyền tên file un-hashed vào phương thức <code class=" language-php">elixir</code>. Hàm đó sẽ tự động un-hashed tên và xác định hashed version hiện tại của file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>link</span> <span class="token attr-name">rel</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>stylesheet<span class="token punctuation">"</span></span> <span class="token attr-name">href</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>@{{ elixir('css/all.css') }}<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>

<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>script</span> <span class="token attr-name">src</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>@{{ elixir('js/app.js') }}<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>script</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="browser-sync"></a>
    </p>
    <h2><a href="#browser-sync">BrowserSync</a></h2>
    <p>BrowserSync tự động refreshes lại trình duyệt sau khi bạn thay đổi file assets. Phương thức <code class=" language-php">browserSync</code>truyền vào một JavaScript object với một thuộc tính <code class=" language-php">proxy</code> chứa URL ứng dụng. Sau đó, khi bạn chạy <code class=" language-php">gulp watch</code> bạn có thể truy cập ứng dụng web sử dụng cổng 3000 (<code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>project<span class="token punctuation">.</span>dev<span class="token punctuation">:</span><span class="token number">3000</span></code>) để trình duyệt syncing:</p>
    <pre class=" language-javascript"><code class=" language-javascript"><span class="token function">elixir</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>mix<span class="token punctuation">)</span> <span class="token punctuation">{</span>
    mix<span class="token punctuation">.</span><span class="token function">browserSync</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
        proxy<span class="token punctuation">:</span> <span class="token string">'project.dev'</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/elixir">https://laravel.com/docs/5.3/elixir</a></div>
</article>

@endsection