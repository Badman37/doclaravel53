@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Database Testing</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#resetting-the-database-after-each-test">Resetting The Database After Each Test</a>
            <ul>
                <li><a href="#using-migrations">Using Migrations</a>
                </li>
                <li><a href="#using-transactions">Using Transactions</a>
                </li>
            </ul>
        </li>
        <li><a href="#writing-factories">Writing Factories</a>
            <ul>
                <li><a href="#factory-states">Factory States</a>
                </li>
            </ul>
        </li>
        <li><a href="#using-factories">Using Factories</a>
            <ul>
                <li><a href="#creating-models">Creating Models</a>
                </li>
                <li><a href="#persisting-models">Persisting Models</a>
                </li>
                <li><a href="#relationships">Relationships</a>
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel provides a variety of helpful tools to make it easier to test your database driven applications. First, you may use the <code class=" language-php">seeInDatabase</code> helper to assert that data exists in the database matching a given set of criteria. For example, if you would like to verify that there is a record in the <code class=" language-php">users</code> table with the <code class=" language-php">email</code> value of <code class=" language-php">sally@example<span class="token punctuation">.</span>com</code>, you can do the following:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testDatabase<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Make call to application...
</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seeInDatabase<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
        <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'sally@example.com'</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Of course, the <code class=" language-php">seeInDatabase</code> method and other helpers like it are for convenience. You are free to use any of PHPUnit's built-in assertion methods to supplement your tests.</p>
    <p>
        <a name="resetting-the-database-after-each-test"></a>
    </p>
    <h2><a href="#resetting-the-database-after-each-test">Resetting The Database After Each Test</a></h2>
    <p>It is often useful to reset your database after each test so that data from a previous test does not interfere with subsequent tests.</p>
    <p>
        <a name="using-migrations"></a>
    </p>
    <h3>Using Migrations</h3>
    <p>One approach to resetting the database state is to rollback the database after each test and migrate it before the next test. Laravel provides a simple <code class=" language-php">DatabaseMigrations</code> trait that will automatically handle this for you. Simply use the trait on your test class and everything will be handled for you:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>WithoutMiddleware</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseMigrations</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseTransactions</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">DatabaseMigrations</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * A basic functional test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'Laravel 5'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="using-transactions"></a>
    </p>
    <h3>Using Transactions</h3>
    <p>Another approach to resetting the database state is to wrap each test case in a database transaction. Again, Laravel provides a convenient <code class=" language-php">DatabaseTransactions</code> trait that will automatically handle this for you:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>WithoutMiddleware</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseMigrations</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseTransactions</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">DatabaseTransactions</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * A basic functional test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'Laravel 5'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> This trait will only wrap the default database connection in a transaction. If your application is using multiple database connections, you will need to manually handle the transaction logic for those connections.</p>
    </blockquote>
    <p>
        <a name="writing-factories"></a>
    </p>
    <h2><a href="#writing-factories">Writing Factories</a></h2>
    <p>When testing, it is common to need to insert a few records into your database before executing your test. Instead of manually specifying the value of each column when you create this test data, Laravel allows you to define a default set of attributes for each of your <a href="/docs/5.3/eloquent">Eloquent models</a> using model factories. To get started, take a look at the <code class=" language-php">database<span class="token operator">/</span>factories<span class="token operator">/</span>ModelFactory<span class="token punctuation">.</span>php</code> file in your application. Out of the box, this file contains one factory definition:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$factory</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">define<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span>Faker\<span class="token package">Generator</span> <span class="token variable">$faker</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span>
        <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$faker</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">,</span>
        <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$faker</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">email</span><span class="token punctuation">,</span>
        <span class="token string">'password'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">bcrypt<span class="token punctuation">(</span></span><span class="token function">str_random<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
        <span class="token string">'remember_token'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">str_random<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Within the Closure, which serves as the factory definition, you may return the default test values of all attributes on the model. The Closure will receive an instance of the <a href="https://github.com/fzaninotto/Faker">Faker</a> PHP library, which allows you to conveniently generate various kinds of random data for testing.</p>
    <p>Of course, you are free to add your own additional factories to the <code class=" language-php">ModelFactory<span class="token punctuation">.</span>php</code> file. You may also create additional factory files for each model for better organization. For example, you could create <code class=" language-php">UserFactory<span class="token punctuation">.</span>php</code> and <code class=" language-php">CommentFactory<span class="token punctuation">.</span>php</code> files within your <code class=" language-php">database<span class="token operator">/</span>factories</code> directory. All of the files within the <code class=" language-php">factories</code> directory will automatically be loaded by Laravel.</p>
    <p>
        <a name="factory-states"></a>
    </p>
    <h3>Factory States</h3>
    <p>States allow you to define discrete modifications that can be applied to your model factories in any combination. For example, your <code class=" language-php">User</code> model might have a <code class=" language-php">delinquent</code> state that modifies one of its default attribute values. You may define your state transformations using the <code class=" language-php">state</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$factory</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">state<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token string">'delinquent'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$faker</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span>
        <span class="token string">'account_status'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'delinquent'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="using-factories"></a>
    </p>
    <h2><a href="#using-factories">Using Factories</a></h2>
    <p>
        <a name="creating-models"></a>
    </p>
    <h3>Creating Models</h3>
    <p>Once you have defined your factories, you may use the global <code class=" language-php">factory</code> function in your tests or seed files to generate model instances. So, let's take a look at a few examples of creating models. First, we'll use the <code class=" language-php">make</code> method to create models but not save them to the database:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testDatabase<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token variable">$user</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> // Use model in tests...
</span><span class="token punctuation">}</span></code></pre>
    <p>You may also create a Collection of many models or create models of a given type:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Create three App\User instances...
</span><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Create an "admin" App\User instance...
</span><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token string">'admin'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Create three "admin" App\User instances...
</span><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token string">'admin'</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Applying States</h4>
    <p>You may also apply any of your <a href="#factory-states">states</a> to the models. If you would like to apply multiple state transformations to the models, you should specify the name of each state you would like to apply:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">states<span class="token punctuation">(</span></span><span class="token string">'deliquent'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$users</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">states<span class="token punctuation">(</span></span><span class="token string">'premium'</span><span class="token punctuation">,</span> <span class="token string">'deliquent'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Overriding Attributes</h4>
    <p>If you would like to override some of the default values of your models, you may pass an array of values to the <code class=" language-php">make</code> method. Only the specified values will be replaced while the rest of the values remain set to their default values as specified by the factory:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Abigail'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="persisting-models"></a>
    </p>
    <h3>Persisting Models</h3>
    <p>The <code class=" language-php">create</code> method not only creates the model instances but also saves them to the database using Eloquent's <code class=" language-php">save</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testDatabase<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Create a single App\User instance...
</span>    <span class="token variable">$user</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> // Create three App\User instances...
</span>    <span class="token variable">$users</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> // Use model in tests...
</span><span class="token punctuation">}</span></code></pre>
    <p>You may override attributes on the model by passing an array to the <code class=" language-php">create</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Abigail'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="relationships"></a>
    </p>
    <h3>Relationships</h3>
    <p>In this example, we'll attach a relation to some created models. When using the <code class=" language-php">create</code> method to create multiple models, an Eloquent <a href="/docs/5.3/eloquent-collections">collection instance</a> is returned, allowing you to use any of the convenient functions provided by the collection, such as <code class=" language-php">each</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$users</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token number">3</span><span class="token punctuation">)</span>
           <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
           <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">each<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$u</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
                <span class="token variable">$u</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">posts<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Relations &amp; Attribute Closures</h4>
    <p>You may also attach relationships to models using Closure attributes in your factory definitions. For example, if you would like to create a new <code class=" language-php">User</code> instance when creating a <code class=" language-php">Post</code>, you may do the following:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$factory</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">define<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$faker</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span>
        <span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$faker</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">title</span><span class="token punctuation">,</span>
        <span class="token string">'content'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$faker</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">paragraph</span><span class="token punctuation">,</span>
        <span class="token string">'user_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>These Closures also receive the evaluated attribute array of the factory that contains them:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$factory</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">define<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$faker</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span>
        <span class="token string">'title'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$faker</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">title</span><span class="token punctuation">,</span>
        <span class="token string">'content'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$faker</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">paragraph</span><span class="token punctuation">,</span>
        <span class="token string">'user_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">,</span>
        <span class="token string">'user_type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token keyword">array</span> <span class="token variable">$post</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token variable">$post</span><span class="token punctuation">[</span><span class="token string">'user_id'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">type</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
div>Nguồn: <a href="https://laravel.com/docs/5.3/database-testing">https://laravel.com/docs/5.3/database-testing</a></div>
</article>
@endsection