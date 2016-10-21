@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Blade Templates</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#template-inheritance">Template Inheritance</a>
            <ul>
                <li><a href="#defining-a-layout">Định nghĩa một layout</a>
                </li>
                <li><a href="#extending-a-layout">Kế thừa một layout</a>
                </li>
            </ul>
        </li>
        <li><a href="#displaying-data">Hiển thị dữ liệu</a>
            <ul>
                <li><a href="#blade-and-javascript-frameworks">Blade &amp; JavaScript Frameworks</a>
                </li>
            </ul>
        </li>
        <li><a href="#control-structures">Control Structures</a>
            <ul>
                <li><a href="#if-statements">Cấu trúc điều kiện</a>
                </li>
                <li><a href="#loops">Vòng lặp</a>
                </li>
                <li><a href="#the-loop-variable">Biến vòng lặp</a>
                </li>
                <li><a href="#comments">Comments</a>
                </li>
            </ul>
        </li>
        <li><a href="#including-sub-views">Including Sub-Views</a>
            <ul>
                <li><a href="#rendering-views-for-collections">Rendering Views cho Collections</a>
                </li>
            </ul>
        </li>
        <li><a href="#stacks">Stacks</a>
        </li>
        <li><a href="#service-injection">Service Injection</a>
        </li>
        <li><a href="#extending-blade">Extending Blade</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Blade là templating engine đơn giản nhưng rất tuyệt vợi cung cấp bởi Laravel. Không như những  templating engine của PHP, Blade không cấm bạn sử dụng code PHP thuần ở trong view. Thực tế, tât cả các Blade view được compiled từ code PHP và được cache cho đến khi chúng được chỉnh sửa, nghĩa là Blade không làm tăng thêm chi phí cho ứng dụng của bạn. Tất cả các Blade view sử dụng đuôi <code class=" language-php"><span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code> và được lưu trong thư mục <code class=" language-php">resources<span class="token operator">/</span>views</code> directory.</p>
    <p>
        <a name="template-inheritance"></a>
    </p>
    <h2><a href="#template-inheritance">Template Inheritance</a></h2>
    <p>
        <a name="defining-a-layout"></a>
    </p>
    <h3>Định nghĩa một layout</h3>
    <p>Có 2 lợi ích của việc sử dụng Blade là <em>template inheritance</em> và <em>sections</em>. Để bắt đầu, Chúng ta hãy xem ví dụ sau. Đầu tiên, chúng ta cùng xem một trang layout "master". Vì hầu hết các ứng dụng wb đều có một mẫu layout chung giữa các trang với nhau, nó sẽ rất tiện nếu tạo ra layout này thành một Blade view riêng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- Stored in resources/views/layouts/app.blade.php --&gt;</span></span>

<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>html</span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>head</span><span class="token punctuation">&gt;</span></span></span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>title</span><span class="token punctuation">&gt;</span></span></span>App Name <span class="token operator">-</span> @<span class="token keyword">yield</span><span class="token punctuation">(</span><span class="token string">'title'</span><span class="token punctuation">)</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>title</span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>head</span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>body</span><span class="token punctuation">&gt;</span></span></span>
        @<span class="token function">section<span class="token punctuation">(</span></span><span class="token string">'sidebar'</span><span class="token punctuation">)</span>
            This is the master sidebar<span class="token punctuation">.</span>
        @@endsection

        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>container<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
            @<span class="token keyword">yield</span><span class="token punctuation">(</span><span class="token string">'content'</span><span class="token punctuation">)</span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>body</span><span class="token punctuation">&gt;</span></span></span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>html</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>Như bạn có thể thấy, file này có chứa mã HTML mark-up. Tuy nhiên, chú ý ở <code class=" language-php">@@section</code> và <code class=" language-php">@<span class="token keyword">yield</span></code> directives. The <code class=" language-php">@@section</code> directive, đúng như tên của nó, định nghĩa một nội dungtrong khi <code class=" language-php">@<span class="token keyword">yield</span></code> directive sử dụng để hiển thị dữ liệu ở một vị trí đặt trước.</p>
    <p>Bây giờ chúng ta đã tạo xong một layout cho ứng dúng, hãy cùng tạo ra các trang con kế thừa từ layout này.</p>
    <p>
        <a name="extending-a-layout"></a>
    </p>
    <h3>Kế thừa một layout</h3>
    <p>Khi bạn tạo một trang con, sử dụng Blade <code class=" language-php">@<span class="token keyword">extends</span></code> directive để chỉ ra layout của trang con này "inherit" từ đâu. Views kế thừa một Blade layout có thể inject nội dung vào trong sections using <code class=" language-php">@@section</code> directives của layout. Nhớ rằng, như ví dụ trên, nội dung của những section này được hiển thị khi sử dụng <code class=" language-php">@<span class="token keyword">yield</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- Stored in resources/views/child.blade.php --&gt;</span></span>

@<span class="token keyword">extends</span><span class="token punctuation">(</span><span class="token string">'layouts.app'</span><span class="token punctuation">)</span>

@<span class="token function">section<span class="token punctuation">(</span></span><span class="token string">'title'</span><span class="token punctuation">,</span> <span class="token string">'Page Title'</span><span class="token punctuation">)</span>

@<span class="token function">section<span class="token punctuation">(</span></span><span class="token string">'sidebar'</span><span class="token punctuation">)</span>
    @<span class="token keyword">parent</span>

    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>p</span><span class="token punctuation">&gt;</span></span></span>This is appended to the master sidebar<span class="token punctuation">.</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>p</span><span class="token punctuation">&gt;</span></span></span>
@@endsection

@<span class="token function">section<span class="token punctuation">(</span></span><span class="token string">'content'</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>p</span><span class="token punctuation">&gt;</span></span></span>This is my body content<span class="token punctuation">.</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>p</span><span class="token punctuation">&gt;</span></span></span>
@@endsection</code></pre>
    <p>Trong ví dụ trên, phần <code class=" language-php">sidebar</code> để thực hiện <code class=" language-php">@<span class="token keyword">parent</span></code> directive thêm nội dung vài sidebar (thay vì ghi đè toàn bộ). <code class=" language-php">@<span class="token keyword">parent</span></code> directive sẽ được thay thế bởi nội dung của layout khi view được render.</p>
    <p>Blade views có thể được trả về từ routes bằng cách sử dụng hàm global <code class=" language-php">view</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'blade'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'child'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="displaying-data"></a>
    </p>
    <h2><a href="#displaying-data">Hiển thị dữ liệu</a></h2>
    <p>Bạn có thể truyền dữ liệu vào Blade views bằng cách đặt biết trong cặp ngowacj nhọn. Ví dụ, với route dưới:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'greeting'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'welcome'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Samantha'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn có thể hiển thị nội dung của biến <code class=" language-php">name</code> variable như sau:</p>
    <pre class=" language-php"><code class=" language-php">Hello<span class="token punctuation">,</span> <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$name</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token punctuation">.</span></code></pre>
    <p>Tất nhiên, bạn không hề bị giới hạn trong việc hiển thị nội dung của biến vào trong view. Bạn cũng có thể sử dụng hàm echo của PHP để hiển thị biến. Thực tế, you bạn có thể đặt code PHP bạn muốn vào Blade:</p>
    <pre class=" language-php"><code class=" language-php">The current <span class="token constant">UNIX</span> timestamp is <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">time<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token punctuation">.</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Cặp <code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code> của Blade được tự động gửi tới hàm <code class=" language-php">htmlentities</code> của PHP để ngăn chặn các hành vi tấn công XSS.</p>
    </blockquote>
    <h4> Hiển thị dữ liệu nếu tồn tại</h4>
    <p>Thỉnh thoảng bạn muốn hiện giá trị một biến, nhưng bạn không chắc nếu biết đó có giá trị.Chúng ta có thể thể hiện theo kiểu code PHP như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">isset<span class="token punctuation">(</span></span><span class="token variable">$name</span><span class="token punctuation">)</span> <span class="token operator">?</span> <span class="token variable">$name</span> <span class="token punctuation">:</span> <span class="token string">'Default'</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>Tuy nhiên, thay vì viết kiểu ternary, Blade provides cung cấp cho bạn một cách ngắn gọn hơn:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$name</span> <span class="token keyword">or</span> <span class="token string">'Default'</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>Trong ví dụ trên, nếu biến <code class=" language-php"><span class="token variable">$name</span></code> tồn tại, giá trị sẽ được hiện thị. Tuy nhiên, nếu nó không tồn tại, Từ <code class=" language-php"><span class="token keyword">Default</span></code> sẽ được hiển thị.</p>
    <h4>Hiện dữ liệu chưa Unescaped</h4>
    <p>Mặc định, cặp <code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code> được tự động gửi qua hàm <code class=" language-php">htmlentities</code> của PHP để ngăn chặn tấn công XSS. Nếu bạn không muốn dự liệu bị escaped,bạn có thể sử dụng cú pháp:</p>
    <pre class=" language-php"><code class=" language-php">Hello<span class="token punctuation">,</span> <span class="token punctuation">{</span><span class="token operator">!</span><span class="token operator">!</span> <span class="token variable">$name</span> <span class="token operator">!</span><span class="token operator">!</span><span class="token punctuation">}</span><span class="token punctuation">.</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Phải cẩn thận khi hiện nội dung được người dùng cung cấp. Luôn luôn sử dung cặp ngoặc nhọn để ngăn chặn tấn công XSS attacks khi hiển thị dữ liệu được cung cấp.</p>
    </blockquote>
    <p>
        <a name="blade-and-javascript-frameworks"></a>
    </p>
    <h3>Blade &amp; JavaScript Frameworks</h3>
    <p>Vì nhiều JavaScript frameworks cũng sử dụng cặp "ngoặc nhọn" để cho biết một biểu thức cần được hiển thị lên trình duyệt, bạn có thể sử dụng biểu tượng <code class=" language-php">@</code> để nói cho Blade biết được biểu thức này cần được giữ lại. Ví dụ:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h1</span><span class="token punctuation">&gt;</span></span></span>Laravel<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h1</span><span class="token punctuation">&gt;</span></span></span>

Hello<span class="token punctuation">,</span> @<span class="token punctuation">{</span><span class="token punctuation">{</span> name <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token punctuation">.</span></code></pre>
    <p>Trong ví dụ này, biểu tượng <code class=" language-php">@</code> sẽ bị xóa bởi Blade ; tuy nhiên, <code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> name <span class="token punctuation">}</span><span class="token punctuation">}</span></code> được dữ lại cho phép nó được render tiếp bởi Javascript framkwork của bạn.</p>
    <h4>The <code class=" language-php">@@verbatim</code> Directive</h4>
    <p>Nếu bạn muốn hiển thị biến JavaScript trong phần lớn template của bạn, bạn có thể bọc chúng trong <code class=" language-php">@verbatim</code> directive khi đó bạn sẽ không cần tiền tố <code class=" language-php">@</code> trước biểu thức điều kiện:</p>
    <pre class=" language-php"><code class=" language-php">@verbatim
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>container<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
        Hello<span class="token punctuation">,</span> <span class="token punctuation">{</span><span class="token punctuation">{</span> name <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token punctuation">.</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>
@endverbatim</code></pre>
    <p>
        <a name="control-structures"></a>
    </p>
    <h2><a href="#control-structures">Control Structures</a></h2>
    <p>Ngoài template inheritance và hiển thị dữ liệu, Blade còn cung cấp một số short-cuts PHP control structures, như biểu thức điều kiện và vòng lắm. Các short-cuts provide rất rõ ràng, là cách ngắn gọn khi làm việc với PHP control structures, và giống cấu trúc của PHP counterparts.</p>
    <p>
        <a name="if-statements"></a>
    </p>
    <h3>Cấu trúc điều kiện</h3>
    <p>Bạn có xây dựng cấu trúc <code class=" language-php"><span class="token keyword">if</span></code> sbằng cách sử dụng <code class=" language-php">@<span class="token keyword">if</span></code>, <code class=" language-php">@<span class="token keyword">elseif</span></code>, <code class=" language-php">@<span class="token keyword">else</span></code>, và <code class=" language-php">@<span class="token keyword">endif</span></code> directives. Những directives tương ứng giống các từ khóa của PHP:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token function">count<span class="token punctuation">(</span></span><span class="token variable">$records</span><span class="token punctuation">)</span> <span class="token operator">===</span> <span class="token number">1</span><span class="token punctuation">)</span>
    I have one record<span class="token operator">!</span>
@<span class="token keyword">elseif</span> <span class="token punctuation">(</span><span class="token function">count<span class="token punctuation">(</span></span><span class="token variable">$records</span><span class="token punctuation">)</span> <span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">)</span>
    I have multiple records<span class="token operator">!</span>
@<span class="token keyword">else</span>
    I don't have any records<span class="token operator">!</span>
@<span class="token keyword">endif</span></code></pre>
    <p>For convenience, Blade also provides an <code class=" language-php">@@unless</code> directive:</p>
    <pre class=" language-php"><code class=" language-php">@@unless <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">check<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    You are not signed in<span class="token punctuation">.</span>
@@endunless</code></pre>
    <p>
        <a name="loops"></a>
    </p>
    <h3>Vòng lặp</h3>
    <p>Ngoài cấu trúc điều kiẹn, Blade provides cũng cung cấp phương thức hỗ trợ cho việc xử lý vòng lặp. Một lần nữa, mỗi directives tương ứng giống các từ khóa PHP:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">for</span> <span class="token punctuation">(</span><span class="token variable">$i</span> <span class="token operator">=</span> <span class="token number">0</span><span class="token punctuation">;</span> <span class="token variable">$i</span> <span class="token operator">&lt;</span> <span class="token number">10</span><span class="token punctuation">;</span> <span class="token variable">$i</span><span class="token operator">++</span><span class="token punctuation">)</span>
    The current value is <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$i</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
@<span class="token keyword">endfor</span>

@<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$users</span> <span class="token keyword">as</span> <span class="token variable">$user</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>p</span><span class="token punctuation">&gt;</span></span></span>This is user <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>p</span><span class="token punctuation">&gt;</span></span></span>
@<span class="token keyword">endforeach</span>

@@forelse <span class="token punctuation">(</span><span class="token variable">$users</span> <span class="token keyword">as</span> <span class="token variable">$user</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>li</span><span class="token punctuation">&gt;</span></span></span><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>li</span><span class="token punctuation">&gt;</span></span></span>
@@empty
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>p</span><span class="token punctuation">&gt;</span></span></span>No users<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>p</span><span class="token punctuation">&gt;</span></span></span>
@@endforelse

@<span class="token keyword">while</span> <span class="token punctuation">(</span><span class="token boolean">true</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>p</span><span class="token punctuation">&gt;</span></span></span>I'm looping forever<span class="token punctuation">.</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>p</span><span class="token punctuation">&gt;</span></span></span>
@<span class="token keyword">endwhile</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Trong vòng lặp, bạn có thể sử dụng <a href="#the-loop-variable">biến vòng lặp</a> đê lấy được thông tin giá trị của vòng lặp, chẳng hạn như bạn muốn lấy giá trị đầu tiên hoặc cuối cùng của vòng lặp.</p>
    </blockquote>
    <p>Khi sử dụng vòng lặp bạn cũng có thể kết thúc hoặc bỏ qua vòng lặp hiện tại:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$users</span> <span class="token keyword">as</span> <span class="token variable">$user</span><span class="token punctuation">)</span>
    @<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">type</span> <span class="token operator">==</span> <span class="token number">1</span><span class="token punctuation">)</span>
        @<span class="token keyword">continue</span>
    @<span class="token keyword">endif</span>

    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>li</span><span class="token punctuation">&gt;</span></span></span><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>li</span><span class="token punctuation">&gt;</span></span></span>

    @<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">number</span> <span class="token operator">==</span> <span class="token number">5</span><span class="token punctuation">)</span>
        @<span class="token keyword">break</span>
    @<span class="token keyword">endif</span>
@<span class="token keyword">endforeach</span></code></pre>
    <p>Bạn cũng có thể thêm điều kiện directive biểu diễn trong một dòng:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$users</span> <span class="token keyword">as</span> <span class="token variable">$user</span><span class="token punctuation">)</span>
    @<span class="token keyword">continue</span><span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">type</span> <span class="token operator">==</span> <span class="token number">1</span><span class="token punctuation">)</span>

    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>li</span><span class="token punctuation">&gt;</span></span></span><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>li</span><span class="token punctuation">&gt;</span></span></span>

    @<span class="token keyword">break</span><span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">number</span> <span class="token operator">==</span> <span class="token number">5</span><span class="token punctuation">)</span>
@<span class="token keyword">endforeach</span></code></pre>
    <p>
        <a name="the-loop-variable"></a>
    </p>
    <h3>Biến vòng lặp</h3>
    <p>Trong vòng lặp, một biến <code class=" language-php"><span class="token variable">$loop</span></code> sẽ tồn tại bên trong vòng lặp. Biến này cho phép ta truy cập một số thông tin hữu ích của vòng lặp như index của vòng lặp hiện tại và vòng lặp đầu hoặc vòng lặp cuối của nó:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$users</span> <span class="token keyword">as</span> <span class="token variable">$user</span><span class="token punctuation">)</span>
    @<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">first</span><span class="token punctuation">)</span>
        This is the first iteration<span class="token punctuation">.</span>
    @<span class="token keyword">endif</span>

    @<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">last</span><span class="token punctuation">)</span>
        This is the last iteration<span class="token punctuation">.</span>
    @<span class="token keyword">endif</span>

    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>p</span><span class="token punctuation">&gt;</span></span></span>This is user <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>p</span><span class="token punctuation">&gt;</span></span></span>
@<span class="token keyword">endforeach</span></code></pre>
    <p>Nếu bạn có vòng lặp lồng nhau, bạn có thể truy cập biên <code class=" language-php"><span class="token variable">$loop</span></code> của vòng lặp tra qua thuộc tính <code class=" language-php"><span class="token keyword">parent</span></code>:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$users</span> <span class="token keyword">as</span> <span class="token variable">$user</span><span class="token punctuation">)</span>
    @<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">posts</span> <span class="token keyword">as</span> <span class="token variable">$post</span><span class="token punctuation">)</span>
        @<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token keyword">parent</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">first</span><span class="token punctuation">)</span>
            This is first iteration of the <span class="token keyword">parent</span> loop<span class="token punctuation">.</span>
        @<span class="token keyword">endif</span>
    @<span class="token keyword">endforeach</span>
@<span class="token keyword">endforeach</span></code></pre>
    <p>Biến <code class=" language-php"><span class="token variable">$loop</span></code>còn chứa một số thông tin hữu ích:</p>
    <table>
        <thead>
            <tr>
                <th>Thuộc tính</th>
                <th>Miêu tả</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code class=" language-php"><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">index</span></code>
                </td>
                <td>Chỉ số index hiện tại của vòng lặp (starts at 0).</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">iteration</span></code>
                </td>
                <td> Các vòng lặp hiện tại (starts at 1).</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">remaining</span></code>
                </td>
                <td> Số vòng lặp còn lại.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">count</span></code>
                </td>
                <td>Tổng số vòng lặp.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">first</span></code>
                </td>
                <td>Vòng lặp đầu tiên.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">last</span></code>
                </td>
                <td>Vòng lặp cuối cùng.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">depth</span></code>
                </td>
                <td>Độ sâu của vòng lặp hiện tại.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token variable">$loop</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token keyword">parent</span></code>
                </td>
                <td>Biến parent loop của vòng lặp trong 1 vòng lặp lồng.</td>
            </tr>
        </tbody>
    </table>
    <p>
        <a name="comments"></a>
    </p>
    <h3>Comments</h3>
    <p>Blade còn cho phép bạn comment trong view. Tuy nhiên, không như comment của HTML , comment của Blade không đi kèm nội dung HTML được trả về:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span><span class="token operator">--</span> This comment will not be present in the rendered <span class="token constant">HTML</span> <span class="token operator">--</span><span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="including-sub-views"></a>
    </p>
    <h2><a href="#including-sub-views">Including Sub-Views</a></h2>
    <p>Blade's <code class=" language-php">@<span class="token keyword">include</span></code> directive cho phép bạn chèn một Blade view từ một view khác. Tất cả các biến tồn tại trong view cha đều có thể sử dụng ở viree chèn thêm:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span><span class="token punctuation">&gt;</span></span></span>
    @<span class="token keyword">include</span><span class="token punctuation">(</span><span class="token string">'shared.errors'</span><span class="token punctuation">)</span>

    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>form</span><span class="token punctuation">&gt;</span></span></span>
        <span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- Form Contents --&gt;</span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>form</span><span class="token punctuation">&gt;</span></span></span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>Mặc dù các view được chèn thêm kế thừa tất cả dữ liệu từ view cha, bạn cũng có thể truyền một mảng dữ liệu bổ sung:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">include</span><span class="token punctuation">(</span><span class="token string">'view.name'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'some'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'data'</span><span class="token punctuation">]</span><span class="token punctuation">)</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Bạn nên tránh sử dụng <code class=" language-php"><span class="token constant">__DIR__</span></code> và <code class=" language-php"><span class="token constant">__FILE__</span></code> ở trong Blade views, vì chúng sẽ tham chiếu tới vị trí file bị cache.</p>
    </blockquote>
    <p>
        <a name="rendering-views-for-collections"></a>
    </p>
    <h3>Rendering Views cho Collections</h3>
    <p>Bạn có thể kết hợp vòng lặp và view chèn thêm trong một dòng với <code class=" language-php">@@each</code> directive:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">each<span class="token punctuation">(</span></span><span class="token string">'view.name'</span><span class="token punctuation">,</span> <span class="token variable">$jobs</span><span class="token punctuation">,</span> <span class="token string">'job'</span><span class="token punctuation">)</span></code></pre>
    <p>Tham sô thứ nhất là tên của view partial để render các element trong mảng hay collection. Tham số thứ hai là một mảng hoặc collection mà bạn muốn lặp, tham số thứ ba là tên của biến được gán vào trong vòng lặp bên view. Vì vậy, ví dụ, nếu bạn muốn lặp qua một mảng tên <code class=" language-php">jobs</code>, bạn phải truy xuất vào mỗi biến <code class=" language-php">job</code> trong view partial. key của vòng lặp hiện tại sẽ tồn tại như là <code class=" language-php">key</code> bên trong view partial.</p>
    <p>Bạn cũng có thể truyền tham số thứ tư vào <code class=" language-php">@@each</code> directive. tham số này sẽ chỉ định view sẽ dduwcoj render nếu như mảng bị rỗng.</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">each<span class="token punctuation">(</span></span><span class="token string">'view.name'</span><span class="token punctuation">,</span> <span class="token variable">$jobs</span><span class="token punctuation">,</span> <span class="token string">'job'</span><span class="token punctuation">,</span> <span class="token string">'view.empty'</span><span class="token punctuation">)</span></code></pre>
    <p>
        <a name="stacks"></a>
    </p>
    <h2><a href="#stacks">Stacks</a></h2>
    <p>Blade cho phép bạn đẩy tên stack để cho việc render ở một vị trí nào trong view hoặc layout khac. Việc này rất hữu ích cho việc xác định thư viện JavaScript libraries cần cho view con:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">push<span class="token punctuation">(</span></span><span class="token string">'scripts'</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>script</span> <span class="token attr-name">src</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>/example.js<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>script</span><span class="token punctuation">&gt;</span></span></span>
@@endpush</code></pre>
    <p>Bạn có thể đẩy một hoặc nhiều vào stack. Để render thành công một nội dung stack, truyền vào tên của stack trong <code class=" language-php">@@stack</code> directive:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>head</span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- Head Contents --&gt;</span></span>

    @<span class="token function">stack<span class="token punctuation">(</span></span><span class="token string">'scripts'</span><span class="token punctuation">)</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>head</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="service-injection"></a>
    </p>
    <h2><a href="#service-injection">Service Injection</a></h2>
    <p>Để <code class=" language-php">@@inject</code> directive có thể được sử dụng để lấy lại một service từ Laravel <a href="{{URL::asset('')}}docs/5.3/container">service container</a>. Tham số thứ nhất <code class=" language-php">@@inject</code> là tên biến của service sẽ được đặt vào, tham số thứ hai là class hoặc tên interface của service bạn muốn resolve:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">inject<span class="token punctuation">(</span></span><span class="token string">'metrics'</span><span class="token punctuation">,</span> <span class="token string">'App\Services\MetricsService'</span><span class="token punctuation">)</span>

<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span><span class="token punctuation">&gt;</span></span></span>
    Monthly Revenue<span class="token punctuation">:</span> <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$metrics</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">monthlyRevenue<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token punctuation">.</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="extending-blade"></a>
    </p>
    <h2><a href="#extending-blade">Mở rộng Blade</a></h2>
    <p>Blade còn cho phép bạn tùy biên directives bằng phương thức <code class=" language-php">directive</code>. Khi trình viên dich của Blade gặp directive, nó sẽ gọi tới callback được cung cấp với tham số tương ứng.</p>
    <p>Ví dụ dưới đây tạo một <code class=" language-php">@<span class="token function">datetime<span class="token punctuation">(</span></span><span class="token variable">$var</span><span class="token punctuation">)</span></code> directive để thực hiện format một biết <code class=" language-php"><span class="token variable">$var</span></code>, nó sẽ là một thể hiện của <code class=" language-php">DateTime</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Blade</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AppServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Perform post-registration booting of services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Blade<span class="token punctuation">::</span></span><span class="token function">directive<span class="token punctuation">(</span></span><span class="token string">'datetime'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$expression</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> "<span class="token delimiter">&lt;?php</span> <span class="token keyword">echo</span> <span class="token variable">$expression</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">format<span class="token punctuation">(</span></span><span class="token string">'m/d/Y H:i'</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token delimiter">?&gt;</span></span>"<span class="token punctuation">;</span>
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
    <p>Như bạn thấy, chúng ta sẽ móc lỗi phương thức <code class=" language-php">format</code> trong bất cứ biểu thức nào được gửi qua directive. Vì vậy, Trong ví dụ trên, Mã PHP được tạo ra bởi directivesẽ là:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token php"><span class="token delimiter">&lt;?php</span> <span class="token keyword">echo</span> <span class="token variable">$var</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">format<span class="token punctuation">(</span></span><span class="token string">'m/d/Y H:i'</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token delimiter">?&gt;</span></span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Sau khi cập nhật logiccủa mộtBlade directive, bạn cần xóa hết tất cả các Blade view bị cache. cache Blade views có thể xóa bằng lệnh <code class=" language-php">view<span class="token punctuation">:</span>clear</code> Artisan.</p>
    </blockquote>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/blade">https://laravel.com/docs/5.3/blade</a></div>
</article>
@endsection