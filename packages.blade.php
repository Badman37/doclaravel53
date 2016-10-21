@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Package Development</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
            <ul>
                <li><a href="#a-note-on-facades">A Note On Facades</a>
                </li>
            </ul>
        </li>
        <li><a href="#service-providers">Service Providers</a>
        </li>
        <li><a href="#routing">Routing</a>
        </li>
        <li><a href="#resources">Resources</a>
            <ul>
                <li><a href="#configuration">Configuration</a>
                </li>
                <li><a href="#migrations">Migrations</a>
                </li>
                <li><a href="#translations">Translations</a>
                </li>
                <li><a href="#views">Views</a>
                </li>
            </ul>
        </li>
        <li><a href="#commands">Commands</a>
        </li>
        <li><a href="#public-assets">Public Assets</a>
        </li>
        <li><a href="#publishing-file-groups">Publishing File Groups</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Packages are the primary way of adding functionality to Laravel. Packages might be anything from a great way to work with dates like <a href="https://github.com/briannesbitt/Carbon">Carbon</a>, or an entire BDD testing framework like <a href="https://github.com/Behat/Behat">Behat</a>.</p>
    <p>Of course, there are different types of packages. Some packages are stand-alone, meaning they work with any PHP framework. Carbon and Behat are examples of stand-alone packages. Any of these packages may be used with Laravel by simply requesting them in your <code class=" language-php">composer<span class="token punctuation">.</span>json</code> file.</p>
    <p>On the other hand, other packages are specifically intended for use with Laravel. These packages may have routes, controllers, views, and configuration specifically intended to enhance a Laravel application. This guide primarily covers the development of those packages that are Laravel specific.</p>
    <p>
        <a name="a-note-on-facades"></a>
    </p>
    <h3>A Note On Facades</h3>
    <p>When writing a Laravel application, it generally does not matter if you use contracts or facades since both provide essentially equal levels of testability. However, when writing packages, it is best to use <a href="/docs/5.3/contracts">contracts</a> instead of <a href="/docs/5.3/facades">facades</a>. Since your package will not have access to all of Laravel's testing helpers, it will be easier to mock or stub a contract than to mock a facade.</p>
    <p>
        <a name="service-providers"></a>
    </p>
    <h2><a href="#service-providers">Service Providers</a></h2>
    <p><a href="/docs/5.3/providers">Service providers</a> are the connection points between your package and Laravel. A service provider is responsible for binding things into Laravel's <a href="/docs/5.3/container">service container</a> and informing Laravel where to load package resources such as views, configuration, and localization files.</p>
    <p>A service provider extends the <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>ServiceProvider</span></code> class and contains two methods: <code class=" language-php">register</code> and <code class=" language-php">boot</code>. The base <code class=" language-php">ServiceProvider</code> class is located in the <code class=" language-php">illuminate<span class="token operator">/</span>support</code> Composer package, which you should add to your own package's dependencies. To learn more about the structure and purpose of service providers, check out <a href="/docs/5.3/providers">their documentation</a>.</p>
    <p>
        <a name="routing"></a>
    </p>
    <h2><a href="#routing">Routing</a></h2>
    <p>To define routes for your package, simply <code class=" language-php"><span class="token keyword">require</span></code> the routes file from within your package service provider's <code class=" language-php">boot</code> method. From within your routes file, you may use the <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Route</span></code> facade to <a href="/docs/5.3/routing">register routes</a> just as you would within a typical Laravel application:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token operator">!</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">routesAreCached<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">require</span> <span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/../../routes.php'</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="resources"></a>
    </p>
    <h2><a href="#resources">Resources</a></h2>
    <p>
        <a name="configuration"></a>
    </p>
    <h3>Configuration</h3>
    <p>Typically, you will need to publish your package's configuration file to the application's own <code class=" language-php">config</code> directory. This will allow users of your package to easily override your default configuration options. To allow your configuration files to be published, call the <code class=" language-php">publishes</code> method from the <code class=" language-php">boot</code> method of your service provider:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">publishes<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
        <span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/config/courier.php'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">config_path<span class="token punctuation">(</span></span><span class="token string">'courier.php'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now, when users of your package execute Laravel's <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> command, your file will be copied to the specified publish location. Of course, once your configuration has been published, its values may be accessed like any other configuration file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'courier.option'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Default Package Configuration</h4>
    <p>You may also merge your own package configuration file with the application's published copy. This will allow your users to define only the options they actually want to override in the published copy of the configuration. To merge the configurations, use the <code class=" language-php">mergeConfigFrom</code> method within your service provider's <code class=" language-php">register</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Register bindings in the container.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">register<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">mergeConfigFrom<span class="token punctuation">(</span></span>
        <span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/config/courier.php'</span><span class="token punctuation">,</span> <span class="token string">'courier'</span>
    <span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="migrations"></a>
    </p>
    <h3>Migrations</h3>
    <p>If your package contains <a href="/docs/5.3/migrations">database migrations</a>, you may use the <code class=" language-php">loadMigrationsFrom</code> method to inform Laravel how to load them. The <code class=" language-php">loadMigrationsFrom</code> method accepts the path to your package's migrations as its only argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">loadMigrationsFrom<span class="token punctuation">(</span></span><span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/migrations'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once your package's migrations have been registered, they will automatically be run when the <code class=" language-php">php artisan migrate</code> command is executed. You do not need to export them to the application's main <code class=" language-php">database<span class="token operator">/</span>migrations</code> directory.</p>
    <p>
        <a name="translations"></a>
    </p>
    <h3>Translations</h3>
    <p>If your package contains <a href="/docs/5.3/localization">translation files</a>, you may use the <code class=" language-php">loadTranslationsFrom</code> method to inform Laravel how to load them. For example, if your package is named <code class=" language-php">courier</code>, you should add the following to your service provider's <code class=" language-php">boot</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">loadTranslationsFrom<span class="token punctuation">(</span></span><span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/translations'</span><span class="token punctuation">,</span> <span class="token string">'courier'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Package translations are referenced using the <code class=" language-php"><span class="token scope">package<span class="token punctuation">::</span></span>file<span class="token punctuation">.</span>line</code> syntax convention. So, you may load the <code class=" language-php">courier</code> package's <code class=" language-php">welcome</code> line from the <code class=" language-php">messages</code> file like so:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">trans<span class="token punctuation">(</span></span><span class="token string">'courier::messages.welcome'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Publishing Translations</h4>
    <p>If you would like to publish your package's translations to the application's <code class=" language-php">resources<span class="token operator">/</span>lang<span class="token operator">/</span>vendor</code> directory, you may use the service provider's <code class=" language-php">publishes</code> method. The <code class=" language-php">publishes</code> method accepts an array of package paths and their desired publish locations. For example, to publish the translation files for the <code class=" language-php">courier</code> package, you may do the following:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">loadTranslationsFrom<span class="token punctuation">(</span></span><span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/translations'</span><span class="token punctuation">,</span> <span class="token string">'courier'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">publishes<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
        <span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/translations'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">resource_path<span class="token punctuation">(</span></span><span class="token string">'lang/vendor/courier'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now, when users of your package execute Laravel's <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> Artisan command, your package's translations will be published to the specified publish location.</p>
    <p>
        <a name="views"></a>
    </p>
    <h3>Views</h3>
    <p>To register your package's <a href="/docs/5.3/views">views</a> with Laravel, you need to tell Laravel where the views are located. You may do this using the service provider's <code class=" language-php">loadViewsFrom</code> method. The <code class=" language-php">loadViewsFrom</code> method accepts two arguments: the path to your view templates and your package's name. For example, if your package's name is <code class=" language-php">courier</code>, you would add the following to your service provider's <code class=" language-php">boot</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">loadViewsFrom<span class="token punctuation">(</span></span><span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/views'</span><span class="token punctuation">,</span> <span class="token string">'courier'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Package views are referenced using the <code class=" language-php"><span class="token scope">package<span class="token punctuation">::</span></span>view</code> syntax convention. So, once your view path is registered in a service provider, you may load the <code class=" language-php">admin</code> view from the <code class=" language-php">courier</code> package like so:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'admin'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'courier::admin'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Overriding Package Views</h4>
    <p>When you use the <code class=" language-php">loadViewsFrom</code> method, Laravel actually registers two locations for your views: the application's <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>vendor</code> directory and the directory you specify. So, using the <code class=" language-php">courier</code> example, Laravel will first check if a custom version of the view has been provided by the developer in <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>vendor<span class="token operator">/</span>courier</code>. Then, if the view has not been customized, Laravel will search the package view directory you specified in your call to <code class=" language-php">loadViewsFrom</code>. This makes it easy for package users to customize / override your package's views.</p>
    <h4>Publishing Views</h4>
    <p>If you would like to make your views available for publishing to the application's <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>vendor</code> directory, you may use the service provider's <code class=" language-php">publishes</code> method. The <code class=" language-php">publishes</code> method accepts an array of package view paths and their desired publish locations:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">loadViewsFrom<span class="token punctuation">(</span></span><span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/views'</span><span class="token punctuation">,</span> <span class="token string">'courier'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">publishes<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
        <span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/views'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">resource_path<span class="token punctuation">(</span></span><span class="token string">'views/vendor/courier'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now, when users of your package execute Laravel's <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> Artisan command, your package's views will be copied to the specified publish location.</p>
    <p>
        <a name="commands"></a>
    </p>
    <h2><a href="#commands">Commands</a></h2>
    <p>To register your package's Artisan commands with Laravel, you may use the <code class=" language-php">commands</code> method. This method expects an array of command class names. Once the commands have been registered, you may execute them using the <a href="/docs/5.3/artisan">Artisan CLI</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Bootstrap the application services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">app</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">runningInConsole<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">commands<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
            <span class="token scope">FooCommand<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token scope">BarCommand<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="public-assets"></a>
    </p>
    <h2><a href="#public-assets">Public Assets</a></h2>
    <p>Your package may have assets such as JavaScript, CSS, and images. To publish these assets to the application's <code class=" language-php"><span class="token keyword">public</span></code> directory, use the service provider's <code class=" language-php">publishes</code> method. In this example, we will also add a <code class=" language-php"><span class="token keyword">public</span></code> asset group tag, which may be used to publish groups of related assets:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">publishes<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
        <span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/path/to/assets'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">public_path<span class="token punctuation">(</span></span><span class="token string">'vendor/courier'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'public'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now, when your package's users execute the <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> command, your assets will be copied to the specified publish location. Since you will typically need to overwrite the assets every time the package is updated, you may use the <code class=" language-php"><span class="token operator">--</span>force</code> flag:</p>
    <pre class=" language-php"><code class=" language-php">php artisan vendor<span class="token punctuation">:</span>publish <span class="token operator">--</span>tag<span class="token operator">=</span><span class="token keyword">public</span> <span class="token operator">--</span>force</code></pre>
    <p>
        <a name="publishing-file-groups"></a>
    </p>
    <h2><a href="#publishing-file-groups">Publishing File Groups</a></h2>
    <p>You may want to publish groups of package assets and resources separately. For instance, you might want to allow your users to publish your package's configuration files without being forced to publish your package's assets. You may do this by "tagging" them when calling the <code class=" language-php">publishes</code> method from a package's service provider. For example, let's use tags to define two publish groups in the <code class=" language-php">boot</code> method of a package service provider:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Perform post-registration booting of services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">publishes<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
        <span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/../config/package.php'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">config_path<span class="token punctuation">(</span></span><span class="token string">'package.php'</span><span class="token punctuation">)</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'config'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">publishes<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
        <span class="token constant">__DIR__</span><span class="token punctuation">.</span><span class="token string">'/../database/migrations/'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">database_path<span class="token punctuation">(</span></span><span class="token string">'migrations'</span><span class="token punctuation">)</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'migrations'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now your users may publish these groups separately by referencing their tag when executing the <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan vendor<span class="token punctuation">:</span>publish <span class="token operator">--</span>tag<span class="token operator">=</span>config</code></pre>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/packages">https://laravel.com/docs/5.3/packages</a></div>
</article>
@endsection