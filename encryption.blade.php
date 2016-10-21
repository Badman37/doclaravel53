@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Encryption</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#configuration">Configuration</a>
        </li>
        <li><a href="#using-the-encrypter">Using The Encrypter</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel's encrypter uses OpenSSL to provide AES-256 and AES-128 encryption. You are strongly encouraged to use Laravel's built-in encryption facilities and not attempt to roll your own "home grown" encryption algorithms. All of Laravel's encrypted values are signed using a message authentication code (MAC) so that their underlying value can not be modified once encrypted.</p>
    <p>
        <a name="configuration"></a>
    </p>
    <h2><a href="#configuration">Configuration</a></h2>
    <p>Before using Laravel's encrypter, you must set a <code class=" language-php">key</code> option in your <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> configuration file. You should use the <code class=" language-php">php artisan key<span class="token punctuation">:</span>generate</code> command to generate this key since this Artisan command will use PHP's secure random bytes generator to build your key. If this value is not properly set, all values encrypted by Laravel will be insecure.</p>
    <p>
        <a name="using-the-encrypter"></a>
    </p>
    <h2><a href="#using-the-encrypter">Using The Encrypter</a></h2>
    <h4>Encrypting A Value</h4>
    <p>You may encrypt a value using the <code class=" language-php">encrypt</code> helper. All encrypted values are encrypted using OpenSSL and the <code class=" language-php"><span class="token constant">AES</span><span class="token number">-256</span><span class="token operator">-</span><span class="token constant">CBC</span></code> cipher. Furthermore, all encrypted values are signed with a message authentication code (MAC) to detect any modifications to the encrypted string:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Store a secret message for the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">storeSecret<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$id</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">findOrFail<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">fill<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
            <span class="token string">'secret'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">encrypt<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">secret</span><span class="token punctuation">)</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Encrypted values are passed through <code class=" language-php">serialize</code> during encryption, which allows for encryption of objects and arrays. Thus, non-PHP clients receiving encrypted values will need to <code class=" language-php">unserialize</code> the data.</p>
    </blockquote>
    <h4>Decrypting A Value</h4>
    <p>You may decrypt values using the <code class=" language-php">decrypt</code> helper. If the value can not be properly decrypted, such as when the MAC is invalid, an <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Encryption<span class="token punctuation">\</span>DecryptException</span></code> will be thrown:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Encryption<span class="token punctuation">\</span>DecryptException</span><span class="token punctuation">;</span>

<span class="token keyword">try</span> <span class="token punctuation">{</span>
    <span class="token variable">$decrypted</span> <span class="token operator">=</span> <span class="token function">decrypt<span class="token punctuation">(</span></span><span class="token variable">$encryptedValue</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span> <span class="token keyword">catch</span> <span class="token punctuation">(</span><span class="token class-name">DecryptException</span> <span class="token variable">$e</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/encryption">https://laravel.com/docs/5.3/encryption</a></div>
</article>
@endsection