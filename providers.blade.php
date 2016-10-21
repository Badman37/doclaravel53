@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Service Providers</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#writing-service-providers">Viết Service Providers</a>
            <ul>
                <li><a href="#the-register-method">Phương thức Register</a>
                </li>
                <li><a href="#the-boot-method">Phương thức Boot</a>
                </li>
            </ul>
        </li>
        <li><a href="#registering-providers">Registering Providers</a>
        </li>
        <li><a href="#deferred-providers">Deferred Providers</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Service providers là trung tâm của việc khởi tạo tất cả các ứng dụng Laravel. Ứng dụng của bạn, cũng như các thành phần core của Laravel được khởi tạo từ service providers.</p>
    <p>Nhưng, "bootstrapped" nghĩa là sao? Đơn giản, ý là <strong>đăng ký</strong>, bao gồm đăng kí các liên kết tới service container, event listeners, middleware, và thậm chí các route. Service providers là trung tâp để cấu hình ứng dụng của bạn.</p>
    <p>Nếu bạn mở file <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> nằm trong Laravel, bạn sẽ thấy một mảng <code class=" language-php">providers</code>. Tất cả những service provider class này sẽ được load vào trong ứng dụng. Tất nhiên, nhiều trong số đó được gọi là "deferred" providers, nghĩa là chúng không phải được load trong mọi request, chỉ khi có service nào yêu cầu thì mới thực hiện cung cấp.</p>
    <p>Trong phần tổng quát này, bạn sẽ học cách viết service providers riêng của bạn và đăng kí chúng với Laravel.</p>
    <p>
        <a name="writing-service-providers"></a>
    </p>
    <h2><a href="#writing-service-providers">Viết Service Providers</a></h2>
    <p>Tất cả các service providers đều kế thừa từ class <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>ServiceProvider</span></code>. Hầu hết service providers chứa một phương thức <code class=" language-php">register</code> và <code class=" language-php">boot</code>. Trong phương thức <code class=" language-php">register</code>, bạn nên <strong>chỉ đăng ký vào trong <a href="{{URL::asset('')}}docs/5.3/container">service container</a></strong>. Bạn đừng bao giờ cố gắng đăng kí bất kì các event listeners, routes hay bất kì chắc năng nào khác vào trong hàm <code class=" language-php">register</code>.</p>
    <p>Artisan CLI có thể dễ dàng sinh ra một provider mới thông qua lệnh <code class=" language-php">make<span class="token punctuation">:</span>provider</code>:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>provider RiakServiceProvider</code></pre>
    <p>
        <a name="the-register-method"></a>
    </p>
    <h3>Phương thức register </h3>
    <p>Như đã đề cập ở trước, bên trong hàm <code class=" language-php">register</code>, bạn chỉ nên thực hiện đăng kí vào trong <a href="{{URL::asset('')}}docs/5.3/container">service container</a>. Bạn không nên bao giờ cố gắng đăng kí bất kì event listeners, routes hay bất kì các chức năng nào khác vào trong hàm <code class=" language-php">register</code>. Nếu không, bạn có thể vô tình sử dụng một service được cung cấp bởi một service provider mà chưa được tải.</p>
    <p>Hãy xem một ví dụ service provider cơ bản bên dưới. Trong bất kỳ phương thức service provider, bạn có thể truy cập thuộc tính <code class=" language-php"><span class="token variable">$app</span></code> nó cung cấp để truy cập vào service container:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Riak<span class="token punctuation">\</span>Connection</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">RiakServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Register bindings in the container.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">register<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">singleton<span class="token punctuation">(</span></span><span class="token scope">Connection<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">Connection</span><span class="token punctuation">(</span><span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'riak'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Service provider này chỉ khai báo đúng một hàm <code class=" language-php">register</code>, và sử dụng nó để implementation <code class=" language-php">Riak\<span class="token package">Connection</span></code> trong service container. Nếu bạn không hiểu cách hoạt động của service container, xem tại <a href="{{URL::asset('')}}docs/5.3/container">Service Container</a>.</p>
    <p>
        <a name="the-boot-method"></a>
    </p>
    <h3>Phương thức Boot</h3>
    <p>Vậy nếu như chúng ta muốn đăng kí một view composer vào trong service provider thì sao? Điều này có thể thực hiện bên trong hàm <code class=" language-php">boot</code>. <strong>Hàm này được gọi sau khi tất cả các service providers đã được đăng kí</strong>, nghĩa là bạn có thể truy cập vào trong tất cả các services đã được đăng kí vào trong framework:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ComposerServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Bootstrap any application services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token function">view<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">composer<span class="token punctuation">(</span></span><span class="token string">'view'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> //
</span>        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Boot Method Dependency Injection</h4>
    <p>Bạn có thể type-hint dependencies cho service provider của bạn ở hàm <code class=" language-php">boot</code>. <a href="{{URL::asset('')}}docs/5.3/container">service container</a> sẽ tự động inject bất cứ dependencies nào bạn cần:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Routing<span class="token punctuation">\</span>ResponseFactory</span><span class="token punctuation">;</span>

<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span>ResponseFactory <span class="token variable">$response</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token variable">$response</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">macro<span class="token punctuation">(</span></span><span class="token string">'caps'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="registering-providers"></a>
    </p>
    <h2><a href="#registering-providers">Đăng ký Providers</a></h2>
    <p>Tất cả các service provider được đăng kí bên trong file cấu hình <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code>. File này chứa một mảng các <code class=" language-php">providers</code> danh sách tên của các service providers. Mặc định, một tập hợp các core service provider của Laravel nằm trong mảng này. Những provider này làm nhiệm vụ khởi tạo các thành phần core của Laravel, ví dụ như mailer, queue, cache, và các thành phần khác.</p>
    <p>To register your provider, simply add it to the array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'providers'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
   <span class="token comment" spellcheck="true"> // Other Service Providers
</span>
    <span class="token scope">App<span class="token punctuation">\</span>Providers<span class="token punctuation">\</span>ComposerServiceProvider<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="deferred-providers"></a>
    </p>
    <h2><a href="#deferred-providers">Deferred Providers</a></h2>
    <p>Nếu bạn muốn provider <strong>chỉ</strong> đăng ký bindings trong <a href="{{URL::asset('')}}docs/5.3/container">service container</a>, bạn có thể chọn trì hoãn việc đăng kí cho tới khi nào cần thiết. Việc trì hoãn quá trình tải một provider sẽ cải thiện performance của ứng dụng, vì nó không load từ filesystem trong mọi yêu cầu.</p>
    <p>Laravel biên dịch và lưu một danh sách tất cả các services cung cấp bởi service providers trì hoãn, cùng với tên class service provider. Khi đó, chỉ khi nào bạn cần resolve một trong những service này thì Laravel mới thực hiện load service provider.</p>
    <p>Để trì hoàn việc load một provider, set thuộc tính <code class=" language-php">defer</code> thành <code class=" language-php"><span class="token boolean">true</span></code> avà định nghĩa một phương thức <code class=" language-php">provides</code>. Phương thức <code class=" language-php">provides</code> sẽ trả về bind service container mà provider này đăng kí:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Riak<span class="token punctuation">\</span>Connection</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">RiakServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$defer</span> <span class="token operator">=</span> <span class="token boolean">true</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Register the service provider.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">register<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">singleton<span class="token punctuation">(</span></span><span class="token scope">Connection<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">Connection</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">[</span><span class="token string">'config'</span><span class="token punctuation">]</span><span class="token punctuation">[</span><span class="token string">'riak'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Get the services provided by the provider.
     *
     * @return array
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">provides<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span><span class="token scope">Connection<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

<span class="token punctuation">}</span></code></pre>

<div>Nguồn: <a href="https://laravel.com/docs/5.3/providers">https://laravel.com/docs/5.3/providers</a></div>
</article>
@endsection