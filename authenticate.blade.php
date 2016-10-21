@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Authentication</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
            <ul>
                <li><a href="#introduction-database-considerations">Những chú ý về database</a>
                </li>
            </ul>
        </li>
        <li><a href="#authentication-quickstart">Bắt đầu nhanh với authentication</a>
            <ul>
                <li><a href="#included-routing">Routing</a>
                </li>
                <li><a href="#included-views">Views</a>
                </li>
                <li><a href="#included-authenticating">Authenticating</a>
                </li>
                <li><a href="#retrieving-the-authenticated-user">Nhận người dùng đã authenticate</a>
                </li>
                <li><a href="#protecting-routes">Bảo vệ Routes</a>
                </li>
                <li><a href="#login-throttling">Login Throttling</a>
                </li>
            </ul>
        </li>
        <li><a href="#authenticating-users">Manually Authenticating Users</a>
            <ul>
                <li><a href="#remembering-users">Remembering Users</a>
                </li>
                <li><a href="#other-authentication-methods">Other Authentication Methods</a>
                </li>
            </ul>
        </li>
        <li><a href="#http-basic-authentication">HTTP Basic Authentication</a>
            <ul>
                <li><a href="#stateless-http-basic-authentication">Stateless HTTP Basic Authentication</a>
                </li>
            </ul>
        </li>
        <li><a href="https://github.com/laravel/socialite">Social Authentication</a>
        </li>
        <li><a href="#adding-custom-guards">Adding Custom Guards</a>
        </li>
        <li><a href="#adding-custom-user-providers">Adding Custom User Providers</a>
            <ul>
                <li><a href="#the-user-provider-contract">The User Provider Contract</a>
                </li>
                <li><a href="#the-authenticatable-contract">The Authenticatable Contract</a>
                </li>
            </ul>
        </li>
        <li><a href="#events">Events</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <blockquote class="has-icon tip">
        <p></p>
        <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
        </div> <strong>Bạn có muốn bắt đầu nhanh không?</strong> Chỉ cần chạy <code class=" language-php">php artisan make<span class="token punctuation">:</span>auth</code> và <code class=" language-php">php artisan migrate</code> trong một project mới. Khi đó, vào trình duyệt gõ địa chỉ <code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>your<span class="token operator">-</span>app<span class="token punctuation">.</span>dev<span class="token operator">/</span>register</code> hoặc bất kỳ URL được gán cho ứng dụng. Đó là hai lệnh để sử dụng scaffolding cho việc xác thực tài khoản ứng dụng của bạn!
        <p></p>
    </blockquote>
    <p>Laravel giúp cho việc thực hiện việc xác thực vô cùng đơn giản. Trong thực tế, hầu hết mọi thứ đã được cấu hình cho bạn mà bạn chỉ việc dùng. File cấu hình xác thực được đặt tại <code class=" language-php">config<span class="token operator">/</span>auth<span class="token punctuation">.</span>php</code>, bao gồm một số hướng dẫn tùy biến rõ ràng cho việc tùy biến cách xử lí của các dịch vụ authentication.</p>
    <p>Tại phần core của nó, các cơ sở authentication của Laravel được tạo bởi "guards" và "providers". Guards định nghĩa cái cách mà các user được authentication cho mỗi request.  Ví dụ, Laravel mang theo một <code class=" language-php">session</code> guard cái mà duy trì trạng thái bằng cách sử dụng session storage và cookies.</p>
    <p>Providers định nghĩa cách mà user được truy xuất từ persistent storage của bạn. Laravel hỗ trợ cho việc truy xuất các user sử dụng Eloquent và Query Builder. Tuy nhiên, bạn có thể thoải mái thêm provider nếu cần vào ứng dụng của bạn.</p>
    <p>Đùng lo lắng nếu tất các điều này nghe có vẻ bối rối. Hầu hết các ứng dụng sẽ không cần tùy biến các cấu hình authentication mặc định.</p>
    <p>
        <a name="introduction-database-considerations"></a>
    </p>
    <h3>Những chú ý về database</h3>
    <p>Mặc định, Laravel thêm một <code class=" language-php">App\<span class="token package">User</span></code> <a href="/docs/5.3/eloquent">Eloquent model</a> trong thư mục <code class=" language-php">app</code>. Model này có thể sử dụng với Eloquent authentication driver mặc định. Nếu ứng dụng của bạn không sử dụng Eloquent, bạn có thể dùng <code class=" language-php">database</code> authentication driver sử dụng Laravel query builder.</p>
    <p>Khi xây dựng database schema cho model <code class=" language-php">App\<span class="token package">User</span></code> model, đảm bảo rằng độ dài cột password tối thiểu là 60 kí tự. Mặc định với 255 kí tự sẽ là một lựa chọn tốt.</p>
    <p>Ngoài ra, Bạn cũng nên xác nhận table <code class=" language-php">users</code> (or equivalent) table chứa một nullable, cột <code class=" language-php">remember_token</code> chứa 100 characters. Cột này sẽ được dùng để lưu một token cho session "remember me" khi đang được duy trì bởi ứng dụng của bạn.</p>
    <p>
        <a name="authentication-quickstart"></a>
    </p>
    <h2><a href="#authentication-quickstart">Bắt đầu nhanh với authentication</a></h2>
    <p>Laravel có một số pre-built authentication controllers, chúng ở trong thư mục <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Auth</span></code> namespace. Controller <code class=" language-php">RegisterController</code> xử lý đăng ký user mới, Controller <code class=" language-php">LoginController</code> xử lý authentication, controller <code class=" language-php">ForgotPasswordController</code> xử lý gửi link để khôi phục lại mật khẩu, and controller <code class=" language-php">ResetPasswordController</code> chứa logic khôi phục mật khẩu. Mỗi controllers sử dụng trait cần thiết cho mỗi phương thức. Đối với nhiều ứng dụng, bạn sẽ không cần phải chỉnh sửa nó.</p>
    <p>
        <a name="included-routing"></a>
    </p>
    <h3>Routing</h3>
    <p>Laravel cung cấp một cách nhanh chóng để sinh ra toàn bộ các route và view cần thiết cho authentication chỉ với lệnh</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>auth</code></pre>
    <p>Lệnh này nên được dùng trên các ứng dụng mới và sẽ cài đặt các view đăng kí và đăng nhập cũng như các route cho toàn bộ việc authentication. Controller <code class=" language-php">HomeController</code> sẽ tự động được sinh ra để xử lý request post-login cho trang dashboard của ứng dụng.</p>
    <p>
        <a name="included-views"></a>
    </p>
    <h3>Views</h3>
    <p>Như đã đề cập ở phần trên, lệnh <code class=" language-php">php artisan make<span class="token punctuation">:</span>auth</code> cũng sẽ tạo toàn bộ các view cần thiết cho việc xác thực và đặt chúng trong thư mục <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>auth</code>.</p>
    <p>Lệnh <code class=" language-php">make<span class="token punctuation">:</span>auth</code> cũng tạo một thư mục <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>layouts</code> bao gồm các layout cơ bản cho ứng dụng. Tất cả những view này sử dụng framework Bootstrap, nhưng bạn thoải mái tùy biến nếu bạn thích.</p>
    <p>
        <a name="included-authenticating"></a>
    </p>
    <h3>Authenticating</h3>
    <p>Bây giờ bạn có các route và view chuẩn bị cho các authentication controllers,  bạn đã sẵn sàng để đăng kí và xác nhận những user mới cho ứng dụng! Bạn chỉ đơn giản truy cập ứng dụng thông qua trình duyệt, các authentication controller đã sẵn sàng gồm các logic (thông qua trait của chúng) để xác nhận những user đã tồn tại và lưu những user mới vào database.</p>
    <h4>Tùy chỉnh đường dẫn</h4>
    <p>Khi một user được xác nhận thành công, họ sẽ được chuyển sang URI <code class=" language-php"><span class="token operator">/</span>home</code>. Bạn có thể tùy biến địa chỉ chuyển hướng post-authentication bằng cách định nghĩa thuộc tính <code class=" language-php">redirectTo</code> trong <code class=" language-php">LoginController</code>, <code class=" language-php">RegisterController</code>, và <code class=" language-php">ResetPasswordController</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">protected</span> <span class="token variable">$redirectTo</span> <span class="token operator">=</span> <span class="token string">'/'</span><span class="token punctuation">;</span></code></pre>
    <p>Khi một user không được xác nhận thành công, họ sẽ tự động chuyển hướng quay lại form đăng nhập.</p>
    <h4>Tùy chỉnh guard</h4>
    <p>Bạn cũng có thể tùy biến "guard" cái mà sử dụng để authentication user. Để bắt đầu, định nghĩa một phương thức <code class=" language-php">guard</code> trong <code class=" language-php">LoginController</code>, <code class=" language-php">RegisterController</code>, và <code class=" language-php">ResetPasswordController</code>. Hàm này sẽ trả về một thể hiện guard:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>

<span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function">guard<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">guard<span class="token punctuation">(</span></span><span class="token string">'guard-name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Tùy biến Validation / Storage </h4>
    <p>Để thay đổi các trường trong form được yêu cầu khi người dùng đăng kí với ứng dụng của bạn, hoặc tùy biến các bản ghi user mới được chèn vào database như thế nào, bạn có thể chỉnh sửa class <code class=" language-php">RegisterController</code>. Class này chịu trách nhiệm việc valite và tạo user mới của ứng dụng.</p>
    <p>Phương thức <code class=" language-php">validator</code> của <code class=" language-php">RegisterController</code> chứa những quy định validation cho việc đăng ký một user mới. Bạn có thể thoải mái tùy biến theo ý bạn.</p>
    <p>Phương thức <code class=" language-php">create</code> của <code class=" language-php">RegisterController</code> có chịu trách nhiệm tạo mới một bản ghi mới <code class=" language-php">App\<span class="token package">User</span></code> <a href="{{URL::asset('')}}docs/5.3/eloquent">Eloquent ORM</a>. Bạn có thể tự do tùy biến nếu cần theo ý bạn.</p>
    <p>
        <a name="retrieving-the-authenticated-user"></a>
    </p>
    <h3> Nhận người dùng đã authenticate</h3>
    <p>Bạn có thể truy cập người dùng đã được xác thực thông qua facade <code class=" language-php">Auth</code> facade:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>

<span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Ngoài ra, mội khi user đã được authenticate, bạn có thể truy cập thông qua môt instance <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Request</span></code>. Nhớ rằng, type-hinted class sẽ tự động được injecte vào trong phương thức của controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ProfileController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Update the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">update<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // $request-&gt;user() returns an instance of the authenticated user...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Xác thực user nếu tồn tại</h4>
    <p>Để xác định user đã đăng nhập vào ứng dụng của bạn hay chưa, bạn có thể sử dụng phương thức <code class=" language-php">check</code> trong <code class=" language-php">Auth</code> facade, nó sẽ trả về <code class=" language-php"><span class="token boolean">true</span></code> nếu user được authenticate:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">check<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // The user is logged in...
</span><span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon tip">
        <p></p>
        <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
        </div> Mặc dùng có thể xác định user đã được xác thực bằng phương thức <code class=" language-php">check</code>, bạn có th sử dụng một middleware để xác thực user được authenticate trước khi cho phép user đó truy cập vào routes / controllers. Để tìm hiểu thêm, xem tại <a href="{{URL::asset('')}}docs/5.3/authentication#protecting-routes">bảo vệ routes</a>.
        <p></p>
    </blockquote>
    <p>
        <a name="protecting-routes"></a>
    </p>
    <h3>Bảo vệ Routes</h3>
    <p><a href="{{URL::asset('')}}docs/5.3/middleware">Route middleware</a> ccó thể được sử dụng để cho phép chỉ những user đã được xác thực truy cập vào các route đã cho. Laravel mang tới middleware <code class=" language-php">auth</code>, cái mà được định nghĩa trong <code class=" language-php">Illuminate\<span class="token package">Auth<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>Authenticate</span></code>. Toàn bộ những gì bạn cần là đính kèm middleware vào định nghĩa (khai báo) của route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Only authenticated users may enter...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tất nhiên, bạn có thể sử dụng <a href="{{URL::asset('')}}docs/5.3/controllers">controllers</a>, bạn có thể gọi phương thức <code class=" language-php">middleware</code> từ hàm constructor của controller thay vì gán nó trực tiếp vào route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Chỉ định một guard</h4>
    <p>Khi bạn gán <code class=" language-php">auth</code> middleware vào route, bạn cũng có thể chỉ định guard nào sẽ được dùng để thực thi việc authentication.Guard được chỉ định nên tương ứng với một trong các key trong mảng <code class=" language-php">guards</code> của file cấu hình <code class=" language-php">auth<span class="token punctuation">.</span>php</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth:api'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="login-throttling"></a>
    </p>
    <h3>Login Throttling</h3>
    <p>Nếu bạn sử dụng class <code class=" language-php">LoginController</code> của Laravel, <code class=" language-php">Illuminate\<span class="token package">Foundation<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>ThrottlesLogins</span></code> trait sẽ được thêm vào controller. Mặc định, người dùng sẽ không thể đăng nhập trong 1 phút nếu họ thất bại trong việc cung cấp thông tin chính xác một vài lần. Việc throttling này là duy nhất với một username / e-mail và địa chỉ IP của họ.</p>
    <p>
        <a name="authenticating-users"></a>
    </p>
    <h2><a href="#authenticating-users">Authenticating người dùng thủ công</a></h2>
    <p>Tất nhiên, bạn không bắt buộc phải sử dụng các authentication controller trong Laravel. Nếu bạn lựa chọn xóa những controller này, bạn sẽ cần phải quản lí việc xác thực user bằng cách sử dụng các class Laravel xác thực trực tiếp. Đừng lo lắng, nó là chắc chắn rồi!</p>
    <p>Chúng ta sẽ truy cập vào các authentication services của Laravel thông qua <code class=" language-php">Auth</code> <a href="/docs/5.3/facades">facade</a>, vì vậy chúng ta cần đảm bảo import facade <code class=" language-php">Auth</code> facade ở đầu class. Tiếp thep, hãy kiểm tra phương thức <code class=" language-php">attempt</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AuthController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Handle an authentication attempt.
     *
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">authenticate<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">attempt<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$email</span><span class="token punctuation">,</span> <span class="token string">'password'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$password</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // Authentication passed...
</span>            <span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">intended<span class="token punctuation">(</span></span><span class="token string">'dashboard'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Phương thức <code class=" language-php">attempt</code> chấp nhận một mảng các cặp key / value như là tham số đầu tiên. Các giá trị trong mảng sẽ được dùng để tìm user trong database. Vì vậy trong ví dụ trên, user sẽ được lấy ra bởi giá trị của cột <code class=" language-php">email</code>. Nếu tìm thấy user, hashed password được lưu trong database sẽ được dùng để so sánh với giá trị hashed <code class=" language-php">password</code> mà được truyền vào phương thức thông qua mảng. Nếu 2 hashed password trùng hợp, một session sẽ được bắt đầu cho user.</p>
    <p>Phương thức <code class=" language-php">attempt</code> sẽ trả về <code class=" language-php"><span class="token boolean">true</span></code> nếu xác thực thành công. Ngược lại, <code class=" language-php"><span class="token boolean">false</span></code> sẽ được trả về.</p>
    <p>Phương thức <code class=" language-php">intended</code> trên redirector sẽ chuyển hướng user tới URL họ vừa cố gắn truy cập trước khi bị bắt bởi authentication filter. Một fallback URI có thể được cho trước vào phương thức này trong trường hợp đích đến dự kiến không có.</p>
    <h4>Thêm điều kiện được chỉ định</h4>
    <p>Nếu muốn, bạn cũng có thể thêm những điều kiện mở rộng vào truy vấn xác thực. Ví dụ, chúng ta có thể xác nhận xem user đã được đánh dấu như "active":</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">attempt<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$email</span><span class="token punctuation">,</span> <span class="token string">'password'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$password</span><span class="token punctuation">,</span> <span class="token string">'active'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // The user is active, not suspended, and exists.
</span><span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p></p>
        <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
        </div> Trong ví vụ này, <code class=" language-php">email</code>  là không bắt buộc, nó chỉ được sử dụng như là một ví dụ. Bạn nên sử dụng những tên cột khác tương ứng với "username" trong database.
        <p></p>
    </blockquote>
    <h4>Truy cập thể hiện guard chỉ định</h4>
    <p>Bạn có thể chỉ định các guard instance bạn thích để làm việc bằng cách dùng phương thức <code class=" language-php">guard</code> trong <code class=" language-php">Auth</code> facade. Điều này cho phép bạn quản lí việc xác thực cho những thành phần khác nhau trong ứng dụng bằng cách sử dụng trọn vẹn các model có khả năng xác thực tách biệt hoặc các table user.</p>
    <p>Tên của guard truyền vào phương thức <code class=" language-php">guard</code> mnên tương ứng với một trong các guard được cấu hình trong file <code class=" language-php">auth<span class="token punctuation">.</span>php</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">guard<span class="token punctuation">(</span></span><span class="token string">'admin'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attempt<span class="token punctuation">(</span></span><span class="token variable">$credentials</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Đăng xuât</h4>
    <p>Để đăng xuất người dùng khỏi ứng dụng của bạn, bạn có thể sử dụng phương thức <code class=" language-php">logout</code> trong <code class=" language-php">Auth</code> facade. Việc này sẽ xóa toàn bộ thông tin xác thực trong session của user:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">logout<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="remembering-users"></a>
    </p>
    <h3>Ghi nhớ người dùng</h3>
    <p>Nếu bạn muốn cung cấp chức năng "remember me" ftrong ứng dụng, bạn có thể truyền một giá trị boolean như tham số thứ 2 vào phương thức <code class=" language-php">attempt</code> cái mà sẽ giữ cho người dùng đã được authentication vô thời hạn, hoặc tới khi họ đăng xuất thủ công. Tất nhiện, bảng <code class=" language-php">users</code> phải có một cột tring <code class=" language-php">remember_token</code>, cái mà sẽ được dùng để lưu "remember me" token.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">attempt<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$email</span><span class="token punctuation">,</span> <span class="token string">'password'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$password</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token variable">$remember</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // The user is being remembered...
</span><span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon tip">
        <p></p>
        <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
        </div> Nếu bạn sử dụng controller <code class=" language-php">LoginController</code> cung cấp bởi Laravel, tính năng "remember" đã được tích hợp bởi traits sử dụng trong controller.
        <p></p>
    </blockquote>
    <p>Nếu bạn đang "remembering" người dùng, bạn có thể sử dụng phương thức <code class=" language-php">viaRemember</code> để xác định nếu người dung đã authentication sử dụng cookie "remember me":</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">viaRemember<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="other-authentication-methods"></a>
    </p>
    <h3>Các phương thức Authentication khác</h3>
    <h4>Authenticate một thể hiện người dùng</h4>
    <p>Nếu bạn cần đăng nhập một user instance đang tồn tại vào ứng dụng, bạn có thể gọi phương thức <code class=" language-php">login</code>. Đối tượng đã cho phải là một imlementation của  <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>Authenticatable</span></code> <a href="/docs/5.3/contracts">contract</a>. Tất nhiện, model <code class=" language-php">App\<span class="token package">User</span></code> model của Laravel đã implement interface này rồi:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">login<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Login and "remember" the given user...
</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">login<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Tất nhiên, bạn có thể chỉ định thể hiện guard bạn muốn sử dụng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">guard<span class="token punctuation">(</span></span><span class="token string">'admin'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">login<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Authenticate người dùng bởi ID</h4>
    <p>Để đăng nhập một user vào ứng dụng bằng ID của họ, bạn có thể sử dụng phương thức <code class=" language-php">loginUsingId</code>. Phương thức này chấp nhận primary key của của user bạn muốn để authentication:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">loginUsingId<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Login and "remember" the given user...
</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">loginUsingId<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Authenticate người dùng một lần</h4>
    <p>Bạn có thể sử dụng phương thức <code class=" language-php">once</code> để đăng nhập một user vào ứng dụng cho một single request. Không có session hay cookie được tạo ra, cái có thể hữu ích khi xây dựng stateless API:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">once<span class="token punctuation">(</span></span><span class="token variable">$credentials</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="http-basic-authentication"></a>
    </p>
    <h2><a href="#http-basic-authentication">HTTP Basic Authentication</a></h2>
    <p><a href="http://en.wikipedia.org/wiki/Basic_access_authentication">HTTP Basic Authentication</a> cung cấp một cách nhanh chóng để xác thực người dùng của ứng dụng của bạn mà không cần phải thiết lập một trang "login".  Để bắt đầu, đính kèm <code class=" language-php">auth<span class="token punctuation">.</span>basic</code> <a href="{{URL::asset('')}}docs/5.3/middleware">middleware</a> vào route. Middleware <code class=" language-php">auth<span class="token punctuation">.</span>basic</code> được bao gồm trong Laravel framework, vì thế bạn không cần định nghĩa nó:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Only authenticated users may enter...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth.basic'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Một khi middleware đã được đính kèm vào route, bạn sẽ tự động được nhắc nhở về các thông tin khi truy cập vào route trên trình duyệt. Mặc định, Middleware <code class=" language-php">auth<span class="token punctuation">.</span>basic</code> sẽ sử dụng cột <code class=" language-php">email</code> ctrên các bản ghi như "username".</p>
    <h4>Một lưu ý về FastCGI</h4>
    <p>Nếu bạn đang sử dụng PHP FastCGI, HTTP Basic authentication có thể không hoạt động chính xác. Những dòng sau nên được thêm vào trong file <code class=" language-php"><span class="token punctuation">.</span>htaccess</code>:</p>
    <pre class=" language-php"><code class=" language-php">RewriteCond <span class="token operator">%</span><span class="token punctuation">{</span><span class="token constant">HTTP</span><span class="token punctuation">:</span>Authorization<span class="token punctuation">}</span> <span class="token operator">^</span><span class="token punctuation">(</span><span class="token punctuation">.</span><span class="token operator">+</span><span class="token punctuation">)</span>$
RewriteRule <span class="token punctuation">.</span><span class="token operator">*</span> <span class="token operator">-</span> <span class="token punctuation">[</span>E<span class="token operator">=</span><span class="token constant">HTTP_AUTHORIZATION</span><span class="token punctuation">:</span><span class="token operator">%</span><span class="token punctuation">{</span><span class="token constant">HTTP</span><span class="token punctuation">:</span>Authorization<span class="token punctuation">}</span><span class="token punctuation">]</span></code></pre>
    <p>
        <a name="stateless-http-basic-authentication"></a>
    </p>
    <h3>Stateless HTTP Basic Authentication</h3>
    <p>Bạn cũng có thể sử dụng HTTP Basic Authentication mà không cần thiết lập một cookie định danh người dùng trong session, cái mà là một thành phần hữu ích cho API authentication. Để làm nó, <a href="{{URL::asset('')}}docs/5.3/middleware">Định nghĩa một middleware</a> cái nà gọi phương thức <code class=" language-php">onceBasic</code>. Nếu không có response nào được trả về bởi phương thức <code class=" language-php">onceBasic</code>, request có thể được chuyển vào trong ứng dụng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>Middleware</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AuthenticateOnceWithBasicAuth</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$next</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">onceBasic<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token operator">?</span><span class="token punctuation">:</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

<span class="token punctuation">}</span></code></pre>
    <p>Tiếp thep, <a href="{{URL::asset('')}}docs/5.3/middleware#registering-middleware">Đăng ký route middleware</a> và gán nó vào một route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'api/user'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Only authenticated users may enter...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth.basic.once'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="adding-custom-guards"></a>
    </p>
    <h2><a href="#adding-custom-guards">Thêm tùy biến guard</a></h2>
    <p>bạn có thể định nghĩa thêm authentication guard bằng cách sử dụng phương thức <code class=" language-php">extend</code> trong <code class=" language-php">Auth</code> facade. Bạn nên đặt nó gọi <code class=" language-php">provider</code> ở trong <a href="/docs/5.3/providers">service provider</a>. Laravel đã có sẵn <code class=" language-php">AuthServiceProvider</code>, chúng ta có thể code nó ở trong provider này:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Services<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>JwtGuard</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Providers<span class="token punctuation">\</span>AuthServiceProvider</span> <span class="token keyword">as</span> ServiceProvider<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AuthServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Register any application authentication / authorization services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">registerPolicies<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">extend<span class="token punctuation">(</span></span><span class="token string">'jwt'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">,</span> <span class="token variable">$name</span><span class="token punctuation">,</span> <span class="token keyword">array</span> <span class="token variable">$config</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // Return an instance of Illuminate\Contracts\Auth\Guard...
</span>
            <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">JwtGuard</span><span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">createUserProvider<span class="token punctuation">(</span></span><span class="token variable">$config</span><span class="token punctuation">[</span><span class="token string">'provider'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Như bạn có thể thấy trong ví dụ trên, callback được truyền vào phương thức <code class=" language-php">extend</code> trả về một implementation của <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>Guard</span></code>. Interface này bao gồm vài phương thức bạn sẽ cần để implement để định nghĩa một custom guard, bạn có thể sử dụng guard trong file <code class=" language-php">guards</code> của file cấu hình <code class=" language-php">auth<span class="token punctuation">.</span>php</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'guards'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'api'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'driver'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'jwt'</span><span class="token punctuation">,</span>
        <span class="token string">'provider'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'users'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="adding-custom-user-providers"></a>
    </p>
    <h2><a href="#adding-custom-user-providers">Adding Custom User Providers</a></h2>
    <p>Nếu bạn đang không sử dụng các cơ sở dữ liệu quan hệ truyền thống để lưu trữ user, bạn sẽ cần phải mở rộng Laravel với authentication user provider của bạn. Chúng ta sẽ dùng phương thức <code class=" language-php">provider</code> trong <code class=" language-php">Auth</code> facade để định nghĩa một custom user provider:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Extensions<span class="token punctuation">\</span>RiakUserProvider</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AuthServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Register any application authentication / authorization services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">registerPolicies<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">provider<span class="token punctuation">(</span></span><span class="token string">'riak'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">,</span> <span class="token keyword">array</span> <span class="token variable">$config</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // Return an instance of Illuminate\Contracts\Auth\UserProvider...
</span>
            <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">RiakUserProvider</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token string">'riak.connection'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Sau khi bạn đã đăng kí provider với phương thức <code class=" language-php">provider</code>bạn có thể chuyển sang user provider mới trong file cấu hình <code class=" language-php">auth<span class="token punctuation">.</span>php</code> Đầu tiên, định nghĩa một <code class=" language-php">provider</code> mà sử dụng driver mới của bạn:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'providers'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'users'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'driver'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'riak'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>Sau đó bạn có thể sử dụng provider này trong cấu hình <code class=" language-php">guards</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'guards'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'web'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'driver'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'session'</span><span class="token punctuation">,</span>
        <span class="token string">'provider'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'users'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="the-user-provider-contract"></a>
    </p>
    <h3>The User Provider Contract</h3>
    <p>Các implementation <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>UserProvider</span></code> chỉ chịu trách nhiệm cho việc lấy <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>Authenticatable</span></code> implementation khỏi một persistent storage system, như là MySQL, Riak, etc. Hai interface này cho phép các cơ chế Laravel authentication tiếp tục hoạt động bất kể dữ liệu user được lưu trữ như thế nào hoặc kiểu của các lớp sử dụng để đại diện nó.</p>
    <p>Hãy nhìn qua <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>UserProvider</span></code> contract:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>

<span class="token keyword">interface</span> <span class="token class-name">UserProvider</span> <span class="token punctuation">{</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">retrieveById<span class="token punctuation">(</span></span><span class="token variable">$identifier</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">retrieveByToken<span class="token punctuation">(</span></span><span class="token variable">$identifier</span><span class="token punctuation">,</span> <span class="token variable">$token</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">updateRememberToken<span class="token punctuation">(</span></span>Authenticatable <span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token variable">$token</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">retrieveByCredentials<span class="token punctuation">(</span></span><span class="token keyword">array</span> <span class="token variable">$credentials</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">validateCredentials<span class="token punctuation">(</span></span>Authenticatable <span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token keyword">array</span> <span class="token variable">$credentials</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token punctuation">}</span></code></pre>
    <p>Hàm <code class=" language-php">retrieveById</code> thông thường nhận một key đại diện cho user, như là một auto-incrementing ID từ MySQL database. Implementation <code class=" language-php">Authenticatable</code> tìm kiếm ID sẽ được lấy và trả về bởi phương thức.</p>
    <p>Hàm <code class=" language-php">retrieveByToken</code> truy xuất một user bằng <code class=" language-php"><span class="token variable">$identifier</span></code> và "remember me" <code class=" language-php"><span class="token variable">$token</span></code>,  được lưu ở trong trường <code class=" language-php">remember_token</code>.  Giống như với phương thức trước, implementation <code class=" language-php">Authenticatable</code> sẽ được trả về.</p>
    <p>Hàm <code class=" language-php">updateRememberToken</code> cập nhật trường <code class=" language-php"><span class="token variable">$user</span></code>  <code class=" language-php">remember_token</code> với <code class=" language-php"><span class="token variable">$token</span></code> mới. Token mới có thể là một token hoàn toàn mới, được gán bởi một đăng nhập "remember me" thành công, hoặc <code class=" language-php"><span class="token keyword">null</span></code> khi người dùng đăng xuất.</p>
    <p>Hàm <code class=" language-php">retrieveByCredentials</code> nhận mảng các credentials truyền vào phương thức <code class=" language-php"><span class="token scope">Auth<span class="token punctuation">::</span></span>attempt</code> khi xảy ra đăng nhập vào ứng dụng. Phương thức sau đó "query" underlying persistent storage cho việc tìm kiếm các credentials phù hợp. Cơ bản, phương thức này sẽ chạy 1 truy vấn với điều kiện "where" trên <code class=" language-php"><span class="token variable">$credentials</span><span class="token punctuation">[</span><span class="token string">'username'</span><span class="token punctuation">]</span></code>. Phương thức sau đó trả về một implementation của <code class=" language-php">Authenticatable</code>. <strong>Phương thức này không nên cố gắng validate hay authentiaction mật khẩu..</strong>
    </p>
    <p>Hàm <code class=" language-php">validateCredentials</code> so sánh <code class=" language-php"><span class="token variable">$user</span></code> với <code class=" language-php"><span class="token variable">$credentials</span></code> để authenticate người dùng. Ví dụ, phương thức này có thể so sánh chuỗi <code class=" language-php"><span class="token scope">Hash<span class="token punctuation">::</span></span>check</code> với giá trị của <code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">getAuthPassword<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code> to the value of <code class=" language-php"><span class="token variable">$credentials</span><span class="token punctuation">[</span><span class="token string">'password'</span><span class="token punctuation">]</span></code>. Phương thức này chỉ trả về <code class=" language-php"><span class="token boolean">true</span></code> hoặc <code class=" language-php"><span class="token boolean">false</span></code> nếu mật khẩu không đúng.</p>
    <p>
        <a name="the-authenticatable-contract"></a>
    </p>
    <h3>The Authenticatable Contract</h3>
    <p>Bây giờ chúng ta đã khám phá từng phương thức trong <code class=" language-php">UserProvider</code>, hãy xem qua <code class=" language-php">Authenticatable</code> contract. Nhớ rằng, provider nên trả về các implementations của interface này từ phương thức <code class=" language-php">retrieveById</code> và <code class=" language-php">retrieveByCredentials</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>

<span class="token keyword">interface</span> <span class="token class-name">Authenticatable</span> <span class="token punctuation">{</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getAuthIdentifierName<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getAuthIdentifier<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getAuthPassword<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getRememberToken<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">setRememberToken<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getRememberTokenName<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token punctuation">}</span></code></pre>
    <p>Interface này đơn giản. Hàm <code class=" language-php">getAuthIdentifierName</code> mtrả về tên của trường "primary key" của người dùng và <code class=" language-php">getAuthIdentifier</code> trả về "primary key" của người dùng. Trong MySQL back-end sẽ là auto-incrementing primary key. Hàm <code class=" language-php">getAuthPassword</code> trả về password đã được hashed. Interface này cho phép hệ thống xác thực làm việc với bất kì lớp User nào, bất kể ORM nào hay storage abstraction layer nào bạn đang sử dụng. Mặc định, Laravel bao gồm một class <code class=" language-php">User</code> trong thư mục <code class=" language-php">app</code> cái mà implement interface này, vì vậy bạn có thể tham khảo class này như một ví dụ..</p>
    <p>
        <a name="events"></a>
    </p>
    <h2><a href="#events">Events</a></h2>
    <p>Laravel xây dựng một loạt <a href="{{URL::asset('')}}docs/5.3/events">events</a> khác nhau trong khi xử lí xác thực. Bạn có thể đính kèm các listener vào những event này trong <code class=" language-php">EventServiceProvider</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * The event listener mappings for the application.
 *
 * @var array
 */</span>
<span class="token keyword">protected</span> <span class="token variable">$listen</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'Illuminate\Auth\Events\Registered'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogRegisteredUser'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'Illuminate\Auth\Events\Attempting'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogAuthenticationAttempt'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'Illuminate\Auth\Events\Authenticated'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogAuthenticated'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'Illuminate\Auth\Events\Login'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogSuccessfulLogin'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'Illuminate\Auth\Events\Logout'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogSuccessfulLogout'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'Illuminate\Auth\Events\Lockout'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogLockout'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/authenticate">https://laravel.com/docs/5.3/authenticate</a></div>
</article>
@endsection