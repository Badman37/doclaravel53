@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Service Container</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#binding">Binding</a>
            <ul>
                <li><a href="#binding-basics">Cơ bản về binding</a>
                </li>
                <li><a href="#binding-interfaces-to-implementations">Binding Interfaces vào Implementations</a>
                </li>
                <li><a href="#contextual-binding">Contextual Binding</a>
                </li>
                <li><a href="#tagging">Tagging</a>
                </li>
            </ul>
        </li>
        <li><a href="#resolving">Resolving</a>
            <ul>
                <li><a href="#the-make-method">Phương thức make </a>
                </li>
                <li><a href="#automatic-injection">Tự động Injection</a>
                </li>
            </ul>
        </li>
        <li><a href="#container-events">Container Events</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Laravel service container là một công cụ rất mạnh trong việc quản lý các dependencies và thực hiện xử lý dependency injection. Dependency injection là một cụm từ thể hiện ý như này: các dependencies của class được "injected" vào trong class thông qua hàm khởi tạo hoặc trong một số trường hợp là quả các phương thức "setter".</p>
    <p>Hãy xem ví dụ đơn giản dưới đây:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Repositories<span class="token punctuation">\</span>UserRepository</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The user repository implementation.
     *
     * @var UserRepository
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

    <span class="token comment" spellcheck="true">/**
     * Show the profile for the given user.
     *
     * @param  int  $id 
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">show<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$user</span> <span class="token operator">=</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">users</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">find<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'user.profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'user'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$user</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Trong ví dụ này, cái <code class=" language-php">UserController</code> cần nhận thông tin người dùng từ source. Vì vậy, chúng ta sẽ <strong>inject</strong> vào một service có thể để nhận thông tin người dùng. Trong hoàn cảnh này, <code class=" language-php">UserRepository</code> giống như <a href="{{URL::asset('')}}docs/5.3/eloquent">Eloquent</a> để lấy lại thông tin người dùng từ cơ sở dữ liệu. Tuy nhiên, khi repository được inject, chúng ta có thể dễ dàng trao đổi chúng với thằng khác. Chúng ta cũng dễ dàng "mock", hoặc tạo một hành động giả của <code class=" language-php">UserRepository</code> khi testing.</p>
    <p>Sự hiểu biết sau về Laravel service container là rất cần thiết cho việc phát triển ứng dụng mạnh mẽ và lớn, cũng như đóng góp cho Laravel.</p>
    <p>
        <a name="binding"></a>
    </p>
    <h2><a href="#binding">Binding</a></h2>
    <p>
        <a name="binding-basics"></a>
    </p>
    <h3>Binding Basics</h3>
    <p>Hầu hết tất cả các service container binding của bạn sẽ được đăng lý trong <a href="{{URL::asset('')}}docs/5.3/providers">service providers</a>, vì vậy, trong bối cảnh này hầu hết ví dụ này sẽ chứng minh cách sử dụng container.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Không cần phải bind class vào trong container nếu nó không phụ thuộc vào bất kỳ interface nào. Container không cần được hướng dẫn để xây dựng các đối tượng, vì nó có thể tự động sử lý các đối tượng này sử dụng reflection.</p>
    </blockquote>
    <h4>Ví dụ Binding</h4>
    <p>Bên trong một service provider, bạn luôn luôn có quyền truy cập vào trong container thông qua thuộc tính <code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span></code>. Chúng ta có thể đăng kí liên kết sử dụng phương thức <code class=" language-php">bind</code>, và truyền vào tên của class hay interface mà chúng ta muốn đăng kí cùng với <code class=" language-php">Closure</code> thực hiện trả về thể hiện của class đó:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bind<span class="token punctuation">(</span></span><span class="token string">'HelpSpot\API'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">HelpSpot<span class="token punctuation">\</span>API</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token string">'HttpClient'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Chú ý là chúng ta nhận được container như một đối số truyền vào cho resolver. Sau đó thì chúng ta có thể thực hiện resolve các dependencies con của đối tượng mà đang được xây dựng.</p>
    <h4>Binding A Singleton</h4>
    <p>Phương thức <code class=" language-php">singleton</code> thực hiện liên kết một class hay interface vào container mà chỉ cần thực hiện duy nhất một lần, và sau đó cùng một đối tượng sẽ được trả về trong các lần gọi tiếp theo vào trong container.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">singleton<span class="token punctuation">(</span></span><span class="token string">'HelpSpot\API'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">HelpSpot<span class="token punctuation">\</span>API</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token string">'HttpClient'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Binding Instances</h4>
    <p>Bạn cũng có thể liên kết một instance đang tồn tại vào trong container sử dụng phương thức <code class=" language-php">instance</code>. Instance đó sẽ luôn luôn được trả về trong các lần gọi sau vào container:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$api</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">HelpSpot<span class="token punctuation">\</span>API</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">HttpClient</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">instance<span class="token punctuation">(</span></span><span class="token string">'HelpSpot\Api'</span><span class="token punctuation">,</span> <span class="token variable">$api</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Binding Primitives</h4>
    <p>Thỉnh thoảng bạn có một class nhật một vài injected class khác, nhưng cũng cần một inject giá trị nguyên thủy như một số nguyên. Bạn có thể dễ dàng sử dụng binding để inject bất kỳ giá trị nào vào trong class nếu cần:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">when<span class="token punctuation">(</span></span><span class="token string">'App\Http\Controllers\UserController'</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">needs<span class="token punctuation">(</span></span><span class="token string">'$variableName'</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">give<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="binding-interfaces-to-implementations"></a>
    </p>
    <h3>Binding Interfaces vào Implementations</h3>
    <p>Một tính năng tuyệt vởi của service container là nó có khả năng bind một interface thành một implementation. Ví dụ, giả sử chúng ta có interface <code class=" language-php">EventPusher</code> và một implementation <code class=" language-php">RedisEventPusher</code>. Khi đã có code của implementation <code class=" language-php">RedisEventPusher</code> cho interface, chúng ta có thể đăng ký nó với service container như sau:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bind<span class="token punctuation">(</span></span>
    <span class="token string">'App\Contracts\EventPusher'</span><span class="token punctuation">,</span>
    <span class="token string">'App\Services\RedisEventPusher'</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Lệnh đó sẽ bảo container luôn luôn inject <code class=" language-php">RedisEventPusher</code> khi một class nào đó cần một implementations từ interface<code class=" language-php">EventPusher</code>. Chúng ta có thể type-hint interface <code class=" language-php">EventPusher</code> interface trong một constructor, hay bất cứ vị trí nào mà dependencies có thể được inject bởi service container:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>EventPusher</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/**
 * Create a new class instance.
 *
 * @param  EventPusher  $pusher
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>EventPusher <span class="token variable">$pusher</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">pusher</span> <span class="token operator">=</span> <span class="token variable">$pusher</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="contextual-binding"></a>
    </p>
    <h3>Contextual Binding</h3>
    <p>Đôi khi bạn sẽ có hai classes triển khai từ cùng một interface nhưng bạn muốn inject các implementations khác nhau vào các class. Ví dụ, hai controllers có thể phụ thuộc vào  implementations khác nhau của  <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Filesystem<span class="token punctuation">\</span>Filesystem</span></code> <a href="{{URL::asset('')}}docs/5.3/contracts">contract</a>. Laravel cung cấp một interface đơn giản và liền mạch cho việc khai báo hành vi này:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Storage</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>PhotoController</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>VideoController</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Filesystem<span class="token punctuation">\</span>Filesystem</span><span class="token punctuation">;</span>

<span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">when<span class="token punctuation">(</span></span><span class="token scope">PhotoController<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">needs<span class="token punctuation">(</span></span><span class="token scope">Filesystem<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">give<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
              <span class="token keyword">return</span> <span class="token scope">Storage<span class="token punctuation">::</span></span><span class="token function">disk<span class="token punctuation">(</span></span><span class="token string">'local'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
          <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">when<span class="token punctuation">(</span></span><span class="token scope">VideoController<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">needs<span class="token punctuation">(</span></span><span class="token scope">Filesystem<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">give<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
              <span class="token keyword">return</span> <span class="token scope">Storage<span class="token punctuation">::</span></span><span class="token function">disk<span class="token punctuation">(</span></span><span class="token string">'s3'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
          <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="tagging"></a>
    </p>
    <h3>Tagging</h3>
    <p>Thỉnh thoảng, bạn cần giải quyết tất cả các "category" của binding. Ví dụ, bạn đang xây dụng một tập báo cáo mà sẽ nhận một mảng danh sách các implementations khác nhau của interface <code class=" language-php">Report</code>. Sau khi đăng ký <code class=" language-php">Report</code> implementations, bạn có thể gán chúng vào một tag sử dụng phương thức <code class=" language-php">tag</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bind<span class="token punctuation">(</span></span><span class="token string">'SpeedReport'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bind<span class="token punctuation">(</span></span><span class="token string">'MemoryReport'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">tag<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'SpeedReport'</span><span class="token punctuation">,</span> <span class="token string">'MemoryReport'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'reports'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Khi service đã được tag, bạn có thể dễ dàng resolve chúng qua phương thức <code class=" language-php">tagged</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bind<span class="token punctuation">(</span></span><span class="token string">'ReportAggregator'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">ReportAggregator</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">tagged<span class="token punctuation">(</span></span><span class="token string">'reports'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="resolving"></a>
    </p>
    <h2><a href="#resolving">Resolving</a></h2>
    <p>
        <a name="the-make-method"></a>
    </p>
    <h4>Phương thức <code class=" language-php">make</code></h4>
    <p>Bạn có thể sử dụng phương thức <code class=" language-php">make</code> để resolve một thể hiện class ra khỏi container. Phương thức <code class=" language-php">make</code> nhận tên class hay interface bạn muốn thực hiện resolve:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$api</span> <span class="token operator">=</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token string">'HelpSpot\API'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nếu bạn đang ở ví trị mà code của bạn không truy cập được biến <code class=" language-php"><span class="token variable">$app</span></code>, bạn có thể sử dụng helper global <code class=" language-php">resolve</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$api</span> <span class="token operator">=</span> <span class="token function">resolve<span class="token punctuation">(</span></span><span class="token string">'HelpSpot\API'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="automatic-injection"></a>
    </p>
    <h4>Tự động Injection</h4>
    <p>Ngoài ra, và cũng quang trọng, bạn có thể đơn giản "type-hint" dependency vào trong hàm constructor của class nó sẽ được resolved bởi container, gồm <a href="{{URL::asset('')}}docs/5.3/controllers">controllers</a>, <a href="{{URL::asset('')}}docs/5.3/events">event listeners</a>, <a href="{{URL::asset('')}}docs/5.3/queues">queue jobs</a>, <a href="{{URL::asset('')}}docs/5.3/middleware">middleware</a>, và còn nữa. Trong thực tế, đây là cách giải quyết đối tượng của bạn sẽ được giải quyết bởi container.</p>
    <p>Ví dụ, bạn có thể type-hint một repository được định nghĩa bởi ứng dụng trong hàm khởi tạo constructor của controller. Repository này sẽ tự động được resolv và inject vào class:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Users<span class="token punctuation">\</span>Repository</span> <span class="token keyword">as</span> UserRepository<span class="token punctuation">;</span>

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

    <span class="token comment" spellcheck="true">/**
     * Show the user with the given ID.
     *
     * @param  int  $id
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">show<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="container-events"></a>
    </p>
    <h2><a href="#container-events">Container Events</a></h2>
    <p>Service container sẽ bắn ra các event mỗi khi nó thực hiện resolves một đối tượng. Bạn có thể listen các event qua phương thức <code class=" language-php">resolving</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">resolving<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$object</span><span class="token punctuation">,</span> <span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Called when container resolves object of any type...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">resolving<span class="token punctuation">(</span></span><span class="token scope">HelpSpot<span class="token punctuation">\</span>API<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$api</span><span class="token punctuation">,</span> <span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Called when container resolves objects of type "HelpSpot\API"...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Như bạn có thể thấy, đối tượng đang được resolve sẽ truyền lại vào trong hàm callback, cho phép bạn thiết lập các thuộc tính bổ sung nào vào trong object trước khi được trả lại cho bên sử dụng nó.</p>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/container">https://laravel.com/docs/5.3/container</a></div>
</article>
@endsection