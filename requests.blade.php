@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>HTTP Requests</h1>
    <ul>
        <li><a href="#accessing-the-request">Truy cập vào Request</a>
            <ul>
                <li><a href="#request-path-and-method">Đường dẫn request &amp; Phương thức</a>
                </li>
                <li><a href="#psr7-requests">PSR-7 Requests</a>
                </li>
            </ul>
        </li>
        <li><a href="#retrieving-input">Lấy Input</a>
            <ul>
                <li><a href="#old-input">Input cũ</a>
                </li>
                <li><a href="#cookies">Cookies</a>
                </li>
            </ul>
        </li>
        <li><a href="#files">Files</a>
            <ul>
                <li><a href="#retrieving-uploaded-files">Nhận Files Uploaded</a>
                </li>
                <li><a href="#storing-uploaded-files">Lưua Files Uploaded</a>
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <a name="accessing-the-request"></a>
    </p>
    <h2><a href="#accessing-the-request">Truy cập vào Request</a></h2>
    <p>Để lấy đối tượng hiện tại của HTTP request thông qua dependency injection, bạn phải type-hint vào class <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> trong phương thức controller. Các request đến sẽ được tự động injected bởi <a href="{{URL::asset('')}}docs/5.3/container">service container</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">input<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Dependency Injection &amp; Route Parameters</h4>
    <p>Nếu phương thức controller của bạn cũng cần lấy input từ tham số route thì bạn phải liệt kê danh sách tham số route vào sau các dependencies. Ví dụ, nếu route của bạn định nghĩa như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'user/{id}'</span><span class="token punctuation">,</span> <span class="token string">'UserController@update'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn vẫn phải type-hint <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> và truy cập vào tham số route <code class=" language-php">id</code> bằng cách định nghĩa phương thức trong controller như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Update the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">update<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Truy cập vào Request qua Route Closures</h4>
    <p>Bạn cũng có thể type-hint class <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> trong route Closure. Service sẽ tự động inject các request Closure khi nó sẽ được thực thi:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span>Request <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="request-path-and-method"></a>
    </p>
    <h3>Đường dẫn Request &amp; Phương thức</h3>
    <p>Đối tượng <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> cung cập một số phương thức để kiểm tra HTTP request cho ứng dụng và kế thừa class <code class=" language-php">Symfony\<span class="token package">Component<span class="token punctuation">\</span>HttpFoundation<span class="token punctuation">\</span>Request</span></code> . Chúng ta sẽ thảo luận một số phương thức quan trọng dưới đây.</p>
    <h4>Nhận đường dẫn Request</h4>
    <p>Phương thức <code class=" language-php">path</code> trả về thông tin đường dẫn của request. Vì vậy, Nếu request gửi đến là <code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>domain<span class="token punctuation">.</span>com<span class="token operator">/</span>foo<span class="token operator">/</span>bar</code>, phương thức <code class=" language-php">path</code> sẽ trả về <code class=" language-php">foo<span class="token operator">/</span>bar</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$uri</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Phương thức <code class=" language-php">is</code> sẽ cho phép bạn xác nhận những request gửi đến có đường dẫn khới với pattern hay không. Bạn có thể sử dụng ký tự <code class=" language-php"><span class="token operator">*</span></code> khi sử dụng phương thức này:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">is<span class="token punctuation">(</span></span><span class="token string">'admin/*'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Nhận Request URL</h4>
    <p>Để nhận đường dẫn đầy đủ URL từ request gửi đến bạn có thể sử dụng phương thức <code class=" language-php">url</code> or <code class=" language-php">fullUrl</code>. Phương thức <code class=" language-php">url</code> sẽ trả về URL không có string query, trong khi phương thức <code class=" language-php">fullUrl</code> bao gồm cả string query:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Without Query String...
</span><span class="token variable">$url</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">url<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// With Query String...
</span><span class="token variable">$url</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">fullUrl<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Nhận phương thức Request</h4>
    <p>Phương thức <code class=" language-php">method</code> sẽ trả về phương thức HTTP tương ứng với request. Bạn có thể sử dụng phương thức <code class=" language-php">isMethod</code> để xác thực phương thức HTTP khớp với string:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$method</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">method<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">isMethod<span class="token punctuation">(</span></span><span class="token string">'post'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="psr7-requests"></a>
    </p>
    <h3>PSR-7 Requests</h3>
    <p>Tiêu chuẩn của <a href="http://www.php-fig.org/psr/psr-7/">PSR-7 standard</a> quy định interfaces cho HTTP messages, bao gồm cả requests và responses. Nếu bạn muốn lấy một đối tưởng chuẩn của PSR-7 request thay vì một request Laravel, Đầu tiên bạn cần cài đặt một vài thư viện. Laravel sử dụng component <em>Symfony HTTP Message Bridge</em> để chuyển đổi requests và responses của Laravel thành PSR-7:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> symfony<span class="token operator">/</span>psr<span class="token operator">-</span>http<span class="token operator">-</span>message<span class="token operator">-</span>bridge
composer <span class="token keyword">require</span> zendframework<span class="token operator">/</span>zend<span class="token operator">-</span>diactoros</code></pre>
    <p>Khi bạn đã cài thư viện trên, bạn có thể lấy được PSR-7 request bằng cách type-hinting request interface trên route Closure hoặc phương thức controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Psr<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Message<span class="token punctuation">\</span>ServerRequestInterface</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span>ServerRequestInterface <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Trường hợp nếu bạn trả về PSR-7 response từ route hoặc controller, nó sẽ tự động chuyển thành response Laravel và được hiển thị bởi framework.</p>
    </blockquote>
    <p>
        <a name="retrieving-input"></a>
    </p>
    <h2><a href="#retrieving-input">Lấy Input</a></h2>
    <h4>Lấy tất cả dữ liệu Input</h4>
    <p>Bạn có thể lấy tất cả dữ liệu input như một <code class=" language-php"><span class="token keyword">array</span></code> bằng cách sử dụng phương thức <code class=" language-php">all</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$input</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Lấy giá trị một Input</h4>
    <p>Sử dụng một vài phương thức cơ bản, bạn có thể truy cập tất cả các input từ người dùng qua <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> mà bạn không cần quan tâm tới các method HTTP được sử dụng cho request. Bất kể nó là phương thức HTTP nào, phương thức <code class=" language-php">input</code> sử dụng có thể lấy được input từ người dùng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">input<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn cũng có thể truyền giá trị của tham số như là một đối số thứ hai trong phương thức <code class=" language-php">input</code>. Giá trị sẽ được trả về nếu giá trị input không có trong request:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">input<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'Sally'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Khi bạn làm việc với form chứa mảng input, sử dụng dấm "chấm" để truy cập giá trị của mảng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">input<span class="token punctuation">(</span></span><span class="token string">'products.0.name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$names</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">input<span class="token punctuation">(</span></span><span class="token string">'products.*.name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Lấy Input qua thuộc tính động</h4>
    <p>Bạn có thể lấy input của người dùng bằng cách sử dụng thuộc tính động trong <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code>. Ví dụ, Nếu form ứng dụng của bạn có chứa trường <code class=" language-php">name</code>, bạn có thể truy lấy giá trị bằng cách:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span></code></pre>
    <p>Khi sử dụng thuộc tính động, đầu tiên Laravel sẽ tìm giá trị tham số trong request payload. Nếu nó không tìm thấy, Laravel laravel sẽ tìm trong tham số route.</p>
    <h4>Lấy giá trị JSON Input</h4>
    <p>Khi bạn gửi JSON requests đến ứng dụng, bạn có thể lấy dữ liệu JSON qua phương thức <code class=" language-php">input</code> miễn là <code class=" language-php">Content<span class="token operator">-</span>Type</code> header của request là <code class=" language-php">application<span class="token operator">/</span>json</code>. Bạn cũng có thể dùng cú pháp "dấu chấm" để lấy giá trị mảng JSON:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">input<span class="token punctuation">(</span></span><span class="token string">'user.name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Lấy một phần dữ liệu Input</h4>
    <p>Nếu bạn cần một tập con dữ liệu input, bạn có thể sử dụng phương thức <code class=" language-php">only</code> và <code class=" language-php">except</code>. Cả hai phương thức đều nhận một <code class=" language-php"><span class="token keyword">array</span></code> hoặc một danh sách các đối số:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$input</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">only<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'username'</span><span class="token punctuation">,</span> <span class="token string">'password'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$input</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">only<span class="token punctuation">(</span></span><span class="token string">'username'</span><span class="token punctuation">,</span> <span class="token string">'password'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$input</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">except<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'credit_card'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$input</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">except<span class="token punctuation">(</span></span><span class="token string">'credit_card'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Kiểm tra giá trị Input Value tồn tại</h4>
    <p>Bạn có thể dùng phương thức <code class=" language-php">has</code> để kiểm tra giá trị input tồn tại trong request. Phương thức <code class=" language-php">has</code> trả về <code class=" language-php"><span class="token boolean">true</span></code> nếu giá trị tồn tại và không phải chuỗi rỗng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">has<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="old-input"></a>
    </p>
    <h3>Input cũ</h3>
    <p>Laravel cho phép bạn giữ giá trị input từ lần request cữ tới request tiếp theo. Nó thật sự hữu dụng khi bạn muốn thiết lập lại form sau khi có validate lỗi. Tuy nhiên, nếu bạn sử dụng <a href="{{URL::asset('')}}docs/5.3/validation">validation features</a> của Laravel, thì bạn không phải làm việc này, vì Laravel's built-in validation đã tự động làm việc đó cho bạn rồi.</p>
    <h4>Flashing Input tới Session</h4>
    <p>Phương thức <code class=" language-php">flash</code>trong class <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> sẽ  flash hiện tại input vào trong <a href="/docs/5.3/session">session</a> vì vậy bạn có thể sử dụng trong request tiếp theo của người dùng tới ứng dụng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flash<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn cũng có thể sử dụng phương thức <code class=" language-php">flashOnly</code> và <code class=" language-php">flashExcept</code>để flash một tập con dữ liệu request vào trong session. Nhưng phương thức này rất hữu ích cho việc dữ những thông tin nhạy cảm như mật khẩu ra session:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flashOnly<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'username'</span><span class="token punctuation">,</span> <span class="token string">'email'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flashExcept<span class="token punctuation">(</span></span><span class="token string">'password'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Flashing Input rồi chuyển trang</h4>
    <p>Thỉnh thoảng bạn muốn flash input vào session và chuyển trang về trang trước đó, bạn có thể dễ dàng tạo móc nối vào trong một chuyển trang với phương thức <code class=" language-php">withInput</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'form'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withInput<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'form'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withInput<span class="token punctuation">(</span></span>
    <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">except<span class="token punctuation">(</span></span><span class="token string">'password'</span><span class="token punctuation">)</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Lấy input cũ</h4>
    <p>Để lấy flashed input từ request trước, sử dụng phương thức<code class=" language-php">old</code> của <code class=" language-php">Request</code>. Phương thức <code class=" language-php">old</code> sẽ lấy dữ liệu flashed input data trước ra khỏi  <a href="/docs/5.3/session">session</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$username</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">old<span class="token punctuation">(</span></span><span class="token string">'username'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Laravel còn cung cấp một helper global <code class=" language-php">old</code>. Nếu bạn muốn hiển input cũ trong <a href="/docs/5.3/blade">Blade template</a>, nó thật tiện khi sử dụng helper <code class=" language-php">old</code>. Nếu không có input cũ của trường, <code class=" language-php"><span class="token keyword">null</span></code> sẽ được trả về:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>input</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>text<span class="token punctuation">"</span></span> <span class="token attr-name">name</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>username<span class="token punctuation">"</span></span> <span class="token attr-name">value</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>@{{ old('username') }}<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="cookies"></a>
    </p>
    <h3>Cookies</h3>
    <h4>Lấy Cookies From Requests</h4>
    <p>Tất cả cookies dược tạo bởi Laravel framework đều được mã hóa và ký một mã xác thực, nghĩa là chúng có thể bị coi là không hợp lệ nếu nó bị thay đổi phía dưới client. Để lấy một giá trị cookie từ request, sử dụng phương thức <code class=" language-php">cookie</code> từ <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cookie<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Gắn Cookies vào Responses</h4>
    <p>Bạn có thể gắp một cookie vào <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Response</span></code> bằng cách sử dụng phương thức <code class=" language-php">cookie</code>. Bạn có thể truyền tên, giá trị, và số phút cookie sẽ hết hạn vào phương thức:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token string">'Hello World'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cookie<span class="token punctuation">(</span></span>
    <span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Phương thức <code class=" language-php">cookie</code> ngoài ra còn có một vài đối sô ít được sử dụng. Nói chung, những đối số đó có cùng mục đích và ý nghĩa giống với đối số của  <a href="http://php.net/manual/en/function.setcookie.php">setcookie</a> của PHP:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token string">'Hello World'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cookie<span class="token punctuation">(</span></span>
    <span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">,</span> <span class="token variable">$path</span><span class="token punctuation">,</span> <span class="token variable">$domain</span><span class="token punctuation">,</span> <span class="token variable">$secure</span><span class="token punctuation">,</span> <span class="token variable">$httpOnly</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Tạo Cookie Instances</h4>
    <p>Nếu bạn muốn tạo một <code class=" language-php">Symfony\<span class="token package">Component<span class="token punctuation">\</span>HttpFoundation<span class="token punctuation">\</span>Cookie</span></code> có thể response sau một khoảng thời gian, bạn có thể sử dụng helper global <code class=" language-php">cookie</code>. Khi đó cookie sẽ không gửi lại cho client trừ khi nó được gán vào response instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$cookie</span> <span class="token operator">=</span> <span class="token function">cookie<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token string">'Hello World'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cookie<span class="token punctuation">(</span></span><span class="token variable">$cookie</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="files"></a>
    </p>
    <h3>Files</h3>
    <p>
        <a name="retrieving-uploaded-files"></a>
    </p>
    <h3>Lấy Files Uploaded</h3>
    <p>Bạn có thể lấy files uploaded từ một <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> bằng cách sử dụng phương thức <code class=" language-php">file</code> hoặc sử dụng thuộc tính động. Phương thức <code class=" language-php">file</code> sẽ trả về một class <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>UploadedFile</span></code>, nó kế thừa từ <code class=" language-php">SplFileInfo</code> class của PHP và cung cấp một số phương thức để tương tác với fiel:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$file</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">file<span class="token punctuation">(</span></span><span class="token string">'photo'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$file</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">photo</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn có thể kiểm tra một file có tồn tại trên request hay không bằng cách dùng phương thức <code class=" language-php">hasFile</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasFile<span class="token punctuation">(</span></span><span class="token string">'photo'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Validate Uploads thành công</h4>
    <p>Ngoài việc kiểm tra file upload tồn tại, bạn có thể kiểm tra xem có vấn đề gì khi upload file bằng phương thức <code class=" language-php">isValid</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">file<span class="token punctuation">(</span></span><span class="token string">'photo'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">isValid<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Đường dẫn File &amp; Extensions</h4>
    <p>Class <code class=" language-php">UploadedFile</code> ngoài ra còn chưa phương thức lấy đường dẫn đầy đủ và extension của file. Phương thức <code class=" language-php">extension</code> sẽ cho phép đoán extension trên dựa nội dung của file. Extension này có thể khác với extension được cung cấp bởi client:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">photo</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$extension</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">photo</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">extension<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Phương thức khác của File</h4>
    <p>Có một số phương thức tồn tại trong class <code class=" language-php">UploadedFile</code>. Chi tiết xem tại <a href="http://api.symfony.com/3.0/Symfony/Component/HttpFoundation/File/UploadedFile.html">tài liệu API của class</a> để biết thêm chi tiết các phương thức đấy.</p>
    <p>
        <a name="storing-uploaded-files"></a>
    </p>
    <h3>Lưu Files Uploaded</h3>
    <p>Để lưu một file uploaded, thông thường sử dụng một trong những cấu hình <a href="{{URL::asset('')}}docs/5.3/filesystem">filesystems</a>. Class <code class=" language-php">UploadedFile</code> có phương thức  <code class=" language-php">store</code>nó sẽ chuyển file upload từ ổ cứng của bạn đến một nơi có thể là trên local của bạn hoặc ngay cả trên cloud storage như Amazon S3.</p>
    <p>Phương thức <code class=" language-php">store</code> chấp nhận đường dẫn file nên được lưu trữ đường dẫn tương đối so với thư mục gốc cấu hình của filesystem. Đường dẫn không được chứa tên file, tên sẽ tự động được sinh ra bằng cách sử dụng mã hóa MD5 của nội dung file.</p>
    <p>Phương thức <code class=" language-php">store</code> ngoài ra còn chấp nhận tham số thứ hai có tên của nơi mà bạn sử dụng để lưu file. Phương thức sẽ trả về đường dẫn tương đối của file đối với thư mục gốc:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">photo</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">store<span class="token punctuation">(</span></span><span class="token string">'images'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$path</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">photo</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">store<span class="token punctuation">(</span></span><span class="token string">'images'</span><span class="token punctuation">,</span> <span class="token string">'s3'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu bạn không muốn tên file được tự động tạo ra, bạn có thể sử dụng phương thức<code class=" language-php">storeAs</code>, nó sẽ chấp nhận các đối số như đường dẫn, tên file, và tên nơi lưu:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">photo</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">storeAs<span class="token punctuation">(</span></span><span class="token string">'images'</span><span class="token punctuation">,</span> <span class="token string">'filename.jpg'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$path</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">photo</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">storeAs<span class="token punctuation">(</span></span><span class="token string">'images'</span><span class="token punctuation">,</span> <span class="token string">'filename.jpg'</span><span class="token punctuation">,</span> <span class="token string">'s3'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
 <div>Nguồn: <a href="https://laravel.com/docs/5.3/requests">https://laravel.com/docs/5.3/requests</a></div>
</article>
@endsection