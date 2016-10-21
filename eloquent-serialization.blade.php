@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Eloquent: Serialization</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#serializing-models-and-collections">Serializing Models &amp; Collections</a>
            <ul>
                <li><a href="#serializing-to-arrays">Serializing To Arrays</a>
                </li>
                <li><a href="#serializing-to-json">Serializing To JSON</a>
                </li>
            </ul>
        </li>
        <li><a href="#hiding-attributes-from-json">Hiding Attributes From JSON</a>
        </li>
        <li><a href="#appending-values-to-json">Appending Values To JSON</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>When building JSON APIs, you will often need to convert your models and relationships to arrays or JSON. Eloquent includes convenient methods for making these conversions, as well as controlling which attributes are included in your serializations.</p>
    <p>
        <a name="serializing-models-and-collections"></a>
    </p>
    <h2><a href="#serializing-models-and-collections">Serializing Models &amp; Collections</a></h2>
    <p>
        <a name="serializing-to-arrays"></a>
    </p>
    <h3>Serializing To Arrays</h3>
    <p>To convert a model and its loaded <a href="/docs/5.3/eloquent-relationships">relationships</a> to an array, you should use the <code class=" language-php">toArray</code> method. This method is recursive, so all attributes and all relations (including the relations of relations) will be converted to arrays:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'roles'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">first<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may also convert entire <a href="/docs/5.3/eloquent-collections">collections</a> of models to arrays:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token variable">$users</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="serializing-to-json"></a>
    </p>
    <h3>Serializing To JSON</h3>
    <p>To convert a model to JSON, you should use the <code class=" language-php">toJson</code> method. Like <code class=" language-php">toArray</code>, the <code class=" language-php">toJson</code> method is recursive, so all attributes and relations will be converted to JSON:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toJson<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Alternatively, you may cast a model or collection to a string, which will automatically call the <code class=" language-php">toJson</code> method on the model or collection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token punctuation">(</span>string<span class="token punctuation">)</span> <span class="token variable">$user</span><span class="token punctuation">;</span></code></pre>
    <p>Since models and collections are converted to JSON when cast to a string, you can return Eloquent objects directly from your application's routes or controllers:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="hiding-attributes-from-json"></a>
    </p>
    <h2><a href="#hiding-attributes-from-json">Hiding Attributes From JSON</a></h2>
    <p>Sometimes you may wish to limit the attributes, such as passwords, that are included in your model's array or JSON representation. To do so, add a <code class=" language-php"><span class="token variable">$hidden</span></code> property to your model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$hidden</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'password'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> When hiding relationships, use the relationship's method name, not its dynamic property name.</p>
    </blockquote>
    <p>Alternatively, you may use the <code class=" language-php">visible</code> property to define a white-list of attributes that should be included in your model's array and JSON representation. All other attributes will be hidden when the model is converted to an array or JSON:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$visible</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'first_name'</span><span class="token punctuation">,</span> <span class="token string">'last_name'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Temporarily Modifying Attribute Visibility</h4>
    <p>If you would like to make some typically hidden attributes visible on a given model instance, you may use the <code class=" language-php">makeVisible</code> method. The <code class=" language-php">makeVisible</code> method returns the model instance for convenient method chaining:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">makeVisible<span class="token punctuation">(</span></span><span class="token string">'attribute'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Likewise, if you would like to make some typically visible attributes hidden on a given model instance, you may use the <code class=" language-php">makeHidden</code> method.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">makeHidden<span class="token punctuation">(</span></span><span class="token string">'attribute'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toArray<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="appending-values-to-json"></a>
    </p>
    <h2><a href="#appending-values-to-json">Appending Values To JSON</a></h2>
    <p>Occasionally, when casting models to an array or JSON, you may wish to add attributes that do not have a corresponding column in your database. To do so, first define an <a href="/docs/5.3/eloquent-mutators">accessor</a> for the value:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get the administrator flag for the user.
     *
     * @return bool
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getIsAdminAttribute<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">attributes</span><span class="token punctuation">[</span><span class="token string">'admin'</span><span class="token punctuation">]</span> <span class="token operator">==</span> <span class="token string">'yes'</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>After creating the accessor, add the attribute name to the <code class=" language-php">appends</code> property on the model. Note that attribute names are typically referenced in "snake case", even though the accessor is defined using "camel case":</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The accessors to append to the model's array form.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$appends</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'is_admin'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once the attribute has been added to the <code class=" language-php">appends</code> list, it will be included in both the model's array and JSON representations. Attributes in the <code class=" language-php">appends</code> array will also respect the <code class=" language-php">visible</code> and <code class=" language-php">hidden</code> settings configured on the model.</p>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/eloquent-serialization">https://laravel.com/docs/5.3/eloquent-serialization</a></div>
</article>
@endsection