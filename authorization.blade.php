@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Authorization</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#gates">Gates</a>
            <ul>
                <li><a href="#writing-gates">Viết Gates</a>
                </li>
                <li><a href="#authorizing-actions-via-gates">Hành động authorizing</a>
                </li>
            </ul>
        </li>
        <li><a href="#creating-policies">Tạo mới Policies</a>
            <ul>
                <li><a href="#generating-policies">Tạo ra Policies</a>
                </li>
                <li><a href="#registering-policies">Đăng ký Policies</a>
                </li>
            </ul>
        </li>
        <li><a href="#writing-policies">Viết Policies</a>
            <ul>
                <li><a href="#policy-methods">Phương thức policy</a>
                </li>
                <li><a href="#methods-without-models">Phương thức không models</a>
                </li>
                <li><a href="#policy-filters">Lọc policy</a>
                </li>
            </ul>
        </li>
        <li><a href="#authorizing-actions-using-policies">Hành động authorizing sử dụng policies</a>
            <ul>
                <li><a href="#via-the-user-model">Via The User Model</a>
                </li>
                <li><a href="#via-middleware">Via Middleware</a>
                </li>
                <li><a href="#via-controller-helpers">Via Controller Helpers</a>
                </li>
                <li><a href="#via-blade-templates">Via Blade Templates</a>
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Ngoài việc cung cấp các service <a href="{{URL::asset('')}}docs/5.3/authentication">authentication</a>, Laravel cũng cung cấp một cách đơn giản để tổ chức các logic cấp quyền và điều khiển việc truy cập vào tài nguyên. Như authentication, tiếp cận với ủy quyền của Laravel đơn giản và là hai cách chỉnh của hành động ủy quyền: gates và policies.</p>
    <p>Có thể hiểu gates và policies như routes và controllers. Gates cung cấp một cách đơn giản, Closure based tiếp cận authorization trong policies, như controllers, nhóm các logicc xung quanh một particular model hoặc resource. Chúng ta sẽ khám phá gates trước khi tìm hiểu policies.</p>
    <p>Điều quan trọng là không được xem gates và policies như là loại trừ lẫn nhau trong. Hầu hết các ứng dụng sẽ chứa hỗn hợp của gates và policies, và điều đó khá tốt! Gates hay được ạp dụn cho các hành động không liên quan đến model hoặc resource, như là xem một trang administrator dashboard. Ngược lại, policies được sử dụng khi bạn muốn authorize một hành động cụ thể của model hoặc resource.</p>
    <p>
        <a name="gates"></a>
    </p>
    <h2><a href="#gates">Gates</a></h2>
    <p>
        <a name="writing-gates"></a>
    </p>
    <h3>Viết Gates</h3>
    <p>Gates are Closures xác định người dùng đã ủy quyền để thực hiện một hành động nhất định và thường được định nghĩa trong class <code class=" language-php">App\<span class="token package">Providers<span class="token punctuation">\</span>AuthServiceProvider</span></code> sử dụng <code class=" language-php">Gate</code> facade. Gates luôn luôn nhận một thể hiện của người dùng như là đố số đầu tiên, bạn có thể tùy biến nhận đối số bổ sung như là một relevant Eloquent model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Register any authentication / authorization services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">registerPolicies<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token scope">Gate<span class="token punctuation">::</span></span><span class="token function">define<span class="token punctuation">(</span></span><span class="token string">'update-post'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token operator">==</span> <span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">user_id</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="authorizing-actions-via-gates"></a>
    </p>
    <h3>Ủy quyền hành động</h3>
    <p>Để ủy quyền một hành động sử dụng gates, bạn dùng phương thức <code class=" language-php">allows</code>. Chú ý là bạn không cần truyền chứng thực user hiện tại vào phương thức <code class=" language-php">allows</code>. Laravel sẽ tự động làm việc đó trong gate Closure:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Gate<span class="token punctuation">::</span></span><span class="token function">allows<span class="token punctuation">(</span></span><span class="token string">'update-post'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // The current user can update the post...
</span><span class="token punctuation">}</span></code></pre>
    <p>Nếu bạn muốn xem một người dùng chứng thực cụ thể có được ủy wuyeenf một hành động, bạn có thể dùng phương thức <code class=" language-php">forUser</code> trong <code class=" language-php">Gate</code> facade:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Gate<span class="token punctuation">::</span></span><span class="token function">forUser<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">allows<span class="token punctuation">(</span></span><span class="token string">'update-post'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // The user can update the post...
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="creating-policies"></a>
    </p>
    <h2><a href="#creating-policies">Tạo mới Policies</a></h2>
    <p>
        <a name="generating-policies"></a>
    </p>
    <h3>Tạo ra Policies</h3>
    <p>Policies là các class tổ chức ủy quyền logic xung quanh model hoặc resource cụ thể. Ví dụ, nếu ứng dụng của bạn là blog, bạn có thể có model <code class=" language-php">Post</code> và tương ứng với nó là <code class=" language-php">PostPolicy</code> để ủy quyền người dùng như là được phép tạo mới hoặc update bài viết.</p>
    <p>Bạn có thể tạo ra policy bằng lệnh <code class=" language-php">make<span class="token punctuation">:</span>policy</code> <a href="/docs/5.3/artisan">artisan</a>. policy dduwcoj tạo ra sẽ nằm ở thư mục <code class=" language-php">app<span class="token operator">/</span>Policies</code>. Nếu thư mục không có trong ứng dụng, Laravel sẽ tạo nó giúp bạn:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>policy PostPolicy</code></pre>
    <p>Lệnh <code class=" language-php">make<span class="token punctuation">:</span>policy</code> sẽ tạo ra một class policy rỗng. Nếu bạn muốn tạo một class có đủ "CRUD" policy trong class, bạn có thể chỉ định <code class=" language-php"><span class="token operator">--</span>model</code> khi thực thi lệnh:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>policy PostPolicy <span class="token operator">--</span>model<span class="token operator">=</span>Post</code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Tất cả policies đều được xử lý qua Laravel <a href="{{URL::asset('')}}docs/5.3/container">service container</a>, cho phép bạn type-hint bất cứ dependencies cần thiết trong hàm khởi tạo constructor của prolicy để chúng tự động được injected.</p>
    </blockquote>
    <p>
        <a name="registering-policies"></a>
    </p>
    <h3>Đăng ký Policies</h3>
    <p>Khi policy đã tồn tại, nó cần được đăng ký. Class <code class=" language-php">AuthServiceProvider</code> đã có sẵn trong ứng dụng Laravel chứa một thuộc tính <code class=" language-php">policies</code> nó sẽ map với Eloquent models tương ứng với policies. Đăng ký một policy sẽ hướng dẫn Laravel, mà policy để sử dụng khi cho phép hành động cho bởi một model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Post</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Policies<span class="token punctuation">\</span>PostPolicy</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Gate</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Providers<span class="token punctuation">\</span>AuthServiceProvider</span> <span class="token keyword">as</span> ServiceProvider<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AuthServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The policy mappings for the application.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$policies</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
        <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token keyword">class</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">PostPolicy<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Register any application authentication / authorization services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">registerPolicies<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="writing-policies"></a>
    </p>
    <h2><a href="#writing-policies">Viết Policies</a></h2>
    <p>
        <a name="policy-methods"></a>
    </p>
    <h3>Các phương thức policy</h3>
    <p>Khi policy đã được đăng ký, bạn có thể thêm hành động ủy quyền cho nó. Ví dụ, xem một phương thức <code class=" language-php">update</code> trong class <code class=" language-php">PostPolicy</code> để định nghĩa <code class=" language-php">User</code> có thể cập nhật <code class=" language-php">Post</code> instance.</p>
    <p>Phương thức <code class=" language-php">update</code> sẽ nhận một <code class=" language-php">User</code> và một <code class=" language-php">Post</code> instance là tham số, và trả về <code class=" language-php"><span class="token boolean">true</span></code> hoặc <code class=" language-php"><span class="token boolean">false</span></code> khi người dùng có quyền cập nhật <code class=" language-php">Post</code>. Vì vậy, ví dụ này, hãy xác minh <code class=" language-php">id</code> của người dùng khớp với <code class=" language-php">user_id</code> trong bài viết:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Policies</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Post</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">PostPolicy</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Determine if the given post can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return bool
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">update<span class="token punctuation">(</span></span>User <span class="token variable">$user</span><span class="token punctuation">,</span> Post <span class="token variable">$post</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token operator">===</span> <span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">user_id</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Nếu bạn tiếp tục dịnh nghĩa thêm phương thức trong policy khi cần thiết cho các hành động ủy quyền khác của nó. Ví dụ, bạn có thể định nghĩa <code class=" language-php">view</code> và <code class=" language-php">delete</code> để quỷ quyền hành động <code class=" language-php">Post</code>, nhưng nhớ rằng bạn hoàn toàn thoải mái trong việc đặt tên các phương thức.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Nếu bạn sử dụng lựa chọn <code class=" language-php"><span class="token operator">--</span>model</code> khi tạo policy qua Artisan console, nó sẽ có sẵn một số phương thức <code class=" language-php">view</code>, <code class=" language-php">create</code>, <code class=" language-php">update</code>, và <code class=" language-php">delete</code>.</p>
    </blockquote>
    <p>
        <a name="methods-without-models"></a>
    </p>
    <h3>Phương thức không có models</h3>
    <p>Một số phương thức policy chỉ nhận chứng thực user hiện tại và không cần một thể hiện model họ ủy quyền. Trường hợp này rất phổ biến để ủy quyền hành động <code class=" language-php">create</code>. Ví dụ, nếu bạn tạo mới một blog, bạn có thể kiểm tra nếu người dùng là chứng thực thì có thể tạo bất kỳ bài viết.</p>
    <p>Khi định nghĩa phương thưc policy sẽ không nhận về thể hiện model, như là một phương thức <code class=" language-php">create</code>, nó sẽ không nhận về một thể hiện model. Vì vậy, bạn có thể định nghĩa phương thứ như là để chức thực người dùng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Determine if the given user can create posts.
 *
 * @param  \App\User  $user
 * @return bool
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">create<span class="token punctuation">(</span></span>User <span class="token variable">$user</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Nếu bạn sử dụng lựa chọn <code class=" language-php"><span class="token operator">--</span>model</code> khi tạo policy, tất cả phương thức relevant "CRUD" policy sẽ được thêm vào policy.</p>
    </blockquote>
    <p>
        <a name="policy-filters"></a>
    </p>
    <h3>Lọc policy</h3>
    <p>Đối với người dùng nhất định, bạn có thể ủy quyền tất cả các hành động trong policy. Đề làm điều này, định nghĩa một phương thức <code class=" language-php">before</code> trong policy. Phương thức <code class=" language-php">before</code> sẽ được thực thi trước bất kỳ phương thức nào trong policy, đem lại cho bạn một cơ hội để cho phép các hành động trước khi các phương thức policy được gọi. Tính năng này thương được sử dụng cho người quản trị có quyền thực hiện tất cả các hành động:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">before<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token variable">$ability</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">isSuperAdmin<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token boolean">true</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="authorizing-actions-using-policies"></a>
    </p>
    <h2><a href="#authorizing-actions-using-policies">Ủy quyền hành động sử dụng policies</a></h2>
    <p>
        <a name="via-the-user-model"></a>
    </p>
    <h3>Qua User Model</h3>
    <p>Model <code class=" language-php">User</code> có sẵn trong ứng dụng Laravel đã được thêm vào hai phương thức rất hữu ích cho việc ủy quyền hành động: <code class=" language-php">can</code> và <code class=" language-php">cant</code>. Phương thức <code class=" language-php">can</code> nhận một hành động bạn muốn ủy quyền và liên quan đến model. Ví dụ, định nghĩa một người dùng có quyền cập nhật <code class=" language-php">Post</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">can<span class="token punctuation">(</span></span><span class="token string">'update'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>Nếu một <a href="#registering-policies">policy đã đăng ký</a> cho model, phương thức <code class=" language-php">can</code> sẽ tự động gọi hành động thích hợpvà trả về kiểu boolean. Nếu không policy được đăng ký cho model, phương thức <code class=" language-php">can</code> sẽ cố gắng gọi Closure based Gate khớp với tên hành động.</p>
    <h4>Hành động không yêu cầu Models</h4>
    <p>Nhớ rằng, một số hành động như <code class=" language-php">create</code> có thể không cần thể hiện model. Trong trường hợp này, bạn có thể truyền tên class vào phương thức <code class=" language-php">can</code>. Tên class sẽ được sử dụng để xác định cái mà policy để sử dụng ủy quyền cho hành động:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Post</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">can<span class="token punctuation">(</span></span><span class="token string">'create'</span><span class="token punctuation">,</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Executes the "create" method on the relevant policy...
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="via-middleware"></a>
    </p>
    <h3>Qua Middleware</h3>
    <p>Laravel thêm một middleware có thể ủy quyền hành động trước khi có request gửi đến ngay cả đến với routes hoặc controllers. Mặc định, middleware <code class=" language-php">Illuminate\<span class="token package">Auth<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>Authorize</span></code> middleware được gán key <code class=" language-php">can</code> trong class <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Kernel</span></code>. Hãy khám phá ví dụ <code class=" language-php">can</code> middleware ủy quyền một người dùng có quyền cập nhật bài viết:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Post</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'/post/{post}'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span>Post <span class="token variable">$post</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // The current user may update the post...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'can:update,post'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Trong ví dụ trên, chúng ta truyền vào <code class=" language-php">can</code> middleware hai tham số. Thứ nhất là tên của hành động chúng tao ủy quyền và thứ hai là tham số route chúng ta muốn truyền vào phương thức policy. Trong trường hợp này, Khi chúng ta sử dụng <a href="{{URL::asset('')}}docs/5.3/routing#implicit-binding">implicit model binding</a>, model <code class=" language-php">Post</code> sẽ truyền vào phương thức policy. Nếu người dùng chưa được ủy quyền cho hành động, một HTTP response với một mã <code class=" language-php"><span class="token number">403</span></code> status sẽ được sinh ra bởi middleware.</p>
    <h4>Hành động không yêu cầu Models</h4>
    <p>Một lần nữa, một số hành động như <code class=" language-php">create</code> có thể không yêu cầu model instance. Trong trường hợp này, bạn có thể truyển tên class vào middleware. Tên class sẽ được sử dụng để xác định cái mà policy sử dụng khi ủy quyền hành động:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'/post'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // The current user may create posts...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'can:create,App\Post'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="via-controller-helpers"></a>
    </p>
    <h3>Qua Controller Helpers</h3>
    <p>Ngoài phương thức hữu ích cung câp cho model <code class=" language-php">User</code>, Laravel cung cấp phương thức <code class=" language-php">authorize</code> cho bất cứ controllers kế thừa từ class base <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span></code>. Như phương thức <code class=" language-php">can</code>, phương thức này chấp nhận tên của hành động bạn muốn ủy quyền và liên quan đến model. Nếu hành động chưa được ủy quyền, hàm <code class=" language-php">authorize</code> sẽ ném ra một <code class=" language-php">Illuminate\<span class="token package">Auth<span class="token punctuation">\</span>Access<span class="token punctuation">\</span>AuthorizationException</span></code>, mặc định Laravel exception sẽ sử lý và chuyển thành HTTP response với một mã <code class=" language-php"><span class="token number">403</span></code> status:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Post</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">PostController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Update the given blog post.
     *
     * @param  Request  $request
     * @param  Post  $post
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">update<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">,</span> Post <span class="token variable">$post</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">authorize<span class="token punctuation">(</span></span><span class="token string">'update'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // The current user can update the blog post...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Hành động không yêu cầu models</h4>
    <p>Như đã nói ở trước, một số hành động như <code class=" language-php">create</code> không yêu cầu một thể hiện model. Trong trường hợp này, bạn truyền tên class vào phương thức <code class=" language-php">authorize</code>. Tên class sẽ sử dụng để định nghĩa cái mà policy sử dụng để ủy quyền hành động:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Create a new blog post.
 *
 * @param  Request  $request
 * @return Response
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">create<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">authorize<span class="token punctuation">(</span></span><span class="token string">'create'</span><span class="token punctuation">,</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> // The current user can create blog posts...
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="via-blade-templates"></a>
    </p>
    <h3>Qua Blade Templates</h3>
    <p>Khi viết Blade templates, bạn có thể muốn chỉ hiển thị những hành động mà người dùng có quyền. Ví dụ, bạn có thể hiện thị hành động cập nhật form  cho những người dùng có quyền cập nhật bài viết. Trong trường hợp này, bạn sử dụng <code class=" language-php">@@can</code> and <code class=" language-php">@@cannot</code> directives.</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">can<span class="token punctuation">(</span></span><span class="token string">'update'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- The Current User Can Update The Post --&gt;</span></span>
@@endcan

@<span class="token function">cannot<span class="token punctuation">(</span></span><span class="token string">'update'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- The Current User Can't Update The Post --&gt;</span></span>
@@endcannot</code></pre>
    <p>Những directives là viết tắt của câu lệnh <code class=" language-php">@<span class="token keyword">if</span></code> and <code class=" language-php">@@unless</code>. Cậu lệnh <code class=" language-php">@@can</code> và <code class=" language-php">@@cannot</code> tương ứng với các câu lệnh sau:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">can<span class="token punctuation">(</span></span><span class="token string">'update'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- The Current User Can Update The Post --&gt;</span></span>
@<span class="token keyword">endif</span>

@@unless <span class="token punctuation">(</span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">can<span class="token punctuation">(</span></span><span class="token string">'update'</span><span class="token punctuation">,</span> <span class="token variable">$post</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- The Current User Can't Update The Post --&gt;</span></span>
@@endunless</code></pre>
    <h4>Hành động không yêu cầu models</h4>
    <p>Giống như cách ủy quyền hành động khác, bạn có thể truyền tên class vào <code class=" language-php">@@can</code> và <code class=" language-php">@@cannot</code> directives nếu hành động không yêu cầu thể hiện model:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">can<span class="token punctuation">(</span></span><span class="token string">'create'</span><span class="token punctuation">,</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- The Current User Can Create Posts --&gt;</span></span>
@@endcan

@<span class="token function">cannot<span class="token punctuation">(</span></span><span class="token string">'create'</span><span class="token punctuation">,</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token comment" spellcheck="true">&lt;!-- The Current User Can't Create Posts --&gt;</span></span>
@@endcannot</code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/authorization">https://laravel.com/docs/5.3/authorization</a></div>
</article>

@endsection