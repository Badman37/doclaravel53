@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Database: Seeding</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#writing-seeders">Writing Seeders</a>
            <ul>
                <li><a href="#using-model-factories">Using Model Factories</a>
                </li>
                <li><a href="#calling-additional-seeders">Calling Additional Seeders</a>
                </li>
            </ul>
        </li>
        <li><a href="#running-seeders">Running Seeders</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel includes a simple method of seeding your database with test data using seed classes. All seed classes are stored in the <code class=" language-php">database<span class="token operator">/</span>seeds</code> directory. Seed classes may have any name you wish, but probably should follow some sensible convention, such as <code class=" language-php">UsersTableSeeder</code>, etc. By default, a <code class=" language-php">DatabaseSeeder</code> class is defined for you. From this class, you may use the <code class=" language-php">call</code> method to run other seed classes, allowing you to control the seeding order.</p>
    <p>
        <a name="writing-seeders"></a>
    </p>
    <h2><a href="#writing-seeders">Writing Seeders</a></h2>
    <p>To generate a seeder, execute the <code class=" language-php">make<span class="token punctuation">:</span>seeder</code> <a href="/docs/5.3/artisan">Artisan command</a>. All seeders generated by the framework will be placed in the <code class=" language-php">database<span class="token operator">/</span>seeds</code> directory:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>seeder UsersTableSeeder</code></pre>
    <p>A seeder class only contains one method by default: <code class=" language-php">run</code>. This method is called when the <code class=" language-php">db<span class="token punctuation">:</span>seed</code> <a href="/docs/5.3/artisan">Artisan command</a> is executed. Within the <code class=" language-php">run</code> method, you may insert data into your database however you wish. You may use the <a href="/docs/5.3/queries">query builder</a> to manually insert data or you may use <a href="/docs/5.3/database-testing#writing-factories">Eloquent model factories</a>.</p>
    <p>As an example, let's modify the default <code class=" language-php">DatabaseSeeder</code> class and add a database insert statement to the <code class=" language-php">run</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Seeder</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Database<span class="token punctuation">\</span>Eloquent<span class="token punctuation">\</span>Model</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">DatabaseSeeder</span> <span class="token keyword">extends</span> <span class="token class-name">Seeder</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Run the database seeds.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">run<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">DB<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">insert<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
            <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">str_random<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
            <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">str_random<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">.</span><span class="token string">'@gmail.com'</span><span class="token punctuation">,</span>
            <span class="token string">'password'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">bcrypt<span class="token punctuation">(</span></span><span class="token string">'secret'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="using-model-factories"></a>
    </p>
    <h3>Using Model Factories</h3>
    <p>Of course, manually specifying the attributes for each model seed is cumbersome. Instead, you can use <a href="/docs/5.3/database-testing#writing-factories">model factories</a> to conveniently generate large amounts of database records. First, review the <a href="/docs/5.3/database-testing#writing-factories">model factory documentation</a> to learn how to define your factories. Once you have defined your factories, you may use the <code class=" language-php">factory</code> helper function to insert records into your database.</p>
    <p>For example, let's create 50 users and attach a relationship to each user:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Run the database seeds.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">run<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token number">50</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">each<span class="token punctuation">(</span></span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$u</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token variable">$u</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">posts<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">save<span class="token punctuation">(</span></span><span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>Post<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">make<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="calling-additional-seeders"></a>
    </p>
    <h3>Calling Additional Seeders</h3>
    <p>Within the <code class=" language-php">DatabaseSeeder</code> class, you may use the <code class=" language-php">call</code> method to execute additional seed classes. Using the <code class=" language-php">call</code> method allows you to break up your database seeding into multiple files so that no single seeder class becomes overwhelmingly large. Simply pass the name of the seeder class you wish to run:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Run the database seeds.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">run<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">call<span class="token punctuation">(</span></span><span class="token scope">UsersTableSeeder<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">call<span class="token punctuation">(</span></span><span class="token scope">PostsTableSeeder<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">call<span class="token punctuation">(</span></span><span class="token scope">CommentsTableSeeder<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="running-seeders"></a>
    </p>
    <h2><a href="#running-seeders">Running Seeders</a></h2>
    <p>Once you have written your seeder classes, you may use the <code class=" language-php">db<span class="token punctuation">:</span>seed</code> Artisan command to seed your database. By default, the <code class=" language-php">db<span class="token punctuation">:</span>seed</code> command runs the <code class=" language-php">DatabaseSeeder</code> class, which may be used to call other seed classes. However, you may use the <code class=" language-php"><span class="token operator">--</span><span class="token keyword">class</span></code> option to specify a specific seeder class to run individually:</p>
    <pre class=" language-php"><code class=" language-php">php artisan db<span class="token punctuation">:</span>seed

php artisan db<span class="token punctuation">:</span>seed <span class="token operator">--</span><span class="token keyword">class</span><span class="token operator">=</span>UsersTableSeeder</code></pre>
    <p>You may also seed your database using the <code class=" language-php">migrate<span class="token punctuation">:</span>refresh</code> command, which will also rollback and re-run all of your migrations. This command is useful for completely re-building your database:</p>
    <pre class=" language-php"><code class=" language-php">php artisan migrate<span class="token punctuation">:</span>refresh <span class="token operator">--</span>seed</code></pre>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/seeding">https://laravel.com/docs/5.3/seeding</a></div>
</article>
@endsection