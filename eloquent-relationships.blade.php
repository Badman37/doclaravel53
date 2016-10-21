@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Eloquent: Relationships</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#defining-relationships">Defining Relationships</a>
            <ul>
                <li><a href="#one-to-one">One To One</a>
                </li>
                <li><a href="#one-to-many">One To Many</a>
                </li>
                <li><a href="#one-to-many-inverse">One To Many (Inverse)</a>
                </li>
                <li><a href="#many-to-many">Many To Many</a>
                </li>
                <li><a href="#has-many-through">Has Many Through</a>
                </li>
                <li><a href="#polymorphic-relations">Polymorphic Relations</a>
                </li>
                <li><a href="#many-to-many-polymorphic-relations">Many To Many Polymorphic Relations</a>
                </li>
            </ul>
        </li>
        <li><a href="#querying-relations">Querying Relations</a>
            <ul>
                <li><a href="#relationship-methods-vs-dynamic-properties">Relationship Methods Vs. Dynamic Properties</a>
                </li>
                <li><a href="#querying-relationship-existence">Querying Relationship Existence</a>
                </li>
                <li><a href="#querying-relationship-absence">Querying Relationship Absence</a>
                </li>
                <li><a href="#counting-related-models">Counting Related Models</a>
                </li>
            </ul>
        </li>
        <li><a href="#eager-loading">Eager Loading</a>
            <ul>
                <li><a href="#constraining-eager-loads">Constraining Eager Loads</a>
                </li>
                <li><a href="#lazy-eager-loading">Lazy Eager Loading</a>
                </li>
            </ul>
        </li>
        <li><a href="#inserting-and-updating-related-models">Inserting &amp; Updating Related Models</a>
            <ul>
                <li><a href="#the-save-method">The <code class=" language-php">save</code> Method</a>
                </li>
                <li><a href="#the-create-method">The <code class=" language-php">create</code> Method</a>
                </li>
                <li><a href="#updating-belongs-to-relationships">Belongs To Relationships</a>
                </li>
                <li><a href="#updating-many-to-many-relationships">Many To Many Relationships</a>
                </li>
            </ul>
        </li>
        <li><a href="#touching-parent-timestamps">Touching Parent Timestamps</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Database tables are often related to one another. For example, a blog post may have many comments, or an order could be related to the user who placed it. Eloquent makes managing and working with these relationships easy, and supports several different types of relationships:</p>
    <ul>
        <li><a href="#one-to-one">One To One</a>
        </li>
        <li><a href="#one-to-many">One To Many</a>
        </li>
        <li><a href="#many-to-many">Many To Many</a>
        </li>
        <li><a href="#has-many-through">Has Many Through</a>
        </li>
        <li><a href="#polymorphic-relations">Polymorphic Relations</a>
        </li>
        <li><a href="#many-to-many-polymorphic-relations">Many To Many Polymorphic Relations</a>
        </li>
    </ul>
    <p>
        <a name="defining-relationships"></a>
    </p>
    <h2><a href="#defining-relationships">Defining Relationships</a></h2>
    <p>Eloquent relationships are defined as functions on your Eloquent model classes. Since, like Eloquent models themselves, relationships also serve as powerful <a href="/docs/5.3/queries">query builders</a>, defining relationships as functions provides powerful method chaining and querying capabilities. For example, we may chain additional constraints on this <code class=" language-php">posts</code> relationship:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">posts<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>But, before diving too deep into using relationships, let's learn how to define each type.</p>
    <p>
        <a name="one-to-one"></a>
    </p>
    <h3>One To One</h3>
    <p>A one-to-one relationship is a very basic relation. For example, a <code class=" language-php">User</code> model might be associated with one <code class=" language-php">Phone</code>. To define this relationship, we place a <code class=" language-php">phone</code> method on the <code class=" language-php">User</code> model. The <code class=" language-php">phone</code> method should call the <code class=" language-php">hasOne</code> method and return its result:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get the phone record associated with the user.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">phone<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasOne<span class="token punctuation">(</span></span><span class="token string">'App\Phone'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>The first argument passed to the <code class=" language-php">hasOne</code> method is the name of the related model. Once the relationship is defined, we may retrieve the related record using Eloquent's dynamic properties. Dynamic properties allow you to access relationship functions as if they were properties defined on the model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$phone</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">phone</span><span class="token punctuation">;</span></code></pre>
    <p>Eloquent determines the foreign key of the relationship based on the model name. In this case, the <code class=" language-php">Phone</code> model is automatically assumed to have a <code class=" language-php">user_id</code> foreign key. If you wish to override this convention, you may pass a second argument to the <code class=" language-php">hasOne</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasOne<span class="token punctuation">(</span></span><span class="token string">'App\Phone'</span><span class="token punctuation">,</span> <span class="token string">'foreign_key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Additionally, Eloquent assumes that the foreign key should have a value matching the <code class=" language-php">id</code> (or the custom <code class=" language-php"><span class="token variable">$primaryKey</span></code>) column of the parent. In other words, Eloquent will look for the value of the user's <code class=" language-php">id</code> column in the <code class=" language-php">user_id</code> column of the <code class=" language-php">Phone</code> record. If you would like the relationship to use a value other than <code class=" language-php">id</code>, you may pass a third argument to the <code class=" language-php">hasOne</code> method specifying your custom key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasOne<span class="token punctuation">(</span></span><span class="token string">'App\Phone'</span><span class="token punctuation">,</span> <span class="token string">'foreign_key'</span><span class="token punctuation">,</span> <span class="token string">'local_key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Defining The Inverse Of The Relationship</h4>
    <p>So, we can access the <code class=" language-php">Phone</code> model from our <code class=" language-php">User</code>. Now, let's define a relationship on the <code class=" language-php">Phone</code> model that will let us access the <code class=" language-php">User</code> that owns the phone. We can define the inverse of a <code class=" language-php">hasOne</code> relationship using the <code class=" language-php">belongsTo</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Phone</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get the user that owns the phone.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo<span class="token punctuation">(</span></span><span class="token string">'App\User'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>In the example above, Eloquent will try to match the <code class=" language-php">user_id</code> from the <code class=" language-php">Phone</code> model to an <code class=" language-php">id</code> on the <code class=" language-php">User</code> model. Eloquent determines the default foreign key name by examining the name of the relationship method and suffixing the method name with <code class=" language-php">_id</code>. However, if the foreign key on the <code class=" language-php">Phone</code> model is not <code class=" language-php">user_id</code>, you may pass a custom key name as the second argument to the <code class=" language-php">belongsTo</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the user that owns the phone.
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo<span class="token punctuation">(</span></span><span class="token string">'App\User'</span><span class="token punctuation">,</span> <span class="token string">'foreign_key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>If your parent model does not use <code class=" language-php">id</code> as its primary key, or you wish to join the child model to a different column, you may pass a third argument to the <code class=" language-php">belongsTo</code> method specifying your parent table's custom key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the user that owns the phone.
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo<span class="token punctuation">(</span></span><span class="token string">'App\User'</span><span class="token punctuation">,</span> <span class="token string">'foreign_key'</span><span class="token punctuation">,</span> <span class="token string">'other_key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="one-to-many"></a>
    </p>
    <h3>One To Many</h3>
    <p>A "one-to-many" relationship is used to define relationships where a single model owns any amount of other models. For example, a blog post may have an infinite number of comments. Like all other Eloquent relationships, one-to-many relationships are defined by placing a function on your Eloquent model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Post</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get the comments for the blog post.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">comments<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasMany<span class="token punctuation">(</span></span><span class="token string">'App\Comment'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Remember, Eloquent will automatically determine the proper foreign key column on the <code class=" language-php">Comment</code> model. By convention, Eloquent will take the "snake case" name of the owning model and suffix it with <code class=" language-php">_id</code>. So, for this example, Eloquent will assume the foreign key on the <code class=" language-php">Comment</code> model is <code class=" language-php">post_id</code>.</p>
    <p>Once the relationship has been defined, we can access the collection of comments by accessing the <code class=" language-php">comments</code> property. Remember, since Eloquent provides "dynamic properties", we can access relationship functions as if they were defined as properties on the model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$comments</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">comments</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$comments</span> <span class="token keyword">as</span> <span class="token variable">$comment</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>Of course, since all relationships also serve as query builders, you can add further constraints to which comments are retrieved by calling the <code class=" language-php">comments</code> method and continuing to chain conditions onto the query:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$comments</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">comments<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'title'</span><span class="token punctuation">,</span> <span class="token string">'foo'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">first<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Like the <code class=" language-php">hasOne</code> method, you may also override the foreign and local keys by passing additional arguments to the <code class=" language-php">hasMany</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasMany<span class="token punctuation">(</span></span><span class="token string">'App\Comment'</span><span class="token punctuation">,</span> <span class="token string">'foreign_key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasMany<span class="token punctuation">(</span></span><span class="token string">'App\Comment'</span><span class="token punctuation">,</span> <span class="token string">'foreign_key'</span><span class="token punctuation">,</span> <span class="token string">'local_key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="one-to-many-inverse"></a>
    </p>
    <h3>One To Many (Inverse)</h3>
    <p>Now that we can access all of a post's comments, let's define a relationship to allow a comment to access its parent post. To define the inverse of a <code class=" language-php">hasMany</code> relationship, define a relationship function on the child model which calls the <code class=" language-php">belongsTo</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Comment</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get the post that owns the comment.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">post<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo<span class="token punctuation">(</span></span><span class="token string">'App\Post'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once the relationship has been defined, we can retrieve the <code class=" language-php">Post</code> model for a <code class=" language-php">Comment</code> by accessing the <code class=" language-php">post</code> "dynamic property":</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$comment</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Comment<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$comment</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">title</span><span class="token punctuation">;</span></code></pre>
    <p>In the example above, Eloquent will try to match the <code class=" language-php">post_id</code> from the <code class=" language-php">Comment</code> model to an <code class=" language-php">id</code> on the <code class=" language-php">Post</code> model. Eloquent determines the default foreign key name by examining the name of the relationship method and suffixing the method name with <code class=" language-php">_id</code>. However, if the foreign key on the <code class=" language-php">Comment</code> model is not <code class=" language-php">post_id</code>, you may pass a custom key name as the second argument to the <code class=" language-php">belongsTo</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the post that owns the comment.
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">post<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo<span class="token punctuation">(</span></span><span class="token string">'App\Post'</span><span class="token punctuation">,</span> <span class="token string">'foreign_key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>If your parent model does not use <code class=" language-php">id</code> as its primary key, or you wish to join the child model to a different column, you may pass a third argument to the <code class=" language-php">belongsTo</code> method specifying your parent table's custom key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the post that owns the comment.
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">post<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo<span class="token punctuation">(</span></span><span class="token string">'App\Post'</span><span class="token punctuation">,</span> <span class="token string">'foreign_key'</span><span class="token punctuation">,</span> <span class="token string">'other_key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="many-to-many"></a>
    </p>
    <h3>Many To Many</h3>
    <p>Many-to-many relations are slightly more complicated than <code class=" language-php">hasOne</code> and <code class=" language-php">hasMany</code> relationships. An example of such a relationship is a user with many roles, where the roles are also shared by other users. For example, many users may have the role of "Admin". To define this relationship, three database tables are needed: <code class=" language-php">users</code>, <code class=" language-php">roles</code>, and <code class=" language-php">role_user</code>. The <code class=" language-php">role_user</code> table is derived from the alphabetical order of the related model names, and contains the <code class=" language-php">user_id</code> and <code class=" language-php">role_id</code> columns.</p>
    <p>Many-to-many relationships are defined by writing a method that returns the result of the <code class=" language-php">belongsToMany</code> method. For example, let's define the <code class=" language-php">roles</code> method on our <code class=" language-php">User</code> model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The roles that belong to the user.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany<span class="token punctuation">(</span></span><span class="token string">'App\Role'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once the relationship is defined, you may access the user's roles using the <code class=" language-php">roles</code> dynamic property:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">roles</span> <span class="token keyword">as</span> <span class="token variable">$role</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>Of course, like all other relationship types, you may call the <code class=" language-php">roles</code> method to continue chaining query constraints onto the relationship:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$roles</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orderBy<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>As mentioned previously, to determine the table name of the relationship's joining table, Eloquent will join the two related model names in alphabetical order. However, you are free to override this convention. You may do so by passing a second argument to the <code class=" language-php">belongsToMany</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany<span class="token punctuation">(</span></span><span class="token string">'App\Role'</span><span class="token punctuation">,</span> <span class="token string">'role_user'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>In addition to customizing the name of the joining table, you may also customize the column names of the keys on the table by passing additional arguments to the <code class=" language-php">belongsToMany</code> method. The third argument is the foreign key name of the model on which you are defining the relationship, while the fourth argument is the foreign key name of the model that you are joining to:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany<span class="token punctuation">(</span></span><span class="token string">'App\Role'</span><span class="token punctuation">,</span> <span class="token string">'role_user'</span><span class="token punctuation">,</span> <span class="token string">'user_id'</span><span class="token punctuation">,</span> <span class="token string">'role_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Defining The Inverse Of The Relationship</h4>
    <p>To define the inverse of a many-to-many relationship, you simply place another call to <code class=" language-php">belongsToMany</code> on your related model. To continue our user roles example, let's define the <code class=" language-php">users</code> method on the <code class=" language-php">Role</code> model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Role</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The users that belong to the role.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">users<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany<span class="token punctuation">(</span></span><span class="token string">'App\User'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>As you can see, the relationship is defined exactly the same as its <code class=" language-php">User</code> counterpart, with the exception of simply referencing the <code class=" language-php">App\<span class="token package">User</span></code> model. Since we're reusing the <code class=" language-php">belongsToMany</code> method, all of the usual table and key customization options are available when defining the inverse of many-to-many relationships.</p>
    <h4>Retrieving Intermediate Table Columns</h4>
    <p>As you have already learned, working with many-to-many relations requires the presence of an intermediate table. Eloquent provides some very helpful ways of interacting with this table. For example, let's assume our <code class=" language-php">User</code> object has many <code class=" language-php">Role</code> objects that it is related to. After accessing this relationship, we may access the intermediate table using the <code class=" language-php">pivot</code> attribute on the models:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">roles</span> <span class="token keyword">as</span> <span class="token variable">$role</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">echo</span> <span class="token variable">$role</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">pivot</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">created_at</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Notice that each <code class=" language-php">Role</code> model we retrieve is automatically assigned a <code class=" language-php">pivot</code> attribute. This attribute contains a model representing the intermediate table, and may be used like any other Eloquent model.</p>
    <p>By default, only the model keys will be present on the <code class=" language-php">pivot</code> object. If your pivot table contains extra attributes, you must specify them when defining the relationship:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany<span class="token punctuation">(</span></span><span class="token string">'App\Role'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withPivot<span class="token punctuation">(</span></span><span class="token string">'column1'</span><span class="token punctuation">,</span> <span class="token string">'column2'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you want your pivot table to have automatically maintained <code class=" language-php">created_at</code> and <code class=" language-php">updated_at</code> timestamps, use the <code class=" language-php">withTimestamps</code> method on the relationship definition:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany<span class="token punctuation">(</span></span><span class="token string">'App\Role'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withTimestamps<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Filtering Relationships Via Intermediate Table Columns</h4>
    <p>You can also filter the results returned by <code class=" language-php">belongsToMany</code> using the <code class=" language-php">wherePivot</code> and <code class=" language-php">wherePivotIn</code> methods when defining the relationship:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany<span class="token punctuation">(</span></span><span class="token string">'App\Role'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">wherePivot<span class="token punctuation">(</span></span><span class="token string">'approved'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsToMany<span class="token punctuation">(</span></span><span class="token string">'App\Role'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">wherePivotIn<span class="token punctuation">(</span></span><span class="token string">'priority'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="has-many-through"></a>
    </p>
    <h3>Has Many Through</h3>
    <p>The "has-many-through" relationship provides a convenient short-cut for accessing distant relations via an intermediate relation. For example, a <code class=" language-php">Country</code> model might have many <code class=" language-php">Post</code> models through an intermediate <code class=" language-php">User</code> model. In this example, you could easily gather all blog posts for a given country. Let's look at the tables required to define this relationship:</p>
    <pre class=" language-php"><code class=" language-php">countries
    id <span class="token operator">-</span> integer
    name <span class="token operator">-</span> string

users
    id <span class="token operator">-</span> integer
    country_id <span class="token operator">-</span> integer
    name <span class="token operator">-</span> string

posts
    id <span class="token operator">-</span> integer
    user_id <span class="token operator">-</span> integer
    title <span class="token operator">-</span> string</code></pre>
    <p>Though <code class=" language-php">posts</code> does not contain a <code class=" language-php">country_id</code> column, the <code class=" language-php">hasManyThrough</code> relation provides access to a country's posts via <code class=" language-php"><span class="token variable">$country</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">posts</span></code>. To perform this query, Eloquent inspects the <code class=" language-php">country_id</code> on the intermediate <code class=" language-php">users</code> table. After finding the matching user IDs, they are used to query the <code class=" language-php">posts</code> table.</p>
    <p>Now that we have examined the table structure for the relationship, let's define it on the <code class=" language-php">Country</code> model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Country</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get all of the posts for the country.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">posts<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasManyThrough<span class="token punctuation">(</span></span><span class="token string">'App\Post'</span><span class="token punctuation">,</span> <span class="token string">'App\User'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>The first argument passed to the <code class=" language-php">hasManyThrough</code> method is the name of the final model we wish to access, while the second argument is the name of the intermediate model.</p>
    <p>Typical Eloquent foreign key conventions will be used when performing the relationship's queries. If you would like to customize the keys of the relationship, you may pass them as the third and fourth arguments to the <code class=" language-php">hasManyThrough</code> method. The third argument is the name of the foreign key on the intermediate model, the fourth argument is the name of the foreign key on the final model, and the fifth argument is the local key:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">class</span> <span class="token class-name">Country</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">posts<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasManyThrough<span class="token punctuation">(</span></span>
            <span class="token string">'App\Post'</span><span class="token punctuation">,</span> <span class="token string">'App\User'</span><span class="token punctuation">,</span>
            <span class="token string">'country_id'</span><span class="token punctuation">,</span> <span class="token string">'user_id'</span><span class="token punctuation">,</span> <span class="token string">'id'</span>
        <span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="polymorphic-relations"></a>
    </p>
    <h3>Polymorphic Relations</h3>
    <h4>Table Structure</h4>
    <p>Polymorphic relations allow a model to belong to more than one other model on a single association. For example, imagine users of your application can "comment" both posts and videos. Using polymorphic relationships, you can use a single <code class=" language-php">comments</code> table for both of these scenarios. First, let's examine the table structure required to build this relationship:</p>
    <pre class=" language-php"><code class=" language-php">posts
    id <span class="token operator">-</span> integer
    title <span class="token operator">-</span> string
    body <span class="token operator">-</span> text

videos
    id <span class="token operator">-</span> integer
    title <span class="token operator">-</span> string
    url <span class="token operator">-</span> string

comments
    id <span class="token operator">-</span> integer
    body <span class="token operator">-</span> text
    commentable_id <span class="token operator">-</span> integer
    commentable_type <span class="token operator">-</span> string</code></pre>
    <p>Two important columns to note are the <code class=" language-php">commentable_id</code> and <code class=" language-php">commentable_type</code> columns on the <code class=" language-php">comments</code> table. The <code class=" language-php">commentable_id</code> column will contain the ID value of the post or video, while the <code class=" language-php">commentable_type</code> column will contain the class name of the owning model. The <code class=" language-php">commentable_type</code> column is how the ORM determines which "type" of owning model to return when accessing the <code class=" language-php">commentable</code> relation.</p>
    <h4>Model Structure</h4>
    <p>Next, let's examine the model definitions needed to build this relationship:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Comment</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get all of the owning commentable models.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">commentable<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">morphTo<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>

<span class="token keyword">class</span> <span class="token class-name">Post</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get all of the post's comments.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">comments<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">morphMany<span class="token punctuation">(</span></span><span class="token string">'App\Comment'</span><span class="token punctuation">,</span> <span class="token string">'commentable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>

<span class="token keyword">class</span> <span class="token class-name">Video</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get all of the video's comments.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">comments<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">morphMany<span class="token punctuation">(</span></span><span class="token string">'App\Comment'</span><span class="token punctuation">,</span> <span class="token string">'commentable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Retrieving Polymorphic Relations</h4>
    <p>Once your database table and models are defined, you may access the relationships via your models. For example, to access all of the comments for a post, we can simply use the <code class=" language-php">comments</code> dynamic property:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$post</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">comments</span> <span class="token keyword">as</span> <span class="token variable">$comment</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>You may also retrieve the owner of a polymorphic relation from the polymorphic model by accessing the name of the method that performs the call to <code class=" language-php">morphTo</code>. In our case, that is the <code class=" language-php">commentable</code> method on the <code class=" language-php">Comment</code> model. So, we will access that method as a dynamic property:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$comment</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Comment<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$commentable</span> <span class="token operator">=</span> <span class="token variable">$comment</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">commentable</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">commentable</code> relation on the <code class=" language-php">Comment</code> model will return either a <code class=" language-php">Post</code> or <code class=" language-php">Video</code> instance, depending on which type of model owns the comment.</p>
    <h4>Custom Polymorphic Types</h4>
    <p>By default, Laravel will use the fully qualified class name to store the type of the related model. For instance, given the example above where a <code class=" language-php">Comment</code> may belong to a <code class=" language-php">Post</code> or a <code class=" language-php">Video</code>, the default <code class=" language-php">commentable_type</code> would be either <code class=" language-php">App\<span class="token package">Post</span></code> or <code class=" language-php">App\<span class="token package">Video</span></code>, respectively. However, you may wish to decouple your database from your application's internal structure. In that case, you may define a relationship "morph map" to instruct Eloquent to use a custom name for each model instead of the class name:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Relations<span class="token punctuation">\</span>Relation</span><span class="token punctuation">;</span>

<span class="token scope">Relation<span class="token punctuation">::</span></span><span class="token function">morphMap<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'posts'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token string">'videos'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">App<span class="token punctuation">\</span>Video<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may register the <code class=" language-php">morphMap</code> in the <code class=" language-php">boot</code> function of your <code class=" language-php">AppServiceProvider</code> or create a separate service provider if you wish.</p>
    <p>
        <a name="many-to-many-polymorphic-relations"></a>
    </p>
    <h3>Many To Many Polymorphic Relations</h3>
    <h4>Table Structure</h4>
    <p>In addition to traditional polymorphic relations, you may also define "many-to-many" polymorphic relations. For example, a blog <code class=" language-php">Post</code> and <code class=" language-php">Video</code> model could share a polymorphic relation to a <code class=" language-php">Tag</code> model. Using a many-to-many polymorphic relation allows you to have a single list of unique tags that are shared across blog posts and videos. First, let's examine the table structure:</p>
    <pre class=" language-php"><code class=" language-php">posts
    id <span class="token operator">-</span> integer
    name <span class="token operator">-</span> string

videos
    id <span class="token operator">-</span> integer
    name <span class="token operator">-</span> string

tags
    id <span class="token operator">-</span> integer
    name <span class="token operator">-</span> string

taggables
    tag_id <span class="token operator">-</span> integer
    taggable_id <span class="token operator">-</span> integer
    taggable_type <span class="token operator">-</span> string</code></pre>
    <h4>Model Structure</h4>
    <p>Next, we're ready to define the relationships on the model. The <code class=" language-php">Post</code> and <code class=" language-php">Video</code> models will both have a <code class=" language-php">tags</code> method that calls the <code class=" language-php">morphToMany</code> method on the base Eloquent class:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Post</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get all of the tags for the post.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">tags<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">morphToMany<span class="token punctuation">(</span></span><span class="token string">'App\Tag'</span><span class="token punctuation">,</span> <span class="token string">'taggable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Defining The Inverse Of The Relationship</h4>
    <p>Next, on the <code class=" language-php">Tag</code> model, you should define a method for each of its related models. So, for this example, we will define a <code class=" language-php">posts</code> method and a <code class=" language-php">videos</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Tag</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get all of the posts that are assigned this tag.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">posts<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">morphedByMany<span class="token punctuation">(</span></span><span class="token string">'App\Post'</span><span class="token punctuation">,</span> <span class="token string">'taggable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Get all of the videos that are assigned this tag.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">videos<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">morphedByMany<span class="token punctuation">(</span></span><span class="token string">'App\Video'</span><span class="token punctuation">,</span> <span class="token string">'taggable'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Retrieving The Relationship</h4>
    <p>Once your database table and models are defined, you may access the relationships via your models. For example, to access all of the tags for a post, you can simply use the <code class=" language-php">tags</code> dynamic property:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$post</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">tags</span> <span class="token keyword">as</span> <span class="token variable">$tag</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>You may also retrieve the owner of a polymorphic relation from the polymorphic model by accessing the name of the method that performs the call to <code class=" language-php">morphedByMany</code>. In our case, that is the <code class=" language-php">posts</code> or <code class=" language-php">videos</code> methods on the <code class=" language-php">Tag</code> model. So, you will access those methods as dynamic properties:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$tag</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Tag<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$tag</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">videos</span> <span class="token keyword">as</span> <span class="token variable">$video</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="querying-relations"></a>
    </p>
    <h2><a href="#querying-relations">Querying Relations</a></h2>
    <p>Since all types of Eloquent relationships are defined via functions, you may call those functions to obtain an instance of the relationship without actually executing the relationship queries. In addition, all types of Eloquent relationships also serve as <a href="/docs/5.3/queries">query builders</a>, allowing you to continue to chain constraints onto the relationship query before finally executing the SQL against your database.</p>
    <p>For example, imagine a blog system in which a <code class=" language-php">User</code> model has many associated <code class=" language-php">Post</code> models:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get all of the posts for the user.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">posts<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hasMany<span class="token punctuation">(</span></span><span class="token string">'App\Post'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>You may query the <code class=" language-php">posts</code> relationship and add additional constraints to the relationship like so:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">posts<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'active'</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You are able to use any of the <a href="/docs/5.3/queries">query builder</a> methods on the relationship, so be sure to explore the query builder documentation to learn about all of the methods that are available to you.</p>
    <p>
        <a name="relationship-methods-vs-dynamic-properties"></a>
    </p>
    <h3>Relationship Methods Vs. Dynamic Properties</h3>
    <p>If you do not need to add additional constraints to an Eloquent relationship query, you may simply access the relationship as if it were a property. For example, continuing to use our <code class=" language-php">User</code> and <code class=" language-php">Post</code> example models, we may access all of a user's posts like so:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">posts</span> <span class="token keyword">as</span> <span class="token variable">$post</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>Dynamic properties are "lazy loading", meaning they will only load their relationship data when you actually access them. Because of this, developers often use <a href="#eager-loading">eager loading</a> to pre-load relationships they know will be accessed after loading the model. Eager loading provides a significant reduction in SQL queries that must be executed to load a model's relations.</p>
    <p>
        <a name="querying-relationship-existence"></a>
    </p>
    <h3>Querying Relationship Existence</h3>
    <p>When accessing the records for a model, you may wish to limit your results based on the existence of a relationship. For example, imagine you want to retrieve all blog posts that have at least one comment. To do so, you may pass the name of the relationship to the <code class=" language-php">has</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Retrieve all posts that have at least one comment...
</span><span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">has<span class="token punctuation">(</span></span><span class="token string">'comments'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may also specify an operator and count to further customize the query:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Retrieve all posts that have three or more comments...
</span><span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token function">has<span class="token punctuation">(</span></span><span class="token string">'comments'</span><span class="token punctuation">,</span> <span class="token string">'&gt;='</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Nested <code class=" language-php">has</code> statements may also be constructed using "dot" notation. For example, you may retrieve all posts that have at least one comment and vote:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Retrieve all posts that have at least one comment with votes...
</span><span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token function">has<span class="token punctuation">(</span></span><span class="token string">'comments.votes'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you need even more power, you may use the <code class=" language-php">whereHas</code> and <code class=" language-php">orWhereHas</code> methods to put "where" conditions on your <code class=" language-php">has</code> queries. These methods allow you to add customized constraints to a relationship constraint, such as checking the content of a comment:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Retrieve all posts with at least one comment containing words like foo%
</span><span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token function">whereHas<span class="token punctuation">(</span></span><span class="token string">'comments'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'content'</span><span class="token punctuation">,</span> <span class="token string">'like'</span><span class="token punctuation">,</span> <span class="token string">'foo%'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="querying-relationship-absence"></a>
    </p>
    <h3>Querying Relationship Absence</h3>
    <p>When accessing the records for a model, you may wish to limit your results based on the absence of a relationship. For example, imagine you want to retrieve all blog posts that <strong>don't</strong> have any comments. To do so, you may pass the name of the relationship to the <code class=" language-php">doesntHave</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">doesntHave<span class="token punctuation">(</span></span><span class="token string">'comments'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you need even more power, you may use the <code class=" language-php">whereDoesntHave</code> method to put "where" conditions on your <code class=" language-php">doesntHave</code> queries. This method allows you to add customized constraints to a relationship constraint, such as checking the content of a comment:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token function">whereDoesntHave<span class="token punctuation">(</span></span><span class="token string">'comments'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'content'</span><span class="token punctuation">,</span> <span class="token string">'like'</span><span class="token punctuation">,</span> <span class="token string">'foo%'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="counting-related-models"></a>
    </p>
    <h3>Counting Related Models</h3>
    <p>If you want to count the number of results from a relationship without actually loading them you may use the <code class=" language-php">withCount</code> method, which will place a <code class=" language-php"><span class="token punctuation">{</span>relation<span class="token punctuation">}</span>_count</code> column on your resulting models. For example:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">withCount<span class="token punctuation">(</span></span><span class="token string">'comments'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$posts</span> <span class="token keyword">as</span> <span class="token variable">$post</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">echo</span> <span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">comments_count</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>You may add retrieve the "counts" for multiple relations as well as add constraints to the queries:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$posts</span> <span class="token operator">=</span> <span class="token scope">Post<span class="token punctuation">::</span></span><span class="token function">withCount<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'votes'</span><span class="token punctuation">,</span> <span class="token string">'comments'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'content'</span><span class="token punctuation">,</span> <span class="token string">'like'</span><span class="token punctuation">,</span> <span class="token string">'foo%'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$posts</span><span class="token punctuation">[</span><span class="token number">0</span><span class="token punctuation">]</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">votes_count</span><span class="token punctuation">;</span>
<span class="token keyword">echo</span> <span class="token variable">$posts</span><span class="token punctuation">[</span><span class="token number">0</span><span class="token punctuation">]</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">comments_count</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="eager-loading"></a>
    </p>
    <h2><a href="#eager-loading">Eager Loading</a></h2>
    <p>When accessing Eloquent relationships as properties, the relationship data is "lazy loaded". This means the relationship data is not actually loaded until you first access the property. However, Eloquent can "eager load" relationships at the time you query the parent model. Eager loading alleviates the N + 1 query problem. To illustrate the N + 1 query problem, consider a <code class=" language-php">Book</code> model that is related to <code class=" language-php">Author</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Book</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Get the author that wrote the book.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">author<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo<span class="token punctuation">(</span></span><span class="token string">'App\Author'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now, let's retrieve all books and their authors:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$books</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Book<span class="token punctuation">::</span></span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$books</span> <span class="token keyword">as</span> <span class="token variable">$book</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">echo</span> <span class="token variable">$book</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">author</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>This loop will execute 1 query to retrieve all of the books on the table, then another query for each book to retrieve the author. So, if we have 25 books, this loop would run 26 queries: 1 for the original book, and 25 additional queries to retrieve the author of each book.</p>
    <p>Thankfully, we can use eager loading to reduce this operation to just 2 queries. When querying, you may specify which relationships should be eager loaded using the <code class=" language-php">with</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$books</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Book<span class="token punctuation">::</span></span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'author'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$books</span> <span class="token keyword">as</span> <span class="token variable">$book</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">echo</span> <span class="token variable">$book</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">author</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>For this operation, only two queries will be executed:</p>
    <pre class=" language-php"><code class=" language-php">select <span class="token operator">*</span> from books

select <span class="token operator">*</span> from authors where id in <span class="token punctuation">(</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">,</span> <span class="token number">4</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">,</span> <span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span></code></pre>
    <h4>Eager Loading Multiple Relationships</h4>
    <p>Sometimes you may need to eager load several different relationships in a single operation. To do so, just pass additional arguments to the <code class=" language-php">with</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$books</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Book<span class="token punctuation">::</span></span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'author'</span><span class="token punctuation">,</span> <span class="token string">'publisher'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Nested Eager Loading</h4>
    <p>To eager load nested relationships, you may use "dot" syntax. For example, let's eager load all of the book's authors and all of the author's personal contacts in one Eloquent statement:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$books</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Book<span class="token punctuation">::</span></span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'author.contacts'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="constraining-eager-loads"></a>
    </p>
    <h3>Constraining Eager Loads</h3>
    <p>Sometimes you may wish to eager load a relationship, but also specify additional query constraints for the eager loading query. Here's an example:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">with<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'posts'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">where<span class="token punctuation">(</span></span><span class="token string">'title'</span><span class="token punctuation">,</span> <span class="token string">'like'</span><span class="token punctuation">,</span> <span class="token string">'%first%'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>In this example, Eloquent will only eager load posts where the post's <code class=" language-php">title</code> column contains the word <code class=" language-php">first</code>. Of course, you may call other <a href="/docs/5.3/queries">query builder</a> methods to further customize the eager loading operation:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">with<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'posts'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orderBy<span class="token punctuation">(</span></span><span class="token string">'created_at'</span><span class="token punctuation">,</span> <span class="token string">'desc'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="lazy-eager-loading"></a>
    </p>
    <h3>Lazy Eager Loading</h3>
    <p>Sometimes you may need to eager load a relationship after the parent model has already been retrieved. For example, this may be useful if you need to dynamically decide whether to load related models:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$books</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Book<span class="token punctuation">::</span></span><span class="token function">all<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$someCondition</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$books</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">load<span class="token punctuation">(</span></span><span class="token string">'author'</span><span class="token punctuation">,</span> <span class="token string">'publisher'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>If you need to set additional query constraints on the eager loading query, you may pass an array keyed by the relationships you wish to load. The array values should be <code class=" language-php">Closure</code> instances which receive the query instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$books</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">load<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'author'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$query</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">orderBy<span class="token punctuation">(</span></span><span class="token string">'published_date'</span><span class="token punctuation">,</span> <span class="token string">'asc'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="inserting-and-updating-related-models"></a>
    </p>
    <h2><a href="#inserting-and-updating-related-models">Inserting &amp; Updating Related Models</a></h2>
    <p>
        <a name="the-save-method"></a>
    </p>
    <h3>The Save Method</h3>
    <p>Eloquent provides convenient methods for adding new models to relationships. For example, perhaps you need to insert a new <code class=" language-php">Comment</code> for a <code class=" language-php">Post</code> model. Instead of manually setting the <code class=" language-php">post_id</code> attribute on the <code class=" language-php">Comment</code>, you may insert the <code class=" language-php">Comment</code> directly from the relationship's <code class=" language-php">save</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$comment</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">App<span class="token punctuation">\</span>Comment</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'message'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'A new comment.'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$post</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">comments<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token variable">$comment</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Notice that we did not access the <code class=" language-php">comments</code> relationship as a dynamic property. Instead, we called the <code class=" language-php">comments</code> method to obtain an instance of the relationship. The <code class=" language-php">save</code> method will automatically add the appropriate <code class=" language-php">post_id</code> value to the new <code class=" language-php">Comment</code> model.</p>
    <p>If you need to save multiple related models, you may use the <code class=" language-php">saveMany</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$post</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">comments<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">saveMany<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token keyword">new</span> <span class="token class-name">App<span class="token punctuation">\</span>Comment</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'message'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'A new comment.'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token keyword">new</span> <span class="token class-name">App<span class="token punctuation">\</span>Comment</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token string">'message'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Another comment.'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="the-create-method"></a>
    </p>
    <h3>The Create Method</h3>
    <p>In addition to the <code class=" language-php">save</code> and <code class=" language-php">saveMany</code> methods, you may also use the <code class=" language-php">create</code> method, which accepts an array of attributes, creates a model, and inserts it into the database. Again, the difference between <code class=" language-php">save</code> and <code class=" language-php">create</code> is that <code class=" language-php">save</code> accepts a full Eloquent model instance while <code class=" language-php">create</code> accepts a plain PHP <code class=" language-php"><span class="token keyword">array</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$post</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$comment</span> <span class="token operator">=</span> <span class="token variable">$post</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">comments<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'message'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'A new comment.'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Before using the <code class=" language-php">create</code> method, be sure to review the documentation on attribute <a href="/docs/5.3/eloquent#mass-assignment">mass assignment</a>.</p>
    <p>
        <a name="updating-belongs-to-relationships"></a>
    </p>
    <h3>Belongs To Relationships</h3>
    <p>When updating a <code class=" language-php">belongsTo</code> relationship, you may use the <code class=" language-php">associate</code> method. This method will set the foreign key on the child model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$account</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Account<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">account<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">associate<span class="token punctuation">(</span></span><span class="token variable">$account</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>When removing a <code class=" language-php">belongsTo</code> relationship, you may use the <code class=" language-php">dissociate</code> method. This method will set the relationship's foreign key to <code class=" language-php"><span class="token keyword">null</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">account<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">dissociate<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="updating-many-to-many-relationships"></a>
    </p>
    <h3>Many To Many Relationships</h3>
    <h4>Attaching / Detaching</h4>
    <p>Eloquent also provides a few additional helper methods to make working with related models more convenient. For example, let's imagine a user can have many roles and a role can have many users. To attach a role to a user by inserting a record in the intermediate table that joins the models, use the <code class=" language-php">attach</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach<span class="token punctuation">(</span></span><span class="token variable">$roleId</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>When attaching a relationship to a model, you may also pass an array of additional data to be inserted into the intermediate table:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach<span class="token punctuation">(</span></span><span class="token variable">$roleId</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'expires'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$expires</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Of course, sometimes it may be necessary to remove a role from a user. To remove a many-to-many relationship record, use the <code class=" language-php">detach</code> method. The <code class=" language-php">detach</code> method will remove the appropriate record out of the intermediate table; however, both models will remain in the database:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Detach a single role from the user...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">detach<span class="token punctuation">(</span></span><span class="token variable">$roleId</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Detach all roles from the user...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">detach<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>For convenience, <code class=" language-php">attach</code> and <code class=" language-php">detach</code> also accept arrays of IDs as input:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">detach<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'expires'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$expires</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Syncing Associations</h4>
    <p>You may also use the <code class=" language-php">sync</code> method to construct many-to-many associations. The <code class=" language-php">sync</code> method accepts an array of IDs to place on the intermediate table. Any IDs that are not in the given array will be removed from the intermediate table. So, after this operation is complete, only the IDs in the given array will exist in the intermediate table:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sync<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may also pass additional intermediate table values with the IDs:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sync<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'expires'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you do not want to detach existing IDs, you may use the <code class=" language-php">syncWithoutDetaching</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">syncWithoutDetaching<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Saving Additional Data On A Pivot Table</h4>
    <p>When working with a many-to-many relationship, the <code class=" language-php">save</code> method accepts an array of additional intermediate table attributes as its second argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token variable">$role</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'expires'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$expires</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Updating A Record On A Pivot Table</h4>
    <p>If you need to update an existing row in your pivot table, you may use <code class=" language-php">updateExistingPivot</code> method. This method accepts the pivot record foreign key and an array of attributes to update:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">roles<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">updateExistingPivot<span class="token punctuation">(</span></span><span class="token variable">$roleId</span><span class="token punctuation">,</span> <span class="token variable">$attributes</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="touching-parent-timestamps"></a>
    </p>
    <h2><a href="#touching-parent-timestamps">Touching Parent Timestamps</a></h2>
    <p>When a model <code class=" language-php">belongsTo</code> or <code class=" language-php">belongsToMany</code> another model, such as a <code class=" language-php">Comment</code> which belongs to a <code class=" language-php">Post</code>, it is sometimes helpful to update the parent's timestamp when the child model is updated. For example, when a <code class=" language-php">Comment</code> model is updated, you may want to automatically "touch" the <code class=" language-php">updated_at</code> timestamp of the owning <code class=" language-php">Post</code>. Eloquent makes it easy. Just add a <code class=" language-php">touches</code> property containing the names of the relationships to the child model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Comment</span> <span class="token keyword">extends</span> <span class="token class-name">Model</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * All of the relationships to be touched.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$touches</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string">'post'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Get the post that the comment belongs to.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">post<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">belongsTo<span class="token punctuation">(</span></span><span class="token string">'App\Post'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Now, when you update a <code class=" language-php">Comment</code>, the owning <code class=" language-php">Post</code> will have its <code class=" language-php">updated_at</code> column updated as well, making it more convenient to know when to invalidate a cache of the <code class=" language-php">Post</code> model:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$comment</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>Comment<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$comment</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">text</span> <span class="token operator">=</span> <span class="token string">'Edit to this comment!'</span><span class="token punctuation">;</span>

<span class="token variable">$comment</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/eloquent-relationships">https://laravel.com/docs/5.3/eloquent-relationships</a></div>
</article>
@endsection