@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Collections</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
            <ul>
                <li><a href="#creating-collections">Creating Collections</a>
                </li>
            </ul>
        </li>
        <li><a href="#available-methods">Available Methods</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>The <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>Collection</span></code> class provides a fluent, convenient wrapper for working with arrays of data. For example, check out the following code. We'll use the <code class=" language-php">collect</code> helper to create a new collection instance from the array, run the <code class=" language-php">strtoupper</code> function on each element, and then remove all empty elements:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'taylor'</span><span class="token punctuation">,</span> <span class="token string">'abigail'</span><span class="token punctuation">,</span> <span class="token keyword">null</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">map<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$name</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">strtoupper<span class="token punctuation">(</span></span><span class="token variable">$name</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span>
<span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">reject<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$name</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">empty<span class="token punctuation">(</span></span><span class="token variable">$name</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>As you can see, the <code class=" language-php">Collection</code> class allows you to chain its methods to perform fluent mapping and reducing of the underlying array. In general, collections are immutable, meaning every <code class=" language-php">Collection</code> method returns an entirely new <code class=" language-php">Collection</code> instance.</p>
    <p>
        <a name="creating-collections"></a>
    </p>
    <h3>Creating Collections</h3>
    <p>As mentioned above, the <code class=" language-php">collect</code> helper returns a new <code class=" language-php">Illuminate\<span class="token package">Support<span class="token punctuation">\</span>Collection</span></code> instance for the given array. So, creating a collection is as simple as:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> The results of <a href="/docs/5.3/eloquent">Eloquent</a> queries are always returned as <code class=" language-php">Collection</code> instances.</p>
    </blockquote>
    <p>
        <a name="available-methods"></a>
    </p>
    <h2><a href="#available-methods">Available Methods</a></h2>
    <p>For the remainder of this documentation, we'll discuss each method available on the <code class=" language-php">Collection</code> class. Remember, all of these methods may be chained to fluently manipulating the underlying array. Furthermore, almost every method returns a new <code class=" language-php">Collection</code> instance, allowing you to preserve the original copy of the collection when necessary:</p>
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
        <p><a href="#method-all">all</a>
            <a href="#method-avg">avg</a>
            <a href="#method-chunk">chunk</a>
            <a href="#method-collapse">collapse</a>
            <a href="#method-combine">combine</a>
            <a href="#method-contains">contains</a>
            <a href="#method-count">count</a>
            <a href="#method-diff">diff</a>
            <a href="#method-diffkeys">diffKeys</a>
            <a href="#method-each">each</a>
            <a href="#method-every">every</a>
            <a href="#method-except">except</a>
            <a href="#method-filter">filter</a>
            <a href="#method-first">first</a>
            <a href="#method-flatmap">flatMap</a>
            <a href="#method-flatten">flatten</a>
            <a href="#method-flip">flip</a>
            <a href="#method-forget">forget</a>
            <a href="#method-forpage">forPage</a>
            <a href="#method-get">get</a>
            <a href="#method-groupby">groupBy</a>
            <a href="#method-has">has</a>
            <a href="#method-implode">implode</a>
            <a href="#method-intersect">intersect</a>
            <a href="#method-isempty">isEmpty</a>
            <a href="#method-keyby">keyBy</a>
            <a href="#method-keys">keys</a>
            <a href="#method-last">last</a>
            <a href="#method-map">map</a>
            <a href="#method-mapwithkeys">mapWithKeys</a>
            <a href="#method-max">max</a>
            <a href="#method-merge">merge</a>
            <a href="#method-min">min</a>
            <a href="#method-only">only</a>
            <a href="#method-pipe">pipe</a>
            <a href="#method-pluck">pluck</a>
            <a href="#method-pop">pop</a>
            <a href="#method-prepend">prepend</a>
            <a href="#method-pull">pull</a>
            <a href="#method-push">push</a>
            <a href="#method-put">put</a>
            <a href="#method-random">random</a>
            <a href="#method-reduce">reduce</a>
            <a href="#method-reject">reject</a>
            <a href="#method-reverse">reverse</a>
            <a href="#method-search">search</a>
            <a href="#method-shift">shift</a>
            <a href="#method-shuffle">shuffle</a>
            <a href="#method-slice">slice</a>
            <a href="#method-sort">sort</a>
            <a href="#method-sortby">sortBy</a>
            <a href="#method-sortbydesc">sortByDesc</a>
            <a href="#method-splice">splice</a>
            <a href="#method-split">split</a>
            <a href="#method-sum">sum</a>
            <a href="#method-take">take</a>
            <a href="#method-toarray">toArray</a>
            <a href="#method-tojson">toJson</a>
            <a href="#method-transform">transform</a>
            <a href="#method-union">union</a>
            <a href="#method-unique">unique</a>
            <a href="#method-values">values</a>
            <a href="#method-where">where</a>
            <a href="#method-wherestrict">whereStrict</a>
            <a href="#method-wherein">whereIn</a>
            <a href="#method-whereinloose">whereInLoose</a>
            <a href="#method-zip">zip</a>
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
        <a name="method-all"></a>
    </p>
    <h4 id="collection-method" class="first-collection-method"><code class=" language-php"><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">all</code> method returns the underlying array represented by the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 3]</span></code></pre>
    <p>
        <a name="method-avg"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">avg<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">avg</code> method returns the average of all items in the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">avg<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 3</span></code></pre>
    <p>If the collection contains nested arrays or objects, you should pass a key to use for determining which values to calculate the average:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'JavaScript: The Good Parts'</span><span class="token punctuation">,</span> <span class="token string">'pages'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">176</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'JavaScript: The Definitive Guide'</span><span class="token punctuation">,</span> <span class="token string">'pages'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1096</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">avg<span class="token punctuation">(</span></span><span class="token string">'pages'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 636</span></code></pre>
    <p>
        <a name="method-chunk"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">chunk<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">chunk</code> method breaks the collection into multiple, smaller collections of a given size:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">,</span> <span class="token number">6</span><span class="token punctuation">,</span> <span class="token number">7</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunks</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">chunk<span class="token punctuation">(</span></span><span class="token number">4</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunks</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [[1, 2, 3, 4], [5, 6, 7]]</span></code></pre>
    <p>This method is especially useful in <a href="/docs/5.3/views">views</a> when working with a grid system such as <a href="http://getbootstrap.com/css/#grid">Bootstrap</a>. Imagine you have a collection of <a href="/docs/5.3/eloquent">Eloquent</a> models you want to display in a grid:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$products</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">chunk<span class="token punctuation">(</span></span><span class="token number">3</span><span class="token punctuation">)</span> <span class="token keyword">as</span> <span class="token variable">$chunk</span><span class="token punctuation">)</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>row<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
        @<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$chunk</span> <span class="token keyword">as</span> <span class="token variable">$product</span><span class="token punctuation">)</span>
            <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col-xs-4<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$product</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>
        @<span class="token keyword">endforeach</span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>
@<span class="token keyword">endforeach</span></code></pre>
    <p>
        <a name="method-collapse"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">collapse<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">collapse</code> method collapses a collection of arrays into a single, flat collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">,</span> <span class="token number">6</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token number">7</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">,</span> <span class="token number">9</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collapsed</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">collapse<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collapsed</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 3, 4, 5, 6, 7, 8, 9]</span></code></pre>
    <p>
        <a name="method-combine"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">combine<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">combine</code> method combines the keys of the collection with the values of another array or collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'age'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$combined</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">combine<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'George'</span><span class="token punctuation">,</span> <span class="token number">29</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$combined</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['name' =&gt; 'George', 'age' =&gt; 29]</span></code></pre>
    <p>
        <a name="method-contains"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">contains<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">contains</code> method determines whether the collection contains a given item:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">contains<span class="token punctuation">(</span></span><span class="token string">'Desk'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// true
</span>
<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">contains<span class="token punctuation">(</span></span><span class="token string">'New York'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// false</span></code></pre>
    <p>You may also pass a key / value pair to the <code class=" language-php">contains</code> method, which will determine if the given pair exists in the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">contains<span class="token punctuation">(</span></span><span class="token string">'product'</span><span class="token punctuation">,</span> <span class="token string">'Bookcase'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// false</span></code></pre>
    <p>Finally, you may also pass a callback to the <code class=" language-php">contains</code> method to perform your own truth test:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">contains<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">&gt;</span> <span class="token number">5</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// false</span></code></pre>
    <p>
        <a name="method-count"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">count<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">count</code> method returns the total number of items in the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">count<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 4</span></code></pre>
    <p>
        <a name="method-diff"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">diff<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">diff</code> method compares the collection against another collection or a plain PHP <code class=" language-php"><span class="token keyword">array</span></code> based on its values. This method will return the values in the original collection that are not present in the given collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$diff</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">diff<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">6</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$diff</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 3, 5]</span></code></pre>
    <p>
        <a name="method-diffkeys"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">diffKeys<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">diffKeys</code> method compares the collection against another collection or a plain PHP <code class=" language-php"><span class="token keyword">array</span></code> based on its keys. This method will return the key / value pairs in the original collection that are not present in the given collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'one'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">10</span><span class="token punctuation">,</span>
    <span class="token string">'two'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">20</span><span class="token punctuation">,</span>
    <span class="token string">'three'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">30</span><span class="token punctuation">,</span>
    <span class="token string">'four'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">40</span><span class="token punctuation">,</span>
    <span class="token string">'five'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">50</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$diff</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">diffKeys<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'two'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">2</span><span class="token punctuation">,</span>
    <span class="token string">'four'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">4</span><span class="token punctuation">,</span>
    <span class="token string">'six'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">6</span><span class="token punctuation">,</span>
    <span class="token string">'eight'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">8</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$diff</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['one' =&gt; 10, 'three' =&gt; 30, 'five' =&gt; 50]</span></code></pre>
    <p>
        <a name="method-each"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">each<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">each</code> method iterates over the items in the collection and passes each item to a callback:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">each<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you would like to stop iterating through the items, you may return <code class=" language-php"><span class="token boolean">false</span></code> from your callback:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">each<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token comment" spellcheck="true">/* some condition */</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token boolean">false</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="method-every"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">every<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">every</code> method creates a new collection consisting of every n-th element:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'a'</span><span class="token punctuation">,</span> <span class="token string">'b'</span><span class="token punctuation">,</span> <span class="token string">'c'</span><span class="token punctuation">,</span> <span class="token string">'d'</span><span class="token punctuation">,</span> <span class="token string">'e'</span><span class="token punctuation">,</span> <span class="token string">'f'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">every<span class="token punctuation">(</span></span><span class="token number">4</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['a', 'e']</span></code></pre>
    <p>You may optionally pass an offset as the second argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">every<span class="token punctuation">(</span></span><span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['b', 'f']</span></code></pre>
    <p>
        <a name="method-except"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">except<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">except</code> method returns all items in the collection except for those with the specified keys:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">,</span> <span class="token string">'discount'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">false</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">except<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'price'</span><span class="token punctuation">,</span> <span class="token string">'discount'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['product_id' =&gt; 1]</span></code></pre>
    <p>For the inverse of <code class=" language-php">except</code>, see the <a href="#method-only">only</a> method.</p>
    <p>
        <a name="method-filter"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">filter<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">filter</code> method filters the collection using the given callback, keeping only those items that pass a given truth test:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">filter<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">&gt;</span> <span class="token number">2</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [3, 4]</span></code></pre>
    <p>For the inverse of <code class=" language-php">filter</code>, see the <a href="#method-reject">reject</a> method.</p>
    <p>
        <a name="method-first"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">first<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">first</code> method returns the first element in the collection that passes a given truth test:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">first<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">&gt;</span> <span class="token number">2</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 3</span></code></pre>
    <p>You may also call the <code class=" language-php">first</code> method with no arguments to get the first element in the collection. If the collection is empty, <code class=" language-php"><span class="token keyword">null</span></code> is returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">first<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 1</span></code></pre>
    <p>
        <a name="method-flatmap"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">flatMap<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">flatMap</code> method iterates through the collection and passes each value to the given callback. The callback is free to modify the item and return it, thus forming a new collection of modified items. Then, the array is flattened by a level:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Sally'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'school'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Arkansas'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'age'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">28</span><span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$flattened</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flatMap<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$values</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">array_map<span class="token punctuation">(</span></span><span class="token string">'strtoupper'</span><span class="token punctuation">,</span> <span class="token variable">$values</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$flattened</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['name' =&gt; 'SALLY', 'school' =&gt; 'ARKANSAS', 'age' =&gt; '28'];</span></code></pre>
    <p>
        <a name="method-flatten"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">flatten<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">flatten</code> method flattens a multi-dimensional collection into a single dimension:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'taylor'</span><span class="token punctuation">,</span> <span class="token string">'languages'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'php'</span><span class="token punctuation">,</span> <span class="token string">'javascript'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$flattened</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flatten<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$flattened</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['taylor', 'php', 'javascript'];</span></code></pre>
    <p>You may optionally pass the function a "depth" argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'Apple'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'iPhone 6S'</span><span class="token punctuation">,</span> <span class="token string">'brand'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Apple'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token string">'Samsung'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Galaxy S7'</span><span class="token punctuation">,</span> <span class="token string">'brand'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Samsung'</span><span class="token punctuation">]</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$products</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flatten<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$products</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        ['name' =&gt; 'iPhone 6S', 'brand' =&gt; 'Apple'],
        ['name' =&gt; 'Galaxy S7', 'brand' =&gt; 'Samsung'],
    ]
*/</span></code></pre>
    <p>In this example, calling <code class=" language-php">flatten</code> without providing the depth would have also flattened the nested arrays, resulting in <code class=" language-php"><span class="token punctuation">[</span><span class="token string">'iPhone 6S'</span><span class="token punctuation">,</span> <span class="token string">'Apple'</span><span class="token punctuation">,</span> <span class="token string">'Galaxy S7'</span><span class="token punctuation">,</span> <span class="token string">'Samsung'</span><span class="token punctuation">]</span></code>. Providing a depth allows you to restrict the levels of nested arrays that will be flattened.</p>
    <p>
        <a name="method-flip"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">flip<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">flip</code> method swaps the collection's keys with their corresponding values:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'taylor'</span><span class="token punctuation">,</span> <span class="token string">'framework'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'laravel'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$flipped</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">flip<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$flipped</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['taylor' =&gt; 'name', 'laravel' =&gt; 'framework']</span></code></pre>
    <p>
        <a name="method-forget"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">forget<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">forget</code> method removes an item from the collection by its key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'taylor'</span><span class="token punctuation">,</span> <span class="token string">'framework'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'laravel'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">forget<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['framework' =&gt; 'laravel']</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Unlike most other collection methods, <code class=" language-php">forget</code> does not return a new modified collection; it modifies the collection it is called on.</p>
    </blockquote>
    <p>
        <a name="method-forpage"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">forPage<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">forPage</code> method returns a new collection containing the items that would be present on a given page number. The method accepts the page number as its first argument and the number of items to show per page as its second argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">,</span> <span class="token number">6</span><span class="token punctuation">,</span> <span class="token number">7</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">,</span> <span class="token number">9</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">forPage<span class="token punctuation">(</span></span><span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [4, 5, 6]</span></code></pre>
    <p>
        <a name="method-get"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">get</code> method returns the item at a given key. If the key does not exist, <code class=" language-php"><span class="token keyword">null</span></code> is returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'taylor'</span><span class="token punctuation">,</span> <span class="token string">'framework'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'laravel'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// taylor</span></code></pre>
    <p>You may optionally pass a default value as the second argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'taylor'</span><span class="token punctuation">,</span> <span class="token string">'framework'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'laravel'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">,</span> <span class="token string">'default-value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// default-value</span></code></pre>
    <p>You may even pass a callback as the default value. The result of the callback will be returned if the specified key does not exist:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'email'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token string">'default-value'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// default-value</span></code></pre>
    <p>
        <a name="method-groupby"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">groupBy<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">groupBy</code> method groups the collection's items by a given key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'account_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'account-x10'</span><span class="token punctuation">,</span> <span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'account_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'account-x10'</span><span class="token punctuation">,</span> <span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Bookcase'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'account_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'account-x11'</span><span class="token punctuation">,</span> <span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$grouped</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">groupBy<span class="token punctuation">(</span></span><span class="token string">'account_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$grouped</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        'account-x10' =&gt; [
            ['account_id' =&gt; 'account-x10', 'product' =&gt; 'Chair'],
            ['account_id' =&gt; 'account-x10', 'product' =&gt; 'Bookcase'],
        ],
        'account-x11' =&gt; [
            ['account_id' =&gt; 'account-x11', 'product' =&gt; 'Desk'],
        ],
    ]
*/</span></code></pre>
    <p>In addition to passing a string <code class=" language-php">key</code>, you may also pass a callback. The callback should return the value you wish to key the group by:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$grouped</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">groupBy<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">substr<span class="token punctuation">(</span></span><span class="token variable">$item</span><span class="token punctuation">[</span><span class="token string">'account_id'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token operator">-</span><span class="token number">3</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$grouped</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        'x10' =&gt; [
            ['account_id' =&gt; 'account-x10', 'product' =&gt; 'Chair'],
            ['account_id' =&gt; 'account-x10', 'product' =&gt; 'Bookcase'],
        ],
        'x11' =&gt; [
            ['account_id' =&gt; 'account-x11', 'product' =&gt; 'Desk'],
        ],
    ]
*/</span></code></pre>
    <p>
        <a name="method-has"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">has<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">has</code> method determines if a given key exists in the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'account_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">has<span class="token punctuation">(</span></span><span class="token string">'email'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// false</span></code></pre>
    <p>
        <a name="method-implode"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">implode<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">implode</code> method joins the items in a collection. Its arguments depend on the type of items in the collection. If the collection contains arrays or objects, you should pass the key of the attributes you wish to join, and the "glue" string you wish to place between the values:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'account_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'account_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">implode<span class="token punctuation">(</span></span><span class="token string">'product'</span><span class="token punctuation">,</span> <span class="token string">', '</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Desk, Chair</span></code></pre>
    <p>If the collection contains simple strings or numeric values, simply pass the "glue" as the only argument to the method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">implode<span class="token punctuation">(</span></span><span class="token string">'-'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// '1-2-3-4-5'</span></code></pre>
    <p>
        <a name="method-intersect"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">intersect<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">intersect</code> method removes any values from the original collection that are not present in the given <code class=" language-php"><span class="token keyword">array</span></code> or collection. The resulting collection will preserve the original collection's keys:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'Sofa'</span><span class="token punctuation">,</span> <span class="token string">'Chair'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$intersect</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">intersect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'Chair'</span><span class="token punctuation">,</span> <span class="token string">'Bookcase'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$intersect</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [0 =&gt; 'Desk', 2 =&gt; 'Chair']</span></code></pre>
    <p>
        <a name="method-isempty"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">isEmpty<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">isEmpty</code> method returns <code class=" language-php"><span class="token boolean">true</span></code> if the collection is empty; otherwise, <code class=" language-php"><span class="token boolean">false</span></code> is returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">isEmpty<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// true</span></code></pre>
    <p>
        <a name="method-keyby"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">keyBy<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">keyBy</code> method keys the collection by the given key. If multiple items have the same key, only the last one will appear in the new collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'prod-100'</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'desk'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'prod-200'</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'chair'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$keyed</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">keyBy<span class="token punctuation">(</span></span><span class="token string">'product_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$keyed</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        'prod-100' =&gt; ['product_id' =&gt; 'prod-100', 'name' =&gt; 'Desk'],
        'prod-200' =&gt; ['product_id' =&gt; 'prod-200', 'name' =&gt; 'Chair'],
    ]
*/</span></code></pre>
    <p>You may also pass a callback to the method. The callback should return the value to key the collection by:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$keyed</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">keyBy<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">strtoupper<span class="token punctuation">(</span></span><span class="token variable">$item</span><span class="token punctuation">[</span><span class="token string">'product_id'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$keyed</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        'PROD-100' =&gt; ['product_id' =&gt; 'prod-100', 'name' =&gt; 'Desk'],
        'PROD-200' =&gt; ['product_id' =&gt; 'prod-200', 'name' =&gt; 'Chair'],
    ]
*/</span></code></pre>
    <p>
        <a name="method-keys"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">keys<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">keys</code> method returns all of the collection's keys:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'prod-100'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'prod-100'</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token string">'prod-200'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'prod-200'</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$keys</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">keys<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$keys</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['prod-100', 'prod-200']</span></code></pre>
    <p>
        <a name="method-last"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">last<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">last</code> method returns the last element in the collection that passes a given truth test:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">last<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">&lt;</span> <span class="token number">3</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 2</span></code></pre>
    <p>You may also call the <code class=" language-php">last</code> method with no arguments to get the last element in the collection. If the collection is empty, <code class=" language-php"><span class="token keyword">null</span></code> is returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">last<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 4</span></code></pre>
    <p>
        <a name="method-map"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">map<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">map</code> method iterates through the collection and passes each value to the given callback. The callback is free to modify the item and return it, thus forming a new collection of modified items:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$multiplied</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">map<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$item</span> <span class="token operator">*</span> <span class="token number">2</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$multiplied</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [2, 4, 6, 8, 10]</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Like most other collection methods, <code class=" language-php">map</code> returns a new collection instance; it does not modify the collection it is called on. If you want to transform the original collection, use the <a href="#method-transform"><code class=" language-php">transform</code></a> method.</p>
    </blockquote>
    <p>
        <a name="method-mapwithkeys"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">mapWithKeys<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">mapWithKeys</code> method iterates through the collection and passes each value to the given callback. The callback should return an associative array containing a single key / value pair:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span>
        <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'John'</span><span class="token punctuation">,</span>
        <span class="token string">'department'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Sales'</span><span class="token punctuation">,</span>
        <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'john@example.com'</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span>
        <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Jane'</span><span class="token punctuation">,</span>
        <span class="token string">'department'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Marketing'</span><span class="token punctuation">,</span>
        <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'jane@example.com'</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$keyed</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">mapWithKeys<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span><span class="token variable">$item</span><span class="token punctuation">[</span><span class="token string">'email'</span><span class="token punctuation">]</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$item</span><span class="token punctuation">[</span><span class="token string">'name'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$keyed</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        'john@example.com' =&gt; 'John',
        'jane@example.com' =&gt; 'Jane',
    ]
*/</span></code></pre>
    <p>
        <a name="method-max"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">max<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">max</code> method returns the maximum value of a given key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$max</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token punctuation">[</span><span class="token string">'foo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">10</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'foo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">20</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">max<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 20
</span>
<span class="token variable">$max</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">max<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 5</span></code></pre>
    <p>
        <a name="method-merge"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">merge<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">merge</code> method merges the given array into the original collection. If a string key in the given array matches a string key in the original collection, the given array's value will overwrite the value in the original collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$merged</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">merge<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">,</span> <span class="token string">'discount'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">false</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$merged</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['product_id' =&gt; 1, 'price' =&gt; 200, 'discount' =&gt; false]</span></code></pre>
    <p>If the given array's keys are numeric, the values will be appended to the end of the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'Chair'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$merged</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">merge<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'Bookcase'</span><span class="token punctuation">,</span> <span class="token string">'Door'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$merged</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['Desk', 'Chair', 'Bookcase', 'Door']</span></code></pre>
    <p>
        <a name="method-min"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">min<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">min</code> method returns the minimum value of a given key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$min</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token punctuation">[</span><span class="token string">'foo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">10</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'foo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">20</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">min<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 10
</span>
<span class="token variable">$min</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">min<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 1</span></code></pre>
    <p>
        <a name="method-only"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">only<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">only</code> method returns the items in the collection with the specified keys:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">,</span> <span class="token string">'discount'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">false</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">only<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'product_id'</span><span class="token punctuation">,</span> <span class="token string">'name'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['product_id' =&gt; 1, 'name' =&gt; 'Desk']</span></code></pre>
    <p>For the inverse of <code class=" language-php">only</code>, see the <a href="#method-except">except</a> method.</p>
    <p>
        <a name="method-pipe"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">pipe<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">pipe</code> method passes the collection to the given callback and returns the result:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$piped</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">pipe<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$collection</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sum<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 6</span></code></pre>
    <p>
        <a name="method-pluck"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">pluck<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">pluck</code> method retrieves all of the values for a given key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'prod-100'</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'prod-200'</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$plucked</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">pluck<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$plucked</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['Desk', 'Chair']</span></code></pre>
    <p>You may also specify how you wish the resulting collection to be keyed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$plucked</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">pluck<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'product_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$plucked</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['prod-100' =&gt; 'Desk', 'prod-200' =&gt; 'Chair']</span></code></pre>
    <p>
        <a name="method-pop"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">pop<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">pop</code> method removes and returns the last item from the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">pop<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 5
</span>
<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 3, 4]</span></code></pre>
    <p>
        <a name="method-prepend"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">prepend<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">prepend</code> method adds an item to the beginning of the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">prepend<span class="token punctuation">(</span></span><span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [0, 1, 2, 3, 4, 5]</span></code></pre>
    <p>You may also pass a second argument to set the key of the prepended item:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'one'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token string">'two'</span><span class="token punctuation">,</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">2</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">prepend<span class="token punctuation">(</span></span><span class="token number">0</span><span class="token punctuation">,</span> <span class="token string">'zero'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['zero' =&gt; 0, 'one' =&gt; 1, 'two', =&gt; 2]</span></code></pre>
    <p>
        <a name="method-pull"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">pull<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">pull</code> method removes and returns an item from the collection by its key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'prod-100'</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">pull<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 'Desk'
</span>
<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['product_id' =&gt; 'prod-100']</span></code></pre>
    <p>
        <a name="method-push"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">push<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">push</code> method appends an item to the end of the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">push<span class="token punctuation">(</span></span><span class="token number">5</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 3, 4, 5]</span></code></pre>
    <p>
        <a name="method-put"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">put<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">put</code> method sets the given key and value in the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'product_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'price'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ['product_id' =&gt; 1, 'name' =&gt; 'Desk', 'price' =&gt; 100]</span></code></pre>
    <p>
        <a name="method-random"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">random<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">random</code> method returns a random item from the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">random<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 4 - (retrieved randomly)</span></code></pre>
    <p>You may optionally pass an integer to <code class=" language-php">random</code> to specify how many items you would like to randomly retrieve. If that integer is more than <code class=" language-php"><span class="token number">1</span></code>, a collection of items is returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$random</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">random<span class="token punctuation">(</span></span><span class="token number">3</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$random</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [2, 4, 5] - (retrieved randomly)</span></code></pre>
    <p>
        <a name="method-reduce"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">reduce<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">reduce</code> method reduces the collection to a single value, passing the result of each iteration into the subsequent iteration:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$total</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">reduce<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$carry</span><span class="token punctuation">,</span> <span class="token variable">$item</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$carry</span> <span class="token operator">+</span> <span class="token variable">$item</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 6</span></code></pre>
    <p>The value for <code class=" language-php"><span class="token variable">$carry</span></code> on the first iteration is <code class=" language-php"><span class="token keyword">null</span></code>; however, you may specify its initial value by passing a second argument to <code class=" language-php">reduce</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">reduce<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$carry</span><span class="token punctuation">,</span> <span class="token variable">$item</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$carry</span> <span class="token operator">+</span> <span class="token variable">$item</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 10</span></code></pre>
    <p>
        <a name="method-reject"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">reject<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">reject</code> method filters the collection using the given callback. The callback should return <code class=" language-php"><span class="token boolean">true</span></code> if the item should be removed from the resulting collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">reject<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$value</span> <span class="token operator">&gt;</span> <span class="token number">2</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2]</span></code></pre>
    <p>For the inverse of the <code class=" language-php">reject</code> method, see the <a href="#method-filter"><code class=" language-php">filter</code></a> method.</p>
    <p>
        <a name="method-reverse"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">reverse<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">reverse</code> method reverses the order of the collection's items:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$reversed</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">reverse<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$reversed</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [5, 4, 3, 2, 1]</span></code></pre>
    <p>
        <a name="method-search"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">search<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">search</code> method searches the collection for the given value and returns its key if found. If the item is not found, <code class=" language-php"><span class="token boolean">false</span></code> is returned.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">6</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">search<span class="token punctuation">(</span></span><span class="token number">4</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 1</span></code></pre>
    <p>The search is done using a "loose" comparison, meaning a string with an integer value will be considered equal to an integer of the same value. To use strict comparison, pass <code class=" language-php"><span class="token boolean">true</span></code> as the second argument to the method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">search<span class="token punctuation">(</span></span><span class="token string">'4'</span><span class="token punctuation">,</span> <span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// false</span></code></pre>
    <p>Alternatively, you may pass in your own callback to search for the first item that passes your truth test:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">search<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$item</span> <span class="token operator">&gt;</span> <span class="token number">5</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 2</span></code></pre>
    <p>
        <a name="method-shift"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">shift<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">shift</code> method removes and returns the first item from the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">shift<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 1
</span>
<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [2, 3, 4, 5]</span></code></pre>
    <p>
        <a name="method-shuffle"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">shuffle<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">shuffle</code> method randomly shuffles the items in the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$shuffled</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">shuffle<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$shuffled</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [3, 2, 5, 1, 4] // (generated randomly)</span></code></pre>
    <p>
        <a name="method-slice"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">slice<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">slice</code> method returns a slice of the collection starting at the given index:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">,</span> <span class="token number">6</span><span class="token punctuation">,</span> <span class="token number">7</span><span class="token punctuation">,</span> <span class="token number">8</span><span class="token punctuation">,</span> <span class="token number">9</span><span class="token punctuation">,</span> <span class="token number">10</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$slice</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">slice<span class="token punctuation">(</span></span><span class="token number">4</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$slice</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [5, 6, 7, 8, 9, 10]</span></code></pre>
    <p>If you would like to limit the size of the returned slice, pass the desired size as the second argument to the method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$slice</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">slice<span class="token punctuation">(</span></span><span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$slice</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [5, 6]</span></code></pre>
    <p>The returned slice will preserve keys by default. If you do not wish to preserve the original keys, you can use the <code class=" language-php">values</code> method to reindex them.</p>
    <p>
        <a name="method-sort"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">sort<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">sort</code> method sorts the collection. The sorted collection keeps the original array keys, so in this example we'll use the <a href="#method-values"><code class=" language-php">values</code></a> method to reset the keys to consecutively numbered indexes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">5</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$sorted</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sort<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$sorted</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 3, 4, 5]</span></code></pre>
    <p>If your sorting needs are more advanced, you may pass a callback to <code class=" language-php">sort</code> with your own algorithm. Refer to the PHP documentation on <a href="http://php.net/manual/en/function.usort.php#refsect1-function.usort-parameters"><code class=" language-php">usort</code></a>, which is what the collection's <code class=" language-php">sort</code> method calls under the hood.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> If you need to sort a collection of nested arrays or objects, see the <a href="#method-sortby"><code class=" language-php">sortBy</code></a> and <a href="#method-sortbydesc"><code class=" language-php">sortByDesc</code></a> methods.</p>
    </blockquote>
    <p>
        <a name="method-sortby"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">sortBy<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">sortBy</code> method sorts the collection by the given key. The sorted collection keeps the original array keys, so in this example we'll use the <a href="#method-values"><code class=" language-php">values</code></a> method to reset the keys to consecutively numbered indexes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Bookcase'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">150</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$sorted</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sortBy<span class="token punctuation">(</span></span><span class="token string">'price'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$sorted</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        ['name' =&gt; 'Chair', 'price' =&gt; 100],
        ['name' =&gt; 'Bookcase', 'price' =&gt; 150],
        ['name' =&gt; 'Desk', 'price' =&gt; 200],
    ]
*/</span></code></pre>
    <p>You can also pass your own callback to determine how to sort the collection values:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'colors'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'Black'</span><span class="token punctuation">,</span> <span class="token string">'Mahogany'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">,</span> <span class="token string">'colors'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'Black'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Bookcase'</span><span class="token punctuation">,</span> <span class="token string">'colors'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'Red'</span><span class="token punctuation">,</span> <span class="token string">'Beige'</span><span class="token punctuation">,</span> <span class="token string">'Brown'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$sorted</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sortBy<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$product</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">count<span class="token punctuation">(</span></span><span class="token variable">$product</span><span class="token punctuation">[</span><span class="token string">'colors'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$sorted</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        ['name' =&gt; 'Chair', 'colors' =&gt; ['Black']],
        ['name' =&gt; 'Desk', 'colors' =&gt; ['Black', 'Mahogany']],
        ['name' =&gt; 'Bookcase', 'colors' =&gt; ['Red', 'Beige', 'Brown']],
    ]
*/</span></code></pre>
    <p>
        <a name="method-sortbydesc"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">sortByDesc<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>This method has the same signature as the <a href="#method-sortby"><code class=" language-php">sortBy</code></a> method, but will sort the collection in the opposite order.</p>
    <p>
        <a name="method-splice"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">splice<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">splice</code> method removes and returns a slice of items starting at the specified index:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">splice<span class="token punctuation">(</span></span><span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [3, 4, 5]
</span>
<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2]</span></code></pre>
    <p>You may pass a second argument to limit the size of the resulting chunk:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">splice<span class="token punctuation">(</span></span><span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [3]
</span>
<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 4, 5]</span></code></pre>
    <p>In addition, you can pass a third argument containing the new items to replace the items removed from the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">splice<span class="token punctuation">(</span></span><span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token number">10</span><span class="token punctuation">,</span> <span class="token number">11</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [3]
</span>
<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 10, 11, 4, 5]</span></code></pre>
    <p>
        <a name="method-split"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">split<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">split</code> method breaks a collection into the given number of groups:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$groups</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">split<span class="token punctuation">(</span></span><span class="token number">3</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$groups</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [[1, 2], [3, 4], [5]]</span></code></pre>
    <p>
        <a name="method-sum"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">sum<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">sum</code> method returns the sum of all items in the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sum<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 15</span></code></pre>
    <p>If the collection contains nested arrays or objects, you should pass a key to use for determining which values to sum:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'JavaScript: The Good Parts'</span><span class="token punctuation">,</span> <span class="token string">'pages'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">176</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'JavaScript: The Definitive Guide'</span><span class="token punctuation">,</span> <span class="token string">'pages'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1096</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sum<span class="token punctuation">(</span></span><span class="token string">'pages'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 1272</span></code></pre>
    <p>In addition, you may pass your own callback to determine which values of the collection to sum:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">,</span> <span class="token string">'colors'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'Black'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'colors'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'Black'</span><span class="token punctuation">,</span> <span class="token string">'Mahogany'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Bookcase'</span><span class="token punctuation">,</span> <span class="token string">'colors'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'Red'</span><span class="token punctuation">,</span> <span class="token string">'Beige'</span><span class="token punctuation">,</span> <span class="token string">'Brown'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sum<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$product</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token function">count<span class="token punctuation">(</span></span><span class="token variable">$product</span><span class="token punctuation">[</span><span class="token string">'colors'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// 6</span></code></pre>
    <p>
        <a name="method-take"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">take<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">take</code> method returns a new collection with the specified number of items:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">0</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">take<span class="token punctuation">(</span></span><span class="token number">3</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [0, 1, 2]</span></code></pre>
    <p>You may also pass a negative integer to take the specified amount of items from the end of the collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">0</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">take<span class="token punctuation">(</span></span><span class="token operator">-</span><span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$chunk</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [4, 5]</span></code></pre>
    <p>
        <a name="method-toarray"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">toArray</code> method converts the collection into a plain PHP <code class=" language-php"><span class="token keyword">array</span></code>. If the collection's values are <a href="/docs/5.3/eloquent">Eloquent</a> models, the models will also be converted to arrays:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        ['name' =&gt; 'Desk', 'price' =&gt; 200],
    ]
*/</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> <code class=" language-php">toArray</code> also converts all of the collection's nested objects to an array. If you want to get the raw underlying array, use the <a href="#method-all"><code class=" language-php">all</code></a> method instead.</p>
    </blockquote>
    <p>
        <a name="method-tojson"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">toJson<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">toJson</code> method converts the collection into JSON:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toJson<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// '{"name":"Desk", "price":200}'</span></code></pre>
    <p>
        <a name="method-transform"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">transform<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">transform</code> method iterates over the collection and calls the given callback with each item in the collection. The items in the collection will be replaced by the values returned by the callback:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">transform<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">,</span> <span class="token variable">$key</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$item</span> <span class="token operator">*</span> <span class="token number">2</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [2, 4, 6, 8, 10]</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Unlike most other collection methods, <code class=" language-php">transform</code> modifies the collection itself. If you wish to create a new collection instead, use the <a href="#method-map"><code class=" language-php">map</code></a> method.</p>
    </blockquote>
    <p>
        <a name="method-union"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">union<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">union</code> method adds the given array to the collection. If the given array contains keys that are already in the original collection, the original collection's values will be preferred:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'a'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token number">2</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'b'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$union</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">union<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">3</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'c'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token number">1</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'b'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$union</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1 =&gt; ['a'], 2 =&gt; ['b'], [3 =&gt; ['c']]</span></code></pre>
    <p>
        <a name="method-unique"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">unique<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">unique</code> method returns all of the unique items in the collection. The returned collection keeps the original array keys, so in this example we'll use the <a href="#method-values"><code class=" language-php">values</code></a> method to reset the keys to consecutively numbered indexes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$unique</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unique<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$unique</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [1, 2, 3, 4]</span></code></pre>
    <p>When dealing with nested arrays or objects, you may specify the key used to determine uniqueness:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'iPhone 6'</span><span class="token punctuation">,</span> <span class="token string">'brand'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Apple'</span><span class="token punctuation">,</span> <span class="token string">'type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'phone'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'iPhone 5'</span><span class="token punctuation">,</span> <span class="token string">'brand'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Apple'</span><span class="token punctuation">,</span> <span class="token string">'type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'phone'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Apple Watch'</span><span class="token punctuation">,</span> <span class="token string">'brand'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Apple'</span><span class="token punctuation">,</span> <span class="token string">'type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'watch'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Galaxy S6'</span><span class="token punctuation">,</span> <span class="token string">'brand'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Samsung'</span><span class="token punctuation">,</span> <span class="token string">'type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'phone'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Galaxy Gear'</span><span class="token punctuation">,</span> <span class="token string">'brand'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Samsung'</span><span class="token punctuation">,</span> <span class="token string">'type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'watch'</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$unique</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unique<span class="token punctuation">(</span></span><span class="token string">'brand'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$unique</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        ['name' =&gt; 'iPhone 6', 'brand' =&gt; 'Apple', 'type' =&gt; 'phone'],
        ['name' =&gt; 'Galaxy S6', 'brand' =&gt; 'Samsung', 'type' =&gt; 'phone'],
    ]
*/</span></code></pre>
    <p>You may also pass your own callback to determine item uniqueness:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$unique</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unique<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$item</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$item</span><span class="token punctuation">[</span><span class="token string">'brand'</span><span class="token punctuation">]</span><span class="token punctuation">.</span><span class="token variable">$item</span><span class="token punctuation">[</span><span class="token string">'type'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$unique</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        ['name' =&gt; 'iPhone 6', 'brand' =&gt; 'Apple', 'type' =&gt; 'phone'],
        ['name' =&gt; 'Apple Watch', 'brand' =&gt; 'Apple', 'type' =&gt; 'watch'],
        ['name' =&gt; 'Galaxy S6', 'brand' =&gt; 'Samsung', 'type' =&gt; 'phone'],
        ['name' =&gt; 'Galaxy Gear', 'brand' =&gt; 'Samsung', 'type' =&gt; 'watch'],
    ]
*/</span></code></pre>
    <p>
        <a name="method-values"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">values</code> method returns a new collection with the keys reset to consecutive integers:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token number">10</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token number">11</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$values</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">values<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$values</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
    [
        0 =&gt; ['product' =&gt; 'Desk', 'price' =&gt; 200],
        1 =&gt; ['product' =&gt; 'Desk', 'price' =&gt; 200],
    ]
*/</span></code></pre>
    <p>
        <a name="method-where"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">where<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">where</code> method filters the collection by a given key / value pair:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Bookcase'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">150</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Door'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'price'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
[
    ['product' =&gt; 'Chair', 'price' =&gt; 100],
    ['product' =&gt; 'Door', 'price' =&gt; 100],
]
*/</span></code></pre>
    <p>The <code class=" language-php">where</code> method uses loose comparisons when checking item values. Use the <a href="#method-wherestrict"><code class=" language-php">whereStrict</code></a> method to filter using "strict" comparisons.</p>
    <p>
        <a name="method-wherestrict"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">whereStrict<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>This method has the same signature as the <a href="#method-where"><code class=" language-php">where</code></a> method; however, all values are compared using "strict" comparisons.</p>
    <p>
        <a name="method-wherein"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">whereIn<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">whereIn</code> method filters the collection by a given key / value contained within the given array.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Desk'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Chair'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Bookcase'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">150</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">[</span><span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Door'</span><span class="token punctuation">,</span> <span class="token string">'price'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">100</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">whereIn<span class="token punctuation">(</span></span><span class="token string">'price'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token number">150</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$filtered</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/*
[
    ['product' =&gt; 'Bookcase', 'price' =&gt; 150],
    ['product' =&gt; 'Desk', 'price' =&gt; 200],
]
*/</span></code></pre>
    <p>The <code class=" language-php">whereIn</code> method uses strict comparisons when checking item values. Use the <a href="#method-whereinloose"><code class=" language-php">whereInLoose</code></a> method to filter using "loose" comparisons.</p>
    <p>
        <a name="method-whereinloose"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">whereInLoose<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>This method has the same signature as the <a href="#method-wherein"><code class=" language-php">whereIn</code></a> method; however, all values are compared using "loose" comparisons.</p>
    <p>
        <a name="method-zip"></a>
    </p>
    <h4 id="collection-method"><code class=" language-php"><span class="token function">zip<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code></h4>
    <p>The <code class=" language-php">zip</code> method merges together the values of the given array with the values of the original collection at the corresponding index:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token function">collect<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'Chair'</span><span class="token punctuation">,</span> <span class="token string">'Desk'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$zipped</span> <span class="token operator">=</span> <span class="token variable">$collection</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">zip<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">100</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$zipped</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// [['Chair', 100], ['Desk', 200]]</span></code></pre>

<div>Nguồn: <a href="https://laravel.com/docs/5.3/collections">https://laravel.com/docs/5.3/collections</a></div>
</article>
@endsection