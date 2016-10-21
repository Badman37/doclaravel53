@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Pagination</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#basic-usage">Basic Usage</a>
            <ul>
                <li><a href="#paginating-query-builder-results">Paginating Query Builder Results</a>
                </li>
                <li><a href="#paginating-eloquent-results">Paginating Eloquent Results</a>
                </li>
                <li><a href="#manually-creating-a-paginator">Manually Creating A Paginator</a>
                </li>
            </ul>
        </li>
        <li><a href="#displaying-pagination-results">Displaying Pagination Results</a>
            <ul>
                <li><a href="#converting-results-to-json">Converting Results To JSON</a>
                </li>
            </ul>
        </li>
        <li><a href="#customizing-the-pagination-view">Customizing The Pagination View</a>
        </li>
        <li><a href="#paginator-instance-methods">Paginator Instance Methods</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>In other frameworks, pagination can be very painful. Laravel's paginator is integrated with the <a href="/docs/5.3/queries">query builder</a> and <a href="/docs/5.3/eloquent">Eloquent ORM</a> and provides convenient, easy-to-use pagination of database results out of the box. The HTML generated by the paginator is compatible with the <a href="http://getbootstrap.com/">Bootstrap CSS framework</a>.</p>
    <p>
        <a name="basic-usage"></a>
    </p>
    <h2><a href="#basic-usage">Basic Usage</a></h2>
    <p>
        <a name="paginating-query-builder-results"></a>
    </p>
    <h3>Paginating Query Builder Results</h3>
    <p>There are several ways to paginate items. The simplest is by using the <code class=" language-php">paginate</code> method on the <a href="/docs/5.3/queries">query builder</a> or an <a href="/docs/5.3/eloquent">Eloquent query</a>. The <code class=" language-php">paginate</code> method automatically takes care of setting the proper limit and offset based on the current page being viewed by the user. By default, the current page is detected by the value of the <code class=" language-php">page</code> query string argument on the HTTP request. Of course, this value is automatically detected by Laravel, and is also automatically inserted into links generated by the paginator.</p>
    <p>In this example, the only argument passed to the <code class=" language-php">paginate</code> method is the number of items you would like displayed "per page". In this case, let's specify that we would like to display <code class=" language-php"><span class="token number">15</span></code> items per page:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>DB</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Show all of the users for the application.
     *
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">index<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">DB<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">paginate<span class="token punctuation">(</span></span><span class="token number">15</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token keyword">return</span> <span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'user.index'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'users'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$users</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Currently, pagination operations that use a <code class=" language-php">groupBy</code> statement cannot be executed efficiently by Laravel. If you need to use a <code class=" language-php">groupBy</code> with a paginated result set, it is recommended that you query the database and create a paginator manually.</p>
    </blockquote>
    <h4>"Simple Pagination"</h4>
    <p>If you only need to display simple "Next" and "Previous" links in your pagination view, you may use the <code class=" language-php">simplePaginate</code> method to perform a more efficient query. This is very useful for large datasets when you do not need to display a link for each page number when rendering your view:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">DB<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">simplePaginate<span class="token punctuation">(</span></span><span class="token number">15</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="paginating-eloquent-results"></a>
    </p>
    <h3>Paginating Eloquent Results</h3>
    <p>You may also paginate <a href="/docs/5.3/eloquent">Eloquent</a> queries. In this example, we will paginate the <code class=" language-php">User</code> model with <code class=" language-php"><span class="token number">15</span></code> items per page. As you can see, the syntax is nearly identical to paginating query builder results:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">paginate<span class="token punctuation">(</span></span><span class="token number">15</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Of course, you may call <code class=" language-php">paginate</code> after setting other constraints on the query, such as <code class=" language-php">where</code> clauses:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'votes'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">paginate<span class="token punctuation">(</span></span><span class="token number">15</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may also use the <code class=" language-php">simplePaginate</code> method when paginating Eloquent models:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'votes'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">simplePaginate<span class="token punctuation">(</span></span><span class="token number">15</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="manually-creating-a-paginator"></a>
    </p>
    <h3>Manually Creating A Paginator</h3>
    <p>Sometimes you may wish to create a pagination instance manually, passing it an array of items. You may do so by creating either an <code class=" language-php">Illuminate\<span class="token package">Pagination<span class="token punctuation">\</span>Paginator</span></code> or <code class=" language-php">Illuminate\<span class="token package">Pagination<span class="token punctuation">\</span>LengthAwarePaginator</span></code> instance, depending on your needs.</p>
    <p>The <code class=" language-php">Paginator</code> class does not need to know the total number of items in the result set; however, because of this, the class does not have methods for retrieving the index of the last page. The <code class=" language-php">LengthAwarePaginator</code> accepts almost the same arguments as the <code class=" language-php">Paginator</code>; however, it does require a count of the total number of items in the result set.</p>
    <p>In other words, the <code class=" language-php">Paginator</code> corresponds to the <code class=" language-php">simplePaginate</code> method on the query builder and Eloquent, while the <code class=" language-php">LengthAwarePaginator</code> corresponds to the <code class=" language-php">paginate</code> method.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> When manually creating a paginator instance, you should manually "slice" the array of results you pass to the paginator. If you're unsure how to do this, check out the <a href="http://php.net/manual/en/function.array-slice.php">array_slice</a> PHP function.</p>
    </blockquote>
    <p>
        <a name="displaying-pagination-results"></a>
    </p>
    <h2><a href="#displaying-pagination-results">Displaying Pagination Results</a></h2>
    <p>When calling the <code class=" language-php">paginate</code> method, you will receive an instance of <code class=" language-php">Illuminate\<span class="token package">Pagination<span class="token punctuation">\</span>LengthAwarePaginator</span></code>. When calling the <code class=" language-php">simplePaginate</code> method, you will receive an instance of <code class=" language-php">Illuminate\<span class="token package">Pagination<span class="token punctuation">\</span>Paginator</span></code>. These objects provide several methods that describe the result set. In addition to these helpers methods, the paginator instances are iterators and may be looped as an array. So, once you have retrieved the results, you may display the results and render the page links using <a href="/docs/5.3/blade">Blade</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>container<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
    @<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$users</span> <span class="token keyword">as</span> <span class="token variable">$user</span><span class="token punctuation">)</span>
        <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
    @<span class="token keyword">endforeach</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>

<span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$users</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">links<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>The <code class=" language-php">links</code> method will render the links to the rest of the pages in the result set. Each of these links will already contain the proper <code class=" language-php">page</code> query string variable. Remember, the HTML generated by the <code class=" language-php">links</code> method is compatible with the <a href="https://getbootstrap.com">Bootstrap CSS framework</a>.</p>
    <h4>Customizing The Paginator URI</h4>
    <p>The <code class=" language-php">setPath</code> method allows you to customize the URI used by the paginator when generating links. For example, if you want the paginator to generate links like <code class=" language-php">http<span class="token punctuation">:</span><span class="token operator">/</span><span class="token operator">/</span>example<span class="token punctuation">.</span>com<span class="token operator">/</span>custom<span class="token operator">/</span>url<span class="token operator">?</span>page<span class="token operator">=</span>N</code>, you should pass <code class=" language-php">custom<span class="token operator">/</span>url</code> to the <code class=" language-php">setPath</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">paginate<span class="token punctuation">(</span></span><span class="token number">15</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token variable">$users</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">setPath<span class="token punctuation">(</span></span><span class="token string">'custom/url'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Appending To Pagination Links</h4>
    <p>You may append to the query string of pagination links using the <code class=" language-php">appends</code> method. For example, to append <code class=" language-php">sort<span class="token operator">=</span>votes</code> to each pagination link, you should make the following call to <code class=" language-php">appends</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$users</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">appends<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'sort'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'votes'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">links<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>If you wish to append a "hash fragment" to the paginator's URLs, you may use the <code class=" language-php">fragment</code> method. For example, to append <code class=" language-php"><span class="token comment" spellcheck="true">#foo</span></code> to the end of each pagination link, make the following call to the <code class=" language-php">fragment</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$users</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">fragment<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">links<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="converting-results-to-json"></a>
    </p>
    <h3>Converting Results To JSON</h3>
    <p>The Laravel paginator result classes implement the <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Jsonable</span></code> Interface contract and expose the <code class=" language-php">toJson</code> method, so it's very easy to convert your pagination results to JSON. You may also convert a paginator instance to JSON by simply returning it from a route or controller action:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">paginate<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The JSON from the paginator will include meta information such as <code class=" language-php">total</code>, <code class=" language-php">current_page</code>, <code class=" language-php">last_page</code>, and more. The actual result objects will be available via the <code class=" language-php">data</code> key in the JSON array. Here is an example of the JSON created by returning a paginator instance from a route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span>
   <span class="token string">"total"</span><span class="token punctuation">:</span> <span class="token number">50</span><span class="token punctuation">,</span>
   <span class="token string">"per_page"</span><span class="token punctuation">:</span> <span class="token number">15</span><span class="token punctuation">,</span>
   <span class="token string">"current_page"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
   <span class="token string">"last_page"</span><span class="token punctuation">:</span> <span class="token number">4</span><span class="token punctuation">,</span>
   <span class="token string">"next_page_url"</span><span class="token punctuation">:</span> <span class="token string">"http://laravel.app?page=2"</span><span class="token punctuation">,</span>
   <span class="token string">"prev_page_url"</span><span class="token punctuation">:</span> <span class="token keyword">null</span><span class="token punctuation">,</span>
   <span class="token string">"from"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
   <span class="token string">"to"</span><span class="token punctuation">:</span> <span class="token number">15</span><span class="token punctuation">,</span>
   <span class="token string">"data"</span><span class="token punctuation">:</span><span class="token punctuation">[</span>
        <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // Result Object
</span>        <span class="token punctuation">}</span><span class="token punctuation">,</span>
        <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // Result Object
</span>        <span class="token punctuation">}</span>
   <span class="token punctuation">]</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="customizing-the-pagination-view"></a>
    </p>
    <h2><a href="#customizing-the-pagination-view">Customizing The Pagination View</a></h2>
    <p>By default, the views rendered to display the pagination links are compatible with the Bootstrap CSS framework. However, if you are not using Bootstrap, you are free to define your own views to render these links. When calling the <code class=" language-php">links</code> method on a paginator instance, pass the view name as the first argument to the method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$paginator</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">links<span class="token punctuation">(</span></span><span class="token string">'view.name'</span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>However, the easiest way to customize the pagination views is by exporting them to your <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>vendor</code> directory using the <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan vendor<span class="token punctuation">:</span>publish <span class="token operator">--</span>tag<span class="token operator">=</span>laravel<span class="token operator">-</span>pagination</code></pre>
    <p>This command will place the views in the <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>vendor<span class="token operator">/</span>pagination</code> directory. The <code class=" language-php"><span class="token keyword">default</span><span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code> file within this directory corresponds to the default pagination view. Simply edit this file to modify the pagination HTML.</p>
    <p>
        <a name="paginator-instance-methods"></a>
    </p>
    <h2><a href="#paginator-instance-methods">Paginator Instance Methods</a></h2>
    <p>Each paginator instance provides additional pagination information via the following methods:</p>
    <ul>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">count<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">currentPage<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">firstItem<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasMorePages<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">lastItem<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">lastPage<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">(</span>Not available when using simplePaginate<span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nextPageUrl<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">perPage<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">previousPageUrl<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">total<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">(</span>Not available when using simplePaginate<span class="token punctuation">)</span></code>
        </li>
        <li><code class=" language-php"><span class="token variable">$results</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">url<span class="token punctuation">(</span></span><span class="token variable">$page</span><span class="token punctuation">)</span></code>
        </li>
    </ul>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/pagination">https://laravel.com/docs/5.3/pagination</a></div>
</article>
@endsection