@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Cache</h1>
    <ul>
        <li><a href="#configuration">Configuration</a>
            <ul>
                <li><a href="#driver-prerequisites">Driver Prerequisites</a>
                </li>
            </ul>
        </li>
        <li><a href="#cache-usage">Cache Usage</a>
            <ul>
                <li><a href="#obtaining-a-cache-instance">Obtaining A Cache Instance</a>
                </li>
                <li><a href="#retrieving-items-from-the-cache">Retrieving Items From The Cache</a>
                </li>
                <li><a href="#storing-items-in-the-cache">Storing Items In The Cache</a>
                </li>
                <li><a href="#removing-items-from-the-cache">Removing Items From The Cache</a>
                </li>
                <li><a href="#the-cache-helper">The Cache Helper</a>
                </li>
            </ul>
        </li>
        <li><a href="#cache-tags">Cache Tags</a>
            <ul>
                <li><a href="#storing-tagged-cache-items">Storing Tagged Cache Items</a>
                </li>
                <li><a href="#accessing-tagged-cache-items">Accessing Tagged Cache Items</a>
                </li>
                <li><a href="#removing-tagged-cache-items">Removing Tagged Cache Items</a>
                </li>
            </ul>
        </li>
        <li><a href="#adding-custom-cache-drivers">Adding Custom Cache Drivers</a>
            <ul>
                <li><a href="#writing-the-driver">Writing The Driver</a>
                </li>
                <li><a href="#registering-the-driver">Registering The Driver</a>
                </li>
            </ul>
        </li>
        <li><a href="#events">Events</a>
        </li>
    </ul>
    <p>
        <a name="configuration"></a>
    </p>
    <h2><a href="#configuration">Configuration</a></h2>
    <p>Laravel provides an expressive, unified API for various caching backends. The cache configuration is located at <code class=" language-php">config<span class="token operator">/</span>cache<span class="token punctuation">.</span>php</code>. In this file you may specify which cache driver you would like used by default throughout your application. Laravel supports popular caching backends like <a href="http://memcached.org">Memcached</a> and <a href="http://redis.io">Redis</a> out of the box.</p>
    <p>The cache configuration file also contains various other options, which are documented within the file, so make sure to read over these options. By default, Laravel is configured to use the <code class=" language-php">file</code> cache driver, which stores the serialized, cached objects in the filesystem. For larger applications, it is recommended that you use a more robust driver such as Memcached or Redis. You may even configure multiple cache configurations for the same driver.</p>
    <p>
        <a name="driver-prerequisites"></a>
    </p>
    <h3>Driver Prerequisites</h3>
    <h4>Database</h4>
    <p>When using the <code class=" language-php">database</code> cache driver, you will need to setup a table to contain the cache items. You'll find an example <code class=" language-php">Schema</code> declaration for the table below:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Schema<span class="token punctuation">::</span></span><span class="token function">create<span class="token punctuation">(</span></span><span class="token string">'cache'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$table</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unique<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">text<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">integer<span class="token punctuation">(</span></span><span class="token string">'expiration'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> You may also use the <code class=" language-php">php artisan cache<span class="token punctuation">:</span>table</code> Artisan command to generate a migration with the proper schema.</p>
    </blockquote>
    <h4>Memcached</h4>
    <p>Using the Memcached driver requires the <a href="http://pecl.php.net/package/memcached">Memcached PECL package</a> to be installed. You may list all of your Memcached servers in the <code class=" language-php">config<span class="token operator">/</span>cache<span class="token punctuation">.</span>php</code> configuration file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'memcached'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token punctuation">[</span>
        <span class="token string">'host'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'127.0.0.1'</span><span class="token punctuation">,</span>
        <span class="token string">'port'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">11211</span><span class="token punctuation">,</span>
        <span class="token string">'weight'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>You may also set the <code class=" language-php">host</code> option to a UNIX socket path. If you do this, the <code class=" language-php">port</code> option should be set to <code class=" language-php"><span class="token number">0</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'memcached'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token punctuation">[</span>
        <span class="token string">'host'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'/var/run/memcached/memcached.sock'</span><span class="token punctuation">,</span>
        <span class="token string">'port'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">0</span><span class="token punctuation">,</span>
        <span class="token string">'weight'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <h4>Redis</h4>
    <p>Before using a Redis cache with Laravel, you will need to install the <code class=" language-php">predis<span class="token operator">/</span>predis</code> package (~1.0) via Composer.</p>
    <p>For more information on configuring Redis, consult its <a href="/docs/5.3/redis#configuration">Laravel documentation page</a>.</p>
    <p>
        <a name="cache-usage"></a>
    </p>
    <h2><a href="#cache-usage">Cache Usage</a></h2>
    <p>
        <a name="obtaining-a-cache-instance"></a>
    </p>
    <h3>Obtaining A Cache Instance</h3>
    <p>The <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Cache<span class="token punctuation">\</span>Factory</span></code> and <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Cache<span class="token punctuation">\</span>Repository</span></code> <a href="/docs/5.3/contracts">contracts</a> provide access to Laravel's cache services. The <code class=" language-php">Factory</code> contract provides access to all cache drivers defined for your application. The <code class=" language-php">Repository</code> contract is typically an implementation of the default cache driver for your application as specified by your <code class=" language-php">cache</code> configuration file.</p>
    <p>However, you may also use the <code class=" language-php">Cache</code> facade, which is what we will use throughout this documentation. The <code class=" language-php">Cache</code> facade provides convenient, terse access to the underlying implementations of the Laravel cache contracts:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Cache</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Show a list of all users of the application.
     *
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">index<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Accessing Multiple Cache Stores</h4>
    <p>Using the <code class=" language-php">Cache</code> facade, you may access various cache stores via the <code class=" language-php">store</code> method. The key passed to the <code class=" language-php">store</code> method should correspond to one of the stores listed in the <code class=" language-php">stores</code> configuration array in your <code class=" language-php">cache</code> configuration file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">store<span class="token punctuation">(</span></span><span class="token string">'file'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">store<span class="token punctuation">(</span></span><span class="token string">'redis'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'bar'</span><span class="token punctuation">,</span> <span class="token string">'baz'</span><span class="token punctuation">,</span> <span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="retrieving-items-from-the-cache"></a>
    </p>
    <h3>Retrieving Items From The Cache</h3>
    <p>The <code class=" language-php">get</code> method on the <code class=" language-php">Cache</code> facade is used to retrieve items from the cache. If the item does not exist in the cache, <code class=" language-php"><span class="token keyword">null</span></code> will be returned. If you wish, you may pass a second argument to the <code class=" language-php">get</code> method specifying the default value you wish to be returned if the item doesn't exist:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'default'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may even pass a <code class=" language-php">Closure</code> as the default value. The result of the <code class=" language-php">Closure</code> will be returned if the specified item does not exist in the cache. Passing a Closure allows you to defer the retrieval of default values from a database or other external service:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">DB<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Checking For Item Existence</h4>
    <p>The <code class=" language-php">has</code> method may be used to determine if an item exists in the cache:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">has<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Incrementing / Decrementing Values</h4>
    <p>The <code class=" language-php">increment</code> and <code class=" language-php">decrement</code> methods may be used to adjust the value of integer items in the cache. Both of these methods accept an optional second argument indicating the amount by which to increment or decrement the item's value:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">increment<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">increment<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token variable">$amount</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">decrement<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">decrement<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token variable">$amount</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Retrieve &amp; Store</h4>
    <p>Sometimes you may wish to retrieve an item from the cache, but also store a default value if the requested item doesn't exist. For example, you may wish to retrieve all users from the cache or, if they don't exist, retrieve them from the database and add them to the cache. You may do this using the <code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span>remember</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">remember<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">DB<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If the item does not exist in the cache, the <code class=" language-php">Closure</code> passed to the <code class=" language-php">remember</code> method will be executed and its result will be placed in the cache.</p>
    <h4>Retrieve &amp; Delete</h4>
    <p>If you need to retrieve an item from the cache and then delete the item, you may use the <code class=" language-php">pull</code> method. Like the <code class=" language-php">get</code> method, <code class=" language-php"><span class="token keyword">null</span></code> will be returned if the item does not exist in the cache:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">pull<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="storing-items-in-the-cache"></a>
    </p>
    <h3>Storing Items In The Cache</h3>
    <p>You may use the <code class=" language-php">put</code> method on the <code class=" language-php">Cache</code> facade to store items in the cache. When you place an item in the cache, you need to specify the number of minutes for which the value should be cached:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Instead of passing the number of minutes as an integer, you may also pass a <code class=" language-php">DateTime</code> instance representing the expiration time of the cached item:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$expiresAt</span> <span class="token operator">=</span> <span class="token scope">Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">addMinutes<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">,</span> <span class="token variable">$expiresAt</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Store If Not Present</h4>
    <p>The <code class=" language-php">add</code> method will only add the item to the cache if it does not already exist in the cache store. The method will return <code class=" language-php"><span class="token boolean">true</span></code> if the item is actually added to the cache. Otherwise, the method will return <code class=" language-php"><span class="token boolean">false</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">add<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Storing Items Forever</h4>
    <p>The <code class=" language-php">forever</code> method may be used to store an item in the cache permanently. Since these items will not expire, they must be manually removed from the cache using the <code class=" language-php">forget</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">forever<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> If you are using the Memcached driver, items that are stored "forever" may be removed when the cache reaches its size limit.</p>
    </blockquote>
    <p>
        <a name="removing-items-from-the-cache"></a>
    </p>
    <h3>Removing Items From The Cache</h3>
    <p>You may remove items from the cache using the <code class=" language-php">forget</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">forget<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may clear the entire cache using the <code class=" language-php">flush</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">flush<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Flushing the cache does not respect the cache prefix and will remove all entries from the cache. Consider this carefully when clearing a cache which is shared by other applications.</p>
    </blockquote>
    <p>
        <a name="the-cache-helper"></a>
    </p>
    <h3>The Cache Helper</h3>
    <p>In addition to using the <code class=" language-php">Cache</code> facade or <a href="/docs/5.3/contracts">cache contract</a>, you may also use the global <code class=" language-php">cache</code> function to retrieve and store data via the cache. When the <code class=" language-php">cache</code> function is called with a single, string argument, it will return the value of the given key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">cache<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you provide an array of key / value pairs and an expiration time to the function, it will store values in the cache for the specified duration:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">cache<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'value'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">cache<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'value'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token scope">Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">addSeconds<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> When testing call to the global <code class=" language-php">cache</code> function, you may use the <code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span>shouldReceive</code> method just as if you were <a href="/docs/5.3/mocking#mocking-facades">testing a facade</a>.</p>
    </blockquote>
    <p>
        <a name="cache-tags"></a>
    </p>
    <h2><a href="#cache-tags">Cache Tags</a></h2>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Cache tags are not supported when using the <code class=" language-php">file</code> or <code class=" language-php">database</code> cache drivers. Furthermore, when using multiple tags with caches that are stored "forever", performance will be best with a driver such as <code class=" language-php">memcached</code>, which automatically purges stale records.</p>
    </blockquote>
    <p>
        <a name="storing-tagged-cache-items"></a>
    </p>
    <h3>Storing Tagged Cache Items</h3>
    <p>Cache tags allow you to tag related items in the cache and then flush all cached values that have been assigned a given tag. You may access a tagged cache by passing in an ordered array of tag names. For example, let's access a tagged cache and <code class=" language-php">put</code> value in the cache:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">tags<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'people'</span><span class="token punctuation">,</span> <span class="token string">'artists'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'John'</span><span class="token punctuation">,</span> <span class="token variable">$john</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">tags<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'people'</span><span class="token punctuation">,</span> <span class="token string">'authors'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'Anne'</span><span class="token punctuation">,</span> <span class="token variable">$anne</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="accessing-tagged-cache-items"></a>
    </p>
    <h3>Accessing Tagged Cache Items</h3>
    <p>To retrieve a tagged cache item, pass the same ordered list of tags to the <code class=" language-php">tags</code> method and then call the <code class=" language-php">get</code> method with the key you wish to retrieve:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$john</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">tags<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'people'</span><span class="token punctuation">,</span> <span class="token string">'artists'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'John'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$anne</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">tags<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'people'</span><span class="token punctuation">,</span> <span class="token string">'authors'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'Anne'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="removing-tagged-cache-items"></a>
    </p>
    <h3>Removing Tagged Cache Items</h3>
    <p>You may flush all items that are assigned a tag or list of tags. For example, this statement would remove all caches tagged with either <code class=" language-php">people</code>, <code class=" language-php">authors</code>, or both. So, both <code class=" language-php">Anne</code> and <code class=" language-php">John</code> would be removed from the cache:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">tags<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'people'</span><span class="token punctuation">,</span> <span class="token string">'authors'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flush<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>In contrast, this statement would remove only caches tagged with <code class=" language-php">authors</code>, so <code class=" language-php">Anne</code> would be removed, but not <code class=" language-php">John</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">tags<span class="token punctuation">(</span></span><span class="token string">'authors'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flush<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="adding-custom-cache-drivers"></a>
    </p>
    <h2><a href="#adding-custom-cache-drivers">Adding Custom Cache Drivers</a></h2>
    <p>
        <a name="writing-the-driver"></a>
    </p>
    <h3>Writing The Driver</h3>
    <p>To create our custom cache driver, we first need to implement the <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Cache<span class="token punctuation">\</span>Store</span></code> <a href="/docs/5.3/contracts">contract</a> contract. So, a MongoDB cache implementation would look something like this:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Extensions</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Cache<span class="token punctuation">\</span>Store</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">MongoStore</span> <span class="token keyword">implements</span> <span class="token class-name">Store</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">get<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">many<span class="token punctuation">(</span></span><span class="token keyword">array</span> <span class="token variable">$keys</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">put<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">,</span> <span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">putMany<span class="token punctuation">(</span></span><span class="token keyword">array</span> <span class="token variable">$values</span><span class="token punctuation">,</span> <span class="token variable">$minutes</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">increment<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">,</span> <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token number">1</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">decrement<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">,</span> <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token number">1</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">forever<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">,</span> <span class="token variable">$value</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">forget<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">flush<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getPrefix<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">{</span><span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>We just need to implement each of these methods using a MongoDB connection. For an example of how to implement each of these methods, take a look at the <code class=" language-php">Illuminate\<span class="token package">Cache<span class="token punctuation">\</span>MemcachedStore</span></code> in the framework source code. Once our implementation is complete, we can finish our custom driver registration.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">extend<span class="token punctuation">(</span></span><span class="token string">'mongo'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">repository<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">MongoStore</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> If you're wondering where to put your custom cache driver code, you could create an <code class=" language-php">Extensions</code> namespace within your <code class=" language-php">app</code> directory. However, keep in mind that Laravel does not have a rigid application structure and you are free to organize your application according to your preferences.</p>
    </blockquote>
    <p>
        <a name="registering-the-driver"></a>
    </p>
    <h3>Registering The Driver</h3>
    <p>To register the custom cache driver with Laravel, we will use the <code class=" language-php">extend</code> method on the <code class=" language-php">Cache</code> facade. The call to <code class=" language-php"><span class="token scope">Cache<span class="token punctuation">::</span></span>extend</code> could be done in the <code class=" language-php">boot</code> method of the default <code class=" language-php">App\<span class="token package">Providers<span class="token punctuation">\</span>AppServiceProvider</span></code> that ships with fresh Laravel applications, or you may create your own service provider to house the extension - just don't forget to register the provider in the <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> provider array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Extensions<span class="token punctuation">\</span>MongoStore</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Cache</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">CacheServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Perform post-registration booting of services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">extend<span class="token punctuation">(</span></span><span class="token string">'mongo'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$app</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">repository<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">MongoStore</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Register bindings in the container.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">register<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>The first argument passed to the <code class=" language-php">extend</code> method is the name of the driver. This will correspond to your <code class=" language-php">driver</code> option in the <code class=" language-php">config<span class="token operator">/</span>cache<span class="token punctuation">.</span>php</code> configuration file. The second argument is a Closure that should return an <code class=" language-php">Illuminate\<span class="token package">Cache<span class="token punctuation">\</span>Repository</span></code> instance. The Closure will be passed an <code class=" language-php"><span class="token variable">$app</span></code> instance, which is an instance of the <a href="/docs/5.3/container">service container</a>.</p>
    <p>Once your extension is registered, simply update your <code class=" language-php">config<span class="token operator">/</span>cache<span class="token punctuation">.</span>php</code> configuration file's <code class=" language-php">driver</code> option to the name of your extension.</p>
    <p>
        <a name="events"></a>
    </p>
    <h2><a href="#events">Events</a></h2>
    <p>To execute code on every cache operation, you may listen for the <a href="/docs/5.3/events">events</a> fired by the cache. Typically, you should place these event listeners within your <code class=" language-php">EventServiceProvider</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * The event listener mappings for the application.
 *
 * @var array
 */</span>
<span class="token keyword">protected</span> <span class="token variable">$listen</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'Illuminate\Cache\Events\CacheHit'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogCacheHit'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'Illuminate\Cache\Events\CacheMissed'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogCacheMissed'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'Illuminate\Cache\Events\KeyForgotten'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogKeyForgotten'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'Illuminate\Cache\Events\KeyWritten'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogKeyWritten'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/cache">https://laravel.com/docs/5.3/cache</a></div>
</article>
@endsection