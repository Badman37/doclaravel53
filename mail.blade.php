@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Mail</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
            <ul>
                <li><a href="#driver-prerequisites">Driver Prerequisites</a>
                </li>
            </ul>
        </li>
        <li><a href="#generating-mailables">Generating Mailables</a>
        </li>
        <li><a href="#writing-mailables">Writing Mailables</a>
            <ul>
                <li><a href="#configuring-the-sender">Configuring The Sender</a>
                </li>
                <li><a href="#configuring-the-view">Configuring The View</a>
                </li>
                <li><a href="#view-data">View Data</a>
                </li>
                <li><a href="#attachments">Attachments</a>
                </li>
                <li><a href="#inline-attachments">Inline Attachments</a>
                </li>
            </ul>
        </li>
        <li><a href="#sending-mail">Sending Mail</a>
            <ul>
                <li><a href="#queueing-mail">Queueing Mail</a>
                </li>
            </ul>
        </li>
        <li><a href="#mail-and-local-development">Mail &amp; Local Development</a>
        </li>
        <li><a href="#events">Events</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel provides a clean, simple API over the popular <a href="http://swiftmailer.org">SwiftMailer</a> library with drivers for SMTP, Mailgun, SparkPost, Amazon SES, PHP's <code class=" language-php">mail</code> function, and <code class=" language-php">sendmail</code>, allowing you to quickly get started sending mail through a local or cloud based service of your choice.</p>
    <p>
        <a name="driver-prerequisites"></a>
    </p>
    <h3>Driver Prerequisites</h3>
    <p>The API based drivers such as Mailgun and SparkPost are often simpler and faster than SMTP servers. If possible, you should use one of these drivers. All of the API drivers require the Guzzle HTTP library, which may be installed via the Composer package manager:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> guzzlehttp<span class="token operator">/</span>guzzle</code></pre>
    <h4>Mailgun Driver</h4>
    <p>To use the Mailgun driver, first install Guzzle, then set the <code class=" language-php">driver</code> option in your <code class=" language-php">config<span class="token operator">/</span>mail<span class="token punctuation">.</span>php</code> configuration file to <code class=" language-php">mailgun</code>. Next, verify that your <code class=" language-php">config<span class="token operator">/</span>services<span class="token punctuation">.</span>php</code> configuration file contains the following options:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'mailgun'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'domain'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'your-mailgun-domain'</span><span class="token punctuation">,</span>
    <span class="token string">'secret'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'your-mailgun-key'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <h4>SparkPost Driver</h4>
    <p>To use the SparkPost driver, first install Guzzle, then set the <code class=" language-php">driver</code> option in your <code class=" language-php">config<span class="token operator">/</span>mail<span class="token punctuation">.</span>php</code> configuration file to <code class=" language-php">sparkpost</code>. Next, verify that your <code class=" language-php">config<span class="token operator">/</span>services<span class="token punctuation">.</span>php</code> configuration file contains the following options:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'sparkpost'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'secret'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'your-sparkpost-key'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <h4>SES Driver</h4>
    <p>To use the Amazon SES driver you must first install the Amazon AWS SDK for PHP. You may install this library by adding the following line to your <code class=" language-php">composer<span class="token punctuation">.</span>json</code> file's <code class=" language-php"><span class="token keyword">require</span></code> section and running the <code class=" language-php">composer update</code> command:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">"aws/aws-sdk-php"</span><span class="token punctuation">:</span> <span class="token string">"~3.0"</span></code></pre>
    <p>Next, set the <code class=" language-php">driver</code> option in your <code class=" language-php">config<span class="token operator">/</span>mail<span class="token punctuation">.</span>php</code> configuration file to <code class=" language-php">ses</code> and verify that your <code class=" language-php">config<span class="token operator">/</span>services<span class="token punctuation">.</span>php</code> configuration file contains the following options:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'ses'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'your-ses-key'</span><span class="token punctuation">,</span>
    <span class="token string">'secret'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'your-ses-secret'</span><span class="token punctuation">,</span>
    <span class="token string">'region'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'ses-region'</span><span class="token punctuation">,</span> <span class="token comment" spellcheck="true"> // e.g. us-east-1
</span><span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="generating-mailables"></a>
    </p>
    <h2><a href="#generating-mailables">Generating Mailables</a></h2>
    <p>In Laravel, each type of email sent by your application is represented as a "mailable" class. These classes are stored in the <code class=" language-php">app<span class="token operator">/</span>Mail</code> directory. Don't worry if you don't see this directory in your application, since it will be generated for you when you create your first mailable class using the <code class=" language-php">make<span class="token punctuation">:</span>mail</code> command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan make<span class="token punctuation">:</span>mail OrderShipped</code></pre>
    <p>
        <a name="writing-mailables"></a>
    </p>
    <h2><a href="#writing-mailables">Writing Mailables</a></h2>
    <p>All of a mailable class' configuration is done in the <code class=" language-php">build</code> method. Within this method, you may call various methods such as <code class=" language-php">from</code>, <code class=" language-php">subject</code>, <code class=" language-php">view</code>, and <code class=" language-php">attach</code> to configure the email's presentation and delivery.</p>
    <p>
        <a name="configuring-the-sender"></a>
    </p>
    <h3>Configuring The Sender</h3>
    <h4>Using The <code class=" language-php">from</code> Method</h4>
    <p>First, let's explore configuring the sender of the email. Or, in other words, who the email is going to be "from". There are two ways to configure the sender. First, you may use the <code class=" language-php">from</code> method within your mailable class' <code class=" language-php">build</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Build the message.
 *
 * @return $this
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">build<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">from<span class="token punctuation">(</span></span><span class="token string">'example@example.com'</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Using A Global <code class=" language-php">from</code> Address</h4>
    <p>However, if your application uses the same "from" address for all of its emails, it can become cumbersome to call the <code class=" language-php">from</code> method in each mailable class you generate. Instead, you may specify a global "from" address in your <code class=" language-php">config<span class="token operator">/</span>mail<span class="token punctuation">.</span>php</code> configuration file. This address will be used if no other "from" address is specified within the mailable class:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'from'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span><span class="token string">'address'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'example@example.com'</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'App Name'</span><span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="configuring-the-view"></a>
    </p>
    <h3>Configuring The View</h3>
    <p>Within a mailable class' <code class=" language-php">build</code> method, you may use the <code class=" language-php">view</code> method to specify which template should be used when rendering the email's contents. Since each email typically uses a <a href="/docs/5.3/blade">Blade template</a> to render its contents, you have the full power and convenience of the Blade templating engine when building your email's HTML:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Build the message.
 *
 * @return $this
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">build<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> You may wish to create a <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>emails</code> directory to house all of your email templates; however, you are free to place them wherever you wish within your <code class=" language-php">resources<span class="token operator">/</span>views</code> directory.</p>
    </blockquote>
    <h4>Plain Text Emails</h4>
    <p>If you would like to define a plain-text version of your email, you may use the <code class=" language-php">text</code> method. Like the <code class=" language-php">view</code> method, the <code class=" language-php">text</code> method accepts a template name which will be used to render the contents of the email. You are free to define both a HTML and plain-text version of your message:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Build the message.
 *
 * @return $this
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">build<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped'</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">text<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped_plain'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="view-data"></a>
    </p>
    <h3>View Data</h3>
    <h4>Via Public Properties</h4>
    <p>Typically, you will want to pass some data to your view that you can utilize when rendering the email's HTML. There are two ways you may make data available to your view. First, any public property defined on your mailable class will automatically be made available to the view. So, for example, you may pass data into your mailable class' constructor and set that data to public properties defined on the class:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Mail</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Order</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Bus<span class="token punctuation">\</span>Queueable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Mail<span class="token punctuation">\</span>Mailable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>SerializesModels</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">OrderShipped</span> <span class="token keyword">extends</span> <span class="token class-name">Mailable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">Queueable</span><span class="token punctuation">,</span> SerializesModels<span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * The order instance.
     *
     * @var Order
     */</span>
    <span class="token keyword">public</span> <span class="token variable">$order</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new message instance.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>Order <span class="token variable">$order</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order</span> <span class="token operator">=</span> <span class="token variable">$order</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Build the message.
     *
     * @return $this
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">build<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once the data has been set to a public property, it will automatically be available in your view, so you may access it like you would access any other data in your Blade templates:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span><span class="token punctuation">&gt;</span></span></span>
    Price<span class="token punctuation">:</span> <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">price</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <h4>Via The <code class=" language-php">with</code> Method:</h4>
    <p>If you would like to customize the format of your email's data before it is sent to the template, you may manually pass your data to the view via the <code class=" language-php">with</code> method. Typically, you will still pass data via the mailable class' constructor; however, you should set this data to <code class=" language-php"><span class="token keyword">protected</span></code> or <code class=" language-php"><span class="token keyword">private</span></code> properties so the data is not automatically made available to the template. Then, when calling the <code class=" language-php">with</code> method, pass an array of data that you wish to make available to the template:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Mail</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Order</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Bus<span class="token punctuation">\</span>Queueable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Mail<span class="token punctuation">\</span>Mailable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>SerializesModels</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">OrderShipped</span> <span class="token keyword">extends</span> <span class="token class-name">Mailable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">Queueable</span><span class="token punctuation">,</span> SerializesModels<span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * The order instance.
     *
     * @var Order
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$order</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new message instance.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>Order <span class="token variable">$order</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order</span> <span class="token operator">=</span> <span class="token variable">$order</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Build the message.
     *
     * @return $this
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">build<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped'</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">with<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
                        <span class="token string">'orderName'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">,</span>
                        <span class="token string">'orderPrice'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">price</span><span class="token punctuation">,</span>
                    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Once the data has been passed to the <code class=" language-php">with</code> method, it will automatically be available in your view, so you may access it like you would access any other data in your Blade templates:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span><span class="token punctuation">&gt;</span></span></span>
    Price<span class="token punctuation">:</span> <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$orderPrice</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="attachments"></a>
    </p>
    <h3>Attachments</h3>
    <p>To add attachments to an email, use the <code class=" language-php">attach</code> method within the mailable class' <code class=" language-php">build</code> method. The <code class=" language-php">attach</code> method accepts the full path to the file as its first argument:</p>
    <pre class=" language-php"><code class=" language-php">    <span class="token comment" spellcheck="true">/**
     * Build the message.
     *
     * @return $this
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">build<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped'</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach<span class="token punctuation">(</span></span><span class="token string">'/path/to/file'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span></code></pre>
    <p>When attaching files to a message, you may also specify the display name and / or MIME type by passing an <code class=" language-php"><span class="token keyword">array</span></code> as the second argument to the <code class=" language-php">attach</code> method:</p>
    <pre class=" language-php"><code class=" language-php">    <span class="token comment" spellcheck="true">/**
     * Build the message.
     *
     * @return $this
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">build<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped'</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach<span class="token punctuation">(</span></span><span class="token string">'/path/to/file'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
                        <span class="token string">'as'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'name.pdf'</span><span class="token punctuation">,</span>
                        <span class="token string">'mime'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'application/pdf'</span><span class="token punctuation">,</span>
                    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span></code></pre>
    <h4>Raw Data Attachments</h4>
    <p>The <code class=" language-php">attachData</code> method may be used to attach a raw string of bytes as an attachment. For example, you might use this method if you have generated a PDF in memory and want to attach it to the email without writing it to disk. The <code class=" language-php">attachData</code> method accepts the raw data bytes as its first argument, the name of the file as its second argument, and an array of options as its third argument:</p>
    <pre class=" language-php"><code class=" language-php">    <span class="token comment" spellcheck="true">/**
     * Build the message.
     *
     * @return $this
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">build<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">view<span class="token punctuation">(</span></span><span class="token string">'emails.orders.shipped'</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attachData<span class="token punctuation">(</span></span><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">pdf</span><span class="token punctuation">,</span> <span class="token string">'name.pdf'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
                        <span class="token string">'mime'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'application/pdf'</span><span class="token punctuation">,</span>
                    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span></code></pre>
    <p>
        <a name="inline-attachments"></a>
    </p>
    <h3>Inline Attachments</h3>
    <p>Embedding inline images into your emails is typically cumbersome; however, Laravel provides a convenient way to attach images to your emails and retrieving the appropriate CID. To embed an inline image, use the <code class=" language-php">embed</code> method on the <code class=" language-php"><span class="token variable">$message</span></code> variable within your email template. Laravel automatically makes the <code class=" language-php"><span class="token variable">$message</span></code> variable available to all of your email templates, so you don't need to worry about passing it in manually:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>body</span><span class="token punctuation">&gt;</span></span></span>
    Here is an image<span class="token punctuation">:</span>

    <span class="token markup">&lt;img src="{{ $message-&gt;</span><span class="token function">embed<span class="token punctuation">(</span></span><span class="token variable">$pathToFile</span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>"<span class="token operator">&gt;</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>body</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <h4>Embedding Raw Data Attachments</h4>
    <p>If you already have a raw data string you wish to embed into an email template, you may use the <code class=" language-php">embedData</code> method on the <code class=" language-php"><span class="token variable">$message</span></code> variable:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>body</span><span class="token punctuation">&gt;</span></span></span>
    Here is an image from raw data<span class="token punctuation">:</span>

    <span class="token markup">&lt;img src="{{ $message-&gt;</span><span class="token function">embedData<span class="token punctuation">(</span></span><span class="token variable">$data</span><span class="token punctuation">,</span> <span class="token variable">$name</span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>"<span class="token operator">&gt;</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>body</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="sending-mail"></a>
    </p>
    <h2><a href="#sending-mail">Sending Mail</a></h2>
    <p>To send a message, use the <code class=" language-php">to</code> method on the <code class=" language-php">Mail</code> <a href="/docs/5.3/facades">facade</a>. The <code class=" language-php">to</code> method accepts an email address, a user instance, or a collection of users. If you pass an object or collection of objects, the mailer will automatically use their <code class=" language-php">email</code> and <code class=" language-php">name</code> properties when setting the email recipients, so make sure these attributes are available on your objects. Once you have specified your recipients, you may pass an instance of your mailable class to the <code class=" language-php">send</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Order</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Mail<span class="token punctuation">\</span>OrderShipped</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Mail</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>Controller</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">OrderController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Ship the given order.
     *
     * @param  Request  $request
     * @param  int  $orderId
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">ship<span class="token punctuation">(</span></span>Request <span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$orderId</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$order</span> <span class="token operator">=</span> <span class="token scope">Order<span class="token punctuation">::</span></span><span class="token function">findOrFail<span class="token punctuation">(</span></span><span class="token variable">$orderId</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Ship order...
</span>
        <span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">to<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">send<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">OrderShipped</span><span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Of course, you are not limited to just specifying the "to" recipients when sending a message. You are free to set "to", "cc", and "bcc" recipients all within a single, chained method call:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">to<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cc<span class="token punctuation">(</span></span><span class="token variable">$moreUsers</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bcc<span class="token punctuation">(</span></span><span class="token variable">$evenMoreUsers</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">send<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">OrderShipped</span><span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="queueing-mail"></a>
    </p>
    <h3>Queueing Mail</h3>
    <h4>Queueing A Mail Message</h4>
    <p>Since sending email messages can drastically lengthen the response time of your application, many developers choose to queue email messages for background sending. Laravel makes this easy using its built-in <a href="/docs/5.3/queues">unified queue API</a>. To queue a mail message, use the <code class=" language-php">queue</code> method on the <code class=" language-php">Mail</code> facade after specifying the message's recipients:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">to<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cc<span class="token punctuation">(</span></span><span class="token variable">$moreUsers</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bcc<span class="token punctuation">(</span></span><span class="token variable">$evenMoreUsers</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">queue<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">OrderShipped</span><span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>This method will automatically take care of pushing a job onto the queue so the message is sent in the background. Of course, you will need to <a href="/docs/5.3/queues">configure your queues</a> before using this feature.</p>
    <h4>Delayed Message Queueing</h4>
    <p>If you wish to delay the delivery of a queued email message, you may use the <code class=" language-php">later</code> method. As its first argument, the <code class=" language-php">later</code> method accepts a <code class=" language-php">DateTime</code> instance indicating when the message should be sent:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$when</span> <span class="token operator">=</span> <span class="token scope">Carbon<span class="token punctuation">\</span>Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">addMinutes<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">to<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cc<span class="token punctuation">(</span></span><span class="token variable">$moreUsers</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bcc<span class="token punctuation">(</span></span><span class="token variable">$evenMoreUsers</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">later<span class="token punctuation">(</span></span><span class="token variable">$when</span><span class="token punctuation">,</span> <span class="token keyword">new</span> <span class="token class-name">OrderShipped</span><span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Pushing To Specific Queues</h4>
    <p>Since all mailable classes generated using the <code class=" language-php">make<span class="token punctuation">:</span>mail</code> command make use of the <code class=" language-php">Illuminate\<span class="token package">Bus<span class="token punctuation">\</span>Queueable</span></code> trait, you may call the <code class=" language-php">onQueue</code> and <code class=" language-php">onConnection</code> methods on any mailable class instance, allowing you to specify the connection and queue name for the message:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$message</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">OrderShipped</span><span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onConnection<span class="token punctuation">(</span></span><span class="token string">'sqs'</span><span class="token punctuation">)</span>
                <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onQueue<span class="token punctuation">(</span></span><span class="token string">'emails'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">to<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cc<span class="token punctuation">(</span></span><span class="token variable">$moreUsers</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">bcc<span class="token punctuation">(</span></span><span class="token variable">$evenMoreUsers</span><span class="token punctuation">)</span>
    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">queue<span class="token punctuation">(</span></span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Queueing By Default</h4>
    <p>If you have mailable classes that you want to always be queued, you may implement the <code class=" language-php">ShouldQueue</code> contract on the class. Now, even if you call the <code class=" language-php">send</code> method when mailing, the mailable will still be queued since it implements the contract:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>ShouldQueue</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">OrderShipped</span> <span class="token keyword">extends</span> <span class="token class-name">Mailable</span> <span class="token keyword">implements</span> <span class="token class-name">ShouldQueue</span>
<span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="mail-and-local-development"></a>
    </p>
    <h2><a href="#mail-and-local-development">Mail &amp; Local Development</a></h2>
    <p>When developing an application that sends email, you probably don't want to actually send emails to live email addresses. Laravel provides several ways to "disable" the actual sending of emails during local development.</p>
    <h4>Log Driver</h4>
    <p>Instead of sending your emails, the <code class=" language-php">log</code> mail driver will write all email messages to your log files for inspection. For more information on configuring your application per environment, check out the <a href="/docs/5.3/installation#environment-configuration">configuration documentation</a>.</p>
    <h4>Universal To</h4>
    <p>Another solution provided by Laravel is to set a universal recipient of all emails sent by the framework. This way, all the emails generated by your application will be sent to a specific address, instead of the address actually specified when sending the message. This can be done via the <code class=" language-php">to</code> option in your <code class=" language-php">config<span class="token operator">/</span>mail<span class="token punctuation">.</span>php</code> configuration file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'to'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'address'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'example@example.com'</span><span class="token punctuation">,</span>
    <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Example'</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <h4>Mailtrap</h4>
    <p>Finally, you may use a service like <a href="https://mailtrap.io">Mailtrap</a> and the <code class=" language-php">smtp</code> driver to send your email messages to a "dummy" mailbox where you may view them in a true email client. This approach has the benefit of allowing you to actually inspect the final emails in Mailtrap's message viewer.</p>
    <p>
        <a name="events"></a>
    </p>
    <h2><a href="#events">Events</a></h2>
    <p>Laravel fires an event just before sending mail messages. Remember, this event is fired when the mail is <em>sent</em>, not when it is queued. You may register an event listener for this event in your <code class=" language-php">EventServiceProvider</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * The event listener mappings for the application.
 *
 * @var array
 */</span>
<span class="token keyword">protected</span> <span class="token variable">$listen</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'Illuminate\Mail\Events\MessageSending'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Listeners\LogSentMessage'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>

  <div>Nguồn: <a href="https://laravel.com/docs/5.3/mail">https://laravel.com/docs/5.3/mail</a></div>
</article>
@endsection