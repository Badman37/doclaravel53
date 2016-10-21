@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Eloquent: Getting Started</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#defining-models">Defining Models</a>
            <ul>
                <li><a href="#eloquent-model-conventions">Eloquent Model Conventions</a>
                </li>
            </ul>
        </li>
        <li><a href="#retrieving-models">Retrieving Models</a>
            <ul>
                <li><a href="#collections">Collections</a>
                </li>
                <li><a href="#chunking-results">Chunking Results</a>
                </li>
            </ul>
        </li>
        <li><a href="#retrieving-single-models">Retrieving Single Models / Aggregates</a>
            <ul>
                <li><a href="#retrieving-aggregates">Retrieving Aggregates</a>
                </li>
            </ul>
        </li>
        <li><a href="#inserting-and-updating-models">Inserting &amp; Updating Models</a>
            <ul>
                <li><a href="#inserts">Inserts</a>
                </li>
                <li><a href="#updates">Updates</a>
                </li>
                <li><a href="#mass-assignment">Mass Assignment</a>
                </li>
                <li><a href="#other-creation-methods">Other Creation Methods</a>
                </li>
            </ul>
        </li>
        <li><a href="#deleting-models">Deleting Models</a>
            <ul>
                <li><a href="#soft-deleting">Soft Deleting</a>
                </li>
                <li><a href="#querying-soft-deleted-models">Querying Soft Deleted Models</a>
                </li>
            </ul>
        </li>
        <li><a href="#query-scopes">Query Scopes</a>
            <ul>
                <li><a href="#global-scopes">Global Scopes</a>
                </li>
                <li><a href="#local-scopes">Local Scopes</a>
                </li>
            </ul>
        </li>
        <li><a href="#events">Events</a>
            <ul>
                <li><a href="#observers">Observers</a>
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>The Eloquent ORM included with Laravel provides a beautiful, simple ActiveRecord implementation for working with your database. Each database table has a corresponding "Model" which is used to interact with that table. Models allow you to query for data in your tables, as well as insert new records into the table.</p>
    <p>Before getting started, be sure to configure a database connection in <code class=" language-php">config<span class="token operator">/</span>database<span class="token punctuation">.</span>php</code>. For more information on configuring your database, check out <a href="/docs/5.3/database#configuration">the documentation</a>.</p>
    <p>
        <a name="defining-models"></a>
    </p>
    <h2><a href="#defining-models">Defining Models</a></h2>
    <p>To get started, let's create an Eloquent model. Models typically live in the <code class=" language-php">app</code> directory, but you are free to place them anywhere that can be auto-loaded according to your <code class=" language-php">composer<span class="token punctuation">.</span>json</code> file. All Eloquent models extend <code class=" language-php">Illuminate\<span class="token package">Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span></code> class.</p>
    <p>The easiest way to create a model instance is using the <code class=" language-php">make<span class="token punctuation">:</span>model</code> <a href="/docs/5.3/artisan">Artisan command</a>:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>model User</code></pre>
    <p>If you would like to generate a <a href="/docs/5.3/migrations">database migration</a> when you generate the model, you may use the <code class=" language-php"><span class="token operator">--</span>migration</code> or <code class=" language-php"><span class="token operator">-</span>m</code> option:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>model User <span class="token operator">--</span>migration

php artisan make<span class="token punctuation">:</span>model User <span class="token operator">-</span>m</code></pre>
    <p>
        <a name="eloquent-model-conventions"></a>
    </p>
    <h3>Eloquent Model Conventions</h3>
    <p>Now, let's look at an example <code class=" language-php">Flight</code> model, which we will use to retrieve and store information from our <code class=" language-php">flights</code> database table:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Flight</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Table Names</h4>
    <p>Note that we did not tell Eloquent which table to use for our <code class=" language-php">Flight</code> model. By convention, the "snake case", plural name of the class will be used as the table name unless another name is explicitly specified. So, in this case, Eloquent will assume the <code class=" language-php">Flight</code> model stores records in the <code class=" language-php">flights</code> table. You may specify a custom table by defining a <code class=" language-php">table</code> property on your model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Flight</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The table associated with the model.
     *
     * @var string
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$table</span> <span class="token operator">=</span> <span class="token string">'my_flights'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Primary Keys</h4>
    <p>Eloquent will also assume that each table has a primary key column named <code class=" language-php">id</code>. You may define a <code class=" language-php"><span class="token variable">$primaryKey</span></code> property to override this convention.</p>
    <p>In addition, Eloquent assumes that the primary key is an incrementing integer value, which means that by default the primary key will be cast to an <code class=" language-php">int</code> automatically. If you wish to use a non-incrementing or a non-numeric primary key you must set the public <code class=" language-php"><span class="token variable">$incrementing</span></code> property on your model to <code class=" language-php"><span class="token boolean">false</span></code>.</p>
    <h4>Timestamps</h4>
    <p>By default, Eloquent expects <code class=" language-php">created_at</code> and <code class=" language-php">updated_at</code> columns to exist on your tables. If you do not wish to have these columns automatically managed by Eloquent, set the <code class=" language-php"><span class="token variable">$timestamps</span></code> property on your model to <code class=" language-php"><span class="token boolean">false</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Flight</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */</span>
    <span class="token keyword">public</span> <span class="token variable">$timestamps</span> <span class="token operator">=</span> <span class="token boolean">false</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>If you need to customize the format of your timestamps, set the <code class=" language-php"><span class="token variable">$dateFormat</span></code> property on your model. This property determines how date attributes are stored in the database, as well as their format when the model is serialized to an array or JSON:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Flight</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The storage format of the model's date columns.
     *
     * @var string
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$dateFormat</span> <span class="token operator">=</span> <span class="token string">'U'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Database Connection</h4>
    <p>By default, all Eloquent models will use the default database connection configured for your application. If you would like to specify a different connection for the model, use the <code class=" language-php"><span class="token variable">$connection</span></code> property:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Flight</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The connection name for the model.
     *
     * @var string
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$connection</span> <span class="token operator">=</span> <span class="token string">'connection-name'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="retrieving-models"></a>
    </p>
    <h2><a href="#retrieving-models">Retrieving Models</a></h2>
    <p>Once you have created a model and <a href="/docs/5.3/migrations#writing-migrations">its associated database table</a>, you are ready to start retrieving data from your database. Think of each Eloquent model as a powerful <a href="/docs/5.3/queries">query builder</a> allowing you to fluently query the database table associated with the model. For example:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Flight</span><span class="token punctuation">;</span>

<span class="token variable">$flights</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$flights</span> <span class="token keyword">as</span> <span class="token variable">$flight</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">echo</span> <span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Adding Additional Constraints</h4>
    <p>The Eloquent <code class=" language-php">all</code> method will return all of the results in the model's table. Since each Eloquent model serves as a <a href="/docs/5.3/queries">query builder</a>, you may also add constraints to queries, and then use the <code class=" language-php">get</code> method to retrieve the results:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flights</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span>
               <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orderBy<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'desc'</span><span class="token punctuation">)</span>
               <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">take<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span>
               <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Since Eloquent models are query builders, you should review all of the methods available on the <a href="/docs/5.3/queries">query builder</a>. You may use any of these methods in your Eloquent queries.</p>
    </blockquote>
    <p>
        <a name="collections"></a>
    </p>
    <h3>Collections</h3>
    <p>For Eloquent methods like <code class=" language-php">all</code> and <code class=" language-php">get</code> which retrieve multiple results, an instance of <code class=" language-php">Illuminate\<span class="token package">Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Collection</span></code> will be returned. The <code class=" language-php">Collection</code> class provides <a href="/docs/5.3/eloquent-collections#available-methods">a variety of helpful methods</a> for working with your Eloquent results:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flights</span> <span class="token operator">=</span> <span class="token variable">$flights</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">reject<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$flight</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">cancelled</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Of course, you may also simply loop over the collection like an array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$flights</span> <span class="token keyword">as</span> <span class="token variable">$flight</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">echo</span> <span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="chunking-results"></a>
    </p>
    <h3>Chunking Results</h3>
    <p>If you need to process thousands of Eloquent records, use the <code class=" language-php">chunk</code> command. The <code class=" language-php">chunk</code> method will retrieve a "chunk" of Eloquent models, feeding them to a given <code class=" language-php">Closure</code> for processing. Using the <code class=" language-php">chunk</code> method will conserve memory when working with large result sets:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Flight<span class="token punctuation">::</span></span><span class="token function">chunk<span class="token punctuation">(</span></span><span class="token number">200</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$flights</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$flights</span> <span class="token keyword">as</span> <span class="token variable">$flight</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The first argument passed to the method is the number of records you wish to receive per "chunk". The Closure passed as the second argument will be called for each chunk that is retrieved from the database. A database query will be executed to retrieve each chunk of records passed to the Closure.</p>
    <h4>Using Cursors</h4>
    <p>The <code class=" language-php">cursor</code> method allows you to iterate through your database records using a cursor, which will only execute a single query. When processing large amounts of data, the <code class=" language-php">cursor</code> method may be used to greatly reduce your memory usage:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token scope">Flight<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">,</span> <span class="token string">'bar'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cursor<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token keyword">as</span> <span class="token variable">$flight</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="retrieving-single-models"></a>
    </p>
    <h2><a href="#retrieving-single-models">Retrieving Single Models / Aggregates</a></h2>
    <p>Of course, in addition to retrieving all of the records for a given table, you may also retrieve single records using <code class=" language-php">find</code> and <code class=" language-php">first</code>. Instead of returning a collection of models, these methods return a single model instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Retrieve a model by its primary key...
</span><span class="token variable">$flight</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Retrieve the first model matching the query constraints...
</span><span class="token variable">$flight</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">first<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may also call the <code class=" language-php">find</code> method with an array of primary keys, which will return a collection of the matching records:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flights</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Not Found Exceptions</h4>
    <p>Sometimes you may wish to throw an exception if a model is not found. This is particularly useful in routes or controllers. The <code class=" language-php">findOrFail</code> and <code class=" language-php">firstOrFail</code> methods will retrieve the first result of the query; however, if no result is found, a <code class=" language-php">Illuminate\<span class="token package">Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>ModelNotFoundException</span></code> will be thrown:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$model</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">findOrFail<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$model</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'legs'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">firstOrFail<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If the exception is not caught, a <code class=" language-php"><span class="token number">404</span></code> HTTP response is automatically sent back to the user. It is not necessary to write explicit checks to return <code class=" language-php"><span class="token number">404</span></code> responses when using these methods:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/api/flights/{id}'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$id</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">findOrFail<span class="token punctuation">(</span></span><span class="token variable">$id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="retrieving-aggregates"></a>
    </p>
    <h3>Retrieving Aggregates</h3>
    <p>You may also use the <code class=" language-php">count</code>, <code class=" language-php">sum</code>, <code class=" language-php">max</code>, and other <a href="/docs/5.3/queries#aggregates">aggregate methods</a> provided by the <a href="/docs/5.3/queries">query builder</a>. These methods return the appropriate scalar value instead of a full model instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$count</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">count<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$max</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">max<span class="token punctuation">(</span></span><span class="token string">'price'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="inserting-and-updating-models"></a>
    </p>
    <h2><a href="#inserting-and-updating-models">Inserting &amp; Updating Models</a></h2>
    <p>
        <a name="inserts"></a>
    </p>
    <h3>Inserts</h3>
    <p>To create a new record in the database, simply create a new model instance, set attributes on the model, then call the <code class=" language-php">save</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Flight</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">FlightController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Create a new flight instance.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Validate the request...
</span>
        <span class="token variable">$flight</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Flight</span><span class="token punctuation">;</span>

        <span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>

        <span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>In this example, we simply assign the <code class=" language-php">name</code> parameter from the incoming HTTP request to the <code class=" language-php">name</code> attribute of the <code class=" language-php">App\<span class="token package">Flight</span></code> model instance. When we call the <code class=" language-php">save</code> method, a record will be inserted into the database. The <code class=" language-php">created_at</code> and <code class=" language-php">updated_at</code> timestamps will automatically be set when the <code class=" language-php">save</code> method is called, so there is no need to set them manually.</p>
    <p>
        <a name="updates"></a>
    </p>
    <h3>Updates</h3>
    <p>The <code class=" language-php">save</code> method may also be used to update models that already exist in the database. To update a model, you should retrieve it, set any attributes you wish to update, and then call the <code class=" language-php">save</code> method. Again, the <code class=" language-php">updated_at</code> timestamp will automatically be updated, so there is no need to manually set its value:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flight</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span> <span class="token operator">=</span> <span class="token string">'New Flight Name'</span><span class="token punctuation">;</span>

<span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Mass Updates</h4>
    <p>Updates can also be performed against any number of models that match a given query. In this example, all flights that are <code class=" language-php">active</code> and have a <code class=" language-php">destination</code> of <code class=" language-php">San Diego</code> will be marked as delayed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'destination'</span><span class="token punctuation">,</span> <span class="token string">'San Diego'</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">update<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'delayed'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">update</code> method expects an array of column and value pairs representing the columns that should be updated.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> When issuing a mass update via Eloquent, the <code class=" language-php">saved</code> and <code class=" language-php">updated</code> model events will not be fired for the updated models. This is because the models are never actually retrieved when issuing a mass update.</p>
    </blockquote>
    <p>
        <a name="mass-assignment"></a>
    </p>
    <h3>Mass Assignment</h3>
    <p>You may also use the <code class=" language-php">create</code> method to save a new model in a single line. The inserted model instance will be returned to you from the method. However, before doing so, you will need to specify either a <code class=" language-php">fillable</code> or <code class=" language-php">guarded</code> attribute on the model, as all Eloquent models protect against mass-assignment by default.</p>
    <p>A mass-assignment vulnerability occurs when a user passes an unexpected HTTP parameter through a request, and that parameter changes a column in your database you did not expect. For example, a malicious user might send an <code class=" language-php">is_admin</code> parameter through an HTTP request, which is then passed into your model's <code class=" language-php">create</code> method, allowing the user to escalate themselves to an administrator.</p>
    <p>So, to get started, you should define which model attributes you want to make mass assignable. You may do this using the <code class=" language-php"><span class="token variable">$fillable</span></code> property on the model. For example, let's make the <code class=" language-php">name</code> attribute of our <code class=" language-php">Flight</code> model mass assignable:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Flight</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The attributes that are mass assignable.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$fillable</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'name'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once we have made the attributes mass assignable, we can use the <code class=" language-php">create</code> method to insert a new record in the database. The <code class=" language-php">create</code> method returns the saved model instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flight</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Flight 10'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Guarding Attributes</h4>
    <p>While <code class=" language-php"><span class="token variable">$fillable</span></code> serves as a "white list" of attributes that should be mass assignable, you may also choose to use <code class=" language-php"><span class="token variable">$guarded</span></code>. The <code class=" language-php"><span class="token variable">$guarded</span></code> property should contain an array of attributes that you do not want to be mass assignable. All other attributes not in the array will be mass assignable. So, <code class=" language-php"><span class="token variable">$guarded</span></code> functions like a "black list". Of course, you should use either <code class=" language-php"><span class="token variable">$fillable</span></code> or <code class=" language-php"><span class="token variable">$guarded</span></code> - not both. In the example below, all attributes <strong>except for <code class=" language-php">price</code></strong> will be mass assignable:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Flight</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$guarded</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'price'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>If you would like to make all attributes mass assignable, you may define the <code class=" language-php"><span class="token variable">$guarded</span></code> property as an empty array:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * The attributes that aren't mass assignable.
 *
 * @var array
 */</span>
<span class="token keyword">protected</span> <span class="token variable">$guarded</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="other-creation-methods"></a>
    </p>
    <h3>Other Creation Methods</h3>
    <p>There are two other methods you may use to create models by mass assigning attributes: <code class=" language-php">firstOrCreate</code> and <code class=" language-php">firstOrNew</code>. The <code class=" language-php">firstOrCreate</code> method will attempt to locate a database record using the given column / value pairs. If the model can not be found in the database, a record will be inserted with the given attributes.</p>
    <p>The <code class=" language-php">firstOrNew</code> method, like <code class=" language-php">firstOrCreate</code> will attempt to locate a record in the database matching the given attributes. However, if a model is not found, a new model instance will be returned. Note that the model returned by <code class=" language-php">firstOrNew</code> has not yet been persisted to the database. You will need to call <code class=" language-php">save</code> manually to persist it:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Retrieve the flight by the attributes, or create it if it doesn't exist...
</span><span class="token variable">$flight</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">firstOrCreate<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Flight 10'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Retrieve the flight by the attributes, or instantiate a new instance...
</span><span class="token variable">$flight</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">firstOrNew<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Flight 10'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="deleting-models"></a>
    </p>
    <h2><a href="#deleting-models">Deleting Models</a></h2>
    <p>To delete a model, call the <code class=" language-php">delete</code> method on a model instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flight</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">delete<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Deleting An Existing Model By Key</h4>
    <p>In the example above, we are retrieving the model from the database before calling the <code class=" language-php">delete</code> method. However, if you know the primary key of the model, you may delete the model without retrieving it. To do so, call the <code class=" language-php">destroy</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">destroy<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">destroy<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">destroy<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Deleting Models By Query</h4>
    <p>Of course, you may also run a delete statement on a set of models. In this example, we will delete all flights that are marked as inactive. Like mass updates, mass deletes will not fire any model events for the models that are deleted:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$deletedRows</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">delete<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> When executing a mass delete statement via Eloquent, the <code class=" language-php">deleting</code> and <code class=" language-php">deleted</code> model events will not be fired for the deleted models. This is because the models are never actually retrieved when executing the delete statement.</p>
    </blockquote>
    <p>
        <a name="soft-deleting"></a>
    </p>
    <h3>Soft Deleting</h3>
    <p>In addition to actually removing records from your database, Eloquent can also "soft delete" models. When models are soft deleted, they are not actually removed from your database. Instead, a <code class=" language-php">deleted_at</code> attribute is set on the model and inserted into the database. If a model has a non-null <code class=" language-php">deleted_at</code> value, the model has been soft deleted. To enable soft deletes for a model, use the <code class=" language-php">Illuminate\<span class="token package">Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>SoftDeletes</span></code> trait on the model and add the <code class=" language-php">deleted_at</code> column to your <code class=" language-php"><span class="token variable">$dates</span></code> property:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>SoftDeletes</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Flight</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">SoftDeletes</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$dates</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'deleted_at'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Of course, you should add the <code class=" language-php">deleted_at</code> column to your database table. The Laravel <a href="/docs/5.3/migrations">schema builder</a> contains a helper method to create this column:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Schema<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token string">'flights'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$table</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">softDeletes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Now, when you call the <code class=" language-php">delete</code> method on the model, the <code class=" language-php">deleted_at</code> column will be set to the current date and time. And, when querying a model that uses soft deletes, the soft deleted models will automatically be excluded from all query results.</p>
    <p>To determine if a given model instance has been soft deleted, use the <code class=" language-php">trashed</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">trashed<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="querying-soft-deleted-models"></a>
    </p>
    <h3>Querying Soft Deleted Models</h3>
    <h4>Including Soft Deleted Models</h4>
    <p>As noted above, soft deleted models will automatically be excluded from query results. However, you may force soft deleted models to appear in a result set using the <code class=" language-php">withTrashed</code> method on the query:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flights</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">withTrashed<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'account_id'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">withTrashed</code> method may also be used on a <a href="/docs/5.3/eloquent-relationships">relationship</a> query:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">history<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withTrashed<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Retrieving Only Soft Deleted Models</h4>
    <p>The <code class=" language-php">onlyTrashed</code> method will retrieve <strong>only</strong> soft deleted models:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flights</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">onlyTrashed<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'airline_id'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Restoring Soft Deleted Models</h4>
    <p>Sometimes you may wish to "un-delete" a soft deleted model. To restore a soft deleted model into an active state, use the <code class=" language-php">restore</code> method on a model instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">restore<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may also use the <code class=" language-php">restore</code> method in a query to quickly restore multiple models. Again, like other "mass" operations, this will not fire any model events for the models that are restored:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">App<span class="token punctuation">\</span>Flight<span class="token punctuation">::</span></span><span class="token function">withTrashed<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
        <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'airline_id'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span>
        <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">restore<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Like the <code class=" language-php">withTrashed</code> method, the <code class=" language-php">restore</code> method may also be used on <a href="/docs/5.3/eloquent-relationships">relationships</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">history<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">restore<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Permanently Deleting Models</h4>
    <p>Sometimes you may need to truly remove a model from your database. To permanently remove a soft deleted model from the database, use the <code class=" language-php">forceDelete</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Force deleting a single model instance...
</span><span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">forceDelete<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Force deleting all related models...
</span><span class="token variable">$flight</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">history<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">forceDelete<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="query-scopes"></a>
    </p>
    <h2><a href="#query-scopes">Query Scopes</a></h2>
    <p>
        <a name="global-scopes"></a>
    </p>
    <h3>Global Scopes</h3>
    <p>Global scopes allow you to add constraints to all queries for a given model. Laravel's own <a href="#soft-deleting">soft delete</a> functionality utilizes global scopes to only pull "non-deleted" models from the database. Writing your own global scopes can provide a convenient, easy way to make sure every query for a given model receives certain constraints.</p>
    <h4>Writing Global Scopes</h4>
    <p>Writing a global scope is simple. Define a class that implements the <code class=" language-php">Illuminate\<span class="token package">Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Scope</span></code> interface. This interface requires you to implement one method: <code class=" language-php">apply</code>. The <code class=" language-php">apply</code> method may add <code class=" language-php">where</code> constraints to the query as needed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Scopes</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Scope</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Builder</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AgeScope</span> <span class="token keyword">implements</span> <span class="token class-name">Scope</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">apply<span class="token punctuation">(</span></span>Builder <span class="token variable">$builder</span><span class="token punctuation">,</span> Model <span class="token variable">$model</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$builder</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'age'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> There is not a predefined folder for scopes in a default Laravel application, so feel free to make your own <code class=" language-php">Scopes</code> folder within your Laravel application's <code class=" language-php">app</code> directory.</p>
    </blockquote>
    <h4>Applying Global Scopes</h4>
    <p>To assign a global scope to a model, you should override a given model's <code class=" language-php">boot</code> method and use the <code class=" language-php">addGlobalScope</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Scopes<span class="token punctuation">\</span>AgeScope</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The "booting" method of the model.
     *
     * @return void
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword">static</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope"><span class="token keyword">parent</span><span class="token punctuation">::</span></span><span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token scope"><span class="token keyword">static</span><span class="token punctuation">::</span></span><span class="token function">addGlobalScope<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">AgeScope</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>After adding the scope, a query to <code class=" language-php"><span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code> will produce the following SQL:</p>
    <pre class=" language-php"><code class=" language-php">select <span class="token operator">*</span> from `users` where `age` <span class="token operator">&gt;</span> <span class="token number">200</span></code></pre>
    <h4>Anonymous Global Scopes</h4>
    <p>Eloquent also allows you to define global scopes using Closures, which is particularly useful for simple scopes that do not warrant a separate class:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Builder</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The "booting" method of the model.
     *
     * @return void
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword">static</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope"><span class="token keyword">parent</span><span class="token punctuation">::</span></span><span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token scope"><span class="token keyword">static</span><span class="token punctuation">::</span></span><span class="token function">addGlobalScope<span class="token punctuation">(</span></span><span class="token string">'age'</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span>Builder <span class="token variable">$builder</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token variable">$builder</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'age'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>The first argument of the <code class=" language-php"><span class="token function">addGlobalScope<span class="token punctuation">(</span></span><span class="token punctuation">)</span></code> serves as an identifier to remove the scope:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">withoutGlobalScope<span class="token punctuation">(</span></span><span class="token string">'age'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Removing Global Scopes</h4>
    <p>If you would like to remove a global scope for a given query, you may use the <code class=" language-php">withoutGlobalScope</code> method. The method accepts the class name of the global scope as its only argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">withoutGlobalScope<span class="token punctuation">(</span></span><span class="token scope">AgeScope<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you would like to remove several or even all of the global scopes, you may use the <code class=" language-php">withoutGlobalScopes</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Remove all of the global scopes...
</span><span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">withoutGlobalScopes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Remove some of the global scopes...
</span><span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">withoutGlobalScopes<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token scope">FirstScope<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token scope">SecondScope<span class="token punctuation">::</span></span><span class="token keyword">class</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="local-scopes"></a>
    </p>
    <h3>Local Scopes</h3>
    <p>Local scopes allow you to define common sets of constraints that you may easily re-use throughout your application. For example, you may need to frequently retrieve all users that are considered "popular". To define a scope, simply prefix an Eloquent model method with <code class=" language-php">scope</code>.</p>
    <p>Scopes should always return a query builder instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Scope a query to only include popular users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">scopePopular<span class="token punctuation">(</span></span><span class="token variable">$query</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'votes'</span><span class="token punctuation">,</span> <span class="token string">'&gt;'</span><span class="token punctuation">,</span> <span class="token number">100</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">scopeActive<span class="token punctuation">(</span></span><span class="token variable">$query</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Utilizing A Local Scope</h4>
    <p>Once the scope has been defined, you may call the scope methods when querying the model. However, you do not need to include the <code class=" language-php">scope</code> prefix when calling the method. You can even chain calls to various scopes, for example:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">popular<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">active<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orderBy<span class="token punctuation">(</span></span><span class="token string">'created_at'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Dynamic Scopes</h4>
    <p>Sometimes you may wish to define a scope that accepts parameters. To get started, just add your additional parameters to your scope. Scope parameters should be defined after the <code class=" language-php"><span class="token variable">$query</span></code> parameter:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Scope a query to only include users of a given type.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">scopeOfType<span class="token punctuation">(</span></span><span class="token variable">$query</span><span class="token punctuation">,</span> <span class="token variable">$type</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'type'</span><span class="token punctuation">,</span> <span class="token variable">$type</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now, you may pass the parameters when calling the scope:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">ofType<span class="token punctuation">(</span></span><span class="token string">'admin'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="events"></a>
    </p>
    <h2><a href="#events">Events</a></h2>
    <p>Eloquent models fire several events, allowing you to hook into various points in the model's lifecycle using the following methods: <code class=" language-php">creating</code>, <code class=" language-php">created</code>, <code class=" language-php">updating</code>, <code class=" language-php">updated</code>, <code class=" language-php">saving</code>, <code class=" language-php">saved</code>, <code class=" language-php">deleting</code>, <code class=" language-php">deleted</code>, <code class=" language-php">restoring</code>, <code class=" language-php">restored</code>. Events allow you to easily execute code each time a specific model class is saved or updated in the database.</p>
    <p>Whenever a new model is saved for the first time, the <code class=" language-php">creating</code> and <code class=" language-php">created</code> events will fire. If a model already existed in the database and the <code class=" language-php">save</code> method is called, the <code class=" language-php">updating</code> / <code class=" language-php">updated</code> events will fire. However, in both cases, the <code class=" language-php">saving</code> / <code class=" language-php">saved</code> events will fire.</p>
    <p>For example, let's define an Eloquent event listener in a <a href="/docs/5.3/providers">service provider</a>. Within our event listener, we will call the <code class=" language-php">isValid</code> method on the given model, and return <code class=" language-php"><span class="token boolean">false</span></code> if the model is not valid. Returning <code class=" language-php"><span class="token boolean">false</span></code> from an Eloquent event listener will cancel the <code class=" language-php">save</code> / <code class=" language-php">update</code> operation:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AppServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Bootstrap any application services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">creating<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">isValid<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Register the service provider.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">register<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="observers"></a>
    </p>
    <h3>Observers</h3>
    <p>If you are listening for many events on a given model, you may use observers to group all of your listeners into a single class. Observers classes have method names which reflect the Eloquent events you wish to listen for. Each of these methods receives the model as their only argument. Laravel does not include a default directory for observers, so you may create any directory you like to house your observer classes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Observers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserObserver</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">created<span class="token punctuation">(</span></span>User <span class="token variable">$user</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">deleting<span class="token punctuation">(</span></span>User <span class="token variable">$user</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>To register an observer, use the <code class=" language-php">observe</code> method on the model you wish to observe. You may register observers in the <code class=" language-php">boot</code> method of one of your service providers. In this example, we'll register the observer in the <code class=" language-php">AppServiceProvider</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>User</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Observers<span class="token punctuation">\</span>UserObserver</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AppServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Bootstrap any application services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">observe<span class="token punctuation">(</span></span><span class="token scope">UserObserver<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Register the service provider.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">register<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>

<div>Nguồn: <a href="https://laravel.com/docs/5.3/eloquent">https://laravel.com/docs/5.3/eloquent</a></div>
</article>
@endsection