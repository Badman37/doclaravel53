@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Laravel Valet</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
            <ul>
                <li><a href="#valet-or-homestead">Valet hay Homestead</a>
                </li>
            </ul>
        </li>
        <li><a href="#installation">Cài đặt</a>
            <ul>
                <li><a href="#upgrading">Cập nhật</a>
                </li>
            </ul>
        </li>
        <li><a href="#serving-sites">Serving Sites</a>
            <ul>
                <li><a href="#the-park-command">Câu lệnh "Park"</a>
                </li>
                <li><a href="#the-link-command">Câu lệnh "Link"</a>
                </li>
                <li><a href="#securing-sites">Bảo mật Sites với TLS</a>
                </li>
            </ul>
        </li>
        <li><a href="#sharing-sites">Chia sẻ Sites</a>
        </li>
        <li><a href="#viewing-logs">Xem Logs</a>
        </li>
        <li><a href="#custom-valet-drivers">Tùy biến Valet Drivers</a>
        </li>
        <li><a href="#other-valet-commands">Các câu lệnh Valet khác</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Valet là một môi trường phát triển Laravel dành cho những developer thích tối giản giản hóa khi sử dụng Mac. Không có Vagrant, Apache, Nginx, <code class=" language-php"><span class="token operator">/</span>etc<span class="token operator">/</span>hosts</code>. Bạn chỉ có thể chia sẻ sites sử dụng local tunnels. <em>Yeah, Chúng tôi cũng thích.</em>
    </p>
    <p>Laravel Valet cấu hình máy Mac để luôn chạy <a href="https://caddyserver.com">Caddy</a> ở background khi máy khởi động. Sau đó sử dụng <a href="https://en.wikipedia.org/wiki/Dnsmasq">DnsMasq</a>, Valet proxy các request tới tên miền  <code class=" language-php"><span class="token operator">*</span><span class="token punctuation">.</span>dev</code> để trở tới sites cài đặt trên máy local của bạn.</p>
    <p>Nói cách khác, môi trường phát triển Laravel development rất nhanh mà chỉ tốn có 7MB RAM. Valet không phải là phương án thay thế hoàn toàn cho Vagrant hay Homestead, nhưng cung cấp một giải pháp hay nhất nếu bạn muốn một môi trường cơ bản, thoải mái, yêu cầu tốc độ nhanh hoặc khi sử dụng bị giới hạn về RAM.</p>
    <p>Ngoài ra, Valet còn hỗ trợ danh sách bên dưới và còn nhiều hơn nữa:</p>
    <div class="content-list">
        <ul>
            <li><a href="https://laravel.com">Laravel</a>
            </li>
            <li><a href="https://lumen.laravel.com">Lumen</a>
            </li>
            <li><a href="https://symfony.com">Symfony</a>
            </li>
            <li><a href="http://framework.zend.com">Zend</a>
            </li>
            <li><a href="http://cakephp.org">CakePHP 3</a>
            </li>
            <li><a href="https://wordpress.org">WordPress</a>
            </li>
            <li><a href="https://roots.io/bedrock">Bedrock</a>
            </li>
            <li><a href="https://craftcms.com">Craft</a>
            </li>
            <li><a href="https://statamic.com">Statamic</a>
            </li>
            <li><a href="http://jigsaw.tighten.co">Jigsaw</a>
            </li>
            <li>Static HTML</li>
        </ul>
    </div>
    <p>Tuy nhiên, bạn có thể sẽ muốn mở rộng Valet để sử dụng <a href="#custom-valet-drivers">custom drivers</a>.</p>
    <p>
        <a name="valet-or-homestead"></a>
    </p>
    <h3>Valet hay Homestead</h3>
    <p>Như bạn biết, Laravel cung cấp <a href="/docs/5.3/homestead">Homestead</a>, một môi trường phát triên local khác. Homestead và Valet khác nhau ở đối tượng sử dụng và cách tiếp cận để phát triển. Homestead cung cấp máy ảo Ubuntu hoàn toàn cấu hình Nginx tự động. Homestead là một lựa chọn tuyệt vời nếu bạn muốn một môi trường hoàn toàn ảo hóa hoặc nếu bạn đang sử dụng Windows / Linux.</p>
    <p>Valet chi hỗ trợ Mac, và yêu cầu bạn phải cài PHP và một database server trực tiếp trên môi trường local của bạn. Bạn có thể cài những thứ đó rất đơn giản bằng cách sử dụng <a href="http://brew.sh/">Homebrew</a> với vài dòng lệnh đơn giản <code class=" language-php">brew install php70</code> và <code class=" language-php">brew install mariadb</code>. Valet cung cấp môi trường local nhanh và sử dụng ít tài nguyên, vì vậy, đây là một lựa chọn tuyệt vời cho những ai chỉ cần PHP / MySQL mà không muốn một môi trường hoàn toàn ảo hóa.</p>
    <p>Cả Valet và Homestead đều rất tuyệt cho việc cấu hình môi trường phát triển. Việc bạn chọn cái nào đều tùy thuộc vào sở thích của bạn và của team của bạn.</p>
    <p>
        <a name="installation"></a>
    </p>
    <h2><a href="#installation">Cài đặt</a></h2>
    <p><strong>Valet yêu bạn phải dùng MAC và <a href="http://brew.sh/">Homebrew</a>. Trước khi cài đặt, bạn nên chắc chắn rằng MAC của bạn không có ứng dụng nào như Apache hoặc Nginx sử dụng cổng  80.</strong>
    </p>
    <div class="content-list">
        <ul>
            <li>Cài đặt hoặc cập nhật <a href="http://brew.sh/">Homebrew</a> phiên bản mới nhất bằng lệnh <code class=" language-php">brew update</code>.</li>
            <li>Cài đặt PHP 7.0 sử dụng Homebrew bằng lệnh <code class=" language-php">brew install homebrew<span class="token operator">/</span>php<span class="token operator">/</span>php70</code>.</li>
            <li>Cài đặt Valet sử dụng Composer bằng lệnh <code class=" language-php">composer <span class="token keyword">global</span> <span class="token keyword">require</span> laravel<span class="token operator">/</span>valet</code>. Đảm bảo thư mục <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>composer<span class="token operator">/</span>vendor<span class="token operator">/</span>bin</code> ở trong "PATH" của hệ điều hành.</li>
            <li>Chạy lệnh <code class=" language-php">valet install</code>. Nó sẽ cấu hình và cài đặt Valet và DnsMasq, và đăng ký Valet daemon để tự động chạy khi hệ thống khởi động lại.</li>
        </ul>
    </div>
    <p>Sai khi Valet được cài đặt, thử ping đến bất kỳ tên miền <code class=" language-php"><span class="token operator">*</span><span class="token punctuation">.</span>dev</code> ví dụ như <code class=" language-php">ping foobar<span class="token punctuation">.</span>dev</code>. Nếu Valet được cài đặt đúng bạn sẽ nhìn thấy tên miền trả về địa chỉ <code class=" language-php"><span class="token number">127.0</span><span class="token punctuation">.</span><span class="token number">0.1</span></code>.</p>
    <p>Valet sẽ tự khởi động deamon của nó mỗi khi hệ điều hành khởi động lại. Vì thế không cần thiết phải chạy <code class=" language-php">valet start</code> hoặc <code class=" language-php">valet install</code> thêm lần nào nữa sau khi Valet đã được cài đặt.</p>
    <h4>Sử dụng tên miền khác</h4>
    <p>Mặc định, Valet cung cấp project sử dụng tên miền <code class=" language-php"><span class="token punctuation">.</span>dev</code> TLD. Nếu bạn muốn sử dụng tên miền khác, bạn có thể sử dụng lệnh <code class=" language-php">valet domain tld<span class="token operator">-</span>name</code>.</p>
    <p>Ví dụ, nếu bạn muốn sử dụng tên miền dạng <code class=" language-php"><span class="token punctuation">.</span>app</code> thay vì <code class=" language-php"><span class="token punctuation">.</span>dev</code>, chạy lệnh <code class=" language-php">valet domain app</code> và Valet sẽ bắt đầu chạy project của bạn tại  <code class=" language-php"><span class="token operator">*</span><span class="token punctuation">.</span>app</code> tự động.</p>
    <h4>Cơ sở dữ liệu</h4>
    <p>Nếu bạn cần cơ sở dữ liệu, hãy cài MariaDB bằng lệnh <code class=" language-php">brew install mariadb</code> trên terminal. khi MariaDB đã được cài, bạn có thể bắt đầu sử dụng nó bằng lệnh <code class=" language-php">brew services start mariadb</code>. Bạn có thể kết nối với cơ sở dữ liệu tại <code class=" language-php"><span class="token number">127.0</span><span class="token punctuation">.</span><span class="token number">0.1</span></code> sử dụng username là <code class=" language-php">root</code> và password là một chuỗi string rỗng.</p>
    <p>
        <a name="upgrading"></a>
    </p>
    <h3>Cập nhật</h3>
    <p>Nếu bạn muốn cập nhật Valet trên con MAC của bạn, có thể sử dụng lệnh <code class=" language-php">composer <span class="token keyword">global</span> update</code> trên terminal. Sau khi cập nhật, bạn nên chạy lệnh <code class=" language-php">valet install</code> nó sẽ cập nhật lại những thông tin cấu hình cần thiết của bạn.</p>
    <p>
        <a name="serving-sites"></a>
    </p>
    <h2><a href="#serving-sites">Serving Sites</a></h2>
    <p>Khi Valet đã được cài đặt, bạn có thể sẵn sàng bắt đầu serving sites. Valet cung cấp 2 lệnh giúp bạn serve your Laravel sites của bạn: <code class=" language-php">park</code> and <code class=" language-php">link</code>.</p>
    <p>
        <a name="the-park-command"></a>
        <strong>Câu lệnh <code class=" language-php">park</code></strong>
    </p>
    <div class="content-list">
        <ul>
            <li>Tạo một thư mục mới trên MAC của bạn, ví dụ như <code class=" language-php">mkdir <span class="token operator">~</span><span class="token operator">/</span>Sites</code>. Tiếp theo, <code class=" language-php">cd <span class="token operator">~</span><span class="token operator">/</span>Sites</code> và chạy lệnh <code class=" language-php">valet park</code>. Lệnh này sẽ đăng ký thư mục làm việc hiện tại của bạn như là đường dẫn mà Valet có thể tìm kiếm cho sites.</li>
            <li>Tiếp theo, tạo mội site Laravel mới: <code class=" language-php">laravel <span class="token keyword">new</span> <span class="token class-name">blog</span></code>.</li>
            <li>Mở <code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>blog<span class="token punctuation">.</span>dev</code> bằng trình duyệt.</li>
        </ul>
    </div>
    <p><strong>Tất cả chỉ có vậy.</strong> Bây giờ, bất cứ dự án Laravel nào mà bạn tạo trong thư mục "parked" sẽ được tự động được serve theo quy tắc <code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>folder<span class="token operator">-</span>name<span class="token punctuation">.</span>dev</code>.</p>
    <p>
        <a name="the-link-command"></a>
        <strong>The <code class=" language-php">link</code> Command</strong>
    </p>
    <p>Câu lệnh <code class=" language-php">link</code> cũng có thể được sử dụng để serve sites Laravel của bạn. Câu lệnh này cũng có ích khi mà bạn chỉ muốn serve một site trong thư mục, chứ không phải toàn thư mục.</p>
    <div class="content-list">
        <ul>
            <li>Để sử dụng lệnh này,di chuyển tới một trong những dự án của bạn và chạy lệnh <code class=" language-php">valet link app<span class="token operator">-</span>name</code>. Valet sẽ tạo một symbolic link trong <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>valet<span class="token operator">/</span>Sites</code> để trỏ tới thư mục đang làm việc.</li>
            <li>Sau khi chạy lệnh <code class=" language-php">link</code>, bạn có thể truy cập trên trình duyệt tại địa chỉ <code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>app<span class="token operator">-</span>name<span class="token punctuation">.</span>dev</code>.</li>
        </ul>
    </div>
    <p>Để xem danh sách tất cả các thư mục được link, bạn dùng lệnh <code class=" language-php">valet links</code>.Bạn có thể sử dụng <code class=" language-php">valet unlink app<span class="token operator">-</span>name</code> để hủy các symbolic link.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Bạn có thể sử dụng <code class=" language-php">valet link</code> để serve cho dự án nhiều tên miền con. Để thêm một tên miền con vào dự án của bạn dùng lệnh <code class=" language-php">valet link subdomain<span class="token punctuation">.</span>app<span class="token operator">-</span>name</code> từ folder dự án.</p>
    </blockquote>
    <p>
        <a name="securing-sites"></a>
        <strong>Bảo mật Sites với TLS</strong>
    </p>
    <p>Mặc định, Valet serve các site thông qua HTTP thuần. Tuy nhiên, nếu bạn muốn serve mỗi site với mã hóa TLS sử dụng HTTP/2, thì dùng lệnh <code class=" language-php">secure</code> command. Ví dụ, nếu site của bạn được serve tại địa chỉ <code class=" language-php">laravel<span class="token punctuation">.</span>dev</code>, bạn nên chạy lệnh sau để bảo mật nó:</p>
    <pre class=" language-php"><code class=" language-php">valet secure laravel</code></pre>
    <p>Để gỡ "bảo mật" mội site và quay trở lại sử dụng HTTP, thì bạn dùng lệnh <code class=" language-php">unsecure</code>. Giống như lệnh <code class=" language-php">secure</code>, câu lệnh này nhạn tên host mà bạn muốn gỡ chế độ bảo mật:</p>
    <pre class=" language-php"><code class=" language-php">valet unsecure laravel</code></pre>
    <p>
        <a name="sharing-sites"></a>
    </p>
    <h2><a href="#sharing-sites">Chia sẻ Sites</a></h2>
    <p>Valet thậm chí có câu lệnh để bạn chia sẻ site trên máy của bạn ra ngoài. Không cần thiết phải cài đặt thêm cái gì khi mà Valet đã được cài trên máy.</p>
    <p>Để chia sẻ một site, chuyển vào thư mục site và dùng lệnh <code class=" language-php">valet share</code>. Một link công cộng URL sẽ được chèo vào clipboard và bạn có thể dán trực tiếp vào trình duyệt. Chỉ có vậy.</p>
    <p>Để dừng chia sẻ, ấn <code class=" language-php">Control <span class="token operator">+</span> C</code> để hủy tiến trình.</p>
    <p>
        <a name="viewing-logs"></a>
    </p>
    <h2><a href="#viewing-logs">Xem Logs</a></h2>
    <p>Nếu bạn muốn xem tất cả logs site của bạn trong quá trình đang chạy thì dùng lệnh <code class=" language-php">valet logs</code>. Khi có log mới thì nó sẽ được hiển thi ra ở terminal. Thật tuyệt vời đúng không! bạn không cần phải thoải terminal để xem log mà bạn sẽ được xem trực tiếp trên đấy luôn.</p>
    <p>
        <a name="custom-valet-drivers"></a>
    </p>
    <h2><a href="#custom-valet-drivers">Tùy biến Valet Drivers</a></h2>
    <p>YBạn có thể viết riêng "driver" cho Valet để các ứng dụng serve PHP chạy trên các framework hay CMS mà không được hỗ trợ sẵn bởi Valet. Khi bạn cài Valet, thư mục <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>valet<span class="token operator">/</span>Drivers</code> sẽ được tạo và chứa một file <code class=" language-php">SampleValetDriver<span class="token punctuation">.</span>php</code>. File này chứa các ví dụ minh họa cách viết một driver như thế nào. Để viết một driver chỉ yêu cần bạn triển khai ba hàm chính: <code class=" language-php">serves</code>, <code class=" language-php">isStaticFile</code>, và <code class=" language-php">frontControllerPath</code>.</p>
    <p>Tất cả hàm này đều nhật các giá trị <code class=" language-php"><span class="token variable">$sitePath</span></code>, <code class=" language-php"><span class="token variable">$siteName</span></code>, và <code class=" language-php"><span class="token variable">$uri</span></code> vào trong tham số. Tham số <code class=" language-php"><span class="token variable">$sitePath</span></code> là đường dẫn đầy đủ tới site đang được serve trên máy local của bạn, ví dụ <code class=" language-php"><span class="token operator">/</span>Users<span class="token operator">/</span>Lisa<span class="token operator">/</span>Sites<span class="token operator">/</span>my<span class="token operator">-</span>project</code>. Tham số <code class=" language-php"><span class="token variable">$siteName</span></code> là "host" / "site name" trên phần tên miền (<code class=" language-php">my<span class="token operator">-</span>project</code>). Tham số <code class=" language-php"><span class="token variable">$uri</span></code> là request URI tới site (<code class=" language-php"><span class="token operator">/</span>foo<span class="token operator">/</span>bar</code>).</p>
    <p>Khi bạn đã hoàn thiện driver cho Valet, đặt vào trong thư mục <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>valet<span class="token operator">/</span>Drivers</code> và sử dụng quy tắt đặt tên <code class=" language-php">FrameworkValetDriver<span class="token punctuation">.</span>php</code>. Ví dụ, Nếu bạn viết driver cho WordPress thì tên file phải là <code class=" language-php">WordPressValetDriver<span class="token punctuation">.</span>php</code>.</p>
    <p>Hãy cùng nhau xem một ví dụ để bạn biết cách viết một driver cho Valet như thế nào.</p>
    <h4>Hàm <code class=" language-php">serves</code></h4>
    <p>Hàm <code class=" language-php">serves</code> nên trả về <code class=" language-php"><span class="token boolean">true</span></code> nếu driver của bạn cần xử lý request đến. Ngược lại se trả về <code class=" language-php"><span class="token boolean">false</span></code>. Vì vậy, bên trong hàm này bạn nên kiểm tra xem nếu giá trị  <code class=" language-php"><span class="token variable">$sitePath</span></code> có chứa kiểu dự án mà bạn muốn serve hay không.</p>
    <p>Ví dụ, giả sử chúng ta đang viết một <code class=" language-php">WordPressValetDriver</code>. Serve của chúng ta phải có dạng như bên dưới:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Determine if the driver serves the request.
 *
 * @param  string  $sitePath
 * @param  string  $siteName
 * @param  string  $uri
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">serves<span class="token punctuation">(</span></span><span class="token variable">$sitePath</span><span class="token punctuation">,</span> <span class="token variable">$siteName</span><span class="token punctuation">,</span> <span class="token variable">$uri</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">is_dir<span class="token punctuation">(</span></span><span class="token variable">$sitePath</span><span class="token punctuation">.</span><span class="token string">'/wp-admin'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Hàm <code class=" language-php">isStaticFile</code></h4>
    <p>Hàm <code class=" language-php">isStaticFile</code>  nên kiểm tra xem request đến một file có phải là "static", ví dụ như file ảnh hoặc stylesheet. Nếu file là static, hàm sẽ trả về đường dẫn đầy đủ tới file static đó trên máy. Nếu request đến không phải là file static, hàm sẽ trả về <code class=" language-php"><span class="token boolean">false</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Determine if the incoming request is for a static file.
 *
 * @param  string  $sitePath
 * @param  string  $siteName
 * @param  string  $uri
 * @return string|false
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">isStaticFile<span class="token punctuation">(</span></span><span class="token variable">$sitePath</span><span class="token punctuation">,</span> <span class="token variable">$siteName</span><span class="token punctuation">,</span> <span class="token variable">$uri</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token function">file_exists<span class="token punctuation">(</span></span><span class="token variable">$staticFilePath</span> <span class="token operator">=</span> <span class="token variable">$sitePath</span><span class="token punctuation">.</span><span class="token string">'/public/'</span><span class="token punctuation">.</span><span class="token variable">$uri</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$staticFilePath</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">return</span> <span class="token boolean">false</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Hàm <code class=" language-php">isStaticFile</code> chỉ được gọi nếu hàm <code class=" language-php">serves</code> trả về <code class=" language-php"><span class="token boolean">true</span></code> cho request đến và request URL không phải là <code class=" language-php"><span class="token operator">/</span></code>.</p>
    </blockquote>
    <h4>Hàm <code class=" language-php">frontControllerPath</code></h4>
    <p>Hàm <code class=" language-php">frontControllerPath</code> trả về đường dẫn đầy đủ tới "front controller" của ứng dụng, ở đây sẽ là file "index.php" hoặc tương ứng:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the fully resolved path to the application's front controller.
 *
 * @param  string  $sitePath
 * @param  string  $siteName
 * @param  string  $uri
 * @return string
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">frontControllerPath<span class="token punctuation">(</span></span><span class="token variable">$sitePath</span><span class="token punctuation">,</span> <span class="token variable">$siteName</span><span class="token punctuation">,</span> <span class="token variable">$uri</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$sitePath</span><span class="token punctuation">.</span><span class="token string">'/public/index.php'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="other-valet-commands"></a>
    </p>
    <h2><a href="#other-valet-commands">Các câu lệnh Valet khác</a></h2>
    <table>
        <thead>
            <tr>
                <th>Câu lệnh</th>
                <th>Miêu tả</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code class=" language-php">valet forget</code>
                </td>
                <td>Thực thi câu lệnh này trong mội thư mục "parked" để xóa khỏi danh dách được park.</td>
            </tr>
            <tr>
                <td><code class=" language-php">valet paths</code>
                </td>
                <td>Xem tất cả đường dẫn được "parked".</td>
            </tr>
            <tr>
                <td><code class=" language-php">valet restart</code>
                </td>
                <td>Khởi động lại Valet daemon.</td>
            </tr>
            <tr>
                <td><code class=" language-php">valet start</code>
                </td>
                <td>Bắt đầu Valet daemon.</td>
            </tr>
            <tr>
                <td><code class=" language-php">valet stop</code>
                </td>
                <td>Đưng Valet daemon.</td>
            </tr>
            <tr>
                <td><code class=" language-php">valet uninstall</code>
                </td>
                <td>Gỡ bỏ Valet daemon.</td>
            </tr>
        </tbody>
    </table>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/valet">https://laravel.com/docs/5.3/valet</a>
</article>
@endsection