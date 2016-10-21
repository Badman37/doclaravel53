@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Queues</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
            <ul>
                <li><a href="#connections-vs-queues">Connections Vs. Queues</a>
                </li>
                <li><a href="#driver-prerequisites">Driver Prerequisites</a>
                </li>
            </ul>
        </li>
        <li><a href="#creating-jobs">Creating Jobs</a>
            <ul>
                <li><a href="#generating-job-classes">Generating Job Classes</a>
                </li>
                <li><a href="#class-structure">Class Structure</a>
                </li>
            </ul>
        </li>
        <li><a href="#dispatching-jobs">Dispatching Jobs</a>
            <ul>
                <li><a href="#delayed-dispatching">Delayed Dispatching</a>
                </li>
                <li><a href="#customizing-the-queue-and-connection">Customizing The Queue &amp; Connection</a>
                </li>
                <li><a href="#error-handling">Error Handling</a>
                </li>
            </ul>
        </li>
        <li><a href="#running-the-queue-worker">Running The Queue Worker</a>
            <ul>
                <li><a href="#queue-priorities">Queue Priorities</a>
                </li>
                <li><a href="#queue-workers-and-deployment">Queue Workers &amp; Deployment</a>
                </li>
                <li><a href="#job-expirations-and-timeouts">Job Expirations &amp; Timeouts</a>
                </li>
            </ul>
        </li>
        <li><a href="#supervisor-configuration">Supervisor Configuration</a>
        </li>
        <li><a href="#dealing-with-failed-jobs">Dealing With Failed Jobs</a>
            <ul>
                <li><a href="#cleaning-up-after-failed-jobs">Cleaning Up After Failed Jobs</a>
                </li>
                <li><a href="#failed-job-events">Failed Job Events</a>
                </li>
                <li><a href="#retrying-failed-jobs">Retrying Failed Jobs</a>
                </li>
            </ul>
        </li>
        <li><a href="#job-events">Job Events</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel queues provide a unified API across a variety of different queue backends, such as Beanstalk, Amazon SQS, Redis, or even a relational database. Queues allow you to defer the processing of a time consuming task, such as sending an email, until a later time. Deferring these time consuming tasks drastically speeds up web requests to your application.</p>
    <p>The queue configuration file is stored in <code class=" language-php">config<span class="token operator">/</span>queue<span class="token punctuation">.</span>php</code>. In this file you will find connection configurations for each of the queue drivers that are included with the framework, which includes a database, <a href="http://kr.github.com/beanstalkd">Beanstalkd</a>, <a href="http://aws.amazon.com/sqs">Amazon SQS</a>, <a href="http://redis.io">Redis</a>, and synchronous (for local use) driver. A <code class=" language-php"><span class="token keyword">null</span></code> queue driver is also included which simply discards queued jobs.</p>
    <p>
        <a name="connections-vs-queues"></a>
    </p>
    <h3>Connections Vs. Queues</h3>
    <p>Before getting started with Laravel queues, it is important to understand the distinction between "connections" and "queues". In your <code class=" language-php">config<span class="token operator">/</span>queue<span class="token punctuation">.</span>php</code> configuration file, there is a <code class=" language-php">connections</code> configuration option. This option defines a particular connection to a backend service such as Amazon SQS, Beanstalk, or Redis. However, any given queue connection may have multiple "queues" which may be thought of as different stacks or piles of queued jobs.</p>
    <p>Note that each connection configuration example in the <code class=" language-php">queue</code> configuration file contains a <code class=" language-php">queue</code> attribute. This is the default queue that jobs will be dispatched to when they are sent to a given connection. In other words, if you dispatch a job without explicitly defining which queue it should be dispatched to, the job will be placed on the queue that is defined in the <code class=" language-php">queue</code> attribute of the connection configuration:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// This job is sent to the default queue...
</span><span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">Job</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// This job is sent to the "emails" queue...
</span><span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Job</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onQueue<span class="token punctuation">(</span></span><span class="token string">'emails'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Some applications may not need to ever push jobs onto multiples queues, instead preferring to have one simple queue. However, pushing jobs to multiple queues can be especially useful for applications that wish to prioritize or segment how jobs are processed, since the Laravel queue worker allows you to specify which queues it should process by priority. For example, if you push jobs to a <code class=" language-php">high</code> queue, you may run a worker that gives them higher processing priority:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>work <span class="token operator">--</span>queue<span class="token operator">=</span>high<span class="token punctuation">,</span><span class="token keyword">default</span></code></pre>
    <p>
        <a name="driver-prerequisites"></a>
    </p>
    <h3>Driver Prerequisites</h3>
    <h4>Database</h4>
    <p>In order to use the <code class=" language-php">database</code> queue driver, you will need a database table to hold the jobs. To generate a migration that creates this table, run the <code class=" language-php">queue<span class="token punctuation">:</span>table</code> Artisan command. Once the migration has been created, you may migrate your database using the <code class=" language-php">migrate</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>table

php artisan migrate</code></pre>
    <h4>Other Driver Prerequisites</h4>
    <p>The following dependencies are needed for the listed queue drivers:</p>
    <div class="content-list">
        <ul>
            <li>Amazon SQS: <code class=" language-php">aws<span class="token operator">/</span>aws<span class="token operator">-</span>sdk<span class="token operator">-</span>php <span class="token operator">~</span><span class="token number">3.0</span></code>
            </li>
            <li>Beanstalkd: <code class=" language-php">pda<span class="token operator">/</span>pheanstalk <span class="token operator">~</span><span class="token number">3.0</span></code>
            </li>
            <li>Redis: <code class=" language-php">predis<span class="token operator">/</span>predis <span class="token operator">~</span><span class="token number">1.0</span></code>
            </li>
        </ul>
    </div>
    <p>
        <a name="creating-jobs"></a>
    </p>
    <h2><a href="#creating-jobs">Creating Jobs</a></h2>
    <p>
        <a name="generating-job-classes"></a>
    </p>
    <h3>Generating Job Classes</h3>
    <p>By default, all of the queueable jobs for your application are stored in the <code class=" language-php">app<span class="token operator">/</span>Jobs</code> directory. If the <code class=" language-php">app<span class="token operator">/</span>Jobs</code> directory doesn't exist, it will be created when you run the <code class=" language-php">make<span class="token punctuation">:</span>job</code> Artisan command. You may generate a new queued job using the Artisan CLI:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>job SendReminderEmail</code></pre>
    <p>The generated class will implement the <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>ShouldQueue</span></code> interface, indicating to Laravel that the job should be pushed onto the queue instead of run synchronously.</p>
    <p>
        <a name="class-structure"></a>
    </p>
    <h3>Class Structure</h3>
    <p>Job classes are very simple, normally containing only a <code class=" language-php">handle</code> method which is called when the job is processed by the queue. To get started, let's take a look at an example job class. In this example, we'll pretend we manage a podcast publishing service and need to process the uploaded podcast files before they are published:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Jobs</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Podcast</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>AudioProcessor</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>SerializesModels</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>InteractsWithQueue</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>ShouldQueue</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ProcessPodcast</span> <span class="token keyword">implements</span> <span class="token class-name">ShouldQueue</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">InteractsWithQueue</span><span class="token punctuation">,</span> Queueable<span class="token punctuation">,</span> SerializesModels<span class="token punctuation">;</span>

    <span class="token keyword">protected</span> <span class="token variable">$podcast</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new job instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>Podcast <span class="token variable">$podcast</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">podcast</span> <span class="token operator">=</span> <span class="token variable">$podcast</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Execute the job.
     *
     * @param  AudioProcessor  $processor
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span>AudioProcessor <span class="token variable">$processor</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Process uploaded podcast...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>In this example, note that we were able to pass an <a href="/docs/5.3/eloquent">Eloquent model</a> directly into the queued job's constructor. Because of the <code class=" language-php">SerializesModels</code> trait that the job is using, Eloquent models will be gracefully serialized and unserialized when the job is processing. If your queued job accepts an Eloquent model in its constructor, only the identifier for the model will be serialized onto the queue. When the job is actually handled, the queue system will automatically re-retrieve the full model instance from the database. It's all totally transparent to your application and prevents issues that can arise from serializing full Eloquent model instances.</p>
    <p>The <code class=" language-php">handle</code> method is called when the job is processed by the queue. Note that we are able to type-hint dependencies on the <code class=" language-php">handle</code> method of the job. The Laravel <a href="/docs/5.3/container">service container</a> automatically injects these dependencies.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Binary data, such as raw image contents, should be passed through the <code class=" language-php">base64_encode</code> function before being passed to a queued job. Otherwise, the job may not properly serialize to JSON when being placed on the queue.</p>
    </blockquote>
    <p>
        <a name="dispatching-jobs"></a>
    </p>
    <h2><a href="#dispatching-jobs">Dispatching Jobs</a></h2>
    <p>Once you have written your job class, you may dispatch it using the <code class=" language-php">dispatch</code> helper. The only argument you need to pass to the <code class=" language-php">dispatch</code> helper is an instance of the job:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>ProcessPodcast</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">PodcastController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Store a new podcast.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Create podcast...
</span>
        <span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">ProcessPodcast</span><span class="token punctuation">(</span><span class="token variable">$podcast</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> The <code class=" language-php">dispatch</code> helper provides the convenience of a short, globally available function, while also being extremely easy to test. Check out the Laravel <a href="/docs/5.3/testing">testing documentation</a> to learn more.</p>
    </blockquote>
    <p>
        <a name="delayed-dispatching"></a>
    </p>
    <h3>Delayed Dispatching</h3>
    <p>If you would like to delay the execution of a queued job, you may use the <code class=" language-php">delay</code> method on your job instance. The <code class=" language-php">delay</code> method is provided by the <code class=" language-php">Illuminate\<span class="token package">Bus<span class="token punctuation">\</span>Queueable</span></code> trait, which is included by default on all generated job classes. For example, let's specify that a job should not be available for processing until 10 minutes after it has been dispatched:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Carbon<span class="token punctuation">\</span>Carbon</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>ProcessPodcast</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">PodcastController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Store a new podcast.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Create podcast...
</span>
        <span class="token variable">$job</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">ProcessPodcast</span><span class="token punctuation">(</span><span class="token variable">$podcast</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">delay<span class="token punctuation">(</span></span><span class="token scope">Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">addMinutes<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token variable">$job</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> The Amazon SQS queue service has a maximum delay time of 15 minutes.</p>
    </blockquote>
    <p>
        <a name="customizing-the-queue-and-connection"></a>
    </p>
    <h3>Customizing The Queue &amp; Connection</h3>
    <h4>Dispatching To A Particular Queue</h4>
    <p>By pushing jobs to different queues, you may "categorize" your queued jobs and even prioritize how many workers you assign to various queues. Keep in mind, this does not push jobs to different queue "connections" as defined by your queue configuration file, but only to specific queues within a single connection. To specify the queue, use the <code class=" language-php">onQueue</code> method on the job instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>ProcessPodcast</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">PodcastController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Store a new podcast.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Create podcast...
</span>
        <span class="token variable">$job</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">ProcessPodcast</span><span class="token punctuation">(</span><span class="token variable">$podcast</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onQueue<span class="token punctuation">(</span></span><span class="token string">'processing'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token variable">$job</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Dispatching To A Particular Connection</h4>
    <p>If you are working with multiple queue connections, you may specify which connection to push a job to. To specify the connection, use the <code class=" language-php">onConnection</code> method on the job instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>ProcessPodcast</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">PodcastController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Store a new podcast.
     *
     * @param  Request  $request
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">store<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Create podcast...
</span>
        <span class="token variable">$job</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">ProcessPodcast</span><span class="token punctuation">(</span><span class="token variable">$podcast</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onConnection<span class="token punctuation">(</span></span><span class="token string">'sqs'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token variable">$job</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Of course, you may chain the <code class=" language-php">onConnection</code> and <code class=" language-php">onQueue</code> methods to specify the connection and the queue for a job:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$job</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">ProcessPodcast</span><span class="token punctuation">(</span><span class="token variable">$podcast</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onConnection<span class="token punctuation">(</span></span><span class="token string">'sqs'</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onQueue<span class="token punctuation">(</span></span><span class="token string">'processing'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="error-handling"></a>
    </p>
    <h3>Error Handling</h3>
    <p>If an exception is thrown while the job is being processed, the job will automatically be released back onto the queue so it may be attempted again. The job will continue to be released until it has been attempted the maximum number of times allowed by your application. The number of maximum attempts is defined by the <code class=" language-php"><span class="token operator">--</span>tries</code> switch used on the <code class=" language-php">queue<span class="token punctuation">:</span>work</code> Artisan command. More information on running the queue worker <a href="#running-the-queue-worker">can be found below</a>.</p>
    <p>
        <a name="running-the-queue-worker"></a>
    </p>
    <h2><a href="#running-the-queue-worker">Running The Queue Worker</a></h2>
    <p>Laravel includes a queue worker that will process new jobs as they are pushed onto the queue. You may run the worker using the <code class=" language-php">queue<span class="token punctuation">:</span>work</code> Artisan command. Note that once the <code class=" language-php">queue<span class="token punctuation">:</span>work</code> command has started, it will continue to run until it is manually stopped or you close your terminal:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>work</code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> To keep the <code class=" language-php">queue<span class="token punctuation">:</span>work</code> process running permanently in the background, you should use a process monitor such as <a href="#supervisor-configuration">Supervisor</a> to ensure that the queue worker does not stop running.</p>
    </blockquote>
    <p>Remember, queue workers are long-lived processes and store the booted application state in memory. As a result, they will not notice changes in your code base after they have been started. So, during your deployment process, be sure to <a href="#queue-workers-and-deployment">restart your queue workers</a>.</p>
    <h4>Specifying The Connection &amp; Queue</h4>
    <p>You may also specify which queue connection the worker should utilize. The connection name passed to the <code class=" language-php">work</code> command should correspond to one of the connections defined in your <code class=" language-php">config<span class="token operator">/</span>queue<span class="token punctuation">.</span>php</code> configuration file:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>work redis</code></pre>
    <p>You may customize your queue worker even further by only processing particular queues for a given connection. For example, if all of your emails are processed in an <code class=" language-php">emails</code> queue on your <code class=" language-php">redis</code> queue connection, you may issue the following command to start a worker that only processes only that queue:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>work redis <span class="token operator">--</span>queue<span class="token operator">=</span>emails</code></pre>
    <p>
        <a name="queue-priorities"></a>
    </p>
    <h3>Queue Priorities</h3>
    <p>Sometimes you may wish to prioritize how your queues are processed. For example, in your <code class=" language-php">config<span class="token operator">/</span>queue<span class="token punctuation">.</span>php</code> you may set the default <code class=" language-php">queue</code> for your <code class=" language-php">redis</code> connection to <code class=" language-php">low</code>. However, occasionally you may wish to push a job to a <code class=" language-php">high</code> priority queue like so:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">dispatch<span class="token punctuation">(</span></span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Job</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onQueue<span class="token punctuation">(</span></span><span class="token string">'high'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>To start a worker that verifies that all of the <code class=" language-php">high</code> queue jobs are processed before continuing to any jobs on the <code class=" language-php">low</code> queue, pass a comma-delimited list of queue names to the <code class=" language-php">work</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>work <span class="token operator">--</span>queue<span class="token operator">=</span>high<span class="token punctuation">,</span>low</code></pre>
    <p>
        <a name="queue-workers-and-deployment"></a>
    </p>
    <h3>Queue Workers &amp; Deployment</h3>
    <p>Since queue workers are long-lived processes, they will not pick up changes to your code without being restarted. So, the simplest way to deploy an application using queue workers is to restart the workers during your deployment process. You may gracefully restart all of the workers by issuing the <code class=" language-php">queue<span class="token punctuation">:</span>restart</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>restart</code></pre>
    <p>This command will instruct all queue workers to gracefully "die" after they finish processing their current job so that no existing jobs are lost. Since the queue workers will die when the <code class=" language-php">queue<span class="token punctuation">:</span>restart</code> command is executed, you should be running a process manager such as <a href="#supervisor-configuration">Supervisor</a> to automatically restart the queue workers.</p>
    <p>
        <a name="job-expirations-and-timeouts"></a>
    </p>
    <h3>Job Expirations &amp; Timeouts</h3>
    <h4>Job Expiration</h4>
    <p>In your <code class=" language-php">config<span class="token operator">/</span>queue<span class="token punctuation">.</span>php</code> configuration file, each queue connection defines a <code class=" language-php">retry_after</code> option. This option specifies how many seconds the queue connection should wait before retrying a job that is being processed. For example, if the value of <code class=" language-php">retry_after</code> is set to <code class=" language-php"><span class="token number">90</span></code>, the job will be released back onto the queue if it has been processing for 90 seconds without being deleted. Typically, you should set the <code class=" language-php">retry_after</code> value to the maximum number of seconds your jobs should reasonably take to complete processing.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> The only queue connection which does not contain a <code class=" language-php">retry_after</code> value is Amazon SQS. SQS will retry the job based on the <a href="http://docs.aws.amazon.com/AWSSimpleQueueService/latest/SQSDeveloperGuide/AboutVT.html">Default Visibility Timeout</a> which is managed within the AWS console.</p>
    </blockquote>
    <h4>Worker Timeouts</h4>
    <p>The <code class=" language-php">queue<span class="token punctuation">:</span>work</code> Artisan command exposes a <code class=" language-php"><span class="token operator">--</span>timeout</code> option. The <code class=" language-php"><span class="token operator">--</span>timeout</code> option specifies how long the Laravel queue master process will wait before killing off a child queue worker that is processing a job. Sometimes a child queue process can become "frozen" for various reasons, such as an external HTTP call that is not responding. The <code class=" language-php"><span class="token operator">--</span>timeout</code> option removes frozen processes that have exceeded that specified time limit:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>work <span class="token operator">--</span>timeout<span class="token operator">=</span><span class="token number">60</span></code></pre>
    <p>The <code class=" language-php">retry_after</code> configuration option and the <code class=" language-php"><span class="token operator">--</span>timeout</code> CLI option are different, but work together to ensure that jobs are not lost and that jobs are only successfully processed once.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> The <code class=" language-php"><span class="token operator">--</span>timeout</code> value should always be at least several seconds shorter than your <code class=" language-php">retry_after</code> configuration value. This will ensure that a worker processing a given job is always killed before the job is retried. If your <code class=" language-php"><span class="token operator">--</span>timeout</code> option is longer than your <code class=" language-php">retry_after</code> configuration value, your jobs may be processed twice.</p>
    </blockquote>
    <p>
        <a name="supervisor-configuration"></a>
    </p>
    <h2><a href="#supervisor-configuration">Supervisor Configuration</a></h2>
    <h4>Installing Supervisor</h4>
    <p>Supervisor is a process monitor for the Linux operating system, and will automatically restart your <code class=" language-php">queue<span class="token punctuation">:</span>work</code> process if it fails. To install Supervisor on Ubuntu, you may use the following command:</p>
    <pre class=" language-php"><code class=" language-php">sudo apt<span class="token operator">-</span>get install supervisor</code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> If configuring Supervisor yourself sounds overwhelming, consider using <a href="https://forge.laravel.com">Laravel Forge</a>, which will automatically install and configure Supervisor for your Laravel projects.</p>
    </blockquote>
    <h4>Configuring Supervisor</h4>
    <p>Supervisor configuration files are typically stored in the <code class=" language-php"><span class="token operator">/</span>etc<span class="token operator">/</span>supervisor<span class="token operator">/</span>conf<span class="token punctuation">.</span>d</code> directory. Within this directory, you may create any number of configuration files that instruct supervisor how your processes should be monitored. For example, let's create a <code class=" language-php">laravel<span class="token operator">-</span>worker<span class="token punctuation">.</span>conf</code> file that starts and monitors a <code class=" language-php">queue<span class="token punctuation">:</span>work</code> process:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">[</span>program<span class="token punctuation">:</span>laravel<span class="token operator">-</span>worker<span class="token punctuation">]</span>
process_name<span class="token operator">=</span><span class="token operator">%</span><span class="token punctuation">(</span>program_name<span class="token punctuation">)</span>s_<span class="token operator">%</span><span class="token punctuation">(</span>process_num<span class="token punctuation">)</span>02d
command<span class="token operator">=</span>php <span class="token operator">/</span>home<span class="token operator">/</span>forge<span class="token operator">/</span>app<span class="token punctuation">.</span>com<span class="token operator">/</span>artisan queue<span class="token punctuation">:</span>work sqs <span class="token operator">--</span>sleep<span class="token operator">=</span><span class="token number">3</span> <span class="token operator">--</span>tries<span class="token operator">=</span><span class="token number">3</span>
autostart<span class="token operator">=</span><span class="token boolean">true</span>
autorestart<span class="token operator">=</span><span class="token boolean">true</span>
user<span class="token operator">=</span>forge
numprocs<span class="token operator">=</span><span class="token number">8</span>
redirect_stderr<span class="token operator">=</span><span class="token boolean">true</span>
stdout_logfile<span class="token operator">=</span><span class="token operator">/</span>home<span class="token operator">/</span>forge<span class="token operator">/</span>app<span class="token punctuation">.</span>com<span class="token operator">/</span>worker<span class="token punctuation">.</span>log</code></pre>
    <p>In this example, the <code class=" language-php">numprocs</code> directive will instruct Supervisor to run 8 <code class=" language-php">queue<span class="token punctuation">:</span>work</code> processes and monitor all of them, automatically restarting them if they fail. Of course, you should change the <code class=" language-php">queue<span class="token punctuation">:</span>work sqs</code> portion of the <code class=" language-php">command</code> directive to reflect your desired queue connection.</p>
    <h4>Starting Supervisor</h4>
    <p>Once the configuration file has been created, you may update the Supervisor configuration and start the processes using the following commands:</p>
    <pre class=" language-php"><code class=" language-php">sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel<span class="token operator">-</span>worker<span class="token punctuation">:</span><span class="token operator">*</span></code></pre>
    <p>For more information on Supervisor, consult the <a href="http://supervisord.org/index.html">Supervisor documentation</a>.</p>
    <p>
        <a name="dealing-with-failed-jobs"></a>
    </p>
    <h2><a href="#dealing-with-failed-jobs">Dealing With Failed Jobs</a></h2>
    <p>Sometimes your queued jobs will fail. Don't worry, things don't always go as planned! Laravel includes a convenient way to specify the maximum number of times a job should be attempted. After a job has exceeded this amount of attempts, it will be inserted into the <code class=" language-php">failed_jobs</code> database table. To create a migration for the <code class=" language-php">failed_jobs</code> table, you may use the <code class=" language-php">queue<span class="token punctuation">:</span>failed<span class="token operator">-</span>table</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>failed<span class="token operator">-</span>table

php artisan migrate</code></pre>
    <p>Then, when running your <a href="#running-the-queue-worker">queue worker</a>, you should specify the maximum number of times a job should be attempted using the <code class=" language-php"><span class="token operator">--</span>tries</code> switch on the <code class=" language-php">queue<span class="token punctuation">:</span>work</code> command. If you do not specify a value for the <code class=" language-php"><span class="token operator">--</span>tries</code> option, jobs will be attempted indefinitely:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>work redis <span class="token operator">--</span>tries<span class="token operator">=</span><span class="token number">3</span></code></pre>
    <p>
        <a name="cleaning-up-after-failed-jobs"></a>
    </p>
    <h3>Cleaning Up After Failed Jobs</h3>
    <p>You may define a <code class=" language-php">failed</code> method directly on your job class, allowing you to perform job specific clean-up when a failure occurs. This is the perfect location to send an alert to your users or revert any actions performed by the job. The <code class=" language-php">Exception</code> that caused the job to fail will be passed to the <code class=" language-php">failed</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Jobs</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Exception</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Podcast</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>AudioProcessor</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Bus<span class="token punctuation">\</span>Queueable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>SerializesModels</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>InteractsWithQueue</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>ShouldQueue</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ProcessPodcast</span> <span class="token keyword">implements</span> <span class="token class-name">ShouldQueue</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">InteractsWithQueue</span><span class="token punctuation">,</span> Queueable<span class="token punctuation">,</span> SerializesModels<span class="token punctuation">;</span>

    <span class="token keyword">protected</span> <span class="token variable">$podcast</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new job instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>Podcast <span class="token variable">$podcast</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">podcast</span> <span class="token operator">=</span> <span class="token variable">$podcast</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Execute the job.
     *
     * @param  AudioProcessor  $processor
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span>AudioProcessor <span class="token variable">$processor</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Process uploaded podcast...
</span>    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">failed<span class="token punctuation">(</span></span>Exception <span class="token variable">$exception</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Send user notification of failure, etc...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="failed-job-events"></a>
    </p>
    <h3>Failed Job Events</h3>
    <p>If you would like to register an event that will be called when a job fails, you may use the <code class=" language-php"><span class="token scope">Queue<span class="token punctuation">::</span></span>failing</code> method. This event is a great opportunity to notify your team via email or <a href="https://www.hipchat.com">HipChat</a>. For example, we may attach a callback to this event from the <code class=" language-php">AppServiceProvider</code> that is included with Laravel:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Queue</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>JobFailed</span><span class="token punctuation">;</span>
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
        <span class="token scope">Queue<span class="token punctuation">::</span></span><span class="token function">failing<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span>JobFailed <span class="token variable">$event</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // $event-&gt;connectionName
</span>           <span class="token comment" spellcheck="true"> // $event-&gt;job
</span>           <span class="token comment" spellcheck="true"> // $event-&gt;exception
</span>        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
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
        <a name="retrying-failed-jobs"></a>
    </p>
    <h3>Retrying Failed Jobs</h3>
    <p>To view all of your failed jobs that have been inserted into your <code class=" language-php">failed_jobs</code> database table, you may use the <code class=" language-php">queue<span class="token punctuation">:</span>failed</code> Artisan command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>failed</code></pre>
    <p>The <code class=" language-php">queue<span class="token punctuation">:</span>failed</code> command will list the job ID, connection, queue, and failure time. The job ID may be used to retry the failed job. For instance, to retry a failed job that has an ID of <code class=" language-php"><span class="token number">5</span></code>, issue the following command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>retry <span class="token number">5</span></code></pre>
    <p>To retry all of your failed jobs, execute the <code class=" language-php">queue<span class="token punctuation">:</span>retry</code> command and pass <code class=" language-php">all</code> as the ID:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>retry all</code></pre>
    <p>If you would like to delete a failed job, you may use the <code class=" language-php">queue<span class="token punctuation">:</span>forget</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>forget <span class="token number">5</span></code></pre>
    <p>To delete all of your failed jobs, you may use the <code class=" language-php">queue<span class="token punctuation">:</span>flush</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan queue<span class="token punctuation">:</span>flush</code></pre>
    <p>
        <a name="job-events"></a>
    </p>
    <h2><a href="#job-events">Job Events</a></h2>
    <p>Using the <code class=" language-php">before</code> and <code class=" language-php">after</code> methods on the <code class=" language-php">Queue</code> <a href="/docs/5.3/facades">facade</a>, you may specify callbacks to be executed before or after a queued job is processed. These callbacks are a great opportunity to perform additional logging or increment statistics for a dashboard. Typically, you should call these methods from a <a href="/docs/5.3/providers">service provider</a>. For example, we may use the <code class=" language-php">AppServiceProvider</code> that is included with Laravel:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Queue</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>ServiceProvider</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>JobProcessed</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>JobProcessing</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AppServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Bootstrap any application services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Queue<span class="token punctuation">::</span></span><span class="token function">before<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span>JobProcessing <span class="token variable">$event</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // $event-&gt;connectionName
</span>           <span class="token comment" spellcheck="true"> // $event-&gt;job
</span>           <span class="token comment" spellcheck="true"> // $event-&gt;job-&gt;payload()
</span>        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token scope">Queue<span class="token punctuation">::</span></span><span class="token function">after<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span>JobProcessed <span class="token variable">$event</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
           <span class="token comment" spellcheck="true"> // $event-&gt;connectionName
</span>           <span class="token comment" spellcheck="true"> // $event-&gt;job
</span>           <span class="token comment" spellcheck="true"> // $event-&gt;job-&gt;payload()
</span>        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
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

<div>Nguồn: <a href="https://laravel.com/docs/5.3/queues">https://laravel.com/docs/5.3/queues</a></div>
</article>
@endsection