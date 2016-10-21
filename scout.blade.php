@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Laravel Scout</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#installation">Installation</a>
            <ul>
                <li><a href="#queueing">Queueing</a>
                </li>
                <li><a href="#driver-prerequisites">Driver Prerequisites</a>
                </li>
            </ul>
        </li>
        <li><a href="#configuration">Configuration</a>
            <ul>
                <li><a href="#configuring-model-indexes">Configuring Model Indexes</a>
                </li>
                <li><a href="#configuring-searchable-data">Configuring Searchable Data</a>
                </li>
            </ul>
        </li>
        <li><a href="#indexing">Indexing</a>
            <ul>
                <li><a href="#batch-import">Batch Import</a>
                </li>
                <li><a href="#adding-records">Adding Records</a>
                </li>
                <li><a href="#updating-records">Updating Records</a>
                </li>
                <li><a href="#removing-records">Removing Records</a>
                </li>
                <li><a href="#pausing-indexing">Pausing Indexing</a>
                </li>
            </ul>
        </li>
        <li><a href="#searching">Searching</a>
            <ul>
                <li><a href="#where-clauses">Where Clauses</a>
                </li>
                <li><a href="#pagination">Pagination</a>
                </li>
            </ul>
        </li>
        <li><a href="#custom-engines">Custom Engines</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel Scout provides a simple, driver based solution for adding full-text search to your <a href="/docs/5.3/eloquent">Eloquent models</a>. Using model observers, Scout will automatically keep your search indexes in sync with your Eloquent records.</p>
    <p>Currently, Scout ships with an <a href="https://www.algolia.com/">Algolia</a> driver; however, writing custom drivers is simple and you are free to extend Scout with your own search implementations.</p>
    <p>
        <a name="installation"></a>
    </p>
    <h2><a href="#installation">Installation</a></h2>
    <p>First, install the Scout via the Composer package manager:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> laravel<span class="token operator">/</span>scout</code></pre>
    <p>Next, you should add the <code class=" language-php">ScoutServiceProvider</code> to the <code class=" language-php">providers</code> array of your <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> configuration file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Laravel<span class="token punctuation">\</span>Scout<span class="token punctuation">\</span>ScoutServiceProvider<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span></code></pre>
    <p>After registering the Scout service provider, you should publish the Scout configuration using the <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> Artisan command. This command will publish the <code class=" language-php">scout<span class="token punctuation">.</span>php</code> configuration file to your <code class=" language-php">config</code> directory:</p>
    <pre class=" language-php"><code class=" language-php">php artisan vendor<span class="token punctuation">:</span>publish <span class="token operator">--</span>provider<span class="token operator">=</span><span class="token string">"Laravel\Scout\ScoutServiceProvider"</span></code></pre>
    <p>Finally, add the <code class=" language-php">Laravel\<span class="token package">Scout<span class="token punctuation">\</span>Searchable</span></code> trait to the model you would like to make searchable. This trait will register a model observer to keep the model in sync with your search driver:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Scout<span class="token punctuation">\</span>Searchable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Post</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">Searchable</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="queueing"></a>
    </p>
    <h3>Queueing</h3>
    <p>While not strictly required to use Scout, you should strongly consider configuring a <a href="/docs/5.3/queues">queue driver</a> before using the library. Running a queue worker will allow Scout to queue all operations that sync your model information to your search indexes, providing much better response times for your application's web interface.</p>
    <p>Once you have configured a queue driver, set the value of the <code class=" language-php">queue</code> option in your <code class=" language-php">config<span class="token operator">/</span>scout<span class="token punctuation">.</span>php</code> configuration file to <code class=" language-php"><span class="token boolean">true</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'queue'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="driver-prerequisites"></a>
    </p>
    <h3>Driver Prerequisites</h3>
    <h4>Algolia</h4>
    <p>When using the Algolia driver, you should configure your Algolia <code class=" language-php">id</code> and <code class=" language-php">secret</code> credentials in your <code class=" language-php">config<span class="token operator">/</span>scout<span class="token punctuation">.</span>php</code> configuration file. Once your credentials have been configured, you will also need to install the Algolia PHP SDK via the Composer package manager:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> algolia<span class="token operator">/</span>algoliasearch<span class="token operator">-</span>client<span class="token operator">-</span>php</code></pre>
    <p>
        <a name="configuration"></a>
    </p>
    <h2><a href="#configuration">Configuration</a></h2>
    <p>
        <a name="configuring-model-indexes"></a>
    </p>
    <h3>Configuring Model Indexes</h3>
    <p>Each Eloquent model is synced with a given search "index", which contains all of the searchable records for that model. In other words, you can think of each index like a MySQL table. By default, each model will be persisted to an index matching the model's typical "table" name. Typically, this is the plural form of the model name; however, you are free to customize the model's index by overriding the <code class=" language-php">searchableAs</code> method on the model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Scout<span class="token punctuation">\</span>Searchable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Post</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">Searchable</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Get the index name for the model.
     *
     * @return string
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">searchableAs<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token string">'posts_index'</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="configuring-searchable-data"></a>
    </p>
    <h3>Configuring Searchable Data</h3>
    <p>By default, the entire <code class=" language-php">toArray</code> form of a given model will be persisted to its search index. If you would like to customize the data that is synchronized to the search index, you may override the <code class=" language-php">toSearchableArray</code> method on the model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Scout<span class="token punctuation">\</span>Searchable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Post</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">Searchable</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Get the indexable data array for the model.
     *
     * @return array
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">toSearchableArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$array</span> <span class="token operator">=</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Customize array...
</span>
        <span class="token keyword">return</span> <span class="token variable">$array</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="indexing"></a>
    </p>
    <h2><a href="#indexing">Indexing</a></h2>
    <p>
        <a name="batch-import"></a>
    </p>
    <h3>Batch Import</h3>
    <p>If you are installing Scout into an existing project, you may already have database records you need to import into your search driver. Scout provides an <code class=" language-php">import</code> Artisan command that you may use to import all of your existing records into your search indexes:</p>
    <pre class=" language-php"><code class=" language-php">php artisan scout<span class="token punctuation">:</span>import <span class="token string">"App\Post"</span></code></pre>
    <p>
        <a name="adding-records"></a>
    </p>
    <h3>Adding Records</h3>
    <p>Once you have added the <code class=" language-php">Laravel\<span class="token package">Scout<span class="token punctuation">\</span>Searchable</span></code> trait to a model, all you need to do is <code class=" language-php">save</code> a model instance and it will automatically be added to your search index. If you have configured Scout to <a href="#queueing">use queues</a> this operation will be performed in the background by your queue worker:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$order</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">App<span class="token punctuation">\</span>Order</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// ...
</span>
<span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Adding Via Query</h4>
    <p>If you would like to add a collection of models to your search index via an Eloquent query, you may chain the <code class=" language-php">searchable</code> method onto an Eloquent query. The <code class=" language-php">searchable</code> method will <a href="/docs/5.3/eloquent#chunking-results">chunk the results</a> of the query and add the records to your search index. Again, if you have configured Scout to use queues, all of the chunks will be added in the background by your queue workers:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Adding via Eloquent query...
</span><span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'price'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">searchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// You may also add records via relationships...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orders<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">searchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// You may also add records via collections...
</span><span class="token variable">$orders</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">searchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">searchable</code> method can be considered an "upsert" operation. In other words, if the model record is already in your index, it will be updated. If it does not exist in the search index, it will be added to the index.</p>
    <p>
        <a name="updating-records"></a>
    </p>
    <h3>Updating Records</h3>
    <p>To update a searchable model, you only need to update the model instance's properties and <code class=" language-php">save</code> the model to your database. Scout will automatically persist the changes to your search index:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$order</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Update the order...
</span>
<span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may also use the <code class=" language-php">searchable</code> method on an Eloquent query to update a collection of models. If the models do not exist in your search index, they will be created:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Updating via Eloquent query...
</span><span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'price'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">searchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// You may also update via relationships...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orders<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">searchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// You may also update via collections...
</span><span class="token variable">$orders</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">searchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="removing-records"></a>
    </p>
    <h3>Removing Records</h3>
    <p>To remove a record from your index, simply <code class=" language-php">delete</code> the model from the database. This form of removal is even compatible with <a href="/docs/5.3/eloquent#soft-deleting">soft deleted</a> models:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$order</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">delete<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you do not want to retrieve the model before deleting the record, you may use the <code class=" language-php">unsearchable</code> method on an Eloquent query instance or collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Removing via Eloquent query...
</span><span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'price'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsearchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// You may also remove via relationships...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orders<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsearchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// You may also remove via collections...
</span><span class="token variable">$orders</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unsearchable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="pausing-indexing"></a>
    </p>
    <h3>Pausing Indexing</h3>
    <p>Sometimes you may need to perform a batch of Eloquent operations on a model without syncing the model data to your search index. You may do this using the <code class=" language-php">withoutSyncingToSearch</code> method. This method accepts a single callback which will be immediately executed. Any model operations that occur within the callback will not be synced to the model's index:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">withoutSyncingToSearch<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Perform model actions...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="searching"></a>
    </p>
    <h2><a href="#searching">Searching</a></h2>
    <p>You may begin searching a model using the <code class=" language-php">search</code> method. The search method accepts a single string that will be used to search your models. You should then chain the <code class=" language-php">get</code> method onto the search query to retrieve the Eloquent models that match the given search query:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$orders</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">search<span class="token punctuation">(</span></span><span class="token string">'Star Trek'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Since Scout searches return a collection of Eloquent models, you may even return the results directly from a route or controller and they will automatically be converted to JSON:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/search'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span>Request <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">search<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">search</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="where-clauses"></a>
    </p>
    <h3>Where Clauses</h3>
    <p>Scout allows you to add simple "where" clauses to your search queries. Currently, these clauses only support basic numeric equality checks, and are primarily useful for scoping search queries by a tenant ID. Since a search index is not a relational database, more advanced "where" clauses are not currently supported:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$orders</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">search<span class="token punctuation">(</span></span><span class="token string">'Star Trek'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'user_id'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="pagination"></a>
    </p>
    <h3>Pagination</h3>
    <p>In addition to retrieving a collection of models, you may paginate your search results using the <code class=" language-php">paginate</code> method. This method will return a <code class=" language-php">Paginator</code> instance just as if you had <a href="/docs/5.3/pagination">paginated a traditional Eloquent query</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$orders</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">search<span class="token punctuation">(</span></span><span class="token string">'Star Trek'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">paginate<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may specify how many models to retrieve per page by passing the amount as the first argument to the <code class=" language-php">paginate</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$orders</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Order<span class="token punctuation">::</span></span><span class="token function">search<span class="token punctuation">(</span></span><span class="token string">'Star Trek'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">paginate<span class="token punctuation">(</span></span><span class="token number">15</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Once you have retrieved the results, you may display the results and render the page links using <a href="/docs/5.3/blade">Blade</a> just as if you had paginated a traditional Eloquent query:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>container<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
    @<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$orders</span> <span class="token keyword">as</span> <span class="token variable">$order</span><span class="token punctuation">)</span>
        <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">price</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
    @<span class="token keyword">endforeach</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>

<span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$orders</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">links<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="custom-engines"></a>
    </p>
    <h2><a href="#custom-engines">Custom Engines</a></h2>
    <h4>Writing The Engine</h4>
    <p>If one of the built-in Scout search engines doesn't fit your needs, you may write your own custom engine and register it with Scout. Your engine should extend the <code class=" language-php">Laravel\<span class="token package">Scout<span class="token punctuation">\</span>Engines<span class="token punctuation">\</span>Engine</span></code> abstract class. This abstract class contains five methods your custom engine must implement:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Scout<span class="token punctuation">\</span>Builder</span><span class="token punctuation">;</span>

<span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">update<span class="token punctuation">(</span></span><span class="token variable">$models</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">delete<span class="token punctuation">(</span></span><span class="token variable">$models</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">search<span class="token punctuation">(</span></span>Builder <span class="token variable">$builder</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">paginate<span class="token punctuation">(</span></span>Builder <span class="token variable">$builder</span><span class="token punctuation">,</span> <span class="token variable">$perPage</span><span class="token punctuation">,</span> <span class="token variable">$page</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">map<span class="token punctuation">(</span></span><span class="token variable">$results</span><span class="token punctuation">,</span> <span class="token variable">$model</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may find it helpful to review the implementations of these methods on the <code class=" language-php">Laravel\<span class="token package">Scout<span class="token punctuation">\</span>Engines<span class="token punctuation">\</span>AlgoliaEngine</span></code> class. This class will provide you with a good starting point for learning how to implement each of these methods in your own engine.</p>
    <h4>Registering The Engine</h4>
    <p>Once you have written your custom engine, you may register it with Scout using the <code class=" language-php">extend</code> method of the Scout engine manager. You should call the <code class=" language-php">extend</code> method from the <code class=" language-php">boot</code> method of your <code class=" language-php">AppServiceProvider</code> or any other service provider used by your application. For example, if you have written a <code class=" language-php">MySqlSearchEngine</code>, you may register it like so:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Scout<span class="token punctuation">\</span>EngineManager</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/**
 * Bootstrap any application services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token function">resolve<span class="token punctuation">(</span></span><span class="token scope">EngineManager<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">extend<span class="token punctuation">(</span></span><span class="token string">'mysql'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">MySqlSearchEngine</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once your engine has been registered, you may specify it as your default Scout <code class=" language-php">driver</code> in your <code class=" language-php">config<span class="token operator">/</span>scout<span class="token punctuation">.</span>php</code> configuration file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'driver'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'mysql'</span><span class="token punctuation">,</span></code></pre>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/scout">https://laravel.com/docs/5.3/scout</a></div>
</article>
@endsection