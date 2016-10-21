@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Localization</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#retrieving-language-lines">Nhận dòng ngôn ngữ</a>
            <ul>
                <li><a href="#replacing-parameters-in-language-lines">Đổi tham số trong dòng ngôn ngữ</a>
                </li>
                <li><a href="#pluralization">Tạo số nhiều</a>
                </li>
            </ul>
        </li>
        <li><a href="#overriding-package-language-files">Ghi đè nội dung của file ngôn ngữ</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Localization của laravel cung cấp một cách tiện lợi cho việc lấy các chuỗi dữ liệu từ các ngôn ngữ khác nhau, cho phép bạn dễ dàng tạo ứng dụng đa ngôn ngữ trong ứng dụng của bạn. Các chuỗi dữ liệu được lưu rong file nằm ở trong thư mục <code class=" language-php">resources<span class="token operator">/</span>lang</code>. Bên trong thư mục này có chứa các thư mục con cho mỗi ngôn ngữ được hỗ trở bởi ứng dụng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token operator">/</span>resources
    <span class="token operator">/</span>lang
        <span class="token operator">/</span>en
            messages<span class="token punctuation">.</span>php
        <span class="token operator">/</span>es
            messages<span class="token punctuation">.</span>php</code></pre>
    <p>Tất cả các file ngôn ngữ đơn giản chỉ cần trả về mảng các chuỗi key. Ví dụ:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>
    <span class="token string">'welcome'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Welcome to our application'</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <h3>Cấu hình ngôn ngữ</h3>
    <p>Ngôn ngữ mặc định được thiết lập trong file cấu hình <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> . Tất nhiên, bạn có thể chỉnh sửa sao cho phù hợp với ứng dụng của bạn. Bạn cũng có thể thay đổi ngôn ngữ sử dụng mặc định bằng cách sử dụng hàm  <code class=" language-php">setLocale</code> trong <code class=" language-php">App</code> facade:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'welcome/{locale}'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$locale</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token scope">App<span class="token punctuation">::</span></span><span class="token function">setLocale<span class="token punctuation">(</span></span><span class="token variable">$locale</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn cũng có thể cấu hình "ngôn ngữ thay thế", khi mà ngôn ngữ đang sử dụng không có chứa file ngôn ngữ tương ứng. Giống như ngôn ngữ mặc định, ngôn ngữ thay thế cũng được cấu hình trong file <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'fallback_locale'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'en'</span><span class="token punctuation">,</span></code></pre>
    <h4>Kiểm tra ngôn ngữ hiện tại</h4>
    <p>Bạn có thể sử dụng phương thức <code class=" language-php">getLocale</code> and <code class=" language-php">isLocale</code> trong <code class=" language-php">App</code> facade để xác định ngôn ngữ hiện tại hoặc kiểm tra giá trị của ngôn ngữ hiện tại:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$locale</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">::</span></span><span class="token function">getLocale<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">App<span class="token punctuation">::</span></span><span class="token function">isLocale<span class="token punctuation">(</span></span><span class="token string">'en'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="retrieving-language-lines"></a>
    </p>
    <h2><a href="#retrieving-language-lines">Nhận dòng ngôn ngữ</a></h2>
    <p>Bạn có thể lấy các dòng trong file ngôn ngữ bằng cách sử dụng hàm <code class=" language-php">trans</code>. Phương thức <code class=" language-php">trans</code> nhận tên file và khóa trong file ngôn ngữ ở đối số đầu tiên. Ví dụ, để lấy dòng có khóa là <code class=" language-php">welcome</code> trong file <code class=" language-php">resources<span class="token operator">/</span>lang<span class="token operator">/</span>messages<span class="token punctuation">.</span>php</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">trans<span class="token punctuation">(</span></span><span class="token string">'messages.welcome'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tất nhiên nếu bạn sử dụng <a href="{{URL::asset('')}}docs/5.3/blade">Blade templating engine</a>, bạn có thể sử dụng cú pháp <code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code> để hiện thị dòng trong file ngôn ngữ hoặc sử dụng <code class=" language-php">@@lang</code> directive:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">trans<span class="token punctuation">(</span></span><span class="token string">'messages.welcome'</span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>

@<span class="token function">lang<span class="token punctuation">(</span></span><span class="token string">'messages.welcome'</span><span class="token punctuation">)</span></code></pre>
    <p>Trường hợp nếu dòng ngôn ngữ không tồn tại, hàm <code class=" language-php">trans</code> sẽ trả về từ khóa của dòng đó. Vì vậy, ở ví dụ trên, hàm <code class=" language-php">trans</code> sẽ trả về <code class=" language-php">messages<span class="token punctuation">.</span>welcome</code> nếu dòng này không tồn tại.</p>
    <p>
        <a name="replacing-parameters-in-language-lines"></a>
    </p>
    <h3>Đổi tham số trong dòng ngôn ngữ</h3>
    <p>Nếu bạn muốn, bạn có thể khai báo các giá trị thay thế trong file ngôn ngữ. Tất cả các giá trị thay thế được tiền tố với đầu <code class=" language-php"><span class="token punctuation">:</span></code>.Ví dụ, bạn khai báo một nội dung welcome với tên của giá trị thay thế:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'welcome'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Welcome, :name'</span><span class="token punctuation">,</span></code></pre>
    <p>Khi thực hiện thay thế lấy ngôn ngữ, truyền vào một mảng các giá trị thay thế vào tham số thứ hai của hàm <code class=" language-php">trans</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">trans<span class="token punctuation">(</span></span><span class="token string">'messages.welcome'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'dayle'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu giá trị thay thế chứa toàn ký tự in hoa, hoặc chỉ viết đầu chữ hoa, thì giá trị được truyền vào sẽ được viết tương ứng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'welcome'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Welcome, :NAME'</span><span class="token punctuation">,</span><span class="token comment" spellcheck="true"> // Welcome, DAYLE
</span><span class="token string">'goodbye'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Goodbye, :Name'</span><span class="token punctuation">,</span><span class="token comment" spellcheck="true"> // Goodbye, Dayle</span></code></pre>
    <p>
        <a name="pluralization"></a>
    </p>
    <h3>Tạo số nhiều</h3>
    <p>Tạo số nhiều là một vấn đề khó, như các ngôn ngữ khác nhau đều có quy tắc phức tạp để chuyển từ sang số nhiều. Bằng cách sử dụng ký tự "|" , bạn có thể phân biệt được thể số ít hay số nhiều của một chuỗi:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'apples'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'There is one apple|There are many apples'</span><span class="token punctuation">,</span></code></pre>
    <p>Sau khi định nghĩa, bạn có thể dùng hàm <code class=" language-php">trans_choice</code> để lấy dòng ngôn ngữ cho một giá trị "count". Trong ví dụ này, khi mà giá trị count lớn hơn một, thì thể số nhieuf của dòng ngôn ngữ được trả về:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">trans_choice<span class="token punctuation">(</span></span><span class="token string">'messages.apples'</span><span class="token punctuation">,</span> <span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Vì phần phiên dịch của Laravel dựa trên thành phần phiên dịch của Symfony, bạn thậm chí có thể tạo các quy tắc phức tạo cho số nhiêud:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'apples'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'{0} There are none|[1,19] There are some|[20,Inf] There are many'</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="overriding-package-language-files"></a>
    </p>
    <h2><a href="#overriding-package-language-files">Ghi đè nội dung của file ngôn ngữ</a></h2>
    <p>Vài packages có thể đính kèm file ngôn ngữ riêng của nó. Thay vì chỉnh sửa các file ngôn ngữ core, bạn có thể thực hiện ghi đè bằng file riêng của bạn bằng cách đặt vào trong thư mục <code class=" language-php">resources<span class="token operator">/</span>lang<span class="token operator">/</span>vendor<span class="token operator">/</span><span class="token punctuation">{</span>package<span class="token punctuation">}</span><span class="token operator">/</span><span class="token punctuation">{</span>locale<span class="token punctuation">}</span></code>.</p>
    <p>Ví dụ, nếu bạn cần ghi đè nội dung tiếng anh trong file <code class=" language-php">messages<span class="token punctuation">.</span>php</code> của một package tên là <code class=" language-php">skyrim<span class="token operator">/</span>hearthfire</code>, bạn sẽ đặt file ngôn ngữ tại : <code class=" language-php">resources<span class="token operator">/</span>lang<span class="token operator">/</span>vendor<span class="token operator">/</span>hearthfire<span class="token operator">/</span>en<span class="token operator">/</span>messages<span class="token punctuation">.</span>php</code>. Trong file này chỉ nên định nghĩa các dòng ngôn ngữ bạn muốn thay thế. Bất cứ dòng nào bạn không ghi đè thì nõ vẫn lấy từ file gốc.</p>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/localization">https://laravel.com/docs/5.3/localization</a></div>
</article>
@endsection