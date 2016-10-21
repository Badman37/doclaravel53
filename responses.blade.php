@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>HTTP Responses</h1>
    <ul>
        <li><a href="#creating-responses">Tạo Responses</a>
            <ul>
                <li><a href="#attaching-headers-to-responses">Gán Headers vào Responses</a>
                </li>
                <li><a href="#attaching-cookies-to-responses">Gán Cookies vào Responses</a>
                </li>
                <li><a href="#cookies-and-encryption">Cookies &amp; Encryption</a>
                </li>
            </ul>
        </li>
        <li><a href="#redirects">Chuyển trang</a>
            <ul>
                <li><a href="#redirecting-named-routes">Chuyển trang đến Named Routes</a>
                </li>
                <li><a href="#redirecting-controller-actions">Chuyển trang đến Controller Actions</a>
                </li>
                <li><a href="#redirecting-with-flashed-session-data">Chuyển trang với Flashed Session Data</a>
                </li>
            </ul>
        </li>
        <li><a href="#other-response-types">Các kiểu Response khác</a>
            <ul>
                <li><a href="#view-responses">View Responses</a>
                </li>
                <li><a href="#json-responses">JSON Responses</a>
                </li>
                <li><a href="#file-downloads">File Downloads</a>
                </li>
                <li><a href="#file-responses">File Responses</a>
                </li>
            </ul>
        </li>
        <li><a href="#response-macros">Response Macros</a>
        </li>
    </ul>
    <p>
        <a name="creating-responses"></a>
    </p>
    <h2><a href="#creating-responses">Tạo Responses</a></h2>
    <h4>Chuỗi &amp; Mảng</h4>
    <p>Tất cả các route và controller nên trả về một response để gửi cho người dùng trình duyệt. Laravel cung cấp vài cách khác nhau trả về responses. Response cơ bản nhất là trả về một chuỗi từ một route hoặc controller. The framework sẽ tự động chuyển chuỗi thành HTTP response đầy đủ:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token string">'Hello World'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Ngoài việc trả về một chuỗi từ routes và controllers, bạn có thể trả về một mảng. The framework sẽ tự động chuyển mảng thành JSON response:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Bạn có biết là bạn cũng có thể trả về <a href="{{URL::asset('')}}docs/5.3/eloquent-collections">Eloquent collections</a> từ routes hoặc controllers? Chúng sẽ tự động chuyển thành JSON. Tuyệt vời!</p>
    </blockquote>
    <h4>Response Objects</h4>
    <p>Thông thường, bạn không chỉ trả về một chuỗi hoặc một mảng từ route hoặc controller. Mà bạn thường trả về đầy đủ <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Response</span></code> instances hoặc <a href="/docs/5.3/views">views</a>.</p>
    <p>Trả về đầy đủ <code class=" language-php">Response</code> instance cho phép bạn có thể tùy biến HTTP status code và headers của response. Một <code class=" language-php">Response</code> instance kế thừa từ class <code class=" language-php">Symfony\<span class="token package">Component<span class="token punctuation">\</span>HttpFoundation<span class="token punctuation">\</span>Response</span></code>, nó cung cấp một số phương thức của HTTP responses:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'home'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token string">'Hello World'</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">)</span>
                  <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">header<span class="token punctuation">(</span></span><span class="token string">'Content-Type'</span><span class="token punctuation">,</span> <span class="token string">'text/plain'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="attaching-headers-to-responses"></a>
    </p>
    <h4>Gán Headers vào Responses</h4>
    <p>Nhớ rằng hầu hết các phương thức response là có thể móc nối với nhau, cho phép dễ dàng tạo ra một tiến trình response instances. Ví dụ, bạn có thể sử dụng phương thức <code class=" language-php">header</code> để thêm một danh sách headers cho response trước khi gửi chúng lại cho người dùng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token variable">$content</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">header<span class="token punctuation">(</span></span><span class="token string">'Content-Type'</span><span class="token punctuation">,</span> <span class="token variable">$type</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">header<span class="token punctuation">(</span></span><span class="token string">'X-Header-One'</span><span class="token punctuation">,</span> <span class="token string">'Header Value'</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">header<span class="token punctuation">(</span></span><span class="token string">'X-Header-Two'</span><span class="token punctuation">,</span> <span class="token string">'Header Value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Hoặc, bạn có thể dùng phương thức <code class=" language-php">withHeaders</code>truyền vào một mảng các headers để thêm vào response:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token variable">$content</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withHeaders<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
                <span class="token string">'Content-Type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$type</span><span class="token punctuation">,</span>
                <span class="token string">'X-Header-One'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Header Value'</span><span class="token punctuation">,</span>
                <span class="token string">'X-Header-Two'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Header Value'</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="attaching-cookies-to-responses"></a>
    </p>
    <h4>Gán Cookies vào Responses</h4>
    <p>Phương thức <code class=" language-php">cookie</code> trong response instances cho phép bạn dễ dàng gán cookies cho response. Ví dụ, bạn có thể sử dụng phương thức <code class=" language-php">cookie</code> để tạo ra một cookie và dễ dàng gán nó vào response instance như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token variable">$content</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">header<span class="token punctuation">(</span></span><span class="token string">'Content-Type'</span><span class="token punctuation">,</span> <span class="token variable">$type</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cookie<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Phương thức <code class=" language-php">cookie</code> ngoài ra còn có một vài đối số ít được sử dụng. Nói chung, đó là những đối số có mục đích giống như những đối số của phương thức <a href="http://php.net/manual/en/function.setcookie.php">setcookie</a> của PHP:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cookie<span class="token punctuation">(</span></span><span class="token variable">$name</span><span class="token punctuation">,</span> <span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">,</span> <span class="token variable">$path</span><span class="token punctuation">,</span> <span class="token variable">$domain</span><span class="token punctuation">,</span> <span class="token variable">$secure</span><span class="token punctuation">,</span> <span class="token variable">$httpOnly</span><span class="token punctuation">)</span></code></pre>
    <p>
        <a name="cookies-and-encryption"></a>
    </p>
    <h4>Cookies &amp; Encryption</h4>
    <p>Mặc định, tất cả cookies được sinh ra bởi Laravel đều được mã hòa và đăng ký vì vậy client không thể được chỉnh sửa hoặc đọc được. Nếu bạn muốn vô hiệu hóa cho một tập con cookies tạo ra bởi ứng dụng, bạn có thể sử dụng thuộc tính <code class=" language-php"><span class="token variable">$except</span></code> trong <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>EncryptCookies</span></code> middleware, nó nằm ở trong thư mục <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Middleware</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * The names of the cookies that should not be encrypted.
 *
 * @var array
 */</span>
<span class="token keyword">protected</span> <span class="token variable">$except</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'cookie_name'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="redirects"></a>
    </p>
    <h2><a href="#redirects">Chuyển trang</a></h2>
    <p>Chuyển responses là thể hiện của class <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>RedirectResponse</span></code>, và chứa các header cần thiến cho việc chuyển trang người dùng sang một URL khác. Có vài cách để tạo một <code class=" language-php">RedirectResponse</code> instance. Cách đơn giản nhất là sử dụng helper global <code class=" language-php">redirect</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'dashboard'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'home/dashboard'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Thỉnh thoảng bạn có thể muốn chuyển trang của người dùng đến trang trước đó, ví dụ như trường hơp submitted form có lỗi. Bạn có thể làm điều đó bằng cách sử dụng hàm helper global <code class=" language-php">back</code> helper. Trong khi nó kết hợp với <a href="{{URL::asset('')}}docs/5.3/session">session</a>, đảm bảo rằng route đang gọi hàm <code class=" language-php">back</code> là sử dụng nhóm middleware <code class=" language-php">web</code> hoặc có tất cả session middleware được áp dụng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'user/profile'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Validate the request...
</span>
    <span class="token keyword">return</span> <span class="token function">back<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withInput<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="redirecting-named-routes"></a>
    </p>
    <h3>Chuyển trang về tên routes</h3>
    <p>Khi bạn gọi hepler <code class=" language-php">redirect</code> không có tham số, một thể hiện  <code class=" language-php">Illuminate\<span class="token package">Routing<span class="token punctuation">\</span>Redirector</span></code> được trả về, cho phép bạn gọi bất cứ phương thức trên <code class=" language-php">Redirector</code> instance. Ví dụ, tạo ra một <code class=" language-php">RedirectResponse</code> vào tên route, bạn có thể sử dụng phương thức <code class=" language-php">route</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">route<span class="token punctuation">(</span></span><span class="token string">'login'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu route của bạn có tham số, bạn có thể truyền chúng như là đối số thứ hai của phương thức <code class=" language-php">route</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// For a route with the following URI: profile/{id}
</span>
<span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">route<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Populating Parameters Via Eloquent Models</h4>
    <p>Nếu bạn chuyển trang đến một route với một tham số "ID" là một thuộc tính thuộc Eloquent model, đơn giản bạn truyền bởi chính model đó. Tham số ID sẽ được lấy ra tự động:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// For a route with the following URI: profile/{id}
</span>
<span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">route<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token variable">$user</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Bạn cũng có thể tùy biến giá trị tham số của route, bạn phải ghi đè phương thức <code class=" language-php">getRouteKey</code> trong Eloquent model của bạn:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the value of the model's route key.
 *
 * @return mixed
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getRouteKey<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">slug</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="redirecting-controller-actions"></a>
    </p>
    <h3>Chuyên trang đến Controller Actions</h3>
    <p>Bạn cũng có thể truyển trang đến <a href="{{URL::asset('')}}docs/5.3/controllers">controller actions</a>. Đề làm việc đó, truyền controller và tên action vào phương thức <code class=" language-php">action</code>. Nhớ rằng, Bạn không cần phải có đường dẫn đầy đủ của namespace controller, <code class=" language-php">RouteServiceProvider</code> của Laravel nó tự động làm điều đó giúp bạn:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">action<span class="token punctuation">(</span></span><span class="token string">'HomeController@index'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu controller route của bạn có tham số, bạn có thể truyền qua như là một tham số thứ hai của phương thức <code class=" language-php">action</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">action<span class="token punctuation">(</span></span>
    <span class="token string">'UserController@profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">]</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="redirecting-with-flashed-session-data"></a>
    </p>
    <h3>Chuyển trang với dữ liệu Flashed Session</h3>
    <p>Chuyển trang tới một URL mới và <a href="{{URL::asset('')}}docs/5.3/session#flash-data">flashing dữ liệu vào session</a> có thể làm nó cùng một lúc. Thông thường, chuyển trang được thực hiện sau khi bạn flash vào session thành công. Cho thuận tiện, bạn có thể tạo một thể hiện <code class=" language-php">RedirectResponse</code> và flash dữ liệu vào session trong một lần, như bên dưới:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'user/profile'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Update the user's profile...
</span>
    <span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'dashboard'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'status'</span><span class="token punctuation">,</span> <span class="token string">'Profile updated!'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Sau khi người dùng được chuyển tran, bạn có thể hiển thị nội dung flashed từ <a href="/docs/5.3/session">session</a>. Ví dụ, sử dụng <a href="{{URL::asset('')}}docs/5.3/blade">Blade syntax</a>:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token function">session<span class="token punctuation">(</span></span><span class="token string">'status'</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>alert alert-success<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
        <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">session<span class="token punctuation">(</span></span><span class="token string">'status'</span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>
@<span class="token keyword">endif</span></code></pre>
    <p>
        <a name="other-response-types"></a>
    </p>
    <h2><a href="#other-response-types">Các kiểu Response khác</a></h2>
    <p>Phương thức <code class=" language-php">response</code> có thể được dùng để tạo ra kiểu thể hiện response khác. Khi phương thức <code class=" language-php">response</code> được gọi không có tham số, một thực hiện của <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Routing<span class="token punctuation">\</span>ResponseFactory</span></code> <a href="{{URL::asset('')}}docs/5.3/contracts">contract</a> được trả về. Contract này cung cấp vào phương thức cho việc tạo responses.</p>
    <p>
        <a name="view-responses"></a>
    </p>
    <h3>View Responses</h3>
    <p>Nếu bạn muốn kiểm soát status và header của response nhưng bạn cũng muốn trả về một <a href="/docs/5.3/views">view</a> chứa nội dung của response, bạn có thể sử dụng phương thức <code class=" language-php">view</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'hello'</span><span class="token punctuation">,</span> <span class="token variable">$data</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">header<span class="token punctuation">(</span></span><span class="token string">'Content-Type'</span><span class="token punctuation">,</span> <span class="token variable">$type</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tất nhiên, nếu bạn không cần truyền status tùy biến của HTTP hoặc tùy biến header, bạn có thể sử dụng hàm global <code class=" language-php">view</code>.</p>
    <p>
        <a name="json-responses"></a>
    </p>
    <h3>JSON Responses</h3>
    <p>Phương thức <code class=" language-php">json</code> sẽ tự động đặt <code class=" language-php">Content<span class="token operator">-</span>Type</code> header là <code class=" language-php">application<span class="token operator">/</span>json</code>, cũng như chuyển mảng thành JSON bằng hàm <code class=" language-php">json_encode</code> của PHP:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">json<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Abigail'</span><span class="token punctuation">,</span>
    <span class="token string">'state'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'CA'</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu bạn muốn tạo một JSONP response, bạn có thể sử dụng phương thức <code class=" language-php">json</code> kết hợp với phương thức <code class=" language-php">withCallback</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">json<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Abigail'</span><span class="token punctuation">,</span> <span class="token string">'state'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'CA'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withCallback<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">input<span class="token punctuation">(</span></span><span class="token string">'callback'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="file-downloads"></a>
    </p>
    <h3>File Downloads</h3>
    <p>Phương thức <code class=" language-php">download</code> có thể dùng để tạo ra một response bắt trình duyệt của người dùng tải file tại đường dẫn. Phương thức <code class=" language-php">download</code> chấp nhận tên file như là đối số thứ hai của phương thức, mà sẽ xác định tên file được người dùng đang tả. Cuối cùng, bạn có thể truyền một mảng của HTTP headers như là tham số thứ ba của phương thức:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">download<span class="token punctuation">(</span></span><span class="token variable">$pathToFile</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">download<span class="token punctuation">(</span></span><span class="token variable">$pathToFile</span><span class="token punctuation">,</span> <span class="token variable">$name</span><span class="token punctuation">,</span> <span class="token variable">$headers</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Symfony HttpFoundation,là quản lý file tải, yêu cầu file tải có tên là định dạng ASCII.</p>
    </blockquote>
    <p>
        <a name="file-responses"></a>
    </p>
    <h3>File Responses</h3>
    <p>Phương thưcs <code class=" language-php">file</code> sử dụng để hiển thị một file, như là ảnh hoặc PDF, trực tiếp trong trình duyệt của người dùng thay vì phải tải. Phương thức này chấp nhận đường dẫn như là đối số đầu tiên và mảng của header như là đối số thứ hai:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">file<span class="token punctuation">(</span></span><span class="token variable">$pathToFile</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">file<span class="token punctuation">(</span></span><span class="token variable">$pathToFile</span><span class="token punctuation">,</span> <span class="token variable">$headers</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="response-macros"></a>
    </p>
    <h2><a href="#response-macros">Response Macros</a></h2>
    <p>Nếu bạn muốn định nghĩa một tùy biến response bạn có thể sử dụng lại routes và controllers, bạn có thể dùng phương thức <code class=" language-php">macro</code> trong <code class=" language-php">Response</code> facade. Ví dụ, từ một phương thức <a href="{{URL::asset('')}}docs/5.3/providers">service provider's</a> <code class=" language-php">boot</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Response</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ResponseMacroServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Register the application's response macros.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Response<span class="token punctuation">::</span></span><span class="token function">macro<span class="token punctuation">(</span></span><span class="token string">'caps'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token scope">Response<span class="token punctuation">::</span></span><span class="token function">make<span class="token punctuation">(</span></span><span class="token function">strtoupper<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Phương thức <code class=" language-php">macro</code> tên là đối số thứ nhất, và một Closure là đối số thứ hai. Closure của macro sẽ thực thi khi đang gọi macro từ một thực hiện <code class=" language-php">ResponseFactory</code> hoặc phương thức <code class=" language-php">response</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">caps<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/responses">https://laravel.com/docs/5.3/responses</a></div>
</article>
@endsection