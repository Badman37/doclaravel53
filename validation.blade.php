@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Validation</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#validation-quickstart">Bắt đầu nhanh validation</a>
            <ul>
                <li><a href="#quick-defining-the-routes">Xác định routes</a>
                </li>
                <li><a href="#quick-creating-the-controller">Tạo mới Controller</a>
                </li>
                <li><a href="#quick-writing-the-validation-logic">Viết logic validation</a>
                </li>
                <li><a href="#quick-displaying-the-validation-errors">Hiển thị lỗi validation</a>
                </li>
            </ul>
        </li>
        <li><a href="#form-request-validation">Form Request Validation</a>
            <ul>
                <li><a href="#creating-form-requests">Tạo Form Requests</a>
                </li>
                <li><a href="#authorizing-form-requests">Authorizing Form Requests</a>
                </li>
                <li><a href="#customizing-the-error-format">Tùy biến định dạng lỗi</a>
                </li>
                <li><a href="#customizing-the-error-messages">Tùy biến nội dung lỗi</a>
                </li>
            </ul>
        </li>
        <li><a href="#manually-creating-validators">Tự tạo validators</a>
            <ul>
                <li><a href="#automatic-redirection">Redirection tự động</a>
                </li>
                <li><a href="#named-error-bags">Named Error Bags</a>
                </li>
                <li><a href="#after-validation-hook">After Validation Hook</a>
                </li>
            </ul>
        </li>
        <li><a href="#working-with-error-messages">Làm việc với nội dung lỗi</a>
            <ul>
                <li><a href="#custom-error-messages">Tùy biến nội dung lỗi</a>
                </li>
            </ul>
        </li>
        <li><a href="#available-validation-rules">Những quy định validation có sẵn</a>
        </li>
        <li><a href="#conditionally-adding-rules">Thêm quy định có điều kiện</a>
        </li>
        <li><a href="#validating-arrays">Validating mảng</a>
        </li>
        <li><a href="#custom-validation-rules">Tùy biến quy định validation</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Laravel cung cấp một vài cách tiếp cận để validate dữ liệu đến ứng dụng của bạn. Mặc định, class base controller của Laravel sử dụng <code class=" language-php">ValidatesRequests</code> trait cung cấp phương thức khá thuận tiện cho việc validate HTTP request đến với đa dạng quy định validation.</p>
    <p>
        <a name="validation-quickstart"></a>
    </p>
    <h2><a href="#validation-quickstart">Bắt đầu nhanh validation</a></h2>
    <p>Để học tính năng validation của Laravel, Hãy xem một ví dụ hoàn chỉnh validate một form và hiển thị nội dung lỗi trả về cho người dùng.</p>
    <p>
        <a name="quick-defining-the-routes"></a>
    </p>
    <h3>Xác định routes</h3>
    <p>Đầu tiên, giả sử chúng ta có route được định nghĩa trong <code class=" language-php">routes<span class="token operator">/</span>web<span class="token punctuation">.</span>php</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'post/create'</span><span class="token punctuation">,</span> <span class="token string">'PostController@create'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'post'</span><span class="token punctuation">,</span> <span class="token string">'PostController@store'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tất nhiên, phương thức <code class=" language-php"><span class="token constant">GET</span></code> route sẽ hiển thị một form cho người dùng tạo mới một bài viết, trong khi phương thức <code class=" language-php"><span class="token constant">POST</span></code> route sẽ lưu bài viết đấy vào cơ sở dữ liệu.</p>
    <p>
        <a name="quick-creating-the-controller"></a>
    </p>
    <h3>Tạo Controller</h3>
    <p>Tiếp theo, tạo một controller đơn giản xử lý các routes.Bây giờ, chúng ta sẽ để phương thức đấy <code class=" language-php">store</code> rỗng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">PostController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Show the form to create a new blog post.
     *
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'post.create'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Store a new blog post.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Validate and store the blog post...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="quick-writing-the-validation-logic"></a>
    </p>
    <h3>Viết logic validation</h3>
    <p>Bây giờ chúng ta đã sẵn sàng viết logic vào phương thức <code class=" language-php">store</code>  để validate tạo mới bài viết. Nếu bạn kiểm tra class base controller (<code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span></code>) của Laravel, bạn sẽ thấy class sử dụng một <code class=" language-php">ValidatesRequests</code> trait. nó cung cấp một phương thức <code class=" language-php">validate</code> cho tất cả controllers.</p>
    <p>Phương thức <code class=" language-php">validate</code> chấp nhận một HTTP request đến và đặt quy định validation. Nếu quy định validationthành công, code của bạn sẽ thực thi bình thường; tuy nhiên, nếu validation thất bại, mội exception sẽ được ném và tích hợp lỗi response sẽ được tự động gửi cho người dùng. Trong trường hợp là HTTP request, một response chuyển trang sẽ được tạo ra, trong khi một JSON response sẽ được gửi cho AJAX requests.</p>
    <p>Để có thể hiểu rõ hơn về phương thức <code class=" language-php">validate</code> , hãy quay lại phương thức <code class=" language-php">store</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Store a new blog post.
 *
 * @param  Request  $request
 * @return Response
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">validate<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
        <span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|unique:posts|max:255'</span><span class="token punctuation">,</span>
        <span class="token string">'body'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> // The blog post is valid, store in database...
</span><span class="token punctuation">}</span></code></pre>
    <p>Như bạn có thể thấy, chúng ta có thể truyền qua HTTP request  đến và yêu cầu quy định validation vào phương thức <code class=" language-php">validate</code>. Một lần nữa, nếu validation thất bại, Một proper response sẽ tự động được tạo ra. Nếu validation thành công, controller sẽ được thực thi bình thường.</p>
    <h4>Dừng khi validation thất bại</h4>
    <p>Thình thoảng bạn muốn quy định validation trong một thuộc tính sau khi validation đầu tiên thất bại. Để làm việc đó, gán quy định <code class=" language-php">bail</code> cho thuộc tính:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">validate<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'bail|required|unique:posts|max:255'</span><span class="token punctuation">,</span>
    <span class="token string">'body'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Trong ví dụ này, nếu quy định <code class=" language-php">required</code> trên thuộc tính <code class=" language-php">title</code> thất bại, quy định <code class=" language-php">unique</code> sẽ không cần kiểm tra. Quy định sẽ validate trong thứ tự mà nó được gán.</p>
    <h4>Chú ý thuộc tính lồng nhau</h4>
    <p>Nếu HTTP request chứa tham số "lồng nhau", bạn có thể chỉ định chúng trong quy định validate bằng cách sử dụng cú pháp "dấu chấm":</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">validate<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|unique:posts|max:255'</span><span class="token punctuation">,</span>
    <span class="token string">'author.name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required'</span><span class="token punctuation">,</span>
    <span class="token string">'author.description'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="quick-displaying-the-validation-errors"></a>
    </p>
    <h3>Hiển thị validation lỗi</h3>
    <p>Cái gì sẽ xảy ra khi có một tham số request gửi đến không thành không với quy định validation? Như đã đề cập ở trước, Laravel sẽ tự động chuyển trang lại cho người dùng về trang trước đó. Ngoài ra, tất cả các lỗi validation sẽ tự động <a href="{{URL::asset('')}}docs/5.3/session#flash-data">flashed vào session</a>.</p>
    <p>Một lần nữa, chú ý rằng chúng ta sẽ không có một cách rõ ràng bind nội dung lỗi vào view của <code class=" language-php"><span class="token constant">GET</span></code> route. Bời vì Laravel sẽ tự động kiểm tra lỗi trong dữ liệu session, và tự động bind chúng vào view nếu chúng tồn tại. Biến <code class=" language-php"><span class="token variable">$errors</span></code> sẽ là một thể hiện của <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>MessageBag</span></code>. Để biết thêm chi tiết về nó, <a href="#working-with-error-messages">có thể xem tại đây</a>.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Biến <code class=" language-php"><span class="token variable">$errors</span></code> là bound vào view bởi middleware <code class=" language-php">Illuminate\<span class="token package">View<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>ShareErrorsFromSession</span></code>, nó được cung cấp bởi nhóm middleware <code class=" language-php">web</code> middleware. <strong>Khi middleware này được áp dụng, một biến <code class=" language-php"><span class="token variable">$errors</span></code> sẽ luôn luôn tồn tại tronh view của bạn</strong>, cho phép bạn thuận tiện để giả định biến <code class=" language-php"><span class="token variable">$errors</span></code> luôn luôn được định nghĩa và có thể sử dụng.</p>
    </blockquote>
    <p>Vì vậy, trong ví dụ trên, người dùng sẽ chuyển trang đến phương thức <code class=" language-php">create</code> của controller khi validation thất bại, cho phép chúng ta hiển thị nội dung lỗi trên view:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- /resources/views/post/create.blade.php --&gt;</span></span>

<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h1</span><span class="token punctuation">&gt;</span></span></span>Create Post<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h1</span><span class="token punctuation">&gt;</span></span></span>

@<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token function">count<span class="token punctuation">(</span></span><span class="token variable">$errors</span><span class="token punctuation">)</span> <span class="token operator">&gt;</span> <span class="token number">0</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert alert-danger<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>ul</span><span class="token punctuation">&gt;</span></span></span>
            @<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$errors</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token keyword">as</span> <span class="token variable">$error</span><span class="token punctuation">)</span>
                <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>li</span><span class="token punctuation">&gt;</span></span></span><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$error</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>li</span><span class="token punctuation">&gt;</span></span></span>
            @<span class="token keyword">endforeach</span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>ul</span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>
@<span class="token keyword">endif</span>

<span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- Create Post Form --&gt;</span></span></code></pre>
    <p>
        <a name="quick-customizing-the-flashed-error-format"></a>
    </p>
    <h4>Tùy biến định dạng lỗi Flashed </h4>
    <p>Giả sử bạn muốn tùy chỉnh nội dung lỗi của validation được flashed vào session khi validation thất bại, ghi đè phương thức <code class=" language-php">formatValidationErrors</code> trong base controller. Đừng quên import class <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Validation<span class="token punctuation">\</span>Validator</span></code> ở trên đầu file file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Bus<span class="token punctuation">\</span>DispatchesJobs</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Validation<span class="token punctuation">\</span>Validator</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Routing<span class="token punctuation">\</span>Controller</span> <span class="token keyword">as</span> BaseController<span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Validation<span class="token punctuation">\</span>ValidatesRequests</span><span class="token punctuation">;</span>

<span class="token keyword">abstract</span> <span class="token keyword">class</span> <span class="token class-name">Controller</span> <span class="token keyword">extends</span> <span class="token class-name">BaseController</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">DispatchesJobs</span><span class="token punctuation">,</span> ValidatesRequests<span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * {@inheritdoc}
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function">formatValidationErrors<span class="token punctuation">(</span></span>Validator <span class="token variable">$validator</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$validator</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">errors<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="quick-ajax-requests-and-validation"></a>
    </p>
    <h4>AJAX Requests &amp; Validation</h4>
    <p>Trong ví dụ này, chúng ta sử dụng form để gửi dữ liệu vào ứng dụng. Tuy nhiên, nhiều ứng dụng sử dụng AJAX requests. Khi sử dụng phương thức <code class=" language-php">validate</code> trong AJAX request, Laravel sẽ không tạo ra redirect response. Thay vì, Laravel tạo một JSON response chứa tất cả lỗi validation. JSON response này sẽ được gửi với mã 422 HTTP status.</p>
    <p>
        <a name="form-request-validation"></a>
    </p>
    <h2><a href="#form-request-validation">Form Request Validation</a></h2>
    <p>
        <a name="creating-form-requests"></a>
    </p>
    <h3>Tạo Form Requests</h3>
    <p>Với những trường hợp validation phức tạp, bạn có thể tạo một "form request". Form requests là tùy chỉnh class request chứa logic validation. Để tạo class  form request, sử dụng lệnh <code class=" language-php">make<span class="token punctuation">:</span>request</code> Artisan CLI:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>request StoreBlogPost</code></pre>
    <p>class được tạo sẽ nằm ở thư mục <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Requests</code> directory. Nếu thư mục đó không tồn tại, nó sẽ được tạo khi bạn chạy lệnh <code class=" language-php">make<span class="token punctuation">:</span>request</code>. Chúng ta sẽ thêm một vài quy định validation vào trong phương thưc <code class=" language-php">rules</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the validation rules that apply to the request.
 *
 * @return array
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">rules<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span>
        <span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|unique:posts|max:255'</span><span class="token punctuation">,</span>
        <span class="token string">'body'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Bạn đánh giá thế nào về quy định validation? tất cả bạn cần làm là type-hint request vào trong phương thức controller. Form request được validated trước khi phương thức controller được gọi, nghĩa là bạn không cần viết một mớ hỗn độn logic trong controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Store the incoming blog post.
 *
 * @param  StoreBlogPost  $request
 * @return Response
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>StoreBlogPost <span class="token variable">$request</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // The incoming request is valid...
</span><span class="token punctuation">}</span></code></pre>
    <p>Nếu validation thất bại, một chuyển trang response sẽ được tạo ra để gửi cho lại người dùng đến trang trước. Ngoài ra lỗi sẽ được flashed vào session, vì vậy chúng ta có thể hiển thị nó. Nếu request là AJAX request, một HTTP response với mã 422 status sẽ được trả về cho người dùng gồm JSON representation chứa lỗi validation.</p>
    <p>
        <a name="authorizing-form-requests"></a>
    </p>
    <h3>Authorizing Form Requests</h3>
    <p>Class form request ngoài ra còn chứa một phương thức <code class=" language-php">authorize</code>. Bên trong phương thức, bạn có thể xác thực người dùng thực sự đã có quyền cập nhật dữ liệu. Ví dụ, nếu một người dùng cố gắng cập nhật comment của một một bài viết, họ thật sự sở hữa comment đấy? Ví dụ:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Determine if the user is authorized to make this request.
 *
 * @return bool
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">authorize<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token variable">$comment</span> <span class="token operator">=</span> <span class="token scope">Comment<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">route<span class="token punctuation">(</span></span><span class="token string">'comment'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token keyword">return</span> <span class="token variable">$comment</span> <span class="token operator">&amp;&amp;</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">can<span class="token punctuation">(</span></span><span class="token string">'update'</span><span class="token punctuation">,</span> <span class="token variable">$comment</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Khi tất cả các form requests kế thừa từ class base Laravel request, chúng ta có thể sử dụng phương thức <code class=" language-php">user</code> để truy cập xác thức người dùng. Ngoài ra cũng cần gọi phương thức <code class=" language-php">route</code> trong ví dụ trên. Phương thức này cho phép bạn truy cập đến tham số của URI được định nghĩa trong route được gọi, như tham số <code class=" language-php"><span class="token punctuation">{</span>comment<span class="token punctuation">}</span></code> trong ví dụ trên:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'comment/{comment}'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu phương thức <code class=" language-php">authorize</code>  trả về <code class=" language-php"><span class="token boolean">false</span></code>, một HTTP response với mã 403 status sẽ được tự động trả về và phương thức controller sẽ không được thực hiện.</p>
    <p>Nếu bạn có kế hoạch cho phép logic trong một phần khác ứng dung của bạn, đơn giản trả về <code class=" language-php"><span class="token boolean">true</span></code> từ phương thức <code class=" language-php">authorize</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Determine if the user is authorized to make this request.
 *
 * @return bool
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">authorize<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token boolean">true</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="customizing-the-error-format"></a>
    </p>
    <h3>Tùy biến định dạng lỗi</h3>
    <p>Nếu bạn muốn tùy biến định dạng lỗi validation được flashed vào session khi validation thất bại, ghi đè phương thức <code class=" language-php">formatErrors</code> trong base request (<code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Requests<span class="token punctuation">\</span>Request</span></code>). Đừng quên import class <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Validation<span class="token punctuation">\</span>Validator</span></code> class ở trên đầu file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * {@inheritdoc}
 */</span>
<span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function">formatErrors<span class="token punctuation">(</span></span>Validator <span class="token variable">$validator</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$validator</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">errors<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="customizing-the-error-messages"></a>
    </p>
    <h3>Tùy biến nội dung lỗi</h3>
    <p>Bạn có thể muốn tùy biến lỗi dung lỗi bằng cách sử dụng bởi form request bằng cách ghi đè phương thức <code class=" language-php">messages</code>. Phương thức này trả về một mảng các cặp thuộc tính / quy định tương ứng với nội dung lỗi:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">messages<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span>
        <span class="token string">'title.required'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'A title is required'</span><span class="token punctuation">,</span>
        <span class="token string">'body.required'</span>  <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'A message is required'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="manually-creating-validators"></a>
    </p>
    <h2><a href="#manually-creating-validators">Tự tạo validator</a></h2>
    <p>Nếu bạn không muốn sử dụng phương thức <code class=" language-php">ValidatesRequests</code> trait's <code class=" language-php">validate</code>, bạn có thể tự tạo một thể hiện validator instance bằng <code class=" language-php">Validator</code> <a href="{{URL::asset('')}}docs/5.3/facades">facade</a>. Phương thức <code class=" language-php">make</code> trong facade sinh ra một thể hiện mới validator:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Validator</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">PostController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Store a new blog post.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$validator</span> <span class="token operator">=</span> <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
            <span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|unique:posts|max:255'</span><span class="token punctuation">,</span>
            <span class="token string">'body'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required'</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$validator</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">fails<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'post/create'</span><span class="token punctuation">)</span>
                        <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withErrors<span class="token punctuation">(</span></span><span class="token variable">$validator</span><span class="token punctuation">)</span>
                        <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withInput<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>

       <span class="token comment" spellcheck="true"> // Store the blog post...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Đối số đầu tiên truyền vào phương thức <code class=" language-php">make</code> là dữ liệu cần validation. Đối số thứ hai là mảng quy định validation được áp dụng vào dữ liệu.</p>
    <p>Sau khi kiểm tra request validation không thành công, bạn có thể dùng phương thức <code class=" language-php">withErrors</code> để flash nội dung lỗi vào session. Khi sử dụng phương thức này, Biến <code class=" language-php"><span class="token variable">$errors</span></code> sẽ tự động được gửi đến views sau khi chuyển trang, cho phép bạn dễ dàng hiển thị chúng cho người dùng. Phương thức <code class=" language-php">withErrors</code> chấp nhận một validator, <code class=" language-php">MessageBag</code>, hoặc một <code class=" language-php"><span class="token keyword">array</span></code> PHP.</p>
    <p>
        <a name="automatic-redirection"></a>
    </p>
    <h3>Redirection tự động</h3>
    <p>Nếu bạn muốn tạo mới một thể hiện validator những vẫn tự động chuyển trang bởi <code class=" language-php">ValidatesRequest</code> trait, bạn có thể gọi phương thức <code class=" language-php">validate</code> trong một thể hiện hiện tại validator. Nếu validation thất bạn, người dùng sẽ tự động được chuyển trang hoặc trong trường hợp là một AJAX request, một JSON response sẽ được trả về:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|unique:posts|max:255'</span><span class="token punctuation">,</span>
    <span class="token string">'body'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">validate<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="named-error-bags"></a>
    </p>
    <h3>Named Error Bags</h3>
    <p>Nếu bạn có nhiều form trên một trang, bạn có thể sử dụng phương thức <code class=" language-php">MessageBag</code>, cho phép bạn nhận nội dung lỗi từ form cụ thể. Đơn giản chỉ là truyền thêm một tham số thứ hai của phương thức <code class=" language-php">withErrors</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'register'</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withErrors<span class="token punctuation">(</span></span><span class="token variable">$validator</span><span class="token punctuation">,</span> <span class="token string">'login'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn cũng có thể lấy một thể hiện <code class=" language-php">MessageBag</code> từ biến <code class=" language-php"><span class="token variable">$errors</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$errors</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">login</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">first<span class="token punctuation">(</span></span><span class="token string">'email'</span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="after-validation-hook"></a>
    </p>
    <h3>After Validation Hook</h3>
    <p>Ngoài ra validator còn cho phép bạn thêm callbacks để chạy sau khi validation thành công. Điều này cho phép bạn dễ dàng thực hiện các validation và thêm nội dung lỗi cho message collection. Để bắt đầu, sử dụng phương thức <code class=" language-php">after</code> trong một thể hiện validator:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$validator</span> <span class="token operator">=</span> <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$validator</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">after<span class="token punctuation">(</span></span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$validator</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">somethingElseIsInvalid<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token variable">$validator</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">errors<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">add<span class="token punctuation">(</span></span><span class="token string">'field'</span><span class="token punctuation">,</span> <span class="token string">'Something is wrong with this field!'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$validator</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">fails<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="working-with-error-messages"></a>
    </p>
    <h2><a href="#working-with-error-messages">Làm việc với nội dung lỗi</a></h2>
    <p>Sau khi gọi phương thức <code class=" language-php">errors</code> trong một thể hiện <code class=" language-php">Validator</code>, bạn sẽ nhận được một thể hiện <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>MessageBag</span></code>, sẽ có một số phương thức làm việc với nội dung lỗi. Biến <code class=" language-php"><span class="token variable">$errors</span></code> sẽ tự động được tạo cho tất cả các view, ngoài ra nó cũng là một thể hiện của class <code class=" language-php">MessageBag</code>.</p>
    <h4>Nhận về nội dung lỗi đầu tiên của một trường</h4>
    <p>Để nhận về lỗi đầu tiên của một trường, sử dụng phương thức <code class=" language-php">first</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$errors</span> <span class="token operator">=</span> <span class="token variable">$validator</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">errors<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$errors</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">first<span class="token punctuation">(</span></span><span class="token string">'email'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Nhận về tất cả nội dung lỗi của một trường</h4>
    <p>Nếu bạn cần nhận một mảng nội dung của tất cả lỗi của một trường, sử dụng phương thức <code class=" language-php">get</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$errors</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'email'</span><span class="token punctuation">)</span> <span class="token keyword">as</span> <span class="token variable">$message</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>Nếu bạn validating một mảng các trường của form, bạn có thể nhận về tất cả nội dung cho mỗi phần tử của mảng bằng cách sử dụng ký tự <code class=" language-php"><span class="token operator">*</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$errors</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'attachments.*'</span><span class="token punctuation">)</span> <span class="token keyword">as</span> <span class="token variable">$message</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Nhận về tất cả các lỗi của tất cả các trường</h4>
    <p>Để nhận một mảng tất cả các nội dung của tất cả các trường, sử dụng phương thức <code class=" language-php">all</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$errors</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token keyword">as</span> <span class="token variable">$message</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Xác định nội dung của một trường có tồn tại</h4>
    <p>Phương thức <code class=" language-php">has</code> có thể sử dụng để xác định bất kỳ nội dung lỗi tồn tại của một trường:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$errors</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">has<span class="token punctuation">(</span></span><span class="token string">'email'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="custom-error-messages"></a>
    </p>
    <h3>Tùy biến nội dung</h3>
    <p>Nếu bạn cần, bạn có thể tùy biến nội dung lỗi cho thể hiện validation mặc định. Có một vài cách để làm việc này. Đầu tiên, bạn có thể truyền tùy biến nội dung như là tham số thứ ba của hàm <code class=" language-php"><span class="token scope">Validator<span class="token punctuation">::</span></span>make</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$messages</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'required'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'The :attribute field is required.'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$validator</span> <span class="token operator">=</span> <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$input</span><span class="token punctuation">,</span> <span class="token variable">$rules</span><span class="token punctuation">,</span> <span class="token variable">$messages</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Trong ví dụ trên, thuộc tính <code class=" language-php"><span class="token punctuation">:</span>attribute</code> place-holdersẽ thay thế bởi tên thực tế của trường validation. Ngoài ra bạn có thể sử dụng place-holders trong nội dung validation. Ví dụ:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$messages</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'same'</span>    <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'The :attribute and :other must match.'</span><span class="token punctuation">,</span>
    <span class="token string">'size'</span>    <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'The :attribute must be exactly :size.'</span><span class="token punctuation">,</span>
    <span class="token string">'between'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'The :attribute must be between :min - :max.'</span><span class="token punctuation">,</span>
    <span class="token string">'in'</span>      <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'The :attribute must be one of the following types: :values'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <h4>Tùy biến nội dung của thuộc tính cụ thể</h4>
    <p>Thỉnh thoảng bạn có thể tùy biến nội dung lỗi chỉ duy nhất một trường. Bạn có thể sử dụng "dấu chấm". Chỉ định tên của thuộc tính đầu tiên, theo bởi quy định:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$messages</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'email.required'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'We need to know your e-mail address!'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="localization"></a>
    </p>
    <h4>Tùy biến nội dung trong file ngôn ngữ</h4>
    <p>Trong hầu hết các trương hợp, bạn có thể tùy biến nội dung trong một file ngôn ngữ thay vì truyền chúng trực tiếp vào phương thức <code class=" language-php">Validator</code>. Đề làm điều này, bạn thêm nội dung vào mảng <code class=" language-php">custom</code> trong file ngôn ngữ <code class=" language-php">resources<span class="token operator">/</span>lang<span class="token operator">/</span>xx<span class="token operator">/</span>validation<span class="token punctuation">.</span>php</code>.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'custom'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'required'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'We need to know your e-mail address!'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <h4>Tùy biến thuộc tính trong file ngôn ngữ</h4>
    <p>Nếu bạn muốn thuộc tính <code class=" language-php"><span class="token punctuation">:</span>attribute</code> phần nội dung validation sẽ được thay đổi bởi tên thuộc tính tùy chỉnh, bạn có thể tùy biến trong mảng <code class=" language-php">attributes</code> của file ngôn ngữ <code class=" language-php">resources<span class="token operator">/</span>lang<span class="token operator">/</span>xx<span class="token operator">/</span>validation<span class="token punctuation">.</span>php</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'attributes'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'email address'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="available-validation-rules"></a>
    </p>
    <h2><a href="#available-validation-rules">Những quy định validation có sẵn</a></h2>
    <p>Bên dưới là danh sách những quy định có sẵn và hàm của nó:</p>
    <style>
        .collection-method-list > p {
            column-count: 3;
            -moz-column-count: 3;
            -webkit-column-count: 3;
            column-gap: 2em;
            -moz-column-gap: 2em;
            -webkit-column-gap: 2em;
        }
        .collection-method-list a {
            display: block;
        }
    </style>
    <div class="collection-method-list">
        <p><a href="#rule-accepted">Accepted</a>
            <a href="#rule-active-url">Active URL</a>
            <a href="#rule-after">After (Date)</a>
            <a href="#rule-alpha">Alpha</a>
            <a href="#rule-alpha-dash">Alpha Dash</a>
            <a href="#rule-alpha-num">Alpha Numeric</a>
            <a href="#rule-array">Array</a>
            <a href="#rule-before">Before (Date)</a>
            <a href="#rule-between">Between</a>
            <a href="#rule-boolean">Boolean</a>
            <a href="#rule-confirmed">Confirmed</a>
            <a href="#rule-date">Date</a>
            <a href="#rule-date-format">Date Format</a>
            <a href="#rule-different">Different</a>
            <a href="#rule-digits">Digits</a>
            <a href="#rule-digits-between">Digits Between</a>
            <a href="#rule-dimensions">Dimensions (Image Files)</a>
            <a href="#rule-distinct">Distinct</a>
            <a href="#rule-email">E-Mail</a>
            <a href="#rule-exists">Exists (Database)</a>
            <a href="#rule-file">File</a>
            <a href="#rule-filled">Filled</a>
            <a href="#rule-image">Image (File)</a>
            <a href="#rule-in">In</a>
            <a href="#rule-in-array">In Array</a>
            <a href="#rule-integer">Integer</a>
            <a href="#rule-ip">IP Address</a>
            <a href="#rule-json">JSON</a>
            <a href="#rule-max">Max</a>
            <a href="#rule-mimetypes">MIME Types</a>
            <a href="#rule-mimes">MIME Type By File Extension</a>
            <a href="#rule-min">Min</a>
            <a href="#rule-nullable">Nullable</a>
            <a href="#rule-not-in">Not In</a>
            <a href="#rule-numeric">Numeric</a>
            <a href="#rule-present">Present</a>
            <a href="#rule-regex">Regular Expression</a>
            <a href="#rule-required">Required</a>
            <a href="#rule-required-if">Required If</a>
            <a href="#rule-required-unless">Required Unless</a>
            <a href="#rule-required-with">Required With</a>
            <a href="#rule-required-with-all">Required With All</a>
            <a href="#rule-required-without">Required Without</a>
            <a href="#rule-required-without-all">Required Without All</a>
            <a href="#rule-same">Same</a>
            <a href="#rule-size">Size</a>
            <a href="#rule-string">String</a>
            <a href="#rule-timezone">Timezone</a>
            <a href="#rule-unique">Unique (Database)</a>
            <a href="#rule-url">URL</a>
        </p>
    </div>
    <p>
        <a name="rule-accepted"></a>
    </p>
    <h4>accepted</h4>
    <p>Giá trị phải là <em>yes</em>, <em>on</em>, <em>1</em>, or <em>true</em>. Rất hữu dụng cho việc chấp nhận "Terms of Service".</p>
    <p>
        <a name="rule-active-url"></a>
    </p>
    <h4>active_url</h4>
    <p>Giá trị phải là URL theo hàm <code class=" language-php">checkdnsrr</code> của PHP.</p>
    <p>
        <a name="rule-after"></a>
    </p>
    <h4>after:<em>date</em></h4>
    <p>Giá trị phải là một ngày sau ngày đã cho. Giá trị ngày phải hợp lệ theo hàm <code class=" language-php">strtotime</code> của PHP:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'start_date'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|date|after:tomorrow'</span></code></pre>
    <p>Thay vì truyền giá trị ngày vào một chuỗi vào hàm <code class=" language-php">strtotime</code>, bạn có thể chỉ định một trường khác để so sánh ngày:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'finish_date'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|date|after:start_date'</span></code></pre>
    <p>
        <a name="rule-alpha"></a>
    </p>
    <h4>alpha</h4>
    <p>Giá trị phải là chữ cái.</p>
    <p>
        <a name="rule-alpha-dash"></a>
    </p>
    <h4>alpha_dash</h4>
    <p>Giá trị phải là chữ cái hoặc chữ số, gồm cả dấu gạch ngang và dấu gạch dưới.</p>
    <p>
        <a name="rule-alpha-num"></a>
    </p>
    <h4>alpha_num</h4>
    <p>Giá trị phải là chữ số.</p>
    <p>
        <a name="rule-array"></a>
    </p>
    <h4>array</h4>
    <p>Giá trị phải là một <code class=" language-php"><span class="token keyword">array</span></code> PHP.</p>
    <p>
        <a name="rule-before"></a>
    </p>
    <h4>before:<em>date</em></h4>
    <p>Giá trị phải là ngày trước ngày đã cho. Giá trị ngày sẽ được truyền vào hàm <code class=" language-php">strtotime</code> của PHP.</p>
    <p>
        <a name="rule-between"></a>
    </p>
    <h4>between:<em>min</em>,<em>max</em></h4>
    <p>Giá trị phải nằm trong khoảng <em>min</em> and <em>max</em>. Chuỗi, số, và file là giống kiểu <a href="#rule-size"><code class=" language-php">size</code></a> với nhau.</p>
    <p>
        <a name="rule-boolean"></a>
    </p>
    <h4>boolean</h4>
    <p>Giá trị phải là kiểu boolean có thể là <code class=" language-php"><span class="token boolean">true</span></code>, <code class=" language-php"><span class="token boolean">false</span></code>, <code class=" language-php"><span class="token number">1</span></code>, <code class=" language-php"><span class="token number">0</span></code>, <code class=" language-php"><span class="token string">"1"</span></code>, và <code class=" language-php"><span class="token string">"0"</span></code>.</p>
    <p>
        <a name="rule-confirmed"></a>
    </p>
    <h4>confirmed</h4>
    <p>Giá trị phải khớp với trường <code class=" language-php">foo_confirmation</code>. Ví dụ, nếu trường là <code class=" language-php">password</code>, thì giá trị <code class=" language-php">password_confirmation</code> phải khớp với trương mật khẩu.</p>
    <p>
        <a name="rule-date"></a>
    </p>
    <h4>date</h4>
    <p>Giá trị phải là ngày hợp lệ theo hàm <code class=" language-php">strtotime</code> của PHP.</p>
    <p>
        <a name="rule-date-format"></a>
    </p>
    <h4>date_format:<em>format</em></h4>
    <p>Giá trị phải giống <em>format</em> truyền vào. Định dạng phải hợp lệ với hàm <code class=" language-php">date_parse_from_format</code> của PHP. Bạn nên sử dụng <strong>either</strong> <code class=" language-php">date</code> hoặc <code class=" language-php">date_format</code> khi validate một trường.</p>
    <p>
        <a name="rule-different"></a>
    </p>
    <h4>different:<em>field</em></h4>
    <p>Giá trị phải khác giá trị của <em>field</em>.</p>
    <p>
        <a name="rule-digits"></a>
    </p>
    <h4>digits:<em>value</em></h4>
    <p>Giá trị phải là <em>numeric</em> và phải chính xác độ dài là <em>value</em>.</p>
    <p>
        <a name="rule-digits-between"></a>
    </p>
    <h4>digits_between:<em>min</em>,<em>max</em></h4>
    <p>Giá trị phải có độ dài nằm trong khoảng <em>min</em> and <em>max</em>.</p>
    <p>
        <a name="rule-dimensions"></a>
    </p>
    <h4>dimensions</h4>
    <p>Giá trị phải là một ảnh có kích thước giống rule's parameters:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'avatar'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'dimensions:min_width=100,min_height=200'</span></code></pre>
    <p>Tồn tại một số thuộc tính: <em>min_width</em>, <em>max_width</em>, <em>min_height</em>, <em>max_height</em>, <em>width</em>, <em>height</em>, <em>ratio</em>.</p>
    <p>A <em>ratio</em> biểu diễn tỷ lệ chiều rộng chia chiều cao.Có thể được xác định như <code class=" language-php"><span class="token number">3</span><span class="token operator">/</span><span class="token number">2</span></code> hoặc <code class=" language-php"><span class="token number">1.5</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'avatar'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'dimensions:ratio=3/2'</span></code></pre>
    <p>
        <a name="rule-distinct"></a>
    </p>
    <h4>distinct</h4>
    <p>Khi làm việc với mảng, Mảng phải không có giá trị lặp lại.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'foo.*.id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'distinct'</span></code></pre>
    <p>
        <a name="rule-email"></a>
    </p>
    <h4>email</h4>
    <p>Giá trị phải là một địa chỉ email.</p>
    <p>
        <a name="rule-exists"></a>
    </p>
    <h4>exists:<em>table</em>,<em>column</em></h4>
    <p>Giá trị phải có trong bảng cơ sở dữ liệu.</p>
    <h4>Basic Usage Of Exists Rule</h4>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'state'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'exists:states'</span></code></pre>
    <h4>Specifying A Custom Column Name</h4>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'state'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'exists:states,abbreviation'</span></code></pre>
    <p>Thỉnh thoảng, bạn cần kiểm tra kết nối database sử dụng cho <code class=" language-php">exists</code> query. Bạn có thể làm điều này bằng cách thêm  "dấu chấm" vào trước tên kết nối:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'exists:connection.staff,email'</span></code></pre>
    <p>Nếu bạn muốn tùy biến thực thi query , bạn có thể sử dụng class <code class=" language-php">Rule</code>để định nghĩa quy định. Trong ví dụ này, chúng ta chỉ định quy tắc validation như là một mảng thay vì sử dụng ký tự <code class=" language-php"><span class="token operator">|</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Validation<span class="token punctuation">\</span>Rule</span><span class="token punctuation">;</span>

<span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$data</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'required'</span><span class="token punctuation">,</span>
        <span class="token scope">Rule<span class="token punctuation">::</span></span><span class="token function">exists<span class="token punctuation">(</span></span><span class="token string">'staff'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'account_id'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="rule-file"></a>
    </p>
    <h4>file</h4>
    <p>Giá trị phải là một file tải lên thành công.</p>
    <p>
        <a name="rule-filled"></a>
    </p>
    <h4>filled</h4>
    <p>Giá trị không được phép trống.</p>
    <p>
        <a name="rule-image"></a>
    </p>
    <h4>image</h4>
    <p>Giá trị phải là ảnh có định dạng (jpeg, png, bmp, gif, or svg)</p>
    <p>
        <a name="rule-in"></a>
    </p>
    <h4>in:<em>foo</em>,<em>bar</em>,...</h4>
    <p>Giá trị phải thuộc danh sách các giá trị.</p>
    <p>
        <a name="rule-in-array"></a>
    </p>
    <h4>in_array:<em>anotherfield</em></h4>
    <p>Giá trị phải tồn tại trong giá trị của <em>anotherfield</em>'s.</p>
    <p>
        <a name="rule-integer"></a>
    </p>
    <h4>integer</h4>
    <p>Giá trị phải là kiểu integer.</p>
    <p>
        <a name="rule-ip"></a>
    </p>
    <h4>ip</h4>
    <p>Giá trị phải là địa chỉ IP.</p>
    <p>
        <a name="rule-json"></a>
    </p>
    <h4>json</h4>
    <p>Giá trị phải là một string JSON.</p>
    <p>
        <a name="rule-max"></a>
    </p>
    <h4>max:<em>value</em></h4>
    <p>Giá trị phải nhỏ hơn hoặc bằng <em>value</em>. Chuỗi, số, và file là kiểu giống  <a href="#rule-size"><code class=" language-php">size</code></a> với nhau.</p>
    <p>
        <a name="rule-mimetypes"></a>
    </p>
    <h4>mimetypes:<em>text/plain</em>,...</h4>
    <p>Giá trị phải khớp với MIME types:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'video'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'mimetypes:video/avi,video/mpeg,video/quicktime'</span></code></pre>
    <p>Xác định MIME type của file upload, nội dung file sẽ được đọc framework sẽ đoán MIME type, có thể sẽ khác MIME type của người dùng.</p>
    <p>
        <a name="rule-mimes"></a>
    </p>
    <h4>mimes:<em>foo</em>,<em>bar</em>,...</h4>
    <p>Giá trị phải khơp với MIME type ứng với một danh sách extensions.</p>
    <h4>Basic Usage Of MIME Rule</h4>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'photo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'mimes:jpeg,bmp,png'</span></code></pre>
    <p>Mặc dù bạn chỉ cần xác định extensions, thực ra quy định validates này lại là validate MIME type file bằng các đọc nội dung và đoán MIME type.</p>
    <p>Tất cả danh sách MIME types và extensions có thể tìm thấy ở:
        <a href="http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types"></a><a href="http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types">http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types</a>
    </p>
    <p>
        <a name="rule-min"></a>
    </p>
    <h4>min:<em>value</em></h4>
    <p>Giá trị phải nhỏ hơn <em>value</em>. Chuỗi, số, và file là giống <a href="#rule-size"><code class=" language-php">size</code></a> với nhau.</p>
    <p>
        <a name="rule-nullable"></a>
    </p>
    <h4>nullable</h4>
    <p>Giá trị có thể  <code class=" language-php"><span class="token keyword">null</span></code>. Nó rất hữu dụng khi validate string hoặc integer chứa giá trị <code class=" language-php"><span class="token keyword">null</span></code>.</p>
    <p>
        <a name="rule-not-in"></a>
    </p>
    <h4>not_in:<em>foo</em>,<em>bar</em>,...</h4>
    <p>Giá trị phải không thuộc danh sách giá trị.</p>
    <p>
        <a name="rule-numeric"></a>
    </p>
    <h4>numeric</h4>
    <p>Giá trị phải là số.</p>
    <p>
        <a name="rule-present"></a>
    </p>
    <h4>present</h4>
    <p>Giá trị hiện tại phải xuất hiện trong input nhưng thể được trống.</p>
    <p>
        <a name="rule-regex"></a>
    </p>
    <h4>regex:<em>pattern</em></h4>
    <p>Giá trị phải khớp với regular expression.</p>
    <p><strong>Note:</strong> Khi sử dụng <code class=" language-php">regex</code> pattern, nó cần được xác định quy định trong mảng thay vì sử dụng pipe delimiter, đặc biệt nếu regular expression chứa pipe ký tự.</p>
    <p>
        <a name="rule-required"></a>
    </p>
    <h4>required</h4>
    <p>Giá trị phải xuất hiện trong input và không được phép trống. Một trường được coi là "empty" nếu một trong số điều kiện dưới đây đúng:</p>
    <div class="content-list">
        <ul>
            <li>Giá trị là <code class=" language-php"><span class="token keyword">null</span></code>.</li>
            <li>Giá trị là một chuỗi rỗng.</li>
            <li>Giá trị là mảng rỗng hoặc object <code class=" language-php">Countable</code> rỗng.</li>
            <li>Giá trị là file upload không có đường dẫn.</li>
        </ul>
    </div>
    <p>
        <a name="rule-required-if"></a>
    </p>
    <h4>required_if:<em>anotherfield</em>,<em>value</em>,...</h4>
    <p>Giá trị phải xuất hiện và không được trống nếu trường <em>anotherfield</em> bằng bất kỳ <em>value</em>.</p>
    <p>
        <a name="rule-required-unless"></a>
    </p>
    <h4>required_unless:<em>anotherfield</em>,<em>value</em>,...</h4>
    <p>Giá trị phải xuất hiện và không được phép trống trừ khi trường <em>anotherfield</em> bằng bất kỳ <em>value</em>.</p>
    <p>
        <a name="rule-required-with"></a>
    </p>
    <h4>required_with:<em>foo</em>,<em>bar</em>,...</h4>
    <p>Giá trị phải xuất hiện và không được trống <em>only if</em> bất kỳ một trường khác xác định xuất hiện.</p>
    <p>
        <a name="rule-required-with-all"></a>
    </p>
    <h4>required_with_all:<em>foo</em>,<em>bar</em>,...</h4>
    <p>Giá trị phải xuất hiện và không được trống <em>only if</em> tất cả các trường khác xác định xuất hiện.</p>
    <p>
        <a name="rule-required-without"></a>
    </p>
    <h4>required_without:<em>foo</em>,<em>bar</em>,...</h4>
    <p>Giá trị phải xuất hiện và không được trống <em>only when</em> bất cứ trường xác định không xuất hiện.</p>
    <p>
        <a name="rule-required-without-all"></a>
    </p>
    <h4>required_without_all:<em>foo</em>,<em>bar</em>,...</h4>
    <p>The field under validation must be present and not empty <em>only when</em> all of the other specified fields are not present.</p>
    <p>
        <a name="rule-same"></a>
    </p>
    <h4>same:<em>field</em></h4>
    <p> Giá trị <em>field</em> phải khớp với trường này.</p>
    <p>
        <a name="rule-size"></a>
    </p>
    <h4>size:<em>value</em></h4>
    <p>Giá trị phải có kích thước khớp với <em>value</em>. Đối với chuỗi, <em>value</em> tương ứng là số ký tự. Đối với só, <em>value</em> tương ứng là giá trị integer. Đối với mảng, <em>size</em> tương ứng là <code class=" language-php">count</code> phần tử của mảng. Đối với file, <em>size</em> tương ứng là kích thước file kiểu kilobytes.</p>
    <p>
        <a name="rule-string"></a>
    </p>
    <h4>string</h4>
    <p>Giá trị phải là chuỗi. Nếu bạn muốn cho phép trường đó <code class=" language-php"><span class="token keyword">null</span></code>, bạn có thể gán <code class=" language-php">nullable</code> vào trường đó.</p>
    <p>
        <a name="rule-timezone"></a>
    </p>
    <h4>timezone</h4>
    <p>Giá trị phải là timezone identifier hợp lệ với hàm <code class=" language-php">timezone_identifiers_list</code> của PHP.</p>
    <p>
        <a name="rule-unique"></a>
    </p>
    <h4>unique:<em>table</em>,<em>column</em>,<em>except</em>,<em>idColumn</em></h4>
    <p>Giá trị phải là unique trong bảng cơ sở dữ liệu. Nếu tên  <code class=" language-php">column</code> không được chỉ định, trường name sẽ được sử dụng.</p>
    <p><strong>Specifying A Custom Column Name:</strong>
    </p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'unique:users,email_address'</span></code></pre>
    <p><strong>Tùy biến kết nối cơ sở dữ liệu</strong>
    </p>
    <p>Thỉnh thoảng, có thể bạn muốn tủy chỉnh kết nối query cơ sở dữ liệu bởi Validator. Như ở trên, cài đặt <code class=" language-php">unique<span class="token punctuation">:</span>users</code> như một quy định validation sẽ sử dụng kết nối mặc định database để query đến cơ sở dữ liệu. Để ghi đè nó, xác định kết nối và tên bảng sử dụng "dấu chấm":</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'unique:connection.users,email_address'</span></code></pre>
    <p><strong>Validate Uniquebỏ qua ID:</strong>
    </p>
    <p>Thỉnh thoảng, bạn có thể muốn bỏ qua id trong khi kiểm tra unique. Ví dụ, cân nhắc "cập nhận hồ sơ" sẽ bao gồm name, địa chỉ e-mail, và địa điểm của người dùng.Tất nhiên, bạn sẽ muốn xác định email là unique. Tuy nhiên, nếu người dùng chỉ thay đổi tên và không thay đổi email, bạn không muốn validation lỗi được ném ra bởi vì người dùng đó đã sử dụng cái email đấy rồi.</p>
    <p>Chỉ dẫn validator bỏ qua ID của người dùng, chúng ta sử dụng class <code class=" language-php">Rule</code> định nghĩa quy tắc. Trong ví dụ này, chúng ta sẽ chỉ định quy tắc validation như một mảng thay thế sử dụng ký tự để phân cách <code class=" language-php"><span class="token operator">|</span></code> quy định:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Validation<span class="token punctuation">\</span>Rule</span><span class="token punctuation">;</span>

<span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$data</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'required'</span><span class="token punctuation">,</span>
        <span class="token scope">Rule<span class="token punctuation">::</span></span><span class="token function">unique<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">ignore<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu bản user của bạn có a primary key không phải là <code class=" language-php">id</code>, bạn có thể chỉ định name của cột khi gọi phương thức <code class=" language-php">ignore</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">Rule<span class="token punctuation">::</span></span><span class="token function">unique<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">ignore<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">,</span> <span class="token string">'user_id'</span><span class="token punctuation">)</span></code></pre>
    <p><strong>Thêm điều kiện bổ sung:</strong>
    </p>
    <p>Bạn cũng có thể thêm query chứa tùy chỉnh query bằng cách sử dụng phương thức <code class=" language-php">where</code>. Ví dụ, chúng ta thêm một hạn chế để kiểm tra <code class=" language-php">account_id</code> là <code class=" language-php"><span class="token number">1</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">Rule<span class="token punctuation">::</span></span><span class="token function">unique<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'account_id'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span></code></pre>
    <p>
        <a name="rule-url"></a>
    </p>
    <h4>url</h4>
    <p>Giá trị phải là đúng định dạng URL.</p>
    <p>
        <a name="conditionally-adding-rules"></a>
    </p>
    <h2><a href="#conditionally-adding-rules">Thêm quy định có điều kiện</a></h2>
    <h4>Validating khi xuất hiện</h4>
    <p>Trong một số trường hợp, bạn có thể muốn chạy validation kiểm tra lại trường <strong>only</strong> nếu trường đó xuất hiện trong mảng input. Để nhanh chóng làm điều này, thêm <code class=" language-php">sometimes</code> vào trong danh sách quy tắc rule:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$v</span> <span class="token operator">=</span> <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$data</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'sometimes|required|email'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Trong ví dụ trên, trường <code class=" language-php">email</code> sẽ chỉ được validated nếu nó xuất hiện trong mảng <code class=" language-php"><span class="token variable">$data</span></code>.</p>
    <h4>Thêm quy định có điều kiện</h4>
    <p>Thỉnh thoảng bạn muốn thêm quy định trong logic. Ví dụ, bạn có thể muốn yêu cầu một trường chỉ nếu trường khác có giá trị lớn hơn 100. Hoặc, Bạn muốn 2 trường có giá trị chỉ khi trường khác xuất hiện. Để làm việc đó không có gì khó khăn cả. Đầu tiên, tạo một thể hiện <code class=" language-php">Validator</code> với <em>static rules</em> sẽ không bao giờ thay đổi:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$v</span> <span class="token operator">=</span> <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$data</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|email'</span><span class="token punctuation">,</span>
    <span class="token string">'games'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required|numeric'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Giả sử bây giờ ứng dụng web của bạn là sưu tầm game.Nếu một người sưu tầm game đăng ký ứng dụng của bạn và họ có nhỏ hơn 100 games, chúng ta muốn họ giải thích tại sao chọ có quá nhiều game. Ví dụ, có thể họ chạy một shop bán game, hoặc có thể họ thích sư tầm. Để có thể yêu cầu này, chúng ta có thể sử dụng phương thức <code class=" language-php">sometimes</code> trong thể hiện <code class=" language-php">Validator</code>.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$v</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sometimes<span class="token punctuation">(</span></span><span class="token string">'reason'</span><span class="token punctuation">,</span> <span class="token string">'required|max:500'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$input</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$input</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">games</span> <span class="token operator">&gt;=</span> <span class="token number">100</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tham số thứ nhất truyền vào phương thức <code class=" language-php">sometimes</code> là tên của trường chúng ta muốn validate.Tham số thứ hai là quy định chúng ta muốn thêm. Nếu truyền <code class=" language-php">Closure</code> như là tham số thứ ba trả về  <code class=" language-php"><span class="token boolean">true</span></code>, quy định sẽ được thêm. Phương thức này làm cho việc thêm quy định validate phức tạp trở lên dễ dàng hơn, ngay cả khi bạn muốn thêm nhiều validate cho nhiều trường:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$v</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sometimes<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'reason'</span><span class="token punctuation">,</span> <span class="token string">'cost'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'required'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$input</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$input</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">games</span> <span class="token operator">&gt;=</span> <span class="token number">100</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Tham số <code class=" language-php"><span class="token variable">$input</span></code> truyền vào trong <code class=" language-php">Closure</code> là một thể hiện của <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>Fluent</span></code> và bạn có thể truy cập input và file.</p>
    </blockquote>
    <p>
        <a name="validating-arrays"></a>
    </p>
    <h2><a href="#validating-arrays">Validating mảng</a></h2>
    <p>Validating mảng các trường của form không có gì khó khăn. Ví dụ, để validate mỗi email trong mảng trường input là unique, bạn có thể làm như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$validator</span> <span class="token operator">=</span> <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'person.*.email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'email|unique:users'</span><span class="token punctuation">,</span>
    <span class="token string">'person.*.first_name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'required_with:person.*.last_name'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tương tự như vậy, bạn có thể sử dụng ký tự <code class=" language-php"><span class="token operator">*</span></code> khi muốn chỉ định nội  dung validation trong file ngôn ngữ, làm cho việc dễ dàng sử dụng một file nội dung validate cho mảng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'custom'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'person.*.email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'unique'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Each person must have a unique e-mail address'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="custom-validation-rules"></a>
    </p>
    <h2><a href="#custom-validation-rules">Tùy biến quy định validation</a></h2>
    <p>Laravel cung cấp một số quy định validation rất hữu ích; tuy nhiên, có thể bạn muốn tạo validate bởi chính bạn. Một phương thức đăng ký tùy biến quy tắc validationlà sử dụng phương thức <code class=" language-php">extend</code> trong <code class=" language-php">Validator</code> <a href="{{URL::asset('')}}docs/5.3/facades">facade</a>. Chúng ta sẽ sử dụng nó trong một <a href="{{URL::asset('')}}docs/5.3/providers">service provider</a> để đăng ký tùy biến quy tắc validation:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Validator</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AppServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Bootstrap any application services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">extend<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$attribute</span><span class="token punctuation">,</span> <span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$parameters</span><span class="token punctuation">,</span> <span class="token variable">$validator</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">==</span> <span class="token string">'foo'</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Register the service provider.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">register<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Tùy biến validator Closure nhận bốn đối số: tên của <code class=" language-php"><span class="token variable">$attribute</span></code> được validate, giá trị <code class=" language-php"><span class="token variable">$value</span></code> của thuộc tính, một mảng quy định <code class=" language-php"><span class="token variable">$parameters</span></code>, và một thể hiện <code class=" language-php">Validator</code>.</p>
    <p>Bạn cũng có thể truyền một class và method vào phương thức <code class=" language-php">extend</code> thay vì một Closure:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">extend<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">,</span> <span class="token string">'FooValidator@validate'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Định nghĩa nội dung lỗi</h4>
    <p>Bạn có thể định nghĩa một nội dung lỗi cho quy định tùy biến của bạn. Bạn có thể làm như vậy hoặc một mảng nội dung tùy biến nội dung inline hoặc thêm vào validation file ngôn ngữ. Nội dung này sẽ được đặt ở trên đầu của mảng, không ở bên trong mảng <code class=" language-php">custom</code>,nó chỉ dành cho những nội dung lỗi  attribute-specific:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">"foo"</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">"Your input was invalid!"</span><span class="token punctuation">,</span>

<span class="token string">"accepted"</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">"The :attribute must be accepted."</span><span class="token punctuation">,</span>
<span class="token comment" spellcheck="true">
// The rest of the validation error messages...</span></code></pre>
    <p>Khi bạn tùy biến quy định validation, thỉnh thảng bạn cần định nghĩa tùy chỉnh place-holder thay thế nội dung lỗi. Bạn cũng có thể tạo một Validator như miểu tả ở trên sau đó gọi phương thức <code class=" language-php">replacer</code>trong <code class=" language-php">Validator</code> facade. Bạn có thể sử dụng trong phương thức <code class=" language-php">boot</code> của <a href="/docs/5.3/providers">service provider</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Bootstrap any application services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">extend<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">replacer<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$message</span><span class="token punctuation">,</span> <span class="token variable">$attribute</span><span class="token punctuation">,</span> <span class="token variable">$rule</span><span class="token punctuation">,</span> <span class="token variable">$parameters</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token function">str_replace<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Implicit Extensions</h4>
    <p>Mặc định, khi một thuộc tính đã được validated là không xuất hiện hoặc chứa một giá trị rỗng như định nghĩa bởi quy tắc <a href="#rule-required"><code class=" language-php">required</code></a>, quy tắc validation thường, bao gồm cả phần extensions, là không hoạt động. Ví dụ, quy định <a href="#rule-unique"><code class=" language-php">unique</code></a> sẽ không hoạt động lần nữa nếu giá trị <code class=" language-php"><span class="token keyword">null</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$rules</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'unique'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$input</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token keyword">null</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token variable">$input</span><span class="token punctuation">,</span> <span class="token variable">$rules</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">passes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span><span class="token comment" spellcheck="true"> // true</span></code></pre>
    <p>Đối với quy tắc validate hoạt động ngay cả khi thuộc tính là rỗng, quy định phải ngụ ý rằng các thuộc tính là bắt buộc. Như tạo một "implicit" extension, sử dụng phương thức <code class=" language-php"><span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">extendImplicit<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Validator<span class="token punctuation">::</span></span><span class="token function">extendImplicit<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$attribute</span><span class="token punctuation">,</span> <span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$parameters</span><span class="token punctuation">,</span> <span class="token variable">$validator</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">==</span> <span class="token string">'foo'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Một "implicit" extension chỉ <em>implies</em> ngụ ý là các thuộc tính là bắt buộc. Cho dù nó thực sự invalidates thuộc tính là lỗi hoặc rộng là phụ thuộc vào bạn.</p>
    </blockquote>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/validation">https://laravel.com/docs/5.3/validation</a>
</article>
@endsection