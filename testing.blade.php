@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Testing</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#environment">Environment</a>
        </li>
        <li><a href="#creating-and-running-tests">Creating &amp; Running Tests</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel is built with testing in mind. In fact, support for testing with PHPUnit is included out of the box and a <code class=" language-php">phpunit<span class="token punctuation">.</span>xml</code> file is already setup for your application. The framework also ships with convenient helper methods that allow you to expressively test your applications.</p>
    <p>An <code class=" language-php">ExampleTest<span class="token punctuation">.</span>php</code> file is provided in the <code class=" language-php">tests</code> directory. After installing a new Laravel application, simply run <code class=" language-php">phpunit</code> on the command line to run your tests.</p>
    <p>
        <a name="environment"></a>
    </p>
    <h2><a href="#environment">Environment</a></h2>
    <p>When running tests, Laravel will automatically set the configuration environment to <code class=" language-php">testing</code>. Laravel automatically configures the session and cache to the <code class=" language-php"><span class="token keyword">array</span></code> driver while testing, meaning no session or cache data will be persisted while testing.</p>
    <p>You are free to define other testing environment configuration values as necessary. The <code class=" language-php">testing</code> environment variables may be configured in the <code class=" language-php">phpunit<span class="token punctuation">.</span>xml</code> file, but make sure to clear your configuration cache using the <code class=" language-php">config<span class="token punctuation">:</span>clear</code> Artisan command before running your tests!</p>
    <p>
        <a name="creating-and-running-tests"></a>
    </p>
    <h2><a href="#creating-and-running-tests">Creating &amp; Running Tests</a></h2>
    <p>To create a new test case, use the <code class=" language-php">make<span class="token punctuation">:</span>test</code> Artisan command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>test UserTest</code></pre>
    <p>This command will place a new <code class=" language-php">UserTest</code> class within your <code class=" language-php">tests</code> directory. You may then define test methods as you normally would using PHPUnit. To run your tests, simply execute the <code class=" language-php">phpunit</code> command from your terminal:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>WithoutMiddleware</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseMigrations</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseTransactions</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * A basic test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertTrue<span class="token punctuation">(</span></span><span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> If you define your own <code class=" language-php">setUp</code> method within a test class, be sure to call <code class=" language-php"><span class="token scope"><span class="token keyword">parent</span><span class="token punctuation">::</span></span>setUp</code>.</p>
    </blockquote>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/testing">https://laravel.com/docs/5.3/testing</a></div>
</article>
@endsection