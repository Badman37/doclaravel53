@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Eloquent: Collections</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#available-methods">Available Methods</a>
        </li>
        <li><a href="#custom-collections">Custom Collections</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>All multi-result sets returned by Eloquent are instances of the <code class=" language-php">Illuminate\<span class="token package">Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Collection</span></code> object, including results retrieved via the <code class=" language-php">get</code> method or accessed via a relationship. The Eloquent collection object extends the Laravel <a href="/docs/5.3/collections">base collection</a>, so it naturally inherits dozens of methods used to fluently work with the underlying array of Eloquent models.</p>
    <p>Of course, all collections also serve as iterators, allowing you to loop over them as if they were simple PHP arrays:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$users</span> <span class="token keyword">as</span> <span class="token variable">$user</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">echo</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>However, collections are much more powerful than arrays and expose a variety of map / reduce operations that may be chained using an intuitive interface. For example, let's remove all inactive models and gather the first name for each remaining user:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$names</span> <span class="token operator">=</span> <span class="token variable">$users</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">reject<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">active</span> <span class="token operator">===</span> <span class="token boolean">false</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span>
<span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">map<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> While most Eloquent collection methods return a new instance of an Eloquent collection, the <code class=" language-php">pluck</code>, <code class=" language-php">keys</code>, <code class=" language-php">zip</code>, <code class=" language-php">collapse</code>, <code class=" language-php">flatten</code> and <code class=" language-php">flip</code> methods return a <a href="/docs/5.3/collections">base collection</a> instance. Likewise, if a <code class=" language-php">map</code> operation returns a collection that does not contain any Eloquent models, it will be automatically cast to a base collection.</p>
    </blockquote>
    <p>
        <a name="available-methods"></a>
    </p>
    <h2><a href="#available-methods">Available Methods</a></h2>
    <h3>The Base Collection</h3>
    <p>All Eloquent collections extend the base <a href="/docs/5.3/collections">Laravel collection</a> object; therefore, they inherit all of the powerful methods provided by the base collection class:</p>
    <style>
        #collection-method-list > p {
            column-count: 3;
            -moz-column-count: 3;
            -webkit-column-count: 3;
            column-gap: 2em;
            -moz-column-gap: 2em;
            -webkit-column-gap: 2em;
        }
        #collection-method-list a {
            display: block;
        }
    </style>
    <div id="collection-method-list">
        <p><a href="/docs/5.3/collections#method-all">all</a>
            <a href="/docs/5.3/collections#method-avg">avg</a>
            <a href="/docs/5.3/collections#method-chunk">chunk</a>
            <a href="/docs/5.3/collections#method-collapse">collapse</a>
            <a href="/docs/5.3/collections#method-combine">combine</a>
            <a href="/docs/5.3/collections#method-contains">contains</a>
            <a href="/docs/5.3/collections#method-count">count</a>
            <a href="/docs/5.3/collections#method-diff">diff</a>
            <a href="/docs/5.3/collections#method-diffkeys">diffKeys</a>
            <a href="/docs/5.3/collections#method-each">each</a>
            <a href="/docs/5.3/collections#method-every">every</a>
            <a href="/docs/5.3/collections#method-except">except</a>
            <a href="/docs/5.3/collections#method-filter">filter</a>
            <a href="/docs/5.3/collections#method-first">first</a>
            <a href="/docs/5.3/collections#method-flatmap">flatMap</a>
            <a href="/docs/5.3/collections#method-flatten">flatten</a>
            <a href="/docs/5.3/collections#method-flip">flip</a>
            <a href="/docs/5.3/collections#method-forget">forget</a>
            <a href="/docs/5.3/collections#method-forpage">forPage</a>
            <a href="/docs/5.3/collections#method-get">get</a>
            <a href="/docs/5.3/collections#method-groupby">groupBy</a>
            <a href="/docs/5.3/collections#method-has">has</a>
            <a href="/docs/5.3/collections#method-implode">implode</a>
            <a href="/docs/5.3/collections#method-intersect">intersect</a>
            <a href="/docs/5.3/collections#method-isempty">isEmpty</a>
            <a href="/docs/5.3/collections#method-keyby">keyBy</a>
            <a href="/docs/5.3/collections#method-keys">keys</a>
            <a href="/docs/5.3/collections#method-last">last</a>
            <a href="/docs/5.3/collections#method-map">map</a>
            <a href="/docs/5.3/collections#method-max">max</a>
            <a href="/docs/5.3/collections#method-merge">merge</a>
            <a href="/docs/5.3/collections#method-min">min</a>
            <a href="/docs/5.3/collections#method-only">only</a>
            <a href="/docs/5.3/collections#method-pluck">pluck</a>
            <a href="/docs/5.3/collections#method-pop">pop</a>
            <a href="/docs/5.3/collections#method-prepend">prepend</a>
            <a href="/docs/5.3/collections#method-pull">pull</a>
            <a href="/docs/5.3/collections#method-push">push</a>
            <a href="/docs/5.3/collections#method-put">put</a>
            <a href="/docs/5.3/collections#method-random">random</a>
            <a href="/docs/5.3/collections#method-reduce">reduce</a>
            <a href="/docs/5.3/collections#method-reject">reject</a>
            <a href="/docs/5.3/collections#method-reverse">reverse</a>
            <a href="/docs/5.3/collections#method-search">search</a>
            <a href="/docs/5.3/collections#method-shift">shift</a>
            <a href="/docs/5.3/collections#method-shuffle">shuffle</a>
            <a href="/docs/5.3/collections#method-slice">slice</a>
            <a href="/docs/5.3/collections#method-sort">sort</a>
            <a href="/docs/5.3/collections#method-sortby">sortBy</a>
            <a href="/docs/5.3/collections#method-sortbydesc">sortByDesc</a>
            <a href="/docs/5.3/collections#method-splice">splice</a>
            <a href="/docs/5.3/collections#method-sum">sum</a>
            <a href="/docs/5.3/collections#method-take">take</a>
            <a href="/docs/5.3/collections#method-toarray">toArray</a>
            <a href="/docs/5.3/collections#method-tojson">toJson</a>
            <a href="/docs/5.3/collections#method-transform">transform</a>
            <a href="/docs/5.3/collections#method-union">union</a>
            <a href="/docs/5.3/collections#method-unique">unique</a>
            <a href="/docs/5.3/collections#method-values">values</a>
            <a href="/docs/5.3/collections#method-where">where</a>
            <a href="/docs/5.3/collections#method-wherestrict">whereStrict</a>
            <a href="/docs/5.3/collections#method-wherein">whereIn</a>
            <a href="/docs/5.3/collections#method-whereinloose">whereInLoose</a>
            <a href="/docs/5.3/collections#method-zip">zip</a>
        </p>
    </div>
    <p>
        <a name="custom-collections"></a>
    </p>
    <h2><a href="#custom-collections">Custom Collections</a></h2>
    <p>If you need to use a custom <code class=" language-php">Collection</code> object with your own extension methods, you may override the <code class=" language-php">newCollection</code> method on your model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>CustomCollection</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">newCollection<span class="token punctuation">(</span></span><span class="token keyword">array</span> <span class="token variable">$models</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">CustomCollection</span><span class="token punctuation">(</span><span class="token variable">$models</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once you have defined a <code class=" language-php">newCollection</code> method, you will receive an instance of your custom collection anytime Eloquent returns a <code class=" language-php">Collection</code> instance of that model. If you would like to use a custom collection for every model in your application, you should override the <code class=" language-php">newCollection</code> method on a base model class that is extended by all of your models.</p>
    
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/eloquent-collections">https://laravel.com/docs/5.3/eloquent-collections</a></div>
</article>
@endsection