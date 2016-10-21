@extends('documents.laravel53.layout')

@section('content')
<article>
		<h1>Eloquent: Mutators</h1>
<ul>
<li><a href="#introduction">Introduction</a></li>
<li><a href="#accessors-and-mutators">Accessors &amp; Mutators</a>
<ul>
<li><a href="#defining-an-accessor">Defining An Accessor</a></li>
<li><a href="#defining-a-mutator">Defining A Mutator</a></li>
</ul></li>
<li><a href="#date-mutators">Date Mutators</a></li>
<li><a href="#attribute-casting">Attribute Casting</a>
<ul>
<li><a href="#array-and-json-casting">Array &amp; JSON Casting</a></li>
</ul></li>
</ul>
<p><a name="introduction"></a></p>
<h2><a href="#introduction">Introduction</a></h2>
<p>Accessors and mutators allow you to format Eloquent attribute values when you retrieve or set them on model instances. For example, you may want to use the <a href="/docs/5.3/encryption">Laravel encrypter</a> to encrypt a value while it is stored in the database, and then automatically decrypt the attribute when you access it on an Eloquent model.</p>
<p>In addition to custom accessors and mutators, Eloquent can also automatically cast date fields to <a href="https://github.com/briannesbitt/Carbon">Carbon</a> instances or even <a href="#attribute-casting">cast text fields to JSON</a>.</p>
<p><a name="accessors-and-mutators"></a></p>
<h2><a href="#accessors-and-mutators">Accessors &amp; Mutators</a></h2>
<p><a name="defining-an-accessor"></a></p>
<h3>Defining An Accessor</h3>
<p>To define an accessor, create a <code class=" language-php">getFooAttribute</code> method on your model where <code class=" language-php">Foo</code> is the "studly" cased name of the column you wish to access. In this example, we'll define an accessor for the <code class=" language-php">first_name</code> attribute. The accessor will automatically be called by Eloquent when attempting to retrieve the value of the <code class=" language-php">first_name</code> attribute:</p>
<pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">getFirstNameAttribute<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token function">ucfirst<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
<p>As you can see, the original value of the column is passed to the accessor, allowing you to manipulate and return the value. To access the value of the mutator, you may simply access the <code class=" language-php">first_name</code> attribute on a model instance:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$firstName</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">first_name</span><span class="token punctuation">;</span></code></pre>
<p><a name="defining-a-mutator"></a></p>
<h3>Defining A Mutator</h3>
<p>To define a mutator, define a <code class=" language-php">setFooAttribute</code> method on your model where <code class=" language-php">Foo</code> is the "studly" cased name of the column you wish to access. So, again, let's define a mutator for the <code class=" language-php">first_name</code> attribute. This mutator will be automatically called when we attempt to set the value of the <code class=" language-php">first_name</code> attribute on the model:</p>
<pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">setFirstNameAttribute<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">attributes</span><span class="token punctuation">[</span><span class="token string">'first_name'</span><span class="token punctuation">]</span> <span class="token operator">=</span> <span class="token function">strtolower<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
<p>The mutator will receive the value that is being set on the attribute, allowing you to manipulate the value and set the manipulated value on the Eloquent model's internal <code class=" language-php"><span class="token variable">$attributes</span></code> property. So, for example, if we attempt to set the <code class=" language-php">first_name</code> attribute to <code class=" language-php">Sally</code>:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">first_name</span> <span class="token operator">=</span> <span class="token string">'Sally'</span><span class="token punctuation">;</span></code></pre>
<p>In this example, the <code class=" language-php">setFirstNameAttribute</code> function will be called with the value <code class=" language-php">Sally</code>. The mutator will then apply the <code class=" language-php">strtolower</code> function to the name and set its resulting value in the internal <code class=" language-php"><span class="token variable">$attributes</span></code> array.</p>
<p><a name="date-mutators"></a></p>
<h2><a href="#date-mutators">Date Mutators</a></h2>
<p>By default, Eloquent will convert the <code class=" language-php">created_at</code> and <code class=" language-php">updated_at</code> columns to instances of <a href="https://github.com/briannesbitt/Carbon">Carbon</a>, which extends the PHP <code class=" language-php">DateTime</code> class to provide an assortment of helpful methods. You may customize which dates are automatically mutated, and even completely disable this mutation, by overriding the <code class=" language-php"><span class="token variable">$dates</span></code> property of your model:</p>
<pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$dates</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
        <span class="token string">'created_at'</span><span class="token punctuation">,</span>
        <span class="token string">'updated_at'</span><span class="token punctuation">,</span>
        <span class="token string">'deleted_at'</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
<p>When a column is considered a date, you may set its value to a UNIX timestamp, date string (<code class=" language-php">Y<span class="token operator">-</span>m<span class="token operator">-</span>d</code>), date-time string, and of course a <code class=" language-php">DateTime</code> / <code class=" language-php">Carbon</code> instance, and the date's value will automatically be correctly stored in your database:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">deleted_at</span> <span class="token operator">=</span> <span class="token scope">Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<p>As noted above, when retrieving attributes that are listed in your <code class=" language-php"><span class="token variable">$dates</span></code> property, they will automatically be cast to <a href="https://github.com/briannesbitt/Carbon">Carbon</a> instances, allowing you to use any of Carbon's methods on your attributes:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">deleted_at</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">getTimestamp<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<h4>Date Formats</h4>
<p>By default, timestamps are formatted as <code class=" language-php"><span class="token string">'Y-m-d H:i:s'</span></code>. If you need to customize the timestamp format, set the <code class=" language-php"><span class="token variable">$dateFormat</span></code> property on your model. This property determines how date attributes are stored in the database, as well as their format when the model is serialized to an array or JSON:</p>
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
<p><a name="attribute-casting"></a></p>
<h2><a href="#attribute-casting">Attribute Casting</a></h2>
<p>The <code class=" language-php"><span class="token variable">$casts</span></code> property on your model provides a convenient method of converting attributes to common data types. The <code class=" language-php"><span class="token variable">$casts</span></code> property should be an array where the key is the name of the attribute being cast and the value is the type you wish to cast the column to. The supported cast types are: <code class=" language-php">integer</code>, <code class=" language-php">real</code>, <code class=" language-php">float</code>, <code class=" language-php">double</code>, <code class=" language-php">string</code>, <code class=" language-php">boolean</code>, <code class=" language-php">object</code>, <code class=" language-php"><span class="token keyword">array</span></code>, <code class=" language-php">collection</code>, <code class=" language-php">date</code>, <code class=" language-php">datetime</code>, and <code class=" language-php">timestamp</code>.</p>
<p>For example, let's cast the <code class=" language-php">is_admin</code> attribute, which is stored in our database as an integer (<code class=" language-php"><span class="token number">0</span></code> or <code class=" language-php"><span class="token number">1</span></code>) to a boolean value:</p>
<pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The attributes that should be casted to native types.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$casts</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
        <span class="token string">'is_admin'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'boolean'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
<p>Now the <code class=" language-php">is_admin</code> attribute will always be cast to a boolean when you access it, even if the underlying value is stored in the database as an integer:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">is_admin</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
<p><a name="array-and-json-casting"></a></p>
<h3>Array &amp; JSON Casting</h3>
<p>The <code class=" language-php"><span class="token keyword">array</span></code> cast type is particularly useful when working with columns that are stored as serialized JSON. For example, if your database has a <code class=" language-php"><span class="token constant">JSON</span></code> or <code class=" language-php"><span class="token constant">TEXT</span></code> field type that contains serialized JSON, adding the <code class=" language-php"><span class="token keyword">array</span></code> cast to that attribute will automatically deserialize the attribute to a PHP array when you access it on your Eloquent model:</p>
<pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The attributes that should be casted to native types.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$casts</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
        <span class="token string">'options'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'array'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
<p>Once the cast is defined, you may access the <code class=" language-php">options</code> attribute and it will automatically be deserialized from JSON into a PHP array. When you set the value of the <code class=" language-php">options</code> attribute, the given array will automatically be serialized back into JSON for storage:</p>
<pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$options</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">options</span><span class="token punctuation">;</span>

<span class="token variable">$options</span><span class="token punctuation">[</span><span class="token string">'key'</span><span class="token punctuation">]</span> <span class="token operator">=</span> <span class="token string">'value'</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">options</span> <span class="token operator">=</span> <span class="token variable">$options</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/eloquent-mutators">https://laravel.com/docs/5.3/eloquent-mutators</a></div>
	</article>
@endsection