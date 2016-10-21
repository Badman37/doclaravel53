@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Envoy Task Runner</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
            <ul>
                <li><a href="#installation">Installation</a>
                </li>
            </ul>
        </li>
        <li><a href="#writing-tasks">Writing Tasks</a>
            <ul>
                <li><a href="#setup">Setup</a>
                </li>
                <li><a href="#variables">Variables</a>
                </li>
                <li><a href="#stories">Stories</a>
                </li>
                <li><a href="#multiple-servers">Multiple Servers</a>
                </li>
            </ul>
        </li>
        <li><a href="#running-tasks">Running Tasks</a>
            <ul>
                <li><a href="#confirming-task-execution">Confirming Task Execution</a>
                </li>
            </ul>
        </li>
        <li><a href="#notifications">Notifications</a>
            <ul>
                <li><a href="#slack">Slack</a>
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p><a href="https://github.com/laravel/envoy">Laravel Envoy</a> provides a clean, minimal syntax for defining common tasks you run on your remote servers. Using Blade style syntax, you can easily setup tasks for deployment, Artisan commands, and more. Currently, Envoy only supports the Mac and Linux operating systems.</p>
    <p>
        <a name="installation"></a>
    </p>
    <h3>Installation</h3>
    <p>First, install Envoy using the Composer <code class=" language-php"><span class="token keyword">global</span> <span class="token keyword">require</span></code> command:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">global</span> <span class="token keyword">require</span> <span class="token string">"laravel/envoy=~1.0"</span></code></pre>
    <p>Since global Composer libraries can sometimes cause package version conflicts, you may wish to consider using <code class=" language-php">cgr</code>, which is a drop-in replacement for the <code class=" language-php">composer <span class="token keyword">global</span> <span class="token keyword">require</span></code> command. The <code class=" language-php">cgr</code> library's installation instructions can be <a href="https://github.com/consolidation-org/cgr">found on GitHub</a>.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Make sure to place the <code class=" language-php"><span class="token operator">~</span><span class="token operator">/</span><span class="token punctuation">.</span>composer<span class="token operator">/</span>vendor<span class="token operator">/</span>bin</code> directory in your PATH so the <code class=" language-php">envoy</code> executable is found when running the <code class=" language-php">envoy</code> command in your terminal.</p>
    </blockquote>
    <h4>Updating Envoy</h4>
    <p>You may also use Composer to keep your Envoy installation up to date. Issuing the the <code class=" language-php">composer <span class="token keyword">global</span> update</code> command will update all of your globally installed Composer packages:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">global</span> update</code></pre>
    <p>
        <a name="writing-tasks"></a>
    </p>
    <h2><a href="#writing-tasks">Writing Tasks</a></h2>
    <p>All of your Envoy tasks should be defined in an <code class=" language-php">Envoy<span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code> file in the root of your project. Here's an example to get you started:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">servers<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'web'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'user@192.168.1.1'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span>

@<span class="token function">task<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'on'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'web'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
    ls <span class="token operator">-</span>la
@endtask</code></pre>
    <p>As you can see, an array of <code class=" language-php">@servers</code> is defined at the top of the file, allowing you to reference these servers in the <code class=" language-php">on</code> option of your task declarations. Within your <code class=" language-php">@task</code> declarations, you should place the Bash code that should run on your server when the task is executed.</p>
    <p>You can force a script to run locally by specifying the server's IP address as <code class=" language-php"><span class="token number">127.0</span><span class="token punctuation">.</span><span class="token number">0.1</span></code>:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">servers<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'localhost'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'127.0.0.1'</span><span class="token punctuation">]</span><span class="token punctuation">)</span></code></pre>
    <p>
        <a name="setup"></a>
    </p>
    <h3>Setup</h3>
    <p>Sometimes, you may need to execute some PHP code before executing your Envoy tasks. You may use the <code class=" language-php">@setup</code> directive to declare variables and do other general PHP work before any of your other tasks are executed:</p>
    <pre class=" language-php"><code class=" language-php">@setup
    <span class="token variable">$now</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">DateTime</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token variable">$environment</span> <span class="token operator">=</span> <span class="token function">isset<span class="token punctuation">(</span></span><span class="token variable">$env</span><span class="token punctuation">)</span> <span class="token operator">?</span> <span class="token variable">$env</span> <span class="token punctuation">:</span> <span class="token string">"testing"</span><span class="token punctuation">;</span>
@endsetup</code></pre>
    <p>If you need to require other PHP files before your task is executed, you may use the <code class=" language-php">@<span class="token keyword">include</span></code> directive at the top of your <code class=" language-php">Envoy<span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code> file:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token keyword">include</span><span class="token punctuation">(</span><span class="token string">'vendor/autoload.php'</span><span class="token punctuation">)</span>

@<span class="token function">task<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">)</span>
   <span class="token comment" spellcheck="true"> # ...
</span>@endtask</code></pre>
    <p>
        <a name="variables"></a>
    </p>
    <h3>Variables</h3>
    <p>If needed, you may pass option values into Envoy tasks using the command line:</p>
    <pre class=" language-php"><code class=" language-php">envoy run deploy <span class="token operator">--</span>branch<span class="token operator">=</span>master</code></pre>
    <p>You may use access the options in your tasks via Blade's "echo" syntax. Of course, you may also use <code class=" language-php"><span class="token keyword">if</span></code> statements and loops within your tasks. For example, let's verify the presence of the <code class=" language-php"><span class="token variable">$branch</span></code> variable before executing the <code class=" language-php">git pull</code> command:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">servers<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'web'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'192.168.1.1'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>

@<span class="token function">task<span class="token punctuation">(</span></span><span class="token string">'deploy'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'on'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'web'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
    cd site

    @<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$branch</span><span class="token punctuation">)</span>
        git pull origin <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$branch</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
    @<span class="token keyword">endif</span>

    php artisan migrate
@endtask</code></pre>
    <p>
        <a name="stories"></a>
    </p>
    <h3>Stories</h3>
    <p>Stories group a set of tasks under a single, convenient name, allowing you to group small, focused tasks into large tasks. For instance, a <code class=" language-php">deploy</code> story may run the <code class=" language-php">git</code> and <code class=" language-php">composer</code> tasks by listing the task names within its definition:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">servers<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'web'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'192.168.1.1'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>

@<span class="token function">story<span class="token punctuation">(</span></span><span class="token string">'deploy'</span><span class="token punctuation">)</span>
    git
    composer
@endstory

@<span class="token function">task<span class="token punctuation">(</span></span><span class="token string">'git'</span><span class="token punctuation">)</span>
    git pull origin master
@endtask

@<span class="token function">task<span class="token punctuation">(</span></span><span class="token string">'composer'</span><span class="token punctuation">)</span>
    composer install
@endtask</code></pre>
    <p>Once the story has been written, you may run it just like a typical task:</p>
    <pre class=" language-php"><code class=" language-php">envoy run deploy</code></pre>
    <p>
        <a name="multiple-servers"></a>
    </p>
    <h3>Multiple Servers</h3>
    <p>Envoy allows you to easily run a task across multiple servers. First, add additional servers to your <code class=" language-php">@servers</code> declaration. Each server should be assigned a unique name. Once you have defined your additional servers, list each of the servers in the task's <code class=" language-php">on</code> array:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">servers<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'web-1'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'192.168.1.1'</span><span class="token punctuation">,</span> <span class="token string">'web-2'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'192.168.1.2'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>

@<span class="token function">task<span class="token punctuation">(</span></span><span class="token string">'deploy'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'on'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'web-1'</span><span class="token punctuation">,</span> <span class="token string">'web-2'</span><span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
    cd site
    git pull origin <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$branch</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
    php artisan migrate
@endtask</code></pre>
    <h4>Parallel Execution</h4>
    <p>By default, tasks will be executed on each server serially. In other words, a task will finish running on the first server before proceeding to execute on the second server. If you would like to run a task across multiple servers in parallel, add the <code class=" language-php">parallel</code> option to your task declaration:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">servers<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'web-1'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'192.168.1.1'</span><span class="token punctuation">,</span> <span class="token string">'web-2'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'192.168.1.2'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>

@<span class="token function">task<span class="token punctuation">(</span></span><span class="token string">'deploy'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'on'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'web-1'</span><span class="token punctuation">,</span> <span class="token string">'web-2'</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token string">'parallel'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
    cd site
    git pull origin <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$branch</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
    php artisan migrate
@endtask</code></pre>
    <p>
        <a name="running-tasks"></a>
    </p>
    <h2><a href="#running-tasks">Running Tasks</a></h2>
    <p>To run a task or story that is defined in your <code class=" language-php">Envoy<span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code> file, execute Envoy's <code class=" language-php">run</code> command, passing the name of the task or story you would like to execute. Envoy will run the task and display the output from the servers as the task is running:</p>
    <pre class=" language-php"><code class=" language-php">envoy run task</code></pre>
    <p>
        <a name="confirming-task-execution"></a>
    </p>
    <h3>Confirming Task Execution</h3>
    <p>If you would like to be prompted for confirmation before running a given task on your servers, you should add the <code class=" language-php">confirm</code> directive to your task declaration. This option is particularly useful for destructive operations:</p>
    <pre class=" language-php"><code class=" language-php">@<span class="token function">task<span class="token punctuation">(</span></span><span class="token string">'deploy'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'on'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'web'</span><span class="token punctuation">,</span> <span class="token string">'confirm'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
    cd site
    git pull origin <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$branch</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
    php artisan migrate
@endtask</code></pre>
    <p>
        <a name="notifications"></a>
        <a name="hipchat-notifications"></a>
    </p>
    <h2><a href="#hipchat-notifications"><a href="#notifications">Notifications</a></a></h2>
    <p>
        <a name="slack"></a>
    </p>
    <h3>Slack</h3>
    <p>Envoy also supports sending notifications to <a href="https://slack.com">Slack</a> after each task is executed. The <code class=" language-php">@slack</code> directive accepts a Slack hook URL and a channel name. You may retrieve your webhook URL by creating an "Incoming WebHooks" integration in your Slack control panel. You should pass the entire webhook URL into the <code class=" language-php">@slack</code> directive:</p>
    <pre class=" language-php"><code class=" language-php">@after
    @<span class="token function">slack<span class="token punctuation">(</span></span><span class="token string">'webhook-url'</span><span class="token punctuation">,</span> <span class="token comment" spellcheck="true">'#bots')
</span>@endafter</code></pre>
    <p>You may provide one of the following as the channel argument:</p>
    <div class="content-list">
        <ul>
            <li>To send the notification to a channel: <code class=" language-php"><span class="token comment" spellcheck="true">#channel</span></code>
            </li>
            <li>To send the notification to a user: <code class=" language-php">@user</code>
            </li>
        </ul>
    </div>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/envoy">https://laravel.com/docs/5.3/envoy</a></div>
</article>
@endsection