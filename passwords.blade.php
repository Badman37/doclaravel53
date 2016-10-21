@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Khôi phục mật khẩu</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#resetting-database">Những chú ý về database</a>
        </li>
        <li><a href="#resetting-routing">Routing</a>
        </li>
        <li><a href="#resetting-views">Views</a>
        </li>
        <li><a href="#after-resetting-passwords">Sai khi khôi phục mật khẩu</a>
        </li>
        <li><a href="#password-customization">Tùy biến</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Bạn có muốn bắt đầu nhanh không? Chỉ cần chạy <code class=" language-php">php artisan make<span class="token punctuation">:</span>auth</code> trong một project mới. Khi đó, vào trình duyệt gõ địa chỉ <code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>your<span class="token operator">-</span>app<span class="token punctuation">.</span>dev<span class="token operator">/</span>register</code>  hoặc bất kỳ URL được gán cho ứng dụng. Đó là hai lệnh để sử dụng scaffolding cho việc xác thực tài khoản ứng dụng của bạn!</p>
    </blockquote>
    <p>Hầu hết các ứng dụng web đều cung cấp cách khôi phục mật khẩu khi người dùng quên. Thay vì bắt bạn thực hiện tích hợp nó cho mỗi ứng dụng, Laravel cung cấp phương thức khá tiện về việc nhắc nhở mật khẩu và thực hiện khôi phục mật khẩu.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Trước khi sử dụng tính năng khôi phục mật khẩu của Laravel, người dùng của bạn phải sử dụng <code class=" language-php">Illuminate\<span class="token package">Notifications<span class="token punctuation">\</span>Notifiable</span></code> trait.</p>
    </blockquote>
    <p>
        <a name="resetting-database"></a>
    </p>
    <h2><a href="#resetting-database">Những chú ý về database</a></h2>
    <p>Để bắt đầu, hãy chắc chắn model <code class=" language-php">App\<span class="token package">User</span></code> model tích hợp <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>CanResetPassword</span></code> . Tất nhiên, model <code class=" language-php">App\<span class="token package">User</span></code> được thêm bởi framework đẽ được tích hợp interface này, và sử dụng <code class=" language-php">Illuminate\<span class="token package">Auth<span class="token punctuation">\</span>Passwords<span class="token punctuation">\</span>CanResetPassword</span></code> trait để thêm vào phương thức cần thiết để thực hiện interface.</p>
    <h4>Tạo ra bảng reset token</h4>
    <p>Tiếp theo, một bảng cần được tạo ra để lưu reset token của mật khẩu. File migration cho bảng này đã được thêm vào bởi framework, nó nằm trong thư mục <code class=" language-php">database<span class="token operator">/</span>migrations</code>. Vì vậy, tất cả bạn cần làm là chạy lệnh sau để migration database:</p>
    <pre class=" language-php"><code class=" language-php">php artisan migrate</code></pre>
    <p>
        <a name="resetting-routing"></a>
    </p>
    <h2><a href="#resetting-routing">Routing</a></h2>
    <p>Laravel gồm class <code class=" language-php">Auth\<span class="token package">ForgotPasswordController</span></code> và class <code class=" language-php">Auth\<span class="token package">ResetPasswordController</span></code> chứa những logic cần thiết để gửi link password reset vào e-mail cho việc khôi phục mật khẩu. Tất cả route cần làm việc đó được tạo ra bằng lệnh <code class=" language-php">make<span class="token punctuation">:</span>auth</code> Artisan:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>auth</code></pre>
    <p>
        <a name="resetting-views"></a>
    </p>
    <h2><a href="#resetting-views">Views</a></h2>
    <p>Một lần nữa, Laravel sẽ tạo ra tất cả những view cần thiết cho việc khôi phục mật khẩu khi lệnh <code class=" language-php">make<span class="token punctuation">:</span>auth</code> được thực thi. Những view này được lưu tại thư mục <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>auth<span class="token operator">/</span>passwords</code>. Bạn có thể tự do tùy biến nó trong ứng dụng của bạn.</p>
    <p>
        <a name="after-resetting-passwords"></a>
    </p>
    <h2><a href="#after-resetting-passwords">Sau khi khôi phục mật khẩu</a></h2>
    <p>Khi route và view được định nghĩa để khôi phục mật khẩu người dùng, bạn có thể truy cập route bằng trình duyệt tại địa chỉ <code class=" language-php"><span class="token operator">/</span>password<span class="token operator">/</span>reset</code>. Controller <code class=" language-php">ForgotPasswordController</code> được thêm bởi framework đã chứa logic để gửi password reset vào mail, trong khi <code class=" language-php">ResetPasswordController</code> chứa logic để khôi phục lại mật khẩu của người dùng.</p>
    <p>Sau khi khôi phục mật khẩu, người dùng sẽ tự động đăng nhập và chuyển đến trang <code class=" language-php"><span class="token operator">/</span>home</code>. Bạn có thể tùy biến nó và chuyển đến trang khác bằng thuộc tính <code class=" language-php">redirectTo</code> trong <code class=" language-php">ResetPasswordController</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">protected</span> <span class="token variable">$redirectTo</span> <span class="token operator">=</span> <span class="token string">'/dashboard'</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Mặc định, password reset tokens sẽ hết hạn trong vòng 1 giờ. Bạn có thể thay đổi hạn password reset <code class=" language-php">expire</code> trong file <code class=" language-php">config<span class="token operator">/</span>auth<span class="token punctuation">.</span>php</code>.</p>
    </blockquote>
    <p>
        <a name="password-customization"></a>
    </p>
    <h2><a href="#password-customization">Tùy biến</a></h2>
    <h4>Tùy biến authentication guard</h4>
    <p>Trong file <code class=" language-php">auth<span class="token punctuation">.</span>php</code>, bạn có thể cấu hình nhiều "guards",nó để sử dụng để định nghĩa xác thực nhiều bảng người dùng. Bạn có thể tùy biến bao gồm <code class=" language-php">ResetPasswordController</code> sử dụng guard bạn chọn ghi đè phương thức <code class=" language-php">guard</code> trong controller. Phương thức trả về một thể hiện guard:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Auth</span><span class="token punctuation">;</span>

<span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function">guard<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">guard<span class="token punctuation">(</span></span><span class="token string">'guard-name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Tùy biến password Broker</h4>
    <p>Trong file <code class=" language-php">auth<span class="token punctuation">.</span>php</code>, bạn có thể cấu hình nhiều "brokers", nó để sử dụng để khôi phục mật khẩu nhiều bảng người dùng. Bạn có thể tùy biến bao gồm <code class=" language-php">ForgotPasswordController</code> và <code class=" language-php">ResetPasswordController</code> sử dụng broker bạn chọn ghi đè phương thức <code class=" language-php">broker</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Password</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/**
 * Get the broker to be used during password reset.
 *
 * @return PasswordBroker
 */</span>
<span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function">broker<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">Password<span class="token punctuation">::</span></span><span class="token function">broker<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Tùy biến Reset Email</h4>
    <p>Bạn có thể dễ dàng sửa thông báo gửi link password reset cho người dùng. Để bắt đầu, ghi đè phương thức <code class=" language-php">sendPasswordResetNotification</code> trong model <code class=" language-php">User</code>. Trong phương thức này, bạn có thể gửi thông báo cho bất cứ lớp thông báo nào bạn thích. <code class=" language-php"><span class="token variable">$token</span></code> là tham số thứ nhất của phương thức:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Send the password reset notification.
 *
 * @param  string  $token
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">sendPasswordResetNotification<span class="token punctuation">(</span></span><span class="token variable">$token</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">notify<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">ResetPasswordNotification</span><span class="token punctuation">(</span><span class="token variable">$token</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/localization">https://laravel.com/docs/5.3/localization</a></div>
</article>
@endsection