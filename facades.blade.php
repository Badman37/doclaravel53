@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Facades</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#when-to-use-facades">Khi nào sử dụng facades</a>
            <ul>
                <li><a href="#facades-vs-dependency-injection">Facades với. Dependency Injection</a>
                </li>
                <li><a href="#facades-vs-helper-functions">Facades với Phương thức</a>
                </li>
            </ul>
        </li>
        <li><a href="#how-facades-work">Facades hoạt động thế nào</a>
        </li>
        <li><a href="#facade-class-reference">Thao khảo các class facade</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Facades cung cấp một interface "static" cho các class sử dụng trong <a href="{{URL::asset('')}}docs/5.3/container">service container</a>. Laravel mang theo nhiều facades cung cấp cho hầu hết các tính năng của Laravel. Laravel facades phục vụ như "proxies tĩnh" cho các class bên dưới ở trong service container, cung cấp lợi ích của việc sử dụng cú pháp vừa ngắn gọn vừa có thể bảo trì có thể thoải mái hơn là sử dụng các phương thức tĩnh truyền thống.</p>
    <p>Tất cả facades của Laravel được định nghĩa trong <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>Facades</span></code> namespace. Vì vậy, bạn có thể dễ dàng truy cập facade như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Cache</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/cache'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Khắp tài liệu Laravel documentation, rất nhiều ví dụ sử dụng facades để chứng minh sự đa dạng tính năng của framework.</p>
    <p>
        <a name="when-to-use-facades"></a>
    </p>
    <h2><a href="#when-to-use-facades">Khi nào sử dụng facades</a></h2>
    <p>Facades có rất nhiều lợi ích. They cung cấp một cách gắn gọn, dễ nhớ cho phép bạn sử dụng tính năng của Laravel không cần nhớ tên dài của class nó phải được injected hoặc cấu hình thủ công. Hơn nữa, vì tính duy nhất của các phương thức tĩnh PHP, bạn có thể dễ dàng kiểm tra.</p>
    <p>Tuy nhiên, bạn phải cẩn thận khi sử dụng facades. Ngu hiểm nhất của facades là class scope creep. Khi facades dễ sử dụng và không yêu cầu injection, nó dễ dàng cho bạn phát triển nhiều facades trong một class. Sử dụng dependency injection, nó làm cho việc phát triển các dòng code trong class càng ngày càng lớn hơn. Vì vậy, khi sử dụng facades, đặc biệt để ý kích thước class của bạn để class ở phạm vi cho phép.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Khi bạn sử dụng package thứ ba tương tác với Laravel, nó tốt hơn inject để <a href="{{URL::asset('')}}docs/5.3/contracts">Laravel contracts</a> thay vì sử dụng facades. Khi các packages được xây dựng bên ngoài Laravel, bạn sẽ không thể truy cập facade Laravel kiểm tra helper.</p>
    </blockquote>
    <p>
        <a name="facades-vs-dependency-injection"></a>
    </p>
    <h3>Facades với Dependency Injection</h3>
    <p>Một trong những lợi ích chính của dependency injection là có khả năng hoán vị implementations của injected class. Nó thật hữu dụng khi bạn muốn kiểm tra inject một mock hoặc stub và xác nhận rằng các hàm khác cũng được gọi trong stub.</p>
    <p>Thông thường, nó không thể mock hoặc stub một phương thức static. Tuy nhiên, khi facades sử dụng phương thức động đến phương thức proxy gọi đến objects để giải quyết từ service container, chúng ta có thể thật sự test facades cũng như chúng ta test một injected class instance. Ví dụ, cho một route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Cache</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/cache'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Chúng ta có thể viết test để kiểm chứng rằng phương thức <code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span>get</code> được gọi với tham số chúng ta mong đợi:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Cache</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/**
 * A basic functional test example.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">shouldReceive<span class="token punctuation">(</span></span><span class="token string">'get'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">andReturn<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/cache'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="facades-vs-helper-functions"></a>
    </p>
    <h3>Facades Vs Hàm helper</h3>
    <p>Ngoài, Facade của Laravel cung cấp vài hàm  "helper" khác có thể thực hiện các task như sinh ra views, firing events, dispatching jobs, hoặc sending HTTP responses. Rất nhiều hàm helper giống như  facade tương ứng. Ví dụ, facade call và helper call là tương đương:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token scope">View<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tất nhiên là không có sự khác biệt giữa facades và hàm helper. Khi sử dụng hàm helper, bạn vẫn có thể test chúng chính xác như facade của nó.Ví dụ, cho một route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/cache'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">cache<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Hàm <code class=" language-php">cache</code> helper đang gọi một phương thức <code class=" language-php">get</code> trong class dưới <code class=" language-php">Cache</code> facade. Vì vậy, mặc dù chúng ta sử dụng hàm helper, chúng ta có thể viết test để kiểm tra phương thức được gọi với tham số chúng ta mong đợi:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Cache</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/**
 * A basic functional test example.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">shouldReceive<span class="token punctuation">(</span></span><span class="token string">'get'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">andReturn<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/cache'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="how-facades-work"></a>
    </p>
    <h2><a href="#how-facades-work">Facades hoạt động thế nào</a></h2>
    <p>Trong ứng dụng Laravel, một facade là một class nó cho phép truy cập object từ container. Các hàm hoạt động trong <code class=" language-php">Facade</code> class. facades Laravel, và bấn cứ tùy biến facades nào bạn tạo, nó sẽ kế thừa từ class base <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Facade</span></code>.</p>
    <p>Class base <code class=" language-php">Facade</code> có thể sử dụng phương thức magic <code class=" language-php"><span class="token function">__callStatic<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code> để điều khiển thực thi từ facade tới object đã được resolve từ container. Trong ví dụ sau, một phương thức được tạo từ Laravel cache system. Nhìn liếc qua code, người ta có thể đoán được phương thức <code class=" language-php">get</code> được gọi trong class <code class=" language-php">Cache</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Cache</span><span class="token punctuation">;</span>
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
        <span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'user:'</span><span class="token punctuation">.</span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'user'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$user</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Chú ý ở gần đầu file chúng ta có thực hiện "importing" vào facade <code class=" language-php">Cache</code>.  Facade này đóng vai trò như một proxy để truy cập vào phần triển khai phía dưới của interface <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Cache<span class="token punctuation">\</span>Factory</span></code>. Bất cứ việc gọi nào mà chúng ta sử dụng từ facade sẽ được đẩy tới instance phía dưới của Laravel cache service.</p>
    <p>Nếu chúng ta nhìn vào class <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Cache</span></code> bạn sẽ thấy không hề có phương thức tĩnh <code class=" language-php">get</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">class</span> <span class="token class-name">Cache</span> <span class="token keyword">extends</span> <span class="token class-name">Facade</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get the registered name of the component.
     *
     * @return string
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword">static</span> <span class="token keyword">function</span> <span class="token function">getFacadeAccessor<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">{</span> <span class="token keyword">return</span> <span class="token string">'cache'</span><span class="token punctuation">;</span> <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Thay vào đó, facade <code class=" language-php">Cache</code> mở rộng class base <code class=" language-php">Facade</code> à định nghĩa phương thức <code class=" language-php"><span class="token function">getFacadeAccessor<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>. Nhớ là nhiệm vụ của phương thức này là trả về tên của liên kết trong service container. Khi mà người dùng tham chiếu tới bất kì phương thức tĩnh nào trong facade <code class=" language-php">Cache</code>, Laravel thực hiện việc resolve <code class=" language-php">cache</code> binding từ <a href="{{URL::asset('')}}docs/5.3/container">service container</a> và thực thi phương thức được gọi (trong trường hợp này <code class=" language-php">get</code>) đối với object.</p>
    <p>
        <a name="facade-class-reference"></a>
    </p>
    <h2><a href="#facade-class-reference">Thao khảo các class facade</a></h2>
    <p>Dưới đây, bạn có thể tìm các facade và lớp dưới của nó, rất hữu ích khi bạn muốn tìm hiểu nhanh tài liệu API cho một facade nào đó. Các tên khoá bind vào trong <a href="{{URL::asset('')}}docs/5.3/container">service container binding</a> cũng được ghi kèm theo nếu có.</p>
    <table>
        <thead>
            <tr>
                <th>Facade</th>
                <th>Class</th>
                <th>Service Container Binding</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>App</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Foundation/Application.html">Illuminate\Foundation\Application</a>
                </td>
                <td><code class=" language-php">app</code>
                </td>
            </tr>
            <tr>
                <td>Artisan</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Contracts/Console/Kernel.html">Illuminate\Contracts\Console\Kernel</a>
                </td>
                <td><code class=" language-php">artisan</code>
                </td>
            </tr>
            <tr>
                <td>Auth</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Auth/AuthManager.html">Illuminate\Auth\AuthManager</a>
                </td>
                <td><code class=" language-php">auth</code>
                </td>
            </tr>
            <tr>
                <td>Blade</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/View/Compilers/BladeCompiler.html">Illuminate\View\Compilers\BladeCompiler</a>
                </td>
                <td><code class=" language-php">blade<span class="token punctuation">.</span>compiler</code>
                </td>
            </tr>
            <tr>
                <td>Bus</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Contracts/Bus/Dispatcher.html">Illuminate\Contracts\Bus\Dispatcher</a>
                </td>
            </tr>
            <tr>
                <td>Cache</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Cache/Repository.html">Illuminate\Cache\Repository</a>
                </td>
                <td><code class=" language-php">cache</code>
                </td>
            </tr>
            <tr>
                <td>Config</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Config/Repository.html">Illuminate\Config\Repository</a>
                </td>
                <td><code class=" language-php">config</code>
                </td>
            </tr>
            <tr>
                <td>Cookie</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Cookie/CookieJar.html">Illuminate\Cookie\CookieJar</a>
                </td>
                <td><code class=" language-php">cookie</code>
                </td>
            </tr>
            <tr>
                <td>Crypt</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Encryption/Encrypter.html">Illuminate\Encryption\Encrypter</a>
                </td>
                <td><code class=" language-php">encrypter</code>
                </td>
            </tr>
            <tr>
                <td>DB</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Database/DatabaseManager.html">Illuminate\Database\DatabaseManager</a>
                </td>
                <td><code class=" language-php">db</code>
                </td>
            </tr>
            <tr>
                <td>DB (Instance)</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Database/Connection.html">Illuminate\Database\Connection</a>
                </td>
            </tr>
            <tr>
                <td>Event</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Events/Dispatcher.html">Illuminate\Events\Dispatcher</a>
                </td>
                <td><code class=" language-php">events</code>
                </td>
            </tr>
            <tr>
                <td>File</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Filesystem/Filesystem.html">Illuminate\Filesystem\Filesystem</a>
                </td>
                <td><code class=" language-php">files</code>
                </td>
            </tr>
            <tr>
                <td>Gate</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Contracts/Auth/Access/Gate.html">Illuminate\Contracts\Auth\Access\Gate</a>
                </td>
            </tr>
            <tr>
                <td>Hash</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Contracts/Hashing/Hasher.html">Illuminate\Contracts\Hashing\Hasher</a>
                </td>
                <td><code class=" language-php">hash</code>
                </td>
            </tr>
            <tr>
                <td>Lang</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Translation/Translator.html">Illuminate\Translation\Translator</a>
                </td>
                <td><code class=" language-php">translator</code>
                </td>
            </tr>
            <tr>
                <td>Log</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Log/Writer.html">Illuminate\Log\Writer</a>
                </td>
                <td><code class=" language-php">log</code>
                </td>
            </tr>
            <tr>
                <td>Mail</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Mail/Mailer.html">Illuminate\Mail\Mailer</a>
                </td>
                <td><code class=" language-php">mailer</code>
                </td>
            </tr>
            <tr>
                <td>Notification</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Notifications/ChannelManager.html">Illuminate\Notifications\ChannelManager</a>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Auth/Passwords/PasswordBrokerManager.html">Illuminate\Auth\Passwords\PasswordBrokerManager</a>
                </td>
                <td><code class=" language-php">auth<span class="token punctuation">.</span>password</code>
                </td>
            </tr>
            <tr>
                <td>Queue</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Queue/QueueManager.html">Illuminate\Queue\QueueManager</a>
                </td>
                <td><code class=" language-php">queue</code>
                </td>
            </tr>
            <tr>
                <td>Queue (Instance)</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Contracts/Queue/Queue.html">Illuminate\Contracts\Queue\Queue</a>
                </td>
                <td><code class=" language-php">queue</code>
                </td>
            </tr>
            <tr>
                <td>Queue (Base Class)</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Queue/Queue.html">Illuminate\Queue\Queue</a>
                </td>
            </tr>
            <tr>
                <td>Redirect</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Routing/Redirector.html">Illuminate\Routing\Redirector</a>
                </td>
                <td><code class=" language-php">redirect</code>
                </td>
            </tr>
            <tr>
                <td>Redis</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Redis/Database.html">Illuminate\Redis\Database</a>
                </td>
                <td><code class=" language-php">redis</code>
                </td>
            </tr>
            <tr>
                <td>Request</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Http/Request.html">Illuminate\Http\Request</a>
                </td>
                <td><code class=" language-php">request</code>
                </td>
            </tr>
            <tr>
                <td>Response</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Contracts/Routing/ResponseFactory.html">Illuminate\Contracts\Routing\ResponseFactory</a>
                </td>
            </tr>
            <tr>
                <td>Route</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Routing/Router.html">Illuminate\Routing\Router</a>
                </td>
                <td><code class=" language-php">router</code>
                </td>
            </tr>
            <tr>
                <td>Schema</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Database/Schema/Blueprint.html">Illuminate\Database\Schema\Blueprint</a>
                </td>
            </tr>
            <tr>
                <td>Session</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Session/SessionManager.html">Illuminate\Session\SessionManager</a>
                </td>
                <td><code class=" language-php">session</code>
                </td>
            </tr>
            <tr>
                <td>Session (Instance)</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Session/Store.html">Illuminate\Session\Store</a>
                </td>
            </tr>
            <tr>
                <td>Storage</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Contracts/Filesystem/Factory.html">Illuminate\Contracts\Filesystem\Factory</a>
                </td>
                <td><code class=" language-php">filesystem</code>
                </td>
            </tr>
            <tr>
                <td>URL</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Routing/UrlGenerator.html">Illuminate\Routing\UrlGenerator</a>
                </td>
                <td><code class=" language-php">url</code>
                </td>
            </tr>
            <tr>
                <td>Validator</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Validation/Factory.html">Illuminate\Validation\Factory</a>
                </td>
                <td><code class=" language-php">validator</code>
                </td>
            </tr>
            <tr>
                <td>Validator (Instance)</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/Validation/Validator.html">Illuminate\Validation\Validator</a>
                </td>
            </tr>
            <tr>
                <td>View</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/View/Factory.html">Illuminate\View\Factory</a>
                </td>
                <td><code class=" language-php">view</code>
                </td>
            </tr>
            <tr>
                <td>View (Instance)</td>
                <td><a href="http://laravel.com/api/5.3/Illuminate/View/View.html">Illuminate\View\View</a>
                </td>
            </tr>
        </tbody>
    </table>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/facades">https://laravel.com/docs/5.3/facades</a></div>
</article>
@endsection