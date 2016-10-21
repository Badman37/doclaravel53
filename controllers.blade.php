@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Controllers</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#basic-controllers">Cơ bản Controllers</a>
            <ul>
                <li><a href="#defining-controllers">Định nghĩa Controllers</a>
                </li>
                <li><a href="#controllers-and-namespaces">Controllers &amp; Namespaces</a>
                </li>
                <li><a href="#single-action-controllers">Một Action Controllers</a>
                </li>
            </ul>
        </li>
        <li><a href="#controller-middleware">Controller Middleware</a>
        </li>
        <li><a href="#resource-controllers">Resource Controllers</a>
            <ul>
                <li><a href="#restful-partial-resource-routes">Từng phần Resource Routes</a>
                </li>
                <li><a href="#restful-naming-resource-routes">Tên Resource Routes</a>
                </li>
                <li><a href="#restful-naming-resource-route-parameters">Tên tham số Resource Route</a>
                </li>
                <li><a href="#restful-supplementing-resource-controllers">Bổ sung Resource Controllers</a>
                </li>
            </ul>
        </li>
        <li><a href="#dependency-injection-and-controllers">Dependency Injection &amp; Controllers</a>
        </li>
        <li><a href="#route-caching">Route Caching</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Thay vì định nghĩa tất cả các xử lý request logic như Closures ở trong file routes, bạn có thể tổ chức lại việc này bằng cách sử dụng các class Controller. Controllers có thể nhóm các xử lý request logic vào một class. Controllers để tại thư mục <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Controllers</code>.</p>
    <p>
        <a name="basic-controllers"></a>
    </p>
    <h2><a href="#basic-controllers">Cơ bản Controllers</a></h2>
    <p>
        <a name="defining-controllers"></a>
    </p>
    <h3>Định nghĩa Controllers</h3>
    <p>Phía dưới là một ví dụ cơ bản về class controller. Chú ý rằng controller đấy kế thừa từ class base controller của Laravel. Class base controller cung cấp một vài phương thức như <code class=" language-php">middleware</code> có thể sử dụng để gắn middleware vào controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">show<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'user.profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'user'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">findOrFail<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Bạn có thể định nghĩa một route cho action của controller như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'user/{id}'</span><span class="token punctuation">,</span> <span class="token string">'UserController@show'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bây giờ, khi một request giống với route URI, phương thức <code class=" language-php">show</code> của class <code class=" language-php">UserController</code> sẽ được thực thi. Tất nhiên, tham số route sẽ được truyền đến hàm.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Controllers không <strong>yêu cầu</strong> kế thừa từ base class. Tuy nhiên, bạn sẽ không có thêm một số tính năng như một số phương thức <code class=" language-php">middleware</code>, <code class=" language-php">validate</code>, và <code class=" language-php">dispatch</code>.</p>
    </blockquote>
    <p>
        <a name="controllers-and-namespaces"></a>
    </p>
    <h3>Controllers &amp; Namespaces</h3>
    <p>Có điều rất quan trọng cần lưu ý là chúng ta không cần phải ghi rõ tên đẩu đủ của controller namespace khi chúng ta định nghĩa cho controller route. Kể từ khi <code class=" language-php">RouteServiceProvider</code> tải file route bên trong nhóm route có chứa namespace, chúng ta chỉ cần chỉ định tên class sau <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Controllers</span></code> namespace.</p>
    <p>If you choose to nest your controllers deeper into the <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Controllers</span></code> directory, simply use the specific class name relative to the <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Controllers</span></code> root namespace. So, if your full controller class is <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Photos<span class="token punctuation">\</span>AdminController</span></code>, you should register routes to the controller like so:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">,</span> <span class="token string">'Photos\AdminController@method'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="single-action-controllers"></a>
    </p>
    <h3>Một Action Controllers</h3>
    <p>Nếu bạn muốn định nghĩa một controller xử lý duy nhất một action, bạn có thể dùng phương thức <code class=" language-php">__invoke</code> trong controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ShowProfile</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__invoke<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'user.profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'user'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">findOrFail<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Khi đó bạn đăng ký một route cho một action controllers, bạn không cần xác định phương thức:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'user/{id}'</span><span class="token punctuation">,</span> <span class="token string">'ShowProfile'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="controller-middleware"></a>
    </p>
    <h2><a href="#controller-middleware">Controller Middleware</a></h2>
    <p><a href="/docs/5.3/middleware">Middleware</a> có thể được gán cho controller route ở trong file route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token string">'UserController@show'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tuy nhiên, sẽ tiện hơn nếu middlewar được để trong hàm constructor của controller. Sử dụng phương thức <code class=" language-php">middleware</code> trong hàm constructor của controller, Bạn có thể dễ dàng gán middleware cho  action controller. Bạn thậm chí còn có thể hạn chế cho một vài phương thức cụ thể ở trong class controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Instantiate a new new controller instance.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'log'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">only<span class="token punctuation">(</span></span><span class="token string">'index'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'subscribed'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">except<span class="token punctuation">(</span></span><span class="token string">'store'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Controller còn cho phép bạn đăng ký middleware sử dụng một Closure. Phương thức này khá thuận tiện để định nghĩa một middleware cho một controller mà không cần định nghĩa class middleware:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$next</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // ...
</span>
    <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Bạn có thể gán middleware cho một tập con các action của controller; tuy nhiên, tập con action có thể to ra khi controller của bạn nhiều action. Vì thế, nên cân nhắc việc chia thành nhiều controller nhỏ hơn.</p>
    </blockquote>
    <p>
        <a name="resource-controllers"></a>
    </p>
    <h2><a href="#resource-controllers">Resource Controllers</a></h2>
    <p>Laravel resource routing gán kiểu "CRUD" routes cho một controller chỉ với một dòng code. Ví dụ, bạn có thể tạo một controller xử lý tất cả HTTP requests cho "photos" lưu trong ứng dụng của bạn. Sử dụng lệnh <code class=" language-php">make<span class="token punctuation">:</span>controller</code> Artisan, chúng ta có thể nhanh chóng tạo ra một controller:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>controller PhotoController <span class="token operator">--</span>resource</code></pre>
    <p>Câu lệnh trên sẽ sinh ra một controller tại thư mục <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Controllers<span class="token operator">/</span>PhotoController<span class="token punctuation">.</span>php</code>. Controller sẽ bao gồm method cho các action của resource có sẵn.</p>
    <p>Tiếp theo, bạn phải đăng ký một resourceful route cho controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">resource<span class="token punctuation">(</span></span><span class="token string">'photos'</span><span class="token punctuation">,</span> <span class="token string">'PhotoController'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Khai báo route này sẽ tạo ra nhiều route để xử lý đa dạng các actions trong resource. Controller tạo ra sẽ có sẵn vài phương thức gốc dễ cho từng action, gồm những thông báo cho bạn những method HTTP và URIs nó xử lý.</p>
    <h4>Các action xử lý bởi Resource Controller</h4>
    <table>
        <thead>
            <tr>
                <th>Verb</th>
                <th>URI</th>
                <th>Action</th>
                <th>Route Name</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>GET</td>
                <td><code class=" language-php"><span class="token operator">/</span>photos</code>
                </td>
                <td>index</td>
                <td>photos.index</td>
            </tr>
            <tr>
                <td>GET</td>
                <td><code class=" language-php"><span class="token operator">/</span>photos<span class="token operator">/</span>create</code>
                </td>
                <td>create</td>
                <td>photos.create</td>
            </tr>
            <tr>
                <td>POST</td>
                <td><code class=" language-php"><span class="token operator">/</span>photos</code>
                </td>
                <td>store</td>
                <td>photos.store</td>
            </tr>
            <tr>
                <td>GET</td>
                <td><code class=" language-php"><span class="token operator">/</span>photos<span class="token operator">/</span><span class="token punctuation">{</span>photo<span class="token punctuation">}</span></code>
                </td>
                <td>show</td>
                <td>photos.show</td>
            </tr>
            <tr>
                <td>GET</td>
                <td><code class=" language-php"><span class="token operator">/</span>photos<span class="token operator">/</span><span class="token punctuation">{</span>photo<span class="token punctuation">}</span><span class="token operator">/</span>edit</code>
                </td>
                <td>edit</td>
                <td>photos.edit</td>
            </tr>
            <tr>
                <td>PUT/PATCH</td>
                <td><code class=" language-php"><span class="token operator">/</span>photos<span class="token operator">/</span><span class="token punctuation">{</span>photo<span class="token punctuation">}</span></code>
                </td>
                <td>update</td>
                <td>photos.update</td>
            </tr>
            <tr>
                <td>DELETE</td>
                <td><code class=" language-php"><span class="token operator">/</span>photos<span class="token operator">/</span><span class="token punctuation">{</span>photo<span class="token punctuation">}</span></code>
                </td>
                <td>destroy</td>
                <td>photos.destroy</td>
            </tr>
        </tbody>
    </table>
    <h4>Spoofing Form Methods</h4>
    <p>Hãy nhớ rằng HTML forms không hỗ trợ các request <code class=" language-php"><span class="token constant">PUT</span></code>, <code class=" language-php"><span class="token constant">PATCH</span></code>, hoặc <code class=" language-php"><span class="token constant">DELETE</span></code>, bạn sẽ cần thêm một trường hidden  <code class=" language-php">_method</code> vào spoof HTTP verbs. Phương thức <code class=" language-php">method_field</code> có thể làm điều đó gúp bạn:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">method_field<span class="token punctuation">(</span></span><span class="token string">'PUT'</span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="restful-partial-resource-routes"></a>
    </p>
    <h3>Từng phần Resource Routes</h3>
    <p>Khi bạn khai báo một resource route, bạn có thể chỉ định các tập con action của controller cần xử lý thay vì toàn bộ action mặc định ban đầu:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">resource<span class="token punctuation">(</span></span><span class="token string">'photo'</span><span class="token punctuation">,</span> <span class="token string">'PhotoController'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'only'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'index'</span><span class="token punctuation">,</span> <span class="token string">'show'</span>
<span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">resource<span class="token punctuation">(</span></span><span class="token string">'photo'</span><span class="token punctuation">,</span> <span class="token string">'PhotoController'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'except'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'create'</span><span class="token punctuation">,</span> <span class="token string">'store'</span><span class="token punctuation">,</span> <span class="token string">'update'</span><span class="token punctuation">,</span> <span class="token string">'destroy'</span>
<span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="restful-naming-resource-routes"></a>
    </p>
    <h3>Tên Resource Routes</h3>
    <p>Mặc định, tất cả các action của resource controller đều có tên route; tuy nhiên, bạn có thể ghi đè tên đó bằng cách truyền thêm mảng chứa <code class=" language-php">names</code> với tùy chọn của bạn:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">resource<span class="token punctuation">(</span></span><span class="token string">'photo'</span><span class="token punctuation">,</span> <span class="token string">'PhotoController'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'names'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'create'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'photo.build'</span>
<span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="restful-naming-resource-route-parameters"></a>
    </p>
    <h3>Tên tham số Resource Route</h3>
    <p>Mặc định, <code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span>resource</code> sẽ sinh ra tham số route cho  resource routes dựa trên tên của resource. Bạn có thể dễ dàng ghi đè cho từng phần resource cơ bản bằng cách truyền <code class=" language-php">parameters</code> trong mảng như bên dưới. Tham số <code class=" language-php">parameters</code> nên là một mảng kết hợp giứa tên resource và tên tham số:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">resource<span class="token punctuation">(</span></span><span class="token string">'user'</span><span class="token punctuation">,</span> <span class="token string">'AdminUserController'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'parameters'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'user'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'admin_user'</span>
<span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Ví dụ trên sẽ tạo ra những URI sau cho route <code class=" language-php">show</code> của resource:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token operator">/</span>user<span class="token operator">/</span><span class="token punctuation">{</span>admin_user<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="restful-supplementing-resource-controllers"></a>
    </p>
    <h3>Bổ sung Resource Controllers</h3>
    <p>Nếu bạn cần thêm route cho một resource controller ngoài các thiết lập mặc định của resource route, thì bạn nên định nghĩa những routes đó trướckhi gọi <code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span>resource</code>; nếu không thì những route đã được định nghĩa bởi <code class=" language-php">resource</code> method có thể vô tình bị ưu tiên hơn những route bạn bổ sung:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'photos/popular'</span><span class="token punctuation">,</span> <span class="token string">'PhotoController@method'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">resource<span class="token punctuation">(</span></span><span class="token string">'photos'</span><span class="token punctuation">,</span> <span class="token string">'PhotoController'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Bạn nên tập trung vào controllers. Nếu bạn thấy mình thường xuyên thêm các route bên ngoài của các resource route thì hãy cân nhắc chia nhỏ controller hơn.</p>
    </blockquote>
    <p>
        <a name="dependency-injection-and-controllers"></a>
    </p>
    <h2><a href="#dependency-injection-and-controllers">Dependency Injection &amp; Controllers</a></h2>
    <h4>Constructor Injection</h4>
    <p>Phần <a href="{{URL::asset('')}}docs/5.3/container">service container</a> Laravel sử dụng để xử lý tất cả các controllers. Kết quả là, bạn có thể type-hint bất cứ dependencies controller của bạn cần vào trong constructor. Các dependencies sẽ tự động xử lý và injected trong controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Repositories<span class="token punctuation">\</span>UserRepository</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The user repository instance.
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$users</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new controller instance.
     *
     * @param  UserRepository  $users
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>UserRepository <span class="token variable">$users</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">users</span> <span class="token operator">=</span> <span class="token variable">$users</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Tất nhiên,bạn cũng có thể type-hint bất cứ <a href="{{URL::asset('')}}docs/5.3/contracts">Laravel contract</a>. Nếu các thành phần có thể được giải quyết, bạn có thể type-hint nó. Phụ thuộc vào ứng dụng của bạn, inject dependencies của bạn vào trong controller có thể là một cách tốt hơn.</p>
    <h4>Phương thức Injection</h4>
    <p>Ngoài cách constructor injection, bạn cũng có thể type-hint dependencies trong phương thức controller. Một trường hợp phổ biến là phương thức injection là trường hợp injecting <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> vào trong phương thức controller:</p>
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
        <span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Nếu phương thức controller của bạn cũng chờ đợi đầu vào từ tham số của routes, đơn giản là liệt kê các đối số của route sau các dependencies khác. ví dụ, nếu route của bạn định nghĩa như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'user/{id}'</span><span class="token punctuation">,</span> <span class="token string">'UserController@update'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn vẫn có thể type-hint vào <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code> và truy cập vào tham số <code class=" language-php">id</code> bằng cách định nghĩa phương thức controller như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Update the given user.
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
    <p>
        <a name="route-caching"></a>
    </p>
    <h2><a href="#route-caching">Route Caching</a></h2>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Closure based routes không hoạt động cached. Để sử dụng route caching, bạn phải chuyển các Closure routes sang sử dụng các class controller.</p>
    </blockquote>
    <p>Nếu ứng dụng của bạn chỉ sử dụng các controller based routes, thì bạn có thể sử dụng phần nâng cao route cache của Laravel. Sử dụng route cache sẽ giảm thời gian cần đăng ký tất cả các route trong ứng dụng của bạn. Trong một vài trường hợp, việc đăng ký route mcó thể nhanh hơn 100x lần. Để tạo ra route cache, just execute thechỉ cần chạy lệnh <code class=" language-php">route<span class="token punctuation">:</span>cache</code> Artisan:</p>
    <pre class=" language-php"><code class=" language-php">php artisan route<span class="token punctuation">:</span>cache</code></pre>
    <p>Sau khi chạy lệnh, file cached routes của bạn sẽ được tải với mọi request. Nhớ rằng, nếu bạn thêm một route mới bạn cần phải làm mới lại route cache. Vì ký do này bạn chỉ lên chạy một lần khi <code class=" language-php">route<span class="token punctuation">:</span>cache</code> ứng dụng của bạn deploy.</p>
    <p>Bạn có thể sử dụng lệnh <code class=" language-php">route<span class="token punctuation">:</span>clear</code> để xóa route cache:</p>
    <pre class=" language-php"><code class=" language-php">php artisan route<span class="token punctuation">:</span>clear</code></pre>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/controllers">https://laravel.com/docs/5.3/controllers</a></div>
</article>
@endsection