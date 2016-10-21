@extends('documents.laravel53.layout')

@section('content')
	<article>
            <h1>Cài đặt</h1>
            <ul>
                <li><a href="#installation">Cài đặt</a>
                    <ul>
                        <li><a href="#server-requirements">Yêu cầu server</a>
                        </li>
                        <li><a href="#installing-laravel">Cài đặt Laravel</a>
                        </li>
                        <li><a href="#configuration">Cấu hình</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <p>
                <a name="installation"></a>
            </p>
            <h2>Cài đặt</h2>
            <p>
                <a name="server-requirements"></a>
            </p>
            <h3>Yêu cầu server</h3>
            <p>Để sử dụng Laravel framework thì server của bạn cần một số yêu cầu. Tất nhiên, nếu bạn dùng <a href="#">Laravel Homestead</a> thì bạn không phải làm gì cả chỉ việc ngồi cafe và chém gió thôi. Chính vì lý do đấy nên Laravel khuyến khích bạn sử dụng Homestead cho môi trường local của bạn.</p>
            <p>Tuy nhiên, nếu bạn không sử dụng Homestead, thì server của bạn cần phải cài những một số thứ dưới đây:</p>
            <div class="content-list">
                <ul>
                    <li>PHP &gt;= 5.6.4</li>
                    <li>OpenSSL PHP Extension</li>
                    <li>PDO PHP Extension</li>
                    <li>Mbstring PHP Extension</li>
                    <li>Tokenizer PHP Extension</li>
                    <li>XML PHP Extension</li>
                </ul>
            </div>
            <p>
                <a name="installing-laravel"></a>
            </p>
            <h3>Cài đặt Laravel</h3>
            <p>Laravel sử dụng <a href="http://getcomposer.org">Composer</a> để quản lý các dependencies. Vì vậy, trước khi bắt tay vào sử dụng Laravel thì máy tính của bạn phải cài composer trước.</p>
            <h4>Sử dụng Laravel Installer</h4>
            <p>Đầu tên, bạn phải tải Laravel installer bằng cách sử dụng composer:</p>
            <pre><code>composer global require "laravel/installer"</code></pre>
            <p>Đảm bảo rằng bạn phải đặt thư mục <code>$HOME/.composer/vendor/bin</code> vào trong biến môi trường $PATH <code>laravel</code> để thằng Laravel có thể hiểu được.</p>
            <p>Sau khi cài đặt xong, bạn có thể dùng lệnh <code>laravel new</code> để tạo một project Laravel ở đâu mà bạn muốn. Ví dụ, <code>laravel new blog</code> sẽ tạo ra một project tên là <code>blog</code>, trong đó các dependencies sẽ được tạo ra bên trong project đó, việc của bạn chỉ là cafe rung đùi ngồi đợi thôi.</p>
            <pre><code>laravel new blog</code></pre>
            <h4>Sử dụng Composer Create-Project</h4>
            <p>Ngoài cách sử dụng Laravel Install, bạn có thể sử dụng Composer <code>create-project</code> trên terminal:</p>
            <pre><code>composer create-project --prefer-dist laravel/laravel blog</code></pre>
            <h4>Phát triển trên local</h4>
            <p>Nếu máy tính của bạn đã cài PHP rồi thì bạn có thể PHP's built-in để phát triển server ứng dụng của bạn bằng cách sử dụng <code>serve</code> Artisan command. Nó sẽ sinh ra phát triển một server tại địa chỉ <code>http://localhost:8000</code>:</p>
            <pre><code>php artisan serve</code></pre>
            <p>Tất nhiên, nếu bạn làm việc local bằng <a href="#">Homestead</a> và <a href="#">Valet</a> thì việc sử dụng <code>serve</code> Artisan command tất nhiên là cũng hoạt động hoàn hảo.</p>
            <p>
                <a name="configuration"></a>
            </p>
            <h3>Cấu hình</h3>
            <h4>Thư mục</h4>
            <p>Sau khi cài đặt Laravel, bạn nên cấu hình web server's gốc của bạn ở thư mục <code>public</code>. File <code>index.php</code> ở trong thư mục public có nhiệm vụ là nó sẽ điều khiển tất cả các HTTP requests cho ứng dụng của bạn.</p>
            <h4>Cấu hình Files</h4>
            <p>Tất cả các files cấu hình của Laravel framework nó sẽ được đặt trong thư mục <code>config</code>. Với mỗi file trong thư mục đó, bạn có thể chỉnh sửa cấu hình theo ý bạn muốn.</p>
            <h4>Quyền thư mục</h4>
            <p>Sau khi cài Laravel, bạn cần phải cấu hình lại quyền một số folders. Tất cả folders bên trong <code>storage</code> và <code>bootstrap/cache</code> thì thằng web server của bạn phải được phép ghi, nếu không thì Laravel sẽ không chạy. Nếu bạn sử dụng <a href="#">Homestead</a>, thì bạn không phải thực hiện bước này.</p>
            <h4>Application key</h4>
            <p>Việc tiếp theo cũng không kém phần quan trọng bạn cần làm đó là cấu hình lại application key cho ứng dụng của bạn, nó là một chuỗi string random. Nếu ứng dụng của bạn sử dụng Composer hoặc Laravel installer, thì ứng dụng của bạn đã được cấu hình sẵn bởi lệnh <code>php artisan key:generate</code>, bạn sẽ không phải thực hiện nó nữa.</p>
            <p>Thông thường, application key sẽ là một chuỗi chứa 32 ký tự. Nó có thể được cấu hình bên trong file <code>.env</code>. Nếu bạn không có file <code>.env</code> bạn cần thay đổi tên <code>.env.example</code> thành <code>.env</code>. <strong> Nếu ứng dụng của bạn chưa cấu hình application key, các user sessions và mã hóa dữ liệu khác trong ứng dụng của bạn sẽ không được an toàn!</strong>
            </p>
            <h4>Cấu hình bổ sung</h4>
            <p>Laravel hầu như không cần thêm những cấu hình khác. Vì vậy bạn không cần quan tâm đến nó nhiều, mà bạn có thể thoải mái bắt đầu phát triển ứng dụng của bạn. Tuy nhiên, bạn có thể xem lại file <code>config/app.php</code> và tài liệu của nó. Nó chưa một số thông tin như <code>timezone</code> và <code>locale</code> và bạn có thể thay đổi theo ứng dụng của bạn.</p>
            <p>Bạn có thể cấu hình thêm một số thành phần bổ sung của Laravel dưới đây:</p>
            <div class="content-list">
                <ul>
                    <li><a href="#">Cache</a>
                    </li>
                    <li><a href="#">Database</a>
                    </li>
                    <li><a href="#">Session</a>
                    </li>
                </ul>
            </div>
            <p>Khi Laravel đã được cài đặt, bạn cũng có thể tiến hành việc <a href="#">cấu hình môi trường phát triển</a>.</p>

        <div>Nguồn: <a href="https://laravel.com/docs/5.3">https://laravel.com/docs/5.3</a></div>
    </article>
@endsection