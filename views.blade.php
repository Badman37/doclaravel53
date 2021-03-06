@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Views</h1>
    <ul>
        <li><a href="#creating-views">Tạo views</a>
        </li>
        <li><a href="#passing-data-to-views">Truyền dữ liệu vào views</a>
            <ul>
                <li><a href="#sharing-data-with-all-views">Chia sẻ dữ liệu cho tất cả views</a>
                </li>
            </ul>
        </li>
        <li><a href="#view-composers">View Composers</a>
        </li>
    </ul>
    <p>
        <a name="creating-views"></a>
    </p>
    <h2><a href="#creating-views">Tạo Views</a></h2>
    <p>Views chứa nội dung HTML phục vụ cho ứng dụng của bạn và tách riêng ra controller / ứng dụng. Views chứa tại thư mục <code class=" language-php">resources<span class="token operator">/</span>views</code>. Ví dụ đơn giản của view nhìn giống như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- View stored in resources/views/greeting.blade.php --&gt;</span></span>

<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>html</span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>body</span><span class="token punctuation">&gt;</span></span></span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h1</span><span class="token punctuation">&gt;</span></span></span>Hello<span class="token punctuation">,</span> <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$name</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h1</span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>body</span><span class="token punctuation">&gt;</span></span></span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>html</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>Nội dung view này lưu tại <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>greeting<span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code>, chúng ta sẽ trả dữ liệu về hàm <code class=" language-php">view</code> như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'greeting'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'James'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Như bạn có thể thấy, tham số đầu tiên của hàm  <code class=" language-php">view</code> tương ứng với tên tệp tin trong thư mục <code class=" language-php">resources<span class="token operator">/</span>views</code>. Tham số thứ hai là một mảng dữ liệu cần dùng cho view. Trong trường hợp này, chúng ta truyền biến <code class=" language-php">name</code>, khi nó hiển thị ở view, sử dụng cú pháp <a href="{{URL::asset('')}}docs/5.3/blade">Blade syntax</a>.</p>
    <p>Tất nhiên, các view có thể nằm trong thư mục con của thư mục <code class=" language-php">resources<span class="token operator">/</span>views</code>. "Dấu chấm"  sẽ ngăn cách các thư mục con. Ví dụ, Nếu view của bạn lưu trong thư mục <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>admin<span class="token operator">/</span>profile<span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code>, thì khi đó nó sẽ như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'admin.profile'</span><span class="token punctuation">,</span> <span class="token variable">$data</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Kiểm tra tồn tại view</h4>
    <p>Nếu bạn cần kiểm tra view có tồn tại hay không, bạn có thể dùng <code class=" language-php">View</code> facade. Phương thức <code class=" language-php">exists</code> sẽ trả về <code class=" language-php"><span class="token boolean">true</span></code> nếu view tồn tại:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>View</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">View<span class="token punctuation">::</span></span><span class="token function">exists<span class="token punctuation">(</span></span><span class="token string">'emails.customer'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="passing-data-to-views"></a>
    </p>
    <h2><a href="#passing-data-to-views">Truyền dữ liệu vào view</a></h2>
    <p>Như bạn nhìn thấy ở ví dụ trước, bạn có thể truyền một mảng của dữ liệu vào view:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'greetings'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Victoria'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Khi bạn truyền dữ liệu theo cách này, <code class=" language-php"><span class="token variable">$data</span></code>nên là một cặp key/value. Bên trong view, bạn có thể lấy giá trị bằng cách sử dụng key, như <code class=" language-php"><span class="token php"><span class="token delimiter">&lt;?php</span> <span class="token keyword">echo</span> <span class="token variable">$key</span><span class="token punctuation">;</span> <span class="token delimiter">?&gt;</span></span></code>. Bạn cũng có thể để truyền dữ liệu vào view <code class=" language-php">view</code>, bạn có thể dùng phương thức <code class=" language-php">with</code> như bên dưới:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'greeting'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'Victoria'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="sharing-data-with-all-views"></a>
    </p>
    <h4>Chia sẻ dữ liệu cho tất cả views</h4>
    <p>Thỉnh thoảng, bạn cần chia sẻ một phẩn dữ liệu với tất cả các views trong ứng dụng của bạn. Bạn có thể sử dụng phương thức <code class=" language-php">share</code> của facade. Thông thương, bạn chỉ cần họi phương thức <code class=" language-php">share</code>trong phương thức <code class=" language-php">boot</code> của service provider. Bạn có thể thoải mái thêm vào trong <code class=" language-php">AppServiceProvider</code> hoặc tự tạo ra một service provider khác:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>View</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AppServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Bootstrap any application services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">View<span class="token punctuation">::</span></span><span class="token function">share<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
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
    <p>
        <a name="view-composers"></a>
    </p>
    <h2><a href="#view-composers">View Composers</a></h2>
    <p>View composers là callbacks hoặc class phương thức nó được gọi khi một view được render. Nếu bạn có dữ liệu và bạn muốn ràng buộc chúng với một view tại thời điểm view được render, một view composer có thể giúp bạn tổ chức các logic bên trongview đó.</p>
    <p>Đối với ví dụ bên dưới, chúng ta đăng ký một view composers trong <a href="{{URL::asset('')}}docs/5.3/providers">service provider</a>. Chúng ta sẽ sử dụng <code class=" language-php">View</code> facade để truy cập vào thể hiện <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>View<span class="token punctuation">\</span>Factory</span></code>. Ghi nhớ, Laravel không có thư mục mặc định cho view composers. Chúng ta có thể tự do tổ chức theo ý chúng ta muốn. Ví dụ, bạn có thể tạo một thư mục <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>ViewComposers</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>View</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ComposerServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Register bindings in the container.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Using class based composers...
</span>        <span class="token scope">View<span class="token punctuation">::</span></span><span class="token function">composer<span class="token punctuation">(</span></span>
            <span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token string">'App\Http\ViewComposers\ProfileComposer'</span>
        <span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Using Closure based composers...
</span>        <span class="token scope">View<span class="token punctuation">::</span></span><span class="token function">composer<span class="token punctuation">(</span></span><span class="token string">'dashboard'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$view</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> //
</span>        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
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
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Chú ý, nếu bạn tạo mới một service provider chứa những view composer, bạn sẽ cần phải thêm service provider vào trong mảng <code class=" language-php">providers</code> trong file cấu hình <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code>.</p>
    </blockquote>
    <p>Bây giờ bạn đã đăng ký với composer, phương thức <code class=" language-php">ProfileComposer@compose</code> sẽ thực thi mỗi lần <code class=" language-php">profile</code> view được render. Vì vậy, Hãy định nghĩa một class composer:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>ViewComposers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>View<span class="token punctuation">\</span>View</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Repositories<span class="token punctuation">\</span>UserRepository</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ProfileComposer</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The user repository implementation.
     *
     * @var UserRepository
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$users</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>UserRepository <span class="token variable">$users</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Dependencies automatically resolved by service container...
</span>        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">users</span> <span class="token operator">=</span> <span class="token variable">$users</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">compose<span class="token punctuation">(</span></span>View <span class="token variable">$view</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$view</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'count'</span><span class="token punctuation">,</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">users</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">count<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Trước khi view được render, phương thức <code class=" language-php">compose</code> của composer được gọi với thể hiện <code class=" language-php">Illuminate\<span class="token package">View<span class="token punctuation">\</span>View</span></code>. Bạn có thể sử dụng phương thức <code class=" language-php">with</code> để ràng buộc dữ liệu vào view.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div>Tất cả view composers được xử lý qua <a href="{{URL::asset('')}}docs/5.3/container">service container</a>, vì vậy bạn có thể  type-hint bất cứ dependencies bạn cần vào hàm constructor của composer.</p>
    </blockquote>
    <h4>Đính kèm Composer vào nhiều views</h4>
    <p>Bạn có thể gán một view composer vào nhiều views bằng cách truyền một mảng của các view như là tham số thứ nhất của phương thức <code class=" language-php">composer</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">View<span class="token punctuation">::</span></span><span class="token function">composer<span class="token punctuation">(</span></span>
    <span class="token punctuation">[</span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token string">'dashboard'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token string">'App\Http\ViewComposers\MyViewComposer'</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Phương thức <code class=" language-php">composer</code> ngoài ra còn chấp nhận ký tự <code class=" language-php"><span class="token operator">*</span></code> như một ký tự đại diện, cho phép bạn gán một composer vào tất cả các views:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">View<span class="token punctuation">::</span></span><span class="token function">composer<span class="token punctuation">(</span></span><span class="token string">'*'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$view</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>View Creators</h4>
    <p>View <strong>creators</strong> rất giống với view composer; tuy nhiên, chúng sẽ tác động trực tiếp vào các view thay vì chờ các view cho tới khi chúng được render. Để đăng ký một view creator, sử dụng phương thức <code class=" language-php">creator</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">View<span class="token punctuation">::</span></span><span class="token function">creator<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token string">'App\Http\ViewCreators\ProfileCreator'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/views">https://laravel.com/docs/5.3/views</a></div>
</article>
@endsection