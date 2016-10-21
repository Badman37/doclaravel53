@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Laravel Homestead</h1>
    <ul>
        <li><a href="#introduction">Giới thiệu</a>
        </li>
        <li><a href="#installation-and-setup">Cài đặt &amp; thiết lập</a>
            <ul>
                <li><a href="#first-steps">Bước khởi tạo</a>
                </li>
                <li><a href="#configuring-homestead">Cấu hình Homestead</a>
                </li>
                <li><a href="#launching-the-vagrant-box">Khởi động Vagrant Box</a>
                </li>
                <li><a href="#per-project-installation">Cài đặt cho từng dự án</a>
                </li>
                <li><a href="#installing-mariadb">Cài đặt MariaDB</a>
                </li>
            </ul>
        </li>
        <li><a href="#daily-usage">Cách sử dụng thường xuyên</a>
            <ul>
                <li><a href="#accessing-homestead-globally">Truy cập Homestead trên toàn hệ thống</a>
                </li>
                <li><a href="#connecting-via-ssh">Kết nối qua SSH</a>
                </li>
                <li><a href="#connecting-to-databases">Kến nối với cơ sở dữ liệu</a>
                </li>
                <li><a href="#adding-additional-sites">Thêm trang bổ sung</a>
                </li>
                <li><a href="#configuring-cron-schedules">Cấu hình lịch Cron</a>
                </li>
                <li><a href="#ports">Cổng</a>
                </li>
            </ul>
        </li>
        <li><a href="#network-interfaces">Giao thức mạng</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Giới thiệu</a></h2>
    <p>Laravel cố gắng làm cho toàn bộ các kinh nghiệp phát triển PHP trở lên thú vị, bao gồm cả môi trường phát triển local của bạn. <a href="http://vagrantup.com">Vagrant</a> cung cấp đơn giản, thoải mái để quản lý máy ảo.</p>
    <p>Laravel Homestead là bản chính thức, trước khi đóng gói Vagrant box cung cấp cho bạn một môi trường tuyệt vời mà bạn không phải cài PHP, web server hay bất cứ phần mền nào khác trên môi trường local của bạn. Không phải bận tâm về hệ điều hành của bạn là gì? Vagrant boxes đã đầy đủ tất cả mọi thứ, việc bạn chỉ việc phát triển ứng dụng. Nếu có lỗi gì bạn có thể hủy và tạo lại một box chỉ trong vài phút!</p>
    <p>Homestead có thể chạy trên Windowns, Mac hay Linux, nó bao gồm cả Nginx web server, PHP 7.0, MySQL, Postgres, Redis, Memcached, Node, và tất cả những thứ khác bạn cần để phải triển ứng dụng Laravel.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Nếu bạn dùng Windowns, bạn cần bật tính năng hardware virtualization (VT-x). Nó thường được bật thông qua BIOS. Nếu bạn dùng Hyper-V trên hệ thống UEFI bạn cần phải vô hiệu hóa Hyper-V trước khi bật VT-x.</p>
    </blockquote>
    <p>
        <a name="included-software"></a>
    </p>
    <h3>Phần mền bao gồm</h3>
    <ul>
        <li>Ubuntu 16.04</li>
        <li>Git</li>
        <li>PHP 7.0</li>
        <li>Nginx</li>
        <li>MySQL</li>
        <li>MariaDB</li>
        <li>Sqlite3</li>
        <li>Postgres</li>
        <li>Composer</li>
        <li>Node (With PM2, Bower, Grunt, and Gulp)</li>
        <li>Redis</li>
        <li>Memcached</li>
        <li>Beanstalkd</li>
    </ul>
    <p>
        <a name="installation-and-setup"></a>
    </p>
    <h2><a href="#installation-and-setup">Cài đặt &amp; thiết lập</a></h2>
    <p>
        <a name="first-steps"></a>
    </p>
    <h3>Bưới khởi tạo</h3>
    <p>Trước khi chạy môi trường Homestead của bạn, bạn cần phải cài đặt <a href="https://www.virtualbox.org/wiki/Downloads">VirtualBox 5.x</a> hoặc <a href="http://www.vmware.com">VMWare</a> và <a href="http://www.vagrantup.com/downloads.html">Vagrant</a>. Tất cả những phần mền trên đều cung cấp giao diện người dùng và rất dễ cài đặt cho tất cả các hệ điều hành phổ biến.</p>
    <p>Để sử dụng VMware, bạn cần mua cả VMware Fusion / Workstation và cả <a href="http://www.vagrantup.com/vmware">VMware Vagrant plug-in</a>. Dù không miễn phí, nhưng VMware có thể cung cấp hiệu năng truy cập thư mục chia sẻ nhanh hơn.</p>
    <h4>Cài đặt Homestead Vagrant</h4>
    <p>Sai khi bạn đã cài VirtualBox / VMware and Vagrant, bạn cần thêm hộp <code class=" language-php">laravel<span class="token operator">/</span>homestead</code> bằng cách sử dụng lệnh trên terminal. Bạn sẽ mất vài phú để tải nó, phụ thuộc vào tốc độ internet của bạn nhanh hay chậm:</p>
    <pre class=" language-php"><code class=" language-php">vagrant box add laravel<span class="token operator">/</span>homestead</code></pre>
    <p>Nếu dòng lệnh bị lỗi, bạn hãy cập nhật phiên bản mới nhất Vagrant rồi chạy lại.</p>
    <h4>Cài đặt Homestead</h4>
    <p>Bạn có thể cài Homestead bằng cách clone từ kho lưu trữ về.Hãy cân nhắc sao chép vào <code class=" language-php">Homestead</code> trong thư mục "home" của bạn, như vậy thì Homestead sẽ có thể hoạt động như host cho tất cả dự án của bạn:</p>
    <pre class=" language-php"><code class=" language-php">cd <span class="token operator">~</span>

git clone https<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>github<span class="token punctuation">.</span>com<span class="token operator">/</span>laravel<span class="token operator">/</span>homestead<span class="token punctuation">.</span>git Homestead</code></pre>
    <p>Sai khi đã clone Homestead từ kho lưu trữ về, chạy lệnh <code class=" language-php">bash init<span class="token punctuation">.</span>sh</code> từ thư mục Homestead để tạo file cấu hình <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code>. File <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code> sẽ được để ẩn trong thư mục ẩn <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>homestead</code>:</p>
    <pre class=" language-php"><code class=" language-php">bash init<span class="token punctuation">.</span>sh</code></pre>
    <p>
        <a name="configuring-homestead"></a>
    </p>
    <h3>Cấu hình Homestead</h3>
    <h4>Thiệt lập provider</h4>
    <p>Từ khóa <code class=" language-php">provider</code> trong <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>homestead<span class="token operator">/</span>Homestead<span class="token punctuation">.</span>yaml</code> chỉ ra Vagrant provider nào sẽ được sử dụng: <code class=" language-php">virtualbox</code>, <code class=" language-php">vmware_fusion</code>, or <code class=" language-php">vmware_workstation</code>. Bạn có thể thiết lập provider theo ý bạn:</p>
    <pre class=" language-php"><code class=" language-php">provider<span class="token punctuation">:</span> virtualbox</code></pre>
    <h4>Cấu hình Folder chia sẻ</h4>
    <p>Thuộc tính <code class=" language-php">folders</code> trong file <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code> liệt kê tất cả các folder mà bạn muốn chia sẻ với môi trường Homestead. Nếu như file nào có trong folder này thay đổi, thì nó sẽ được đồng bộ giữa môi trường local của bạn và môi trường Homestead. ạn có cấu hình nhiều folder chia sẻ nếu cần:</p>
    <pre class=" language-php"><code class=" language-php">folders<span class="token punctuation">:</span>
    <span class="token operator">-</span> map<span class="token punctuation">:</span> <span class="token operator">~</span><span class="token operator">/</span>Code
      to<span class="token punctuation">:</span> <span class="token operator">/</span>home<span class="token operator">/</span>vagrant<span class="token operator">/</span>Code</code></pre>
    <p>Để bật <a href="http://docs.vagrantup.com/v2/synced-folders/nfs.html">NFS</a>, bạn chỉ cần thêm một cờ đơn giản vào cấu hình chia sẻ folder của bạn:</p>
    <pre class=" language-php"><code class=" language-php">folders<span class="token punctuation">:</span>
    <span class="token operator">-</span> map<span class="token punctuation">:</span> <span class="token operator">~</span><span class="token operator">/</span>Code
      to<span class="token punctuation">:</span> <span class="token operator">/</span>home<span class="token operator">/</span>vagrant<span class="token operator">/</span>Code
      type<span class="token punctuation">:</span> <span class="token string">"nfs"</span></code></pre>
    <h4>Cấu hình Nginx</h4>
    <p>j chưa dùng Nginx bao giờ! Không sao cả. Thuộc tính <code class=" language-php">sites</code> cho phép bạn dễ dàng map một "tên miền" đến một folder trong môi trường Homestead của bạn. Một ví dụ là file cấu hình <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code>. Một lần nữa, bạn có thể thêm nhiều trang vào môi trường Homestead của bạn nếu cần. Homestead có thẻ hoạt động thoải mái, ảo hóa thuận tiện cho mọi dự án Laravel bạn làm việc:</p>
    <pre class=" language-php"><code class=" language-php">sites<span class="token punctuation">:</span>
    <span class="token operator">-</span> map<span class="token punctuation">:</span> homestead<span class="token punctuation">.</span>app
      to<span class="token punctuation">:</span> <span class="token operator">/</span>home<span class="token operator">/</span>vagrant<span class="token operator">/</span>Code<span class="token operator">/</span>Laravel<span class="token operator">/</span><span class="token keyword">public</span></code></pre>
    <p>Nếu bạn thay đổi thuộc tính <code class=" language-php">sites</code> sau khi cung cấp hộp Homestead, bạn cần phải chạy lại lệnh <code class=" language-php">vagrant reload <span class="token operator">--</span>provision</code> để cập nhập lại cấu hình Nginx trên máy ảo.</p>
    <h4>File Hosts</h4>
    <p>Bạn cần thêm "tên miền" cho trang Nginx vào file <code class=" language-php">hosts</code>. File <code class=" language-php">hosts</code> sẽ chuyển hướng request của bạn đến trang Homestead sang máy chủ Homestead của bạn. Trên máy Mac và Linux, nó đặt ở <code class=" language-php"><span class="token operator">/</span>etc<span class="token operator">/</span>hosts</code>. Trên Windowns, nó đặt ở <code class=" language-php">C<span class="token punctuation">:</span>\<span class="token package">Windows<span class="token punctuation">\</span>System32<span class="token punctuation">\</span>drivers<span class="token punctuation">\</span>etc<span class="token punctuation">\</span>hosts</span></code>. Dòng bạn cần thêm vào file này sẽ có dạng bên dưới:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token number">192.168</span><span class="token punctuation">.</span><span class="token number">10.10</span>  homestead<span class="token punctuation">.</span>app</code></pre>
    <p>Bạn phải chắc chắn là địa chỉ IP được liệt kê là địa chỉ có trong file <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>homestead<span class="token operator">/</span>Homestead<span class="token punctuation">.</span>yaml</code>. Sau khi bạn đã thêm tên miền vào file <code class=" language-php">hosts</code> file và chạy hộp Vagrant, bạn sẽ có thể kết nối đến trong thông qua trình duyệt:</p>
    <pre class=" language-php"><code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>homestead<span class="token punctuation">.</span>app</code></pre>
    <p>
        <a name="launching-the-vagrant-box"></a>
    </p>
    <h3>Khởi động Vagrant Box</h3>
    <p>Sau khi bạn chỉnh sửa <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code> theo ý bạn, chạy lệnh <code class=" language-php">vagrant up</code> từ trong thư mục Homestead. Vagrant sẽ khởi động má ảo và tự động cấu hình folder chia sẻ và trang Nginx.</p>
    <p>To destroy the machine, you may use the <code class=" language-php">vagrant destroy <span class="token operator">--</span>force</code> command.</p>
    <p>
        <a name="per-project-installation"></a>
    </p>
    <h3>Cài đặt cho từng dự án</h3>
    <p>Thay vì cài đặt Homestead một cách toàn cục và chia sẻ hộp Homestead giống nhau cho tất cả dự án, bạn có thể cấu hình từng Homestead cho từng dự án. Cài đặt Homestead cho tưng dự án có lợi ích nếu bạn muốn gửi kèm <code class=" language-php">Vagrantfile</code> với dự án của bạn, cho phép người khác làm việc trên dự án đơn giản bằng lệnh <code class=" language-php">vagrant up</code>.</p>
    <p>Để cài Homestead trực tiếp vào dự án của bạn, sử dụng Composer:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> laravel<span class="token operator">/</span>homestead <span class="token operator">--</span>dev</code></pre>
    <p>Sau khi Homestead đã được cài, sử dụng lệnh <code class=" language-php">make</code> để tạo file <code class=" language-php">Vagrantfile</code> và <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code> ftrong thư mục gốc. Lệnh <code class=" language-php">make</code> sẽ tự động cấu hình <code class=" language-php">sites</code> và <code class=" language-php">folders</code> vào file <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code>.</p>
    <p>Mac / Linux:</p>
    <pre class=" language-php"><code class=" language-php">php vendor<span class="token operator">/</span>bin<span class="token operator">/</span>homestead make</code></pre>
    <p>Windows:</p>
    <pre class=" language-php"><code class=" language-php">vendor\<span class="token package"><span class="token punctuation">\</span>bin<span class="token punctuation">\</span><span class="token punctuation">\</span>homestead</span> make</code></pre>
    <p>Tiếp theo, chạy lệnh <code class=" language-php">vagrant up</code> từ terminal và truy cập vào dự án tại <code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>homestead<span class="token punctuation">.</span>app</code> bằng trình duyệt. Nhớ rằng, bạn sẽ cần phải thêm <code class=" language-php">homestead<span class="token punctuation">.</span>app</code> hoặc tên miền bạn chọn vào file <code class=" language-php"><span class="token operator">/</span>etc<span class="token operator">/</span>hosts</code>.</p>
    <p>
        <a name="installing-mariadb"></a>
    </p>
    <h3>Cài đặt MariaDB</h3>
    <p>Nếu bạn thích dùng MariaDB hơn MySQL, bạn có thể thêm tùy chọn <code class=" language-php">mariadb</code> vào file <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code>. Lựa chọn này sẽ loại bỏ MySQL và cài đặt MariaDB. MariaDB sẽ hoạt động thay cho MySQL vì vậy bạn cũng có thể dùng <code class=" language-php">mysql</code> database driver trong cấu hình cơ sở dữ liệu của bạn:</p>
    <pre class=" language-php"><code class=" language-php">box<span class="token punctuation">:</span> laravel<span class="token operator">/</span>homestead
ip<span class="token punctuation">:</span> <span class="token string">"192.168.20.20"</span>
memory<span class="token punctuation">:</span> <span class="token number">2048</span>
cpus<span class="token punctuation">:</span> <span class="token number">4</span>
provider<span class="token punctuation">:</span> virtualbox
mariadb<span class="token punctuation">:</span> <span class="token boolean">true</span></code></pre>
    <p>
        <a name="daily-usage"></a>
    </p>
    <h2><a href="#daily-usage">Cách sử dụng thường xuyên</a></h2>
    <p>
        <a name="accessing-homestead-globally"></a>
    </p>
    <h3>Truy cập Homestead trên toàn hệ thống</h3>
    <p>Thỉnh thoảng bạn muốn chạy <code class=" language-php">vagrant up</code> để khởi động máy ảo Homestead tại bất cứ đâu trong hệ thống. Bạn có thể làm điều đó bằng cách thêm hàm Bash đơn giản vào Bash profile. Hàm này sẽ cho phép bạn chạy lệnh Vagrant cở bất cứ đâu trong hệ thống và nó sẽ tự động chuyển lệnh đấy về nơi mà Homestead được cài đặt:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">function</span> <span class="token function">homestead<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token punctuation">(</span> cd <span class="token operator">~</span><span class="token operator">/</span>Homestead <span class="token operator">&amp;&amp;</span> vagrant $<span class="token operator">*</span> <span class="token punctuation">)</span>
<span class="token punctuation">}</span></code></pre>
    <p>Đảm bảo rằng bạn đã chỉnh đường dẫn <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span>Homestead</code> đúng với nơi mà bạn cài đặt Homestead. Khi đó bạn có thể chạy lệnh như <code class=" language-php">homestead up</code> hoặc <code class=" language-php">homestead ssh</code> từ bất cứ đâu trong hệ thống.</p>
    <p>
        <a name="connecting-via-ssh"></a>
    </p>
    <h3>Kết nối qua SSH</h3>
    <p>Bạn có thể kết nối SSH vào máy ảo bằng lệnh <code class=" language-php">vagrant ssh</code> từ thư mục Homestead.</p>
    <p>Tuy nhiên, nếu bạn muốn kết nối SSH đến máy ảo thường xuyên, bạn nên cân nhắc việc thêm "function" được mô tả bên trên đến máy của bạn để có thể kết nối SSH đến hộp Homestead một cách nhanh chóng.</p>
    <p>
        <a name="connecting-to-databases"></a>
    </p>
    <h3>Kết nối với cơ sở dữ liệu</h3>
    <p>Một cơ sở dữ liệu <code class=" language-php">homestead</code> đã được cấu hình sẽ cho cả MySQL và Postgres. Để thuận tiện,File <code class=" language-php"><span class="token punctuation">.</span>env</code> cấu hình của Laravel framwork có thể kết nối đến cơ sở dữ liệu.</p>
    <p>Để kết nối đến cơ sở dữ liệu MySQL hay Postgres từ môi trường local thông qua Navicat hoặc Sequel Pro, bạn nên kết nối đến địa chỉ <code class=" language-php"><span class="token number">127.0</span><span class="token punctuation">.</span><span class="token number">0.1</span></code> và cổng <code class=" language-php"><span class="token number">33060</span></code> (MySQL) or <code class=" language-php"><span class="token number">54320</span></code> (Postgres). Username và mật khẩu cho cả 2 loại cơ sở dữ liệu là <code class=" language-php">homestead</code> / <code class=" language-php">secret</code>.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Bạn chỉ nên sử dụng những cổng không chuẩn khi kết nối đến cơ sở dữ liệu từ máy của bạn. Bạn sẽ dùng những cổng mặc định 3306 và 5432 trong cấu hình cơ sở dữ lieuj cho dự án Laravel vì Laravel thường được chạy <em>trong</em> máy ảo.</p>
    </blockquote>
    <p>
        <a name="adding-additional-sites"></a>
    </p>
    <h3>Thêm trang bổ sung</h3>
    <p>Khi môi trường Homestead của bạn đã được cung cấp và hoạt động, bạn có thể thêm các trang bổ sung Nginx cho ứng dụng laravel của bạn. Bạn có thể chạy nhiều ứng dụng dụng laravel theo ý bạn trên cùng một môi trường Homestead. Để thêm một trang, bạn chỉ cần thêm vào file <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>homestead<span class="token operator">/</span>Homestead<span class="token punctuation">.</span>yaml</code> và chạy lệnh <code class=" language-php">vagrant reload <span class="token operator">--</span>provision</code> từ terminal trong thư mục Homestead.</p>
    <p>
        <a name="configuring-cron-schedules"></a>
    </p>
    <h3>Cấu hình lịch Cron</h3>
    <p>Laravel cung cấp rất thuật tiện cho việc tạo<a href="/docs/5.3/scheduling">schedule Cron jobs</a> bằng cách lên lịch một câu lệnh <code class=" language-php">schedule<span class="token punctuation">:</span>run</code> Artisan để chạy cho mỗi phút. Câu lệnh <code class=" language-php">schedule<span class="token punctuation">:</span>run</code> sẽ kiểm tra công việc đã được lên lịch được khai báo trong class <code class=" language-php">App\<span class="token package">Console<span class="token punctuation">\</span>Kernel</span></code> để quyết định xem công việc nào sẽ được thực thi.</p>
    <p>Nếu muốn lệnh <code class=" language-php">schedule<span class="token punctuation">:</span>run</code> thực thi cho trang Homestead, bạn có thể tùy chọn <code class=" language-php">schedule</code> thành <code class=" language-php"><span class="token boolean">true</span></code> khi khai báo trang:</p>
    <pre class=" language-php"><code class=" language-php">sites<span class="token punctuation">:</span>
    <span class="token operator">-</span> map<span class="token punctuation">:</span> homestead<span class="token punctuation">.</span>app
      to<span class="token punctuation">:</span> <span class="token operator">/</span>home<span class="token operator">/</span>vagrant<span class="token operator">/</span>Code<span class="token operator">/</span>Laravel<span class="token operator">/</span><span class="token keyword">public</span>
      schedule<span class="token punctuation">:</span> <span class="token boolean">true</span></code></pre>
    <p>Cron job của trang sẽ được dịnh nghĩa trong thư mục <code class=" language-php"><span class="token operator">/</span>etc<span class="token operator">/</span>cron<span class="token punctuation">.</span>d</code> của máy ảo.</p>
    <p>
        <a name="ports"></a>
    </p>
    <h3>Cổng</h3>
    <p>Mặc định, dưới đây là một số cổng cho môi trường Homestead của bạn:</p>
    <ul>
        <li><strong>SSH:</strong> 2222 → Forwards To 22</li>
        <li><strong>HTTP:</strong> 8000 → Forwards To 80</li>
        <li><strong>HTTPS:</strong> 44300 → Forwards To 443</li>
        <li><strong>MySQL:</strong> 33060 → Forwards To 3306</li>
        <li><strong>Postgres:</strong> 54320 → Forwards To 5432</li>
    </ul>
    <h4>Chuyển tiếp giữa các cổng</h4>
    <p>Nếu bạn muốn, bạn có thể chuyển tiếp các cổng bổ sung đến hộp Vagrant, miến là xác định được giao thức của chúng:</p>
    <pre class=" language-php"><code class=" language-php">ports<span class="token punctuation">:</span>
    <span class="token operator">-</span> send<span class="token punctuation">:</span> <span class="token number">93000</span>
      to<span class="token punctuation">:</span> <span class="token number">9300</span>
    <span class="token operator">-</span> send<span class="token punctuation">:</span> <span class="token number">7777</span>
      to<span class="token punctuation">:</span> <span class="token number">777</span>
      protocol<span class="token punctuation">:</span> udp</code></pre>
    <p>
        <a name="network-interfaces"></a>
    </p>
    <h2><a href="#network-interfaces">Giao thức mạng</a></h2>
    <p>Thuộc tính <code class=" language-php">networks</code> của <code class=" language-php">Homestead<span class="token punctuation">.</span>yaml</code> ccấu hình giao thức mạng cho môi trường Homestead của bạn. Bạn có thể tùy biến cấu hình nhiều giao thức theo yêu cầu:</p>
    <pre class=" language-php"><code class=" language-php">networks<span class="token punctuation">:</span>
    <span class="token operator">-</span> type<span class="token punctuation">:</span> <span class="token string">"private_network"</span>
      ip<span class="token punctuation">:</span> <span class="token string">"192.168.10.20"</span></code></pre>
    <p>Để bật giao thức <a href="https://www.vagrantup.com/docs/networking/public_network.html">bridged</a>, cấu hình cài đặt <code class=" language-php">bridge</code> và thay đổi lại của network sang <code class=" language-php">public_network</code>:</p>
    <pre class=" language-php"><code class=" language-php">networks<span class="token punctuation">:</span>
    <span class="token operator">-</span> type<span class="token punctuation">:</span> <span class="token string">"public_network"</span>
      ip<span class="token punctuation">:</span> <span class="token string">"192.168.10.20"</span>
      bridge<span class="token punctuation">:</span> <span class="token string">"en1: Wi-Fi (AirPort)"</span></code></pre>
    <p>Để bật giao thức <a href="https://www.vagrantup.com/docs/networking/public_network.html">DHCP</a>, bạn chỉ cần bỏ <code class=" language-php">ip</code> khỏi cấu hình:</p>
    <pre class=" language-php"><code class=" language-php">networks<span class="token punctuation">:</span>
    <span class="token operator">-</span> type<span class="token punctuation">:</span> <span class="token string">"public_network"</span>
      bridge<span class="token punctuation">:</span> <span class="token string">"en1: Wi-Fi (AirPort)"</span></code></pre>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/homestead">https://laravel.com/docs/5.3/homestead</a> </div>
</article>
@endsection