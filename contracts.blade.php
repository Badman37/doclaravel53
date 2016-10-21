@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Contracts</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
            <ul>
                <li><a href="#contracts-vs-facades">Contracts Vs. Facades</a>
                </li>
            </ul>
        </li>
        <li><a href="#when-to-use-contracts">When To Use Contracts</a>
            <ul>
                <li><a href="#loose-coupling">Loose Coupling</a>
                </li>
                <li><a href="#simplicity">Simplicity</a>
                </li>
            </ul>
        </li>
        <li><a href="#how-to-use-contracts">How To Use Contracts</a>
        </li>
        <li><a href="#contract-reference">Contract Reference</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel's Contracts are a set of interfaces that define the core services provided by the framework. For example, a <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>Queue</span></code> contract defines the methods needed for queueing jobs, while the <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Mail<span class="token punctuation">\</span>Mailer</span></code> contract defines the methods needed for sending e-mail.</p>
    <p>Each contract has a corresponding implementation provided by the framework. For example, Laravel provides a queue implementation with a variety of drivers, and a mailer implementation that is powered by <a href="http://swiftmailer.org/">SwiftMailer</a>.</p>
    <p>All of the Laravel contracts live in <a href="https://github.com/illuminate/contracts">their own GitHub repository</a>. This provides a quick reference point for all available contracts, as well as a single, decoupled package that may be utilized by package developers.</p>
    <p>
        <a name="contracts-vs-facades"></a>
    </p>
    <h3>Contracts Vs. Facades</h3>
    <p>Laravel's <a href="/docs/5.3/facades">facades</a> and helper functions provide a simple way of utilizing Laravel's services without needing to type-hint and resolve contracts out of the service container. In most cases, each facade has an equivalent contract.</p>
    <p>Unlike facades, which do not require you to require them in your class' constructor, contracts allow you to define explicit dependencies for your classes. Some developers prefer to explicitly define their dependencies in this way and therefore prefer to use contracts, while other developers enjoy the convenience of facades.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Most applications will be fine regardless of whether you prefer facades or contracts. However, if you are building a package, you should strongly consider using contracts since they will be easier to test in a package context.</p>
    </blockquote>
    <p>
        <a name="when-to-use-contracts"></a>
    </p>
    <h2><a href="#when-to-use-contracts">When To Use Contracts</a></h2>
    <p>As discussed elsewhere, much of the decision to use contracts or facades will come down to personal taste and the tastes of your development team. Both contracts and facades can be used to create robust, well-tested Laravel applications. As long as you are keeping your class' responsibilities focused, you will notice very few practical differences between using contracts and facades.</p>
    <p>However, you may still have several questions regarding contracts. For example, why use interfaces at all? Isn't using interfaces more complicated? Let's distil the reasons for using interfaces to the following headings: loose coupling and simplicity.</p>
    <p>
        <a name="loose-coupling"></a>
    </p>
    <h3>Loose Coupling</h3>
    <p>First, let's review some code that is tightly coupled to a cache implementation. Consider the following:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Orders</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Repository</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The cache instance.
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$cache</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new repository instance.
     *
     * @param  \SomePackage\Cache\Memcached  $cache
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>\<span class="token package">SomePackage<span class="token punctuation">\</span>Cache<span class="token punctuation">\</span>Memcached</span> <span class="token variable">$cache</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">cache</span> <span class="token operator">=</span> <span class="token variable">$cache</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Retrieve an Order by ID.
     *
     * @param  int  $id
     * @return Order
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">find<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">cache</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">has<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">)</span>    <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> //
</span>        <span class="token punctuation">}</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>In this class, the code is tightly coupled to a given cache implementation. It is tightly coupled because we are depending on a concrete Cache class from a package vendor. If the API of that package changes our code must change as well.</p>
    <p>Likewise, if we want to replace our underlying cache technology (Memcached) with another technology (Redis), we again will have to modify our repository. Our repository should not have so much knowledge regarding who is providing them data or how they are providing it.</p>
    <p><strong>Instead of this approach, we can improve our code by depending on a simple, vendor agnostic interface:</strong>
    </p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Orders</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Cache<span class="token punctuation">\</span>Repository</span> <span class="token keyword">as</span> Cache<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Repository</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The cache instance.
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$cache</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new repository instance.
     *
     * @param  Cache  $cache
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>Cache <span class="token variable">$cache</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">cache</span> <span class="token operator">=</span> <span class="token variable">$cache</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now the code is not coupled to any specific vendor, or even Laravel. Since the contracts package contains no implementation and no dependencies, you may easily write an alternative implementation of any given contract, allowing you to replace your cache implementation without modifying any of your cache consuming code.</p>
    <p>
        <a name="simplicity"></a>
    </p>
    <h3>Simplicity</h3>
    <p>When all of Laravel's services are neatly defined within simple interfaces, it is very easy to determine the functionality offered by a given service. <strong>The contracts serve as succinct documentation to the framework's features.</strong>
    </p>
    <p>In addition, when you depend on simple interfaces, your code is easier to understand and maintain. Rather than tracking down which methods are available to you within a large, complicated class, you can refer to a simple, clean interface.</p>
    <p>
        <a name="how-to-use-contracts"></a>
    </p>
    <h2><a href="#how-to-use-contracts">How To Use Contracts</a></h2>
    <p>So, how do you get an implementation of a contract? It's actually quite simple.</p>
    <p>Many types of classes in Laravel are resolved through the <a href="/docs/5.3/container">service container</a>, including controllers, event listeners, middleware, queued jobs, and even route Closures. So, to get an implementation of a contract, you can just "type-hint" the interface in the constructor of the class being resolved.</p>
    <p>For example, take a look at this event listener:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Listeners</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>OrderWasPlaced</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Redis<span class="token punctuation">\</span>Database</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">CacheOrderInformation</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The Redis database implementation.
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$redis</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new event handler instance.
     *
     * @param  Database  $redis
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>Database <span class="token variable">$redis</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">redis</span> <span class="token operator">=</span> <span class="token variable">$redis</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Handle the event.
     *
     * @param  OrderWasPlaced  $event
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span>OrderWasPlaced <span class="token variable">$event</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>When the event listener is resolved, the service container will read the type-hints on the constructor of the class, and inject the appropriate value. To learn more about registering things in the service container, check out <a href="/docs/5.3/container">its documentation</a>.</p>
    <p>
        <a name="contract-reference"></a>
    </p>
    <h2><a href="#contract-reference">Contract Reference</a></h2>
    <p>This table provides a quick reference to all of the Laravel contracts and their equivalent facades:</p>
    <table>
        <thead>
            <tr>
                <th>Contract</th>
                <th>References Facade</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Auth/Factory.php">Illuminate\Contracts\Auth\Factory</a>
                </td>
                <td>Auth</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Auth/PasswordBroker.php">Illuminate\Contracts\Auth\PasswordBroker</a>
                </td>
                <td>Password</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Bus/Dispatcher.php">Illuminate\Contracts\Bus\Dispatcher</a>
                </td>
                <td>Bus</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Broadcasting/Broadcaster.php">Illuminate\Contracts\Broadcasting\Broadcaster</a>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Cache/Repository.php">Illuminate\Contracts\Cache\Repository</a>
                </td>
                <td>Cache</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Cache/Factory.php">Illuminate\Contracts\Cache\Factory</a>
                </td>
                <td>Cache::driver()</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Config/Repository.php">Illuminate\Contracts\Config\Repository</a>
                </td>
                <td>Config</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Container/Container.php">Illuminate\Contracts\Container\Container</a>
                </td>
                <td>App</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Cookie/Factory.php">Illuminate\Contracts\Cookie\Factory</a>
                </td>
                <td>Cookie</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Cookie/QueueingFactory.php">Illuminate\Contracts\Cookie\QueueingFactory</a>
                </td>
                <td>Cookie::queue()</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Encryption/Encrypter.php">Illuminate\Contracts\Encryption\Encrypter</a>
                </td>
                <td>Crypt</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Events/Dispatcher.php">Illuminate\Contracts\Events\Dispatcher</a>
                </td>
                <td>Event</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Filesystem/Cloud.php">Illuminate\Contracts\Filesystem\Cloud</a>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Filesystem/Factory.php">Illuminate\Contracts\Filesystem\Factory</a>
                </td>
                <td>File</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Filesystem/Filesystem.php">Illuminate\Contracts\Filesystem\Filesystem</a>
                </td>
                <td>File</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Foundation/Application.php">Illuminate\Contracts\Foundation\Application</a>
                </td>
                <td>App</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Hashing/Hasher.php">Illuminate\Contracts\Hashing\Hasher</a>
                </td>
                <td>Hash</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Logging/Log.php">Illuminate\Contracts\Logging\Log</a>
                </td>
                <td>Log</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Mail/MailQueue.php">Illuminate\Contracts\Mail\MailQueue</a>
                </td>
                <td>Mail::queue()</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Mail/Mailer.php">Illuminate\Contracts\Mail\Mailer</a>
                </td>
                <td>Mail</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Queue/Factory.php">Illuminate\Contracts\Queue\Factory</a>
                </td>
                <td>Queue::driver()</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Queue/Queue.php">Illuminate\Contracts\Queue\Queue</a>
                </td>
                <td>Queue</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Redis/Database.php">Illuminate\Contracts\Redis\Database</a>
                </td>
                <td>Redis</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Routing/Registrar.php">Illuminate\Contracts\Routing\Registrar</a>
                </td>
                <td>Route</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Routing/ResponseFactory.php">Illuminate\Contracts\Routing\ResponseFactory</a>
                </td>
                <td>Response</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Routing/UrlGenerator.php">Illuminate\Contracts\Routing\UrlGenerator</a>
                </td>
                <td>URL</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Support/Arrayable.php">Illuminate\Contracts\Support\Arrayable</a>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Support/Jsonable.php">Illuminate\Contracts\Support\Jsonable</a>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Support/Renderable.php">Illuminate\Contracts\Support\Renderable</a>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Validation/Factory.php">Illuminate\Contracts\Validation\Factory</a>
                </td>
                <td>Validator::make()</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/Validation/Validator.php">Illuminate\Contracts\Validation\Validator</a>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/View/Factory.php">Illuminate\Contracts\View\Factory</a>
                </td>
                <td>View::make()</td>
            </tr>
            <tr>
                <td><a href="https://github.com/illuminate/contracts/blob/master/View/View.php">Illuminate\Contracts\View\View</a>
                </td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/contracts">https://laravel.com/docs/5.3/contracts</a></div>
</article>
@endsection