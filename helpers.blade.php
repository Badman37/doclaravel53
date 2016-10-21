@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Helper Functions</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#available-methods">Available Methods</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel includes a variety of global "helper" PHP functions. Many of these functions are used by the framework itself; however, you are free to use them in your own applications if you find them convenient.</p>
    <p>
        <a name="available-methods"></a>
    </p>
    <h2><a href="#available-methods">Available Methods</a></h2>
    <style>
        .collection-method-list > p {
            column-count: 3;
            -moz-column-count: 3;
            -webkit-column-count: 3;
            column-gap: 2em;
            -moz-column-gap: 2em;
            -webkit-column-gap: 2em;
        }
        .collection-method-list a {
            display: block;
        }
    </style>
    <h3>Arrays</h3>
    <div class="collection-method-list">
        <p><a href="#method-array-add">array_add</a>
            <a href="#method-array-collapse">array_collapse</a>
            <a href="#method-array-divide">array_divide</a>
            <a href="#method-array-dot">array_dot</a>
            <a href="#method-array-except">array_except</a>
            <a href="#method-array-first">array_first</a>
            <a href="#method-array-flatten">array_flatten</a>
            <a href="#method-array-forget">array_forget</a>
            <a href="#method-array-get">array_get</a>
            <a href="#method-array-has">array_has</a>
            <a href="#method-array-last">array_last</a>
            <a href="#method-array-only">array_only</a>
            <a href="#method-array-pluck">array_pluck</a>
            <a href="#method-array-prepend">array_prepend</a>
            <a href="#method-array-pull">array_pull</a>
            <a href="#method-array-set">array_set</a>
            <a href="#method-array-sort">array_sort</a>
            <a href="#method-array-sort-recursive">array_sort_recursive</a>
            <a href="#method-array-where">array_where</a>
            <a href="#method-head">head</a>
            <a href="#method-last">last</a>
        </p>
    </div>
    <h3>Paths</h3>
    <div class="collection-method-list">
        <p><a href="#method-app-path">app_path</a>
            <a href="#method-base-path">base_path</a>
            <a href="#method-config-path">config_path</a>
            <a href="#method-database-path">database_path</a>
            <a href="#method-elixir">elixir</a>
            <a href="#method-public-path">public_path</a>
            <a href="#method-resource-path">resource_path</a>
            <a href="#method-storage-path">storage_path</a>
        </p>
    </div>
    <h3>Strings</h3>
    <div class="collection-method-list">
        <p><a href="#method-camel-case">camel_case</a>
            <a href="#method-class-basename">class_basename</a>
            <a href="#method-e">e</a>
            <a href="#method-ends-with">ends_with</a>
            <a href="#method-snake-case">snake_case</a>
            <a href="#method-str-limit">str_limit</a>
            <a href="#method-starts-with">starts_with</a>
            <a href="#method-str-contains">str_contains</a>
            <a href="#method-str-finish">str_finish</a>
            <a href="#method-str-is">str_is</a>
            <a href="#method-str-plural">str_plural</a>
            <a href="#method-str-random">str_random</a>
            <a href="#method-str-singular">str_singular</a>
            <a href="#method-str-slug">str_slug</a>
            <a href="#method-studly-case">studly_case</a>
            <a href="#method-title-case">title_case</a>
            <a href="#method-trans">trans</a>
            <a href="#method-trans-choice">trans_choice</a>
        </p>
    </div>
    <h3>URLs</h3>
    <div class="collection-method-list">
        <p><a href="#method-action">action</a>
            <a href="#method-asset">asset</a>
            <a href="#method-secure-asset">secure_asset</a>
            <a href="#method-route">route</a>
            <a href="#method-url">url</a>
        </p>
    </div>
    <h3>Miscellaneous</h3>
    <div class="collection-method-list">
        <p><a href="#method-abort">abort</a>
            <a href="#method-abort-if">abort_if</a>
            <a href="#method-abort-unless">abort_unless</a>
            <a href="#method-auth">auth</a>
            <a href="#method-back">back</a>
            <a href="#method-bcrypt">bcrypt</a>
            <a href="#method-cache">cache</a>
            <a href="#method-collect">collect</a>
            <a href="#method-config">config</a>
            <a href="#method-csrf-field">csrf_field</a>
            <a href="#method-csrf-token">csrf_token</a>
            <a href="#method-dd">dd</a>
            <a href="#method-dispatch">dispatch</a>
            <a href="#method-env">env</a>
            <a href="#method-event">event</a>
            <a href="#method-factory">factory</a>
            <a href="#method-info">info</a>
            <a href="#method-logger">logger</a>
            <a href="#method-method-field">method_field</a>
            <a href="#method-old">old</a>
            <a href="#method-redirect">redirect</a>
            <a href="#method-request">request</a>
            <a href="#method-response">response</a>
            <a href="#method-session">session</a>
            <a href="#method-value">value</a>
            <a href="#method-view">view</a>
        </p>
    </div>
    <p>
        <a name="method-listing"></a>
    </p>
    <h2><a href="#method-listing">Method Listing</a></h2>
    <style>
        #collection-method code {
            font-size: 14px;
        }
        #collection-method:not(.first-collection-method) {
            margin-top: 50px;
        }
    </style>
    <p>
        <a name="arrays"></a>
    </p>
    <h2><a href="#arrays">Arrays</a></h2>
    <p>
        <a name="method-array-add"></a>
    </p>
    <h4 id="collection-method" class="first-collection-method"><code class=" language-php"><span class="token function">array_add<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_add</code> function adds a given key / value pair to the array if the given key doesn't already exist in the array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_add<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'price'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['name' =&gt; 'Desk', 'price' =&gt; 100]</span></code></pre>
    <p>
        <a name="method-array-collapse"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_collapse<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_collapse</code> function collapses an array of arrays into a single array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_collapse<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">,</span> <span class="token number">6</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token number">7</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">,</span> <span class="token number">9</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 3, 4, 5, 6, 7, 8, 9]</span></code></pre>
    <p>
        <a name="method-array-divide"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_divide<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_divide</code> function returns two arrays, one containing the keys, and the other containing the values of the original array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">list<span class="token punctuation">(</span></span><span class="token variable">$keys</span><span class="token punctuation">,</span> <span class="token variable">$values</span><span class="token punctuation">)</span> <span class="token operator">=</span> <span class="token function">array_divide<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// $keys: ['name']
</span><span class="token comment" spellcheck="true">
// $values: ['Desk']</span></code></pre>
    <p>
        <a name="method-array-dot"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_dot<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_dot</code> function flattens a multi-dimensional array into a single level array that uses "dot" notation to indicate depth:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_dot<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'foo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'bar'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'baz'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['foo.bar' =&gt; 'baz'];</span></code></pre>
    <p>
        <a name="method-array-except"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_except<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_except</code> function removes the given key / value pairs from the array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_except<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'price'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['name' =&gt; 'Desk']</span></code></pre>
    <p>
        <a name="method-array-first"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_first<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_first</code> function returns the first element of an array passing a given truth test:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token number">100</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">,</span> <span class="token number">300</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">array_first<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">&gt;=</span> <span class="token number">150</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 200</span></code></pre>
    <p>A default value may also be passed as the third parameter to the method. This value will be returned if no value passes the truth test:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">array_first<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token variable">$callback</span><span class="token punctuation">,</span> <span class="token variable">$default</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-array-flatten"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_flatten<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_flatten</code> function will flatten a multi-dimensional array into a single level.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Joe'</span><span class="token punctuation">,</span> <span class="token string">'languages'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'PHP'</span><span class="token punctuation">,</span> <span class="token string">'Ruby'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_flatten<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['Joe', 'PHP', 'Ruby'];</span></code></pre>
    <p>
        <a name="method-array-forget"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_forget<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_forget</code> function removes a given key / value pair from a deeply nested array using "dot" notation:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'products'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'desk'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token function">array_forget<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'products.desk'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['products' =&gt; []]</span></code></pre>
    <p>
        <a name="method-array-get"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_get<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_get</code> function retrieves a value from a deeply nested array using "dot" notation:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'products'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'desk'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">array_get<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'products.desk'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['price' =&gt; 100]</span></code></pre>
    <p>The <code class=" language-php">array_get</code> function also accepts a default value, which will be returned if the specific key is not found:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">array_get<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'names.john'</span><span class="token punctuation">,</span> <span class="token string">'default'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-array-has"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_has<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_has</code> function checks that a given item or items exists in an array using "dot" notation:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$hasItem</span> <span class="token operator">=</span> <span class="token function">array_has<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'product.name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// true
</span>
<span class="token variable">$hasItems</span> <span class="token operator">=</span> <span class="token function">array_has<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'product.price'</span><span class="token punctuation">,</span> <span class="token string">'product.discount'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// false</span></code></pre>
    <p>
        <a name="method-array-last"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_last<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_last</code> function returns the last element of an array passing a given truth test:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token number">100</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">,</span> <span class="token number">300</span><span class="token punctuation">,</span> <span class="token number">110</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">array_last<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">&gt;=</span> <span class="token number">150</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 300</span></code></pre>
    <p>
        <a name="method-array-only"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_only<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_only</code> function will return only the specified key / value pairs from the given array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">,</span> <span class="token string">'orders'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">10</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_only<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'price'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['name' =&gt; 'Desk', 'price' =&gt; 100]</span></code></pre>
    <p>
        <a name="method-array-pluck"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_pluck<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_pluck</code> function will pluck a list of the given key / value pairs from the array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'developer'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Taylor'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'developer'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Abigail'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_pluck<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'developer.name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['Taylor', 'Abigail'];</span></code></pre>
    <p>You may also specify how you wish the resulting list to be keyed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_pluck<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'developer.name'</span><span class="token punctuation">,</span> <span class="token string">'developer.id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1 =&gt; 'Taylor', 2 =&gt; 'Abigail'];</span></code></pre>
    <p>
        <a name="method-array-prepend"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_prepend<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_prepend</code> function will push an item onto the beginning of an array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'one'</span><span class="token punctuation">,</span> <span class="token string">'two'</span><span class="token punctuation">,</span> <span class="token string">'three'</span><span class="token punctuation">,</span> <span class="token string">'four'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_prepend<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'zero'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// $array: ['zero', 'one', 'two', 'three', 'four']</span></code></pre>
    <p>
        <a name="method-array-pull"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_pull<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_pull</code> function returns and removes a key / value pair from the array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$name</span> <span class="token operator">=</span> <span class="token function">array_pull<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// $name: Desk
</span><span class="token comment" spellcheck="true">
// $array: ['price' =&gt; 100]</span></code></pre>
    <p>
        <a name="method-array-set"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_set<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_set</code> function sets a value within a deeply nested array using "dot" notation:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'products'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'desk'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token function">array_set<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token string">'products.desk.price'</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['products' =&gt; ['desk' =&gt; ['price' =&gt; 200]]]</span></code></pre>
    <p>
        <a name="method-array-sort"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_sort<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_sort</code> function sorts the array by the results of the given Closure:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_values<span class="token punctuation">(</span></span><span class="token function">array_sort<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span><span class="token punctuation">[</span><span class="token string">'name'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        ['name' =&gt; 'Chair'],
        ['name' =&gt; 'Desk'],
    ]
*/</span></code></pre>
    <p>
        <a name="method-array-sort-recursive"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_sort_recursive<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_sort_recursive</code> function recursively sorts the array using the <code class=" language-php">sort</code> function:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token punctuation">[</span>
        <span class="token string">'Roman'</span><span class="token punctuation">,</span>
        <span class="token string">'Taylor'</span><span class="token punctuation">,</span>
        <span class="token string">'Li'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span>
        <span class="token string">'PHP'</span><span class="token punctuation">,</span>
        <span class="token string">'Ruby'</span><span class="token punctuation">,</span>
        <span class="token string">'JavaScript'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_sort_recursive<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        [
            'Li',
            'Roman',
            'Taylor',
        ],
        [
            'JavaScript',
            'PHP',
            'Ruby',
        ]
    ];
*/</span></code></pre>
    <p>
        <a name="method-array-where"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">array_where<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">array_where</code> function filters the array using the given Closure:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token number">100</span><span class="token punctuation">,</span> <span class="token string">'200'</span><span class="token punctuation">,</span> <span class="token number">300</span><span class="token punctuation">,</span> <span class="token string">'400'</span><span class="token punctuation">,</span> <span class="token number">500</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$array</span> <span class="token operator">=</span> <span class="token function">array_where<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">is_string<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1 =&gt; 200, 3 =&gt; 400]</span></code></pre>
    <p>
        <a name="method-head"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">head<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">head</code> function simply returns the first element in the given array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token number">100</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">,</span> <span class="token number">300</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$first</span> <span class="token operator">=</span> <span class="token function">head<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 100</span></code></pre>
    <p>
        <a name="method-last"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">last<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">last</code> function returns the last element in the given array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$array</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token number">100</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">,</span> <span class="token number">300</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$last</span> <span class="token operator">=</span> <span class="token function">last<span class="token punctuation">(</span></span><span class="token variable">$array</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 300</span></code></pre>
    <p>
        <a name="paths"></a>
    </p>
    <h2><a href="#paths">Paths</a></h2>
    <p>
        <a name="method-app-path"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">app_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">app_path</code> function returns the fully qualified path to the <code class=" language-php">app</code> directory. You may also use the <code class=" language-php">app_path</code> function to generate a fully qualified path to a file relative to the application directory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">app_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">app_path<span class="token punctuation">(</span></span><span class="token string">'Http/Controllers/Controller.php'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-base-path"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">base_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">base_path</code> function returns the fully qualified path to the project root. You may also use the <code class=" language-php">base_path</code> function to generate a fully qualified path to a given file relative to the application directory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">base_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">base_path<span class="token punctuation">(</span></span><span class="token string">'vendor/bin'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-config-path"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">config_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">config_path</code> function returns the fully qualified path to the application configuration directory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">config_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-database-path"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">database_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">database_path</code> function returns the fully qualified path to the application's database directory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">database_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-elixir"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">elixir<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">elixir</code> function gets the path to a <a href="/docs/5.3/elixir">versioned Elixir file</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">elixir<span class="token punctuation">(</span></span><span class="token variable">$file</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-public-path"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">public_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">public_path</code> function returns the fully qualified path to the <code class=" language-php"><span class="token keyword">public</span></code> directory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">public_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-resource-path"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">resource_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">resource_path</code> function returns the fully qualified path to the <code class=" language-php">resources</code> directory. You may also use the <code class=" language-php">resource_path</code> function to generate a fully qualified path to a given file relative to the storage directory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">resource_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">resource_path<span class="token punctuation">(</span></span><span class="token string">'assets/sass/app.scss'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-storage-path"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">storage_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">storage_path</code> function returns the fully qualified path to the <code class=" language-php">storage</code> directory. You may also use the <code class=" language-php">storage_path</code> function to generate a fully qualified path to a given file relative to the storage directory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">storage_path<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$path</span> <span class="token operator">=</span> <span class="token function">storage_path<span class="token punctuation">(</span></span><span class="token string">'app/file.txt'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="strings"></a>
    </p>
    <h2><a href="#strings">Strings</a></h2>
    <p>
        <a name="method-camel-case"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">camel_case<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">camel_case</code> function converts the given string to <code class=" language-php">camelCase</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$camel</span> <span class="token operator">=</span> <span class="token function">camel_case<span class="token punctuation">(</span></span><span class="token string">'foo_bar'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// fooBar</span></code></pre>
    <p>
        <a name="method-class-basename"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">class_basename<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">class_basename</code> returns the class name of the given class with the class' namespace removed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$class</span> <span class="token operator">=</span> <span class="token function">class_basename<span class="token punctuation">(</span></span><span class="token string">'Foo\Bar\Baz'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Baz</span></code></pre>
    <p>
        <a name="method-e"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">e<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">e</code> function runs <code class=" language-php">htmlentities</code> over the given string:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">e<span class="token punctuation">(</span></span>'<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>html</span><span class="token punctuation">&gt;</span></span></span>foo<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>html</span><span class="token punctuation">&gt;</span></span></span>'<span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// &amp;lt;html&amp;gt;foo&amp;lt;/html&amp;gt;</span></code></pre>
    <p>
        <a name="method-ends-with"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">ends_with<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">ends_with</code> function determines if the given string ends with the given value:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">ends_with<span class="token punctuation">(</span></span><span class="token string">'This is my name'</span><span class="token punctuation">,</span> <span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// true</span></code></pre>
    <p>
        <a name="method-snake-case"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">snake_case<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">snake_case</code> function converts the given string to <code class=" language-php">snake_case</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$snake</span> <span class="token operator">=</span> <span class="token function">snake_case<span class="token punctuation">(</span></span><span class="token string">'fooBar'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// foo_bar</span></code></pre>
    <p>
        <a name="method-str-limit"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">str_limit<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">str_limit</code> function limits the number of characters in a string. The function accepts a string as its first argument and the maximum number of resulting characters as its second argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">str_limit<span class="token punctuation">(</span></span><span class="token string">'The PHP framework for web artisans.'</span><span class="token punctuation">,</span> <span class="token number">7</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// The PHP...</span></code></pre>
    <p>
        <a name="method-starts-with"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">starts_with<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">starts_with</code> function determines if the given string begins with the given value:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">starts_with<span class="token punctuation">(</span></span><span class="token string">'This is my name'</span><span class="token punctuation">,</span> <span class="token string">'This'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// true</span></code></pre>
    <p>
        <a name="method-str-contains"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">str_contains<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">str_contains</code> function determines if the given string contains the given value:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">str_contains<span class="token punctuation">(</span></span><span class="token string">'This is my name'</span><span class="token punctuation">,</span> <span class="token string">'my'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// true</span></code></pre>
    <p>You may also pass an array of values to determine if the given string contains any of the values:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">str_contains<span class="token punctuation">(</span></span><span class="token string">'This is my name'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'my'</span><span class="token punctuation">,</span> <span class="token string">'foo'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// true</span></code></pre>
    <p>
        <a name="method-str-finish"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">str_finish<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">str_finish</code> function adds a single instance of the given value to a string:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$string</span> <span class="token operator">=</span> <span class="token function">str_finish<span class="token punctuation">(</span></span><span class="token string">'this/string'</span><span class="token punctuation">,</span> <span class="token string">'/'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// this/string/</span></code></pre>
    <p>
        <a name="method-str-is"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">str_is<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">str_is</code> function determines if a given string matches a given pattern. Asterisks may be used to indicate wildcards:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">str_is<span class="token punctuation">(</span></span><span class="token string">'foo*'</span><span class="token punctuation">,</span> <span class="token string">'foobar'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// true
</span>
<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">str_is<span class="token punctuation">(</span></span><span class="token string">'baz*'</span><span class="token punctuation">,</span> <span class="token string">'foobar'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// false</span></code></pre>
    <p>
        <a name="method-str-plural"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">str_plural<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">str_plural</code> function converts a string to its plural form. This function currently only supports the English language:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$plural</span> <span class="token operator">=</span> <span class="token function">str_plural<span class="token punctuation">(</span></span><span class="token string">'car'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// cars
</span>
<span class="token variable">$plural</span> <span class="token operator">=</span> <span class="token function">str_plural<span class="token punctuation">(</span></span><span class="token string">'child'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// children</span></code></pre>
    <p>You may provide an integer as a second argument to the function to retrieve the singular or plural form of the string:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$plural</span> <span class="token operator">=</span> <span class="token function">str_plural<span class="token punctuation">(</span></span><span class="token string">'child'</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// children
</span>
<span class="token variable">$plural</span> <span class="token operator">=</span> <span class="token function">str_plural<span class="token punctuation">(</span></span><span class="token string">'child'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// child</span></code></pre>
    <p>
        <a name="method-str-random"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">str_random<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">str_random</code> function generates a random string of the specified length. This function uses PHP's <code class=" language-php">random_bytes</code> function:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$string</span> <span class="token operator">=</span> <span class="token function">str_random<span class="token punctuation">(</span></span><span class="token number">40</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-str-singular"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">str_singular<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">str_singular</code> function converts a string to its singular form. This function currently only supports the English language:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$singular</span> <span class="token operator">=</span> <span class="token function">str_singular<span class="token punctuation">(</span></span><span class="token string">'cars'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// car</span></code></pre>
    <p>
        <a name="method-str-slug"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">str_slug<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">str_slug</code> function generates a URL friendly "slug" from the given string:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$title</span> <span class="token operator">=</span> <span class="token function">str_slug<span class="token punctuation">(</span></span><span class="token string">'Laravel 5 Framework'</span><span class="token punctuation">,</span> <span class="token string">'-'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// laravel-5-framework</span></code></pre>
    <p>
        <a name="method-studly-case"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">studly_case<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">studly_case</code> function converts the given string to <code class=" language-php">StudlyCase</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">studly_case<span class="token punctuation">(</span></span><span class="token string">'foo_bar'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// FooBar</span></code></pre>
    <p>
        <a name="method-title-case"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">title_case<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">title_case</code> function converts the given string to <code class=" language-php">Title <span class="token keyword">Case</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$title</span> <span class="token operator">=</span> <span class="token function">title_case<span class="token punctuation">(</span></span><span class="token string">'a nice title uses the correct case'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// A Nice Title Uses The Correct Case</span></code></pre>
    <p>
        <a name="method-trans"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">trans<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">trans</code> function translates the given language line using your <a href="/docs/5.3/localization">localization files</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">trans<span class="token punctuation">(</span></span><span class="token string">'validation.required'</span><span class="token punctuation">)</span><span class="token punctuation">:</span></code></pre>
    <p>
        <a name="method-trans-choice"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">trans_choice<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">trans_choice</code> function translates the given language line with inflection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">trans_choice<span class="token punctuation">(</span></span><span class="token string">'foo.bar'</span><span class="token punctuation">,</span> <span class="token variable">$count</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="urls"></a>
    </p>
    <h2><a href="#urls">URLs</a></h2>
    <p>
        <a name="method-action"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">action<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">action</code> function generates a URL for the given controller action. You do not need to pass the full namespace to the controller. Instead, pass the controller class name relative to the <code class=" language-php">App\<span class="token package">Http<span class="token punctuation">\</span>Controllers</span></code> namespace:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$url</span> <span class="token operator">=</span> <span class="token function">action<span class="token punctuation">(</span></span><span class="token string">'HomeController@getIndex'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If the method accepts route parameters, you may pass them as the second argument to the method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$url</span> <span class="token operator">=</span> <span class="token function">action<span class="token punctuation">(</span></span><span class="token string">'UserController@profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-asset"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">asset<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>Generate a URL for an asset using the current scheme of the request (HTTP or HTTPS):</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$url</span> <span class="token operator">=</span> <span class="token function">asset<span class="token punctuation">(</span></span><span class="token string">'img/photo.jpg'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-secure-asset"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">secure_asset<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>Generate a URL for an asset using HTTPS:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">secure_asset<span class="token punctuation">(</span></span><span class="token string">'foo/bar.zip'</span><span class="token punctuation">,</span> <span class="token variable">$title</span><span class="token punctuation">,</span> <span class="token variable">$attributes</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-route"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">route<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">route</code> function generates a URL for the given named route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$url</span> <span class="token operator">=</span> <span class="token function">route<span class="token punctuation">(</span></span><span class="token string">'routeName'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If the route accepts parameters, you may pass them as the second argument to the method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$url</span> <span class="token operator">=</span> <span class="token function">route<span class="token punctuation">(</span></span><span class="token string">'routeName'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-url"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">url<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">url</code> function generates a fully qualified URL to the given path:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">url<span class="token punctuation">(</span></span><span class="token string">'user/profile'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token function">url<span class="token punctuation">(</span></span><span class="token string">'user/profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If no path is provided, a <code class=" language-php">Illuminate\<span class="token package">Routing<span class="token punctuation">\</span>UrlGenerator</span></code> instance is returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">echo</span> <span class="token function">url<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">current<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword">echo</span> <span class="token function">url<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">full<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword">echo</span> <span class="token function">url<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">previous<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="miscellaneous"></a>
    </p>
    <h2><a href="#miscellaneous">Miscellaneous</a></h2>
    <p>
        <a name="method-abort"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">abort<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">abort</code> function throws a HTTP exception which will be rendered by the exception handler:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">abort<span class="token punctuation">(</span></span><span class="token number">401</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may also provide the exception's response text:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">abort<span class="token punctuation">(</span></span><span class="token number">401</span><span class="token punctuation">,</span> <span class="token string">'Unauthorized.'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-abort-if"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">abort_if<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">abort_if</code> function throws an HTTP exception if a given boolean expression evaluates to <code class=" language-php"><span class="token boolean">true</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">abort_if<span class="token punctuation">(</span></span><span class="token operator">!</span> <span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">isAdmin<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token number">403</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-abort-unless"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">abort_unless<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">abort_unless</code> function throws an HTTP exception if a given boolean expression evaluates to <code class=" language-php"><span class="token boolean">false</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">abort_unless<span class="token punctuation">(</span></span><span class="token scope">Auth<span class="token punctuation">::</span></span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">isAdmin<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token number">403</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-auth"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">auth<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">auth</code> function returns an authenticator instance. You may use it instead of the <code class=" language-php">Auth</code> facade for convenience:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token function">auth<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-back"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">back<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php"><span class="token function">back<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code> function generates a redirect response to the user's previous location:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">back<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-bcrypt"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">bcrypt<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">bcrypt</code> function hashes the given value using Bcrypt. You may use it as an alternative to the <code class=" language-php">Hash</code> facade:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$password</span> <span class="token operator">=</span> <span class="token function">bcrypt<span class="token punctuation">(</span></span><span class="token string">'my-secret-password'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-cache"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">cache<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">cache</code> function may be used to get values from the cache. If the given key does not exist in the cache, an optional default value will be returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">cache<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">cache<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token string">'default'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may add items to the cache by passing an array of key / value pairs to the function. You should also pass the number of minutes or duration the cached value should be considered valid:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">cache<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'value'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">cache<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'value'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token scope">Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">addSeconds<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-collect"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">collect</code> function creates a <a href="/docs/5.3/collections">collection</a> instance from the given array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'taylor'</span><span class="token punctuation">,</span> <span class="token string">'abigail'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-config"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">config<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">config</code> function gets the value of a configuration variable. The configuration values may be accessed using "dot" syntax, which includes the name of the file and the option you wish to access. A default value may be specified and is returned if the configuration option does not exist:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'app.timezone'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'app.timezone'</span><span class="token punctuation">,</span> <span class="token variable">$default</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">config</code> helper may also be used to set configuration variables at runtime by passing an array of key / value pairs:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">config<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'app.debug'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-csrf-field"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">csrf_field<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">csrf_field</code> function generates an HTML <code class=" language-php">hidden</code> input field containing the value of the CSRF token. For example, using <a href="/docs/5.3/blade">Blade syntax</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">csrf_field<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="method-csrf-token"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">csrf_token<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">csrf_token</code> function retrieves the value of the current CSRF token:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$token</span> <span class="token operator">=</span> <span class="token function">csrf_token<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-dd"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">dd<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">dd</code> function dumps the given variables and ends execution of the script:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">dd<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">dd<span class="token punctuation">(</span></span><span class="token variable">$value1</span><span class="token punctuation">,</span> <span class="token variable">$value2</span><span class="token punctuation">,</span> <span class="token variable">$value3</span><span class="token punctuation">,</span> <span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you do not want to halt the execution of your script, use the <code class=" language-php">dump</code> function instead:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">dump<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-dispatch"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">dispatch</code> function pushes a new job onto the Laravel <a href="/docs/5.3/queues">job queue</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>SendEmails</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-env"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">env<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">env</code> function gets the value of an environment variable or returns a default value:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$env</span> <span class="token operator">=</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'APP_ENV'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Return a default value if the variable doesn't exist...
</span><span class="token variable">$env</span> <span class="token operator">=</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'APP_ENV'</span><span class="token punctuation">,</span> <span class="token string">'production'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-event"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">event<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">event</code> function dispatches the given <a href="/docs/5.3/events">event</a> to its listeners:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">event<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">UserRegistered</span><span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-factory"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">factory<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">factory</code> function creates a model factory builder for a given class, name, and amount. It can be used while <a href="/docs/5.3/database-testing#writing-factories">testing</a> or <a href="/docs/5.3/seeding#using-model-factories">seeding</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-info"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">info<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">info</code> function will write information to the log:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">info<span class="token punctuation">(</span></span><span class="token string">'Some helpful information!'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>An array of contextual data may also be passed to the function:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">info<span class="token punctuation">(</span></span><span class="token string">'User login attempt failed.'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-logger"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">logger<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">logger</code> function can be used to write a <code class=" language-php">debug</code> level message to the log:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">logger<span class="token punctuation">(</span></span><span class="token string">'Debug message'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>An array of contextual data may also be passed to the function:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">logger<span class="token punctuation">(</span></span><span class="token string">'User has logged in.'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>A <a href="/docs/5.3/errors#logging">logger</a> instance will be returned if no value is passed to the function:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">logger<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">error<span class="token punctuation">(</span></span><span class="token string">'You are not allowed here.'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-method-field"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">method_field<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">method_field</code> function generates an HTML <code class=" language-php">hidden</code> input field containing the spoofed value of the form's HTTP verb. For example, using <a href="/docs/5.3/blade">Blade syntax</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>form</span> <span class="token attr-name">method</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>POST<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
    <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">method_field<span class="token punctuation">(</span></span><span class="token string">'DELETE'</span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>form</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="method-old"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">old<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">old</code> function <a href="/docs/5.3/requests#retrieving-input">retrieves</a> an old input value flashed into the session:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">old<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">old<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">,</span> <span class="token string">'default'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-redirect"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">redirect<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">redirect</code> function returns a redirect HTTP response, or returns the redirector instance if called with no arguments:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'/home'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">route<span class="token punctuation">(</span></span><span class="token string">'route.name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-request"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">request<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">request</code> function returns the current <a href="/docs/5.3/requests">request</a> instance or obtains an input item:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$request</span> <span class="token operator">=</span> <span class="token function">request<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">request<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token variable">$default</span> <span class="token operator">=</span> <span class="token keyword">null</span><span class="token punctuation">)</span></code></pre>
    <p>
        <a name="method-response"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">response</code> function creates a <a href="/docs/5.3/responses">response</a> instance or obtains an instance of the response factory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token string">'Hello World'</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">,</span> <span class="token variable">$headers</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">response<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">json<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'foo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'bar'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">,</span> <span class="token variable">$headers</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-session"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">session</code> function may be used to get or set session values:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">session<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may set values by passing an array of key / value pairs to the function:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'chairs'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">7</span><span class="token punctuation">,</span> <span class="token string">'instruments'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The session store will be returned if no value is passed to the function:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">session<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">,</span> <span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-value"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">value<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">value</code> function's behavior will simply return the value it is given. However, if you pass a <code class=" language-php">Closure</code> to the function, the <code class=" language-php">Closure</code> will be executed then its result will be returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$value</span> <span class="token operator">=</span> <span class="token function">value<span class="token punctuation">(</span></span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span> <span class="token keyword">return</span> <span class="token string">'bar'</span><span class="token punctuation">;</span> <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-view"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">view<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">view</code> function retrieves a <a href="/docs/5.3/views">view</a> instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'auth.login'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/helpers">https://laravel.com/docs/5.3/helpers</a></div>
</article>
@endsection