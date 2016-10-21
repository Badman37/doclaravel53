@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Event Broadcasting</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
            <ul>
                <li><a href="#configuration">Configuration</a>
                </li>
                <li><a href="#driver-prerequisites">Driver Prerequisites</a>
                </li>
            </ul>
        </li>
        <li><a href="#concept-overview">Concept Overview</a>
            <ul>
                <li><a href="#using-example-application">Using Example Application</a>
                </li>
            </ul>
        </li>
        <li><a href="#defining-broadcast-events">Defining Broadcast Events</a>
            <ul>
                <li><a href="#broadcast-name">Broadcast Name</a>
                </li>
                <li><a href="#broadcast-data">Broadcast Data</a>
                </li>
                <li><a href="#broadcast-queue">Broadcast Queue</a>
                </li>
            </ul>
        </li>
        <li><a href="#authorizing-channels">Authorizing Channels</a>
            <ul>
                <li><a href="#defining-authorization-routes">Defining Authorization Routes</a>
                </li>
                <li><a href="#defining-authorization-callbacks">Defining Authorization Callbacks</a>
                </li>
            </ul>
        </li>
        <li><a href="#broadcasting-events">Broadcasting Events</a>
            <ul>
                <li><a href="#only-to-others">Only To Others</a>
                </li>
            </ul>
        </li>
        <li><a href="#receiving-broadcasts">Receiving Broadcasts</a>
            <ul>
                <li><a href="#installing-laravel-echo">Installing Laravel Echo</a>
                </li>
                <li><a href="#listening-for-events">Listening For Events</a>
                </li>
                <li><a href="#leaving-a-channel">Leaving A Channel</a>
                </li>
                <li><a href="#namespaces">Namespaces</a>
                </li>
            </ul>
        </li>
        <li><a href="#presence-channels">Presence Channels</a>
            <ul>
                <li><a href="#authorizing-presence-channels">Authorizing Presence Channels</a>
                </li>
                <li><a href="#joining-presence-channels">Joining Presence Channels</a>
                </li>
                <li><a href="#broadcasting-to-presence-channels">Broadcasting To Presence Channels</a>
                </li>
            </ul>
        </li>
        <li><a href="#notifications">Notifications</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>In many modern web applications, WebSockets are used to implement realtime, live-updating user interfaces. When some data is updated on the server, a message is typically sent over a WebSocket connection to be handled by the client. This provides a more robust, efficient alternative to continually polling your application for changes.</p>
    <p>To assist you in building these types of applications, Laravel makes it easy to "broadcast" your <a href="/docs/5.3/events">events</a> over a WebSocket connection. Broadcasting your Laravel events allows you to share the same event names between your server-side code and your client-side JavaScript application.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Before diving into event broadcasting, make sure you have read all of the documentation regarding Laravel <a href="/docs/5.3/events">events and listeners</a>.</p>
    </blockquote>
    <p>
        <a name="configuration"></a>
    </p>
    <h3>Configuration</h3>
    <p>All of your application's event broadcasting configuration is stored in the <code class=" language-php">config<span class="token operator">/</span>broadcasting<span class="token punctuation">.</span>php</code> configuration file. Laravel supports several broadcast drivers out of the box: <a href="https://pusher.com">Pusher</a>, <a href="/docs/5.3/redis">Redis</a>, and a <code class=" language-php">log</code> driver for local development and debugging. Additionally, a <code class=" language-php"><span class="token keyword">null</span></code> driver is included which allows you to totally disable broadcasting. A configuration example is included for each of these drivers in the <code class=" language-php">config<span class="token operator">/</span>broadcasting<span class="token punctuation">.</span>php</code> configuration file.</p>
    <h4>Broadcast Service Provider</h4>
    <p>Before broadcasting any events, you will first need to register the <code class=" language-php">App\<span class="token package">Providers<span class="token punctuation">\</span>BroadcastServiceProvider</span></code>. In fresh Laravel applications, you only need to uncomment this provider in the <code class=" language-php">providers</code> array of your <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> configuration file. This provider will allow you to register the broadcast authorization routes and callbacks.</p>
    <h4>CSRF Token</h4>
    <p><a href="#installing-laravel-echo">Laravel Echo</a> will need access to the current session's CSRF token. If available, Echo will pull the token from the <code class=" language-php">Laravel<span class="token punctuation">.</span>csrfToken</code> JavaScript object. This object is defined in the <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>layouts<span class="token operator">/</span>app<span class="token punctuation">.</span>blade<span class="token punctuation">.</span>php</code> layout that is created if you run the <code class=" language-php">make<span class="token punctuation">:</span>auth</code> Artisan command. If you are not using this layout, you may define a <code class=" language-php">meta</code> tag in your application's <code class=" language-php">head</code> HTML element:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>meta</span> <span class="token attr-name">name</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>csrf-token<span class="token punctuation">"</span></span> <span class="token attr-name">content</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>{{ csrf_token() }}<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="driver-prerequisites"></a>
    </p>
    <h3>Driver Prerequisites</h3>
    <h4>Pusher</h4>
    <p>If you are broadcasting your events over <a href="https://pusher.com">Pusher</a>, you should install the Pusher PHP SDK using the Composer package manager:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> pusher<span class="token operator">/</span>pusher<span class="token operator">-</span>php<span class="token operator">-</span>server</code></pre>
    <p>Next, you should configure your Pusher credentials in the <code class=" language-php">config<span class="token operator">/</span>broadcasting<span class="token punctuation">.</span>php</code> configuration file. An example Pusher configuration is already included in this file, allowing you to quickly specify your Pusher key, secret, and application ID.</p>
    <p>When using Pusher and <a href="#installing-laravel-echo">Laravel Echo</a>, you should specify <code class=" language-php">pusher</code> as your desired broadcaster when instantiating an Echo instance:</p>
    <pre class=" language-php"><code class=" language-php">import <span class="token keyword">Echo</span> from <span class="token string">"laravel-echo"</span>

window<span class="token punctuation">.</span><span class="token keyword">Echo</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Echo</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    broadcaster<span class="token punctuation">:</span> <span class="token string">'pusher'</span><span class="token punctuation">,</span>
    key<span class="token punctuation">:</span> <span class="token string">'your-pusher-key'</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Redis</h4>
    <p>If you are using the Redis broadcaster, you should install the Predis library:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> predis<span class="token operator">/</span>predis</code></pre>
    <p>The Redis broadcaster will broadcast messages using Redis' pub / sub feature; however, you will need to pair this with a WebSocket server that can receive the messages from Redis and broadcast them to your WebSocket channels.</p>
    <p>When the Redis broadcaster publishes an event, it will be published on the event's specified channel names and the payload will be a JSON encoded string containing the event name, a <code class=" language-php">data</code> payload, and the user that generated the event's socket ID (if applicable).</p>
    <h4>Socket.IO</h4>
    <p>If you are going to pair the Redis broadcaster with a Socket.IO server, you will need to include the Socket.IO JavaScript client library in your application's <code class=" language-php">head</code> HTML element:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>script</span> <span class="token attr-name">src</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>https://cdn.socket.io/socket.io-1.4.5.js<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>script</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>Next, you will need to instantiate Echo with the <code class=" language-php">socket<span class="token punctuation">.</span>io</code> connector and a <code class=" language-php">host</code>. For example, if your application and socket server are running on the <code class=" language-php">app<span class="token punctuation">.</span>dev</code> domain you should instantiate Echo like so:</p>
    <pre class=" language-php"><code class=" language-php">import <span class="token keyword">Echo</span> from <span class="token string">"laravel-echo"</span>

window<span class="token punctuation">.</span><span class="token keyword">Echo</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Echo</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    broadcaster<span class="token punctuation">:</span> <span class="token string">'socket.io'</span><span class="token punctuation">,</span>
    host<span class="token punctuation">:</span> <span class="token string">'http://app.dev:6001'</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Finally, you will need to run a compatible Socket.IO server. Laravel does not include a Socket.IO server implementation; however, a community driven Socket.IO server is currently maintained at the <a href="https://github.com/tlaverdure/laravel-echo-server">tlaverdure/laravel-echo-server</a> GitHub repository.</p>
    <h4>Queue Prerequisites</h4>
    <p>Before broadcasting events, you will also need to configure and run a <a href="/docs/5.3/queues">queue listener</a>. All event broadcasting is done via queued jobs so that the response time of your application is not seriously affected.</p>
    <p>
        <a name="concept-overview"></a>
    </p>
    <h2><a href="#concept-overview">Concept Overview</a></h2>
    <p>Laravel's event broadcasting allows you to broadcast your server-side Laravel events to your client-side JavaScript application using a driver-based approach to WebSockets. Currently, Laravel ships with <a href="http://pusher.com">Pusher</a> and Redis drivers. The events may be easily consumed on the client-side using the <a href="#installing-laravel-echo">Laravel Echo</a> Javascript package.</p>
    <p>Events are broadcast over "channels", which may be specified as public or private. Any visitor to your application may subscribe to a public channel without any authentication or authorization; however, in order to subscribe to a private channel, a user must be authenticated and authorized to listen on that channel.</p>
    <p>
        <a name="using-example-application"></a>
    </p>
    <h3>Using Example Application</h3>
    <p>Before diving into each component of event broadcasting, let's take a high level overview using an e-commerce store as an example. We won't discuss the details of configuring <a href="http://pusher.com">Pusher</a> or <a href="#echo">Laravel Echo</a> since that will be discussed in detail in other sections of this documentation.</p>
    <p>In our application, let's assume we have a page that allows users to view the shipping status for their orders. Let's also assume that a <code class=" language-php">ShippingStatusUpdated</code> event is fired when a shipping status update is processed by the application:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">event<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">ShippingStatusUpdated</span><span class="token punctuation">(</span><span class="token variable">$update</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>The <code class=" language-php">ShouldBroadcast</code> Interface</h4>
    <p>When a user is viewing one of their orders, we don't want them to have to refresh the page to view status updates. Instead, we want to broadcast the updates to the application as they are created. So, we need to mark the <code class=" language-php">ShippingStatusUpdated</code> event with the <code class=" language-php">ShouldBroadcast</code> interface. This will instruct Laravel to broadcast the event when it is fired:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Events</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>Channel</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>SerializesModels</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>PrivateChannel</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>PresenceChannel</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>InteractsWithSockets</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>ShouldBroadcast</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ShippingStatusUpdated</span> <span class="token keyword">implements</span> <span class="token class-name">ShouldBroadcast</span>
<span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>The <code class=" language-php">ShouldBroadcast</code> interface requires our event to define a <code class=" language-php">broadcastOn</code> method. This method is responsible for returning the channels that the event should broadcast on. An empty stub of this method is already defined on generated event classes, so we only need to fill in its details. We only want the creator of the order to be able to view status updates, so we will broadcast the event on a private channel that is tied to the order:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the channels the event should broadcast on.
 *
 * @return array
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">broadcastOn<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">PrivateChannel</span><span class="token punctuation">(</span><span class="token string">'order.'</span><span class="token punctuation">.</span><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">update</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order_id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>Authorizing Channels</h4>
    <p>Remember, users must be authorized to listen on private channels. We may define our channel authorization rules in the <code class=" language-php">boot</code> method of the <code class=" language-php">BroadcastServiceProvider</code>. In this example, we need to verify that any user attempting to listen on the private <code class=" language-php">order<span class="token number">.1</span></code> channel is actually the creator of the order:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Broadcast<span class="token punctuation">::</span></span><span class="token function">channel<span class="token punctuation">(</span></span><span class="token string">'order.*'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token variable">$orderId</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token operator">===</span> <span class="token scope">Order<span class="token punctuation">::</span></span><span class="token function">findOrNew<span class="token punctuation">(</span></span><span class="token variable">$orderId</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">user_id</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">channel</code> method accepts two arguments: the name of the channel and a callback which returns <code class=" language-php"><span class="token boolean">true</span></code> or <code class=" language-php"><span class="token boolean">false</span></code> indicating whether the user is authorized to listen on the channel.</p>
    <p>All authorization callbacks receive the currently authenticated user as their first argument and any additional wildcard parameters as their subsequent arguments. In this example, we are using the <code class=" language-php"><span class="token operator">*</span></code> character to indicate that the "ID" portion of the channel name is a wildcard.</p>
    <h4>Listening For Event Broadcasts</h4>
    <p>Next, all that remains is to listen for the event in our JavaScript application. We can do this using Laravel Echo. First, we'll use the <code class=" language-php"><span class="token keyword">private</span></code> method to subscribe to the private channel. Then, we may use the <code class=" language-php">listen</code> method to listen for the <code class=" language-php">ShippingStatusUpdated</code> event. By default, all of the event's public properties will be included on the broadcast event:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token keyword">private</span><span class="token punctuation">(</span><span class="token string">'order.'</span> <span class="token operator">+</span> orderId<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">listen<span class="token punctuation">(</span></span><span class="token string">'ShippingStatusUpdated'</span><span class="token punctuation">,</span> <span class="token punctuation">(</span>e<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>e<span class="token punctuation">.</span>update<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="defining-broadcast-events"></a>
    </p>
    <h2><a href="#defining-broadcast-events">Defining Broadcast Events</a></h2>
    <p>To inform Laravel that a given event should be broadcast, implement the <code class=" language-php">Illuminate\<span class="token package">Contracts<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>ShouldBroadcast</span></code> interface on the event class. This interface is already imported into all event classes generated by the framework so you may easily add it to any of your events.</p>
    <p>The <code class=" language-php">ShouldBroadcast</code> interface requires you to implement a single method: <code class=" language-php">broadcastOn</code>. The <code class=" language-php">broadcastOn</code> method should return a channel or array of channels that the event should broadcast on. The channels should be instances of <code class=" language-php">Channel</code>, <code class=" language-php">PrivateChannel</code>, or <code class=" language-php">PresenceChannel</code>. Instances of <code class=" language-php">Channel</code> represent public channels that any user may subscribe to, while <code class=" language-php">PrivateChannels</code> and <code class=" language-php">PresenceChannels</code> represent private channels that require <a href="#authorizing-channels">channel authorization</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Events</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>Channel</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Queue<span class="token punctuation">\</span>SerializesModels</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>PrivateChannel</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>PresenceChannel</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>InteractsWithSockets</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Contracts<span class="token punctuation">\</span>Broadcasting<span class="token punctuation">\</span>ShouldBroadcast</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ServerCreated</span> <span class="token keyword">implements</span> <span class="token class-name">ShouldBroadcast</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">SerializesModels</span><span class="token punctuation">;</span>

    <span class="token keyword">public</span> <span class="token variable">$user</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Create a new event instance.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">__construct<span class="token punctuation">(</span></span>User <span class="token variable">$user</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">user</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token comment" spellcheck="true">/**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">broadcastOn<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">PrivateChannel</span><span class="token punctuation">(</span><span class="token string">'user.'</span><span class="token punctuation">.</span><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Then, you only need to <a href="/docs/5.3/events">fire the event</a> as you normally would. Once the event has been fired, a <a href="/docs/5.3/queues">queued job</a> will automatically broadcast the event over your specified broadcast driver.</p>
    <p>
        <a name="broadcast-name"></a>
    </p>
    <h3>Broadcast Name</h3>
    <p>By default, Laravel will broadcast the event using the event's class name. However, you may customize the broadcast name by defining a <code class=" language-php">broadcastAs</code> method on the event:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * The event's broadcast name.
 *
 * @return string
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">broadcastAs<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token string">'server.created'</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="broadcast-data"></a>
    </p>
    <h3>Broadcast Data</h3>
    <p>When an event is broadcast, all of its <code class=" language-php"><span class="token keyword">public</span></code> properties are automatically serialized and broadcast as the event's payload, allowing you to access any of its public data from your JavaScript application. So, for example, if your event has a single public <code class=" language-php"><span class="token variable">$user</span></code> property that contains an Eloquent model, the event's broadcast payload would be:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token punctuation">{</span>
    <span class="token string">"user"</span><span class="token punctuation">:</span> <span class="token punctuation">{</span>
        <span class="token string">"id"</span><span class="token punctuation">:</span> <span class="token number">1</span><span class="token punctuation">,</span>
        <span class="token string">"name"</span><span class="token punctuation">:</span> <span class="token string">"Patrick Stewart"</span>
        <span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>However, if you wish to have more fine-grained control over your broadcast payload, you may add a <code class=" language-php">broadcastWith</code> method to your event. This method should return the array of data that you wish to broadcast as the event payload:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the data to broadcast.
 *
 * @return array
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">broadcastWith<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="broadcast-queue"></a>
    </p>
    <h3>Broadcast Queue</h3>
    <p>By default, each broadcast event is placed on the default queue for the default queue connection specified in your <code class=" language-php">queue<span class="token punctuation">.</span>php</code> configuration file. You may customize the queue used by the broadcaster by defining a <code class=" language-php">broadcastQueue</code> property on your event class. This property should specify the name of the queue you wish to use when broadcasting:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * The name of the queue on which to place the event.
 *
 * @var string
 */</span>
<span class="token keyword">public</span> <span class="token variable">$broadcastQueue</span> <span class="token operator">=</span> <span class="token string">'your-queue-name'</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="authorizing-channels"></a>
    </p>
    <h2><a href="#authorizing-channels">Authorizing Channels</a></h2>
    <p>Private channels require you to authorize that the currently authenticated user can actually listen on the channel. This is accomplished by making an HTTP request to your Laravel application with the channel name and allowing your application to determine if the user can listen on that channel. When using <a href="#installing-laravel-echo">Laravel Echo</a>, the HTTP request to authorize subscriptions to private channels will be made automatically; however, you do need to define the proper routes to respond to these requests.</p>
    <p>
        <a name="defining-authorization-routes"></a>
    </p>
    <h3>Defining Authorization Routes</h3>
    <p>Thankfully, Laravel makes it easy to define the routes to respond to channel authorization requests. In the <code class=" language-php">BroadcastServiceProvider</code> included with your Laravel application, you will see a call to the <code class=" language-php"><span class="token scope">Broadcast<span class="token punctuation">::</span></span>routes</code> method. This method will register the <code class=" language-php"><span class="token operator">/</span>broadcasting<span class="token operator">/</span>auth</code> route to handle authorization requests:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Broadcast<span class="token punctuation">::</span></span><span class="token function">routes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php"><span class="token scope">Broadcast<span class="token punctuation">::</span></span>routes</code> method will automatically place its routes within the <code class=" language-php">web</code> middleware group; however, you may pass an array of route attributes to the method if you would like to customize the assigned attributes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Broadcast<span class="token punctuation">::</span></span><span class="token function">routes<span class="token punctuation">(</span></span><span class="token variable">$attributes</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="defining-authorization-callbacks"></a>
    </p>
    <h3>Defining Authorization Callbacks</h3>
    <p>Next, we need to define the logic that will actually perform the channel authorization. Like defining the authorization routes, this is also done in the <code class=" language-php">boot</code> method of the <code class=" language-php">BroadcastServiceProvider</code>. In this method, you may use the <code class=" language-php"><span class="token scope">Broadcast<span class="token punctuation">::</span></span>channel</code> method to register channel authorization callbacks:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Broadcast<span class="token punctuation">::</span></span><span class="token function">channel<span class="token punctuation">(</span></span><span class="token string">'order.*'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token variable">$orderId</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token operator">===</span> <span class="token scope">Order<span class="token punctuation">::</span></span><span class="token function">findOrNew<span class="token punctuation">(</span></span><span class="token variable">$orderId</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">user_id</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">channel</code> method accepts two arguments: the name of the channel and a callback which returns <code class=" language-php"><span class="token boolean">true</span></code> or <code class=" language-php"><span class="token boolean">false</span></code> indicating whether the user is authorized to listen on the channel.</p>
    <p>All authorization callbacks receive the currently authenticated user as their first argument and any additional wildcard parameters as their subsequent arguments. In this example, we are using the <code class=" language-php"><span class="token operator">*</span></code> character to indicate that the "ID" portion of the channel name is a wildcard.</p>
    <p>
        <a name="broadcasting-events"></a>
    </p>
    <h2><a href="#broadcasting-events">Broadcasting Events</a></h2>
    <p>Once you have defined an event and marked it with the <code class=" language-php">ShouldBroadcast</code> interface, you only need to fire the event using the <code class=" language-php">event</code> function. The event dispatcher will notice that the event is marked with the <code class=" language-php">ShouldBroadcast</code> interface and will queue the event for broadcasting:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">event<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">ShippingStatusUpdated</span><span class="token punctuation">(</span><span class="token variable">$update</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="only-to-others"></a>
    </p>
    <h3>Only To Others</h3>
    <p>When building an application that utilizes event broadcasting, you may substitute the <code class=" language-php">event</code> function with the <code class=" language-php">broadcast</code> function. Like the <code class=" language-php">event</code> function, the <code class=" language-php">broadcast</code> function dispatches the event to your server-side listeners:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">broadcast<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">ShippingStatusUpdated</span><span class="token punctuation">(</span><span class="token variable">$update</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>However, the <code class=" language-php">broadcast</code> function also exposes the <code class=" language-php">toOthers</code> method which allows you to exclude the current user from the broadcast's recipients:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">broadcast<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">ShippingStatusUpdated</span><span class="token punctuation">(</span><span class="token variable">$update</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toOthers<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>To better understand when you may want to use the <code class=" language-php">toOthers</code> method, let's imagine a task list application where a user may create a new task by entering a task name. To create a task, your application might make a request to a <code class=" language-php"><span class="token operator">/</span>task</code> end-point which broadcasts the task's creation and returns a JSON representation of the new task. When your JavaScript application receives the response from the end-point, it might directly insert the new task into its task list like so:</p>
    <pre class=" language-php"><code class=" language-php">this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'/task'</span><span class="token punctuation">,</span> task<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span><span class="token punctuation">(</span>response<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        this<span class="token punctuation">.</span>tasks<span class="token punctuation">.</span><span class="token function">push<span class="token punctuation">(</span></span>response<span class="token punctuation">.</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>However, remember that we also broadcast the task's creation. If your JavaScript application is listening for this event in order to add tasks to the task list, you will have duplicate tasks in your list: one from the end-point and one from the broadcast.</p>
    <p>You may solve this by using the <code class=" language-php">toOthers</code> method to instruct the broadcaster to not broadcast the event to the current user.</p>
    <h4>Configuration</h4>
    <p>When you initialize a Laravel Echo instance, a socket ID is assigned to the connection. If you are using <a href="https://vuejs.org">Vue</a> and Vue Resource, the socket ID will automatically be attached to every outgoing request as a <code class=" language-php">X<span class="token operator">-</span>Socket<span class="token operator">-</span><span class="token constant">ID</span></code> header. Then, when you call the <code class=" language-php">toOthers</code> method, Laravel will extract the socket ID from the header and instruct the broadcaster to not broadcast to any connections with that socket ID.</p>
    <p>If you are not using Vue and Vue Resource, you will need to manually configure your JavaScript application to send the <code class=" language-php">X<span class="token operator">-</span>Socket<span class="token operator">-</span><span class="token constant">ID</span></code> header. You may retrieve the socket ID using the <code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span>socketId</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">var</span> socketId <span class="token operator">=</span> <span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token function">socketId<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="receiving-broadcasts"></a>
    </p>
    <h2><a href="#receiving-broadcasts">Receiving Broadcasts</a></h2>
    <p>
        <a name="installing-laravel-echo"></a>
    </p>
    <h3>Installing Laravel Echo</h3>
    <p>Laravel Echo is a JavaScript library that makes it painless to subscribe to channels and listen for events broadcast by Laravel. You may install Echo via the NPM package manager. In this example, we will also install the <code class=" language-php">pusher<span class="token operator">-</span>js</code> package since we will be using the Pusher broadcaster:</p>
    <pre class=" language-php"><code class=" language-php">npm install <span class="token operator">--</span>save laravel<span class="token operator">-</span><span class="token keyword">echo</span> pusher<span class="token operator">-</span>js</code></pre>
    <p>Once Echo is installed, you are ready to create a fresh Echo instance in your application's JavaScript. A great place to do this is at the bottom of the <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js<span class="token operator">/</span>bootstrap<span class="token punctuation">.</span>js</code> file that is included with the Laravel framework:</p>
    <pre class=" language-php"><code class=" language-php">import <span class="token keyword">Echo</span> from <span class="token string">"laravel-echo"</span>

window<span class="token punctuation">.</span><span class="token keyword">Echo</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Echo</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    broadcaster<span class="token punctuation">:</span> <span class="token string">'pusher'</span><span class="token punctuation">,</span>
    key<span class="token punctuation">:</span> <span class="token string">'your-pusher-key'</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>When creating an Echo instance that uses the <code class=" language-php">pusher</code> connector, you may also specify a <code class=" language-php">cluster</code> as well as whether the connection should be encrypted:</p>
    <pre class=" language-php"><code class=" language-php">window<span class="token punctuation">.</span><span class="token keyword">Echo</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Echo</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    broadcaster<span class="token punctuation">:</span> <span class="token string">'pusher'</span><span class="token punctuation">,</span>
    key<span class="token punctuation">:</span> <span class="token string">'your-pusher-key'</span><span class="token punctuation">,</span>
    cluster<span class="token punctuation">:</span> <span class="token string">'eu'</span><span class="token punctuation">,</span>
    encrypted<span class="token punctuation">:</span> <span class="token boolean">true</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="listening-for-events"></a>
    </p>
    <h3>Listening For Events</h3>
    <p>Once you have installed and instantiated Echo, you are ready to start listening for event broadcasts. First, use the <code class=" language-php">channel</code> method to retrieve an instance of a channel, then call the <code class=" language-php">listen</code> method to listen for a specified event:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token function">channel<span class="token punctuation">(</span></span><span class="token string">'orders'</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">listen<span class="token punctuation">(</span></span><span class="token string">'OrderShipped'</span><span class="token punctuation">,</span> <span class="token punctuation">(</span>e<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>e<span class="token punctuation">.</span>order<span class="token punctuation">.</span>name<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you would like to listen for events on a private channel, use the <code class=" language-php"><span class="token keyword">private</span></code> method instead. You may continue to chain calls to the <code class=" language-php">listen</code> method to listen for multiple events on a single channel:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token keyword">private</span><span class="token punctuation">(</span><span class="token string">'orders'</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">listen<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">listen<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">listen<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="leaving-a-channel"></a>
    </p>
    <h3>Leaving A Channel</h3>
    <p>To leave a channel, you may call the <code class=" language-php">leave</code> method on your Echo instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token function">leave<span class="token punctuation">(</span></span><span class="token string">'orders'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="namespaces"></a>
    </p>
    <h3>Namespaces</h3>
    <p>You may have noticed in the examples above that we did not specify the full namespace for the event classes. This is because Echo will automatically assume the events are located in the <code class=" language-php">App\<span class="token package">Events</span></code> namespace. However, you may configure the root namespace when you instantiate Echo by passing a <code class=" language-php"><span class="token keyword">namespace</span></code> configuration option:</p>
    <pre class=" language-php"><code class=" language-php">window<span class="token punctuation">.</span><span class="token keyword">Echo</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Echo</span><span class="token punctuation">(</span><span class="token punctuation">{</span>
    broadcaster<span class="token punctuation">:</span> <span class="token string">'pusher'</span><span class="token punctuation">,</span>
    key<span class="token punctuation">:</span> <span class="token string">'your-pusher-key'</span><span class="token punctuation">,</span>
    <span class="token keyword">namespace</span><span class="token punctuation">:</span> <span class="token string">'App.Other.Namespace'</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Alternatively, you may prefix event classes with a <code class=" language-php"><span class="token punctuation">.</span></code> when subscribing to them using Echo. This will allow you to always specify the fully-qualified class name:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token function">channel<span class="token punctuation">(</span></span><span class="token string">'orders'</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">listen<span class="token punctuation">(</span></span><span class="token string">'.Namespace.Event.Class'</span><span class="token punctuation">,</span> <span class="token punctuation">(</span>e<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="presence-channels"></a>
    </p>
    <h2><a href="#presence-channels">Presence Channels</a></h2>
    <p>Presence channels build on the security of private channels while exposing the additional feature of awareness of who is subscribed to the channel. This makes it easy to build powerful, collaborative application features such as notifying users when another user is viewing the same page.</p>
    <p>
        <a name="joining-a-presence-channel"></a>
    </p>
    <h3>Authorizing Presence Channels</h3>
    <p>All presence channels are also private channels; therefore, users must be <a href="#authorizing-channels">authorized to access them</a>. However, when defining authorization callbacks for presence channels, you will not return <code class=" language-php"><span class="token boolean">true</span></code> if the user is authorized to join the channel. Instead, you should return an array of data about the user.</p>
    <p>The data returned by the authorization callback will be made available to the presence channel event listeners in your JavaScript application. If the user is not authorized to join the presence channel, you should return <code class=" language-php"><span class="token boolean">false</span></code> or <code class=" language-php"><span class="token keyword">null</span></code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Broadcast<span class="token punctuation">::</span></span><span class="token function">channel<span class="token punctuation">(</span></span><span class="token string">'chat.*'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token variable">$roomId</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">canJoinRoom<span class="token punctuation">(</span></span><span class="token variable">$roomId</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span><span class="token string">'id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">,</span> <span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="joining-presence-channels"></a>
    </p>
    <h3>Joining Presence Channels</h3>
    <p>To join a presence channel, you may use Echo's <code class=" language-php">join</code> method. The <code class=" language-php">join</code> method will return a <code class=" language-php">PresenceChannel</code> implementation which, along with exposing the <code class=" language-php">listen</code> method, allows you to subscribe to the <code class=" language-php">here</code>, <code class=" language-php">joining</code>, and <code class=" language-php">leaving</code> events.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token function">join<span class="token punctuation">(</span></span><span class="token string">'chat.'</span> <span class="token operator">+</span> roomId<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">here<span class="token punctuation">(</span></span><span class="token punctuation">(</span>users<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">joining<span class="token punctuation">(</span></span><span class="token punctuation">(</span>user<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>user<span class="token punctuation">.</span>name<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">leaving<span class="token punctuation">(</span></span><span class="token punctuation">(</span>user<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>user<span class="token punctuation">.</span>name<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">here</code> callback will be executed immediately once the channel is joined successfully, and will receive an array containing the user information for all of the other users currently subscribed to the channel. The <code class=" language-php">joining</code> method will be executed when a new user joins a channel, while the <code class=" language-php">leaving</code> method will be executed when a user leaves the channel.</p>
    <p>
        <a name="broadcasting-to-presence-channels"></a>
    </p>
    <h3>Broadcasting To Presence Channels</h3>
    <p>Presence channels may receive events just like public or private channels. Using the example of a chatroom, we may want to broadcast <code class=" language-php">NewMessage</code> events to the room's presence channel. To do so, we'll return an instance of <code class=" language-php">PresenceChannel</code> from the event's <code class=" language-php">broadcastOn</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">/**
 * Get the channels the event should broadcast on.
 *
 * @return Channel|array
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">broadcastOn<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">PresenceChannel</span><span class="token punctuation">(</span><span class="token string">'room.'</span><span class="token punctuation">.</span><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">message</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">room_id</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Like public or private events, presence channel events may be broadcast using the <code class=" language-php">broadcast</code> function. As with other events, you may use the <code class=" language-php">toOthers</code> method to exclude the current user from receiving the broadcast:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token function">broadcast<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">NewMessage</span><span class="token punctuation">(</span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">broadcast<span class="token punctuation">(</span></span><span class="token keyword">new</span> <span class="token class-name">NewMessage</span><span class="token punctuation">(</span><span class="token variable">$message</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toOthers<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>You may listen for the join event via Echo's <code class=" language-php">listen</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token function">join<span class="token punctuation">(</span></span><span class="token string">'chat.'</span> <span class="token operator">+</span> roomId<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">here<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">joining<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">leaving<span class="token punctuation">(</span></span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">.</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">listen<span class="token punctuation">(</span></span><span class="token string">'NewMessage'</span><span class="token punctuation">,</span> <span class="token punctuation">(</span>e<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="notifications"></a>
    </p>
    <h2><a href="#notifications">Notifications</a></h2>
    <p>By pairing event broadcasting with <a href="/docs/5.3/notifications">notifications</a>, your JavaScript application may receive new notifications as they occur without needing to refresh the page. First, be sure to read over the documentation on using <a href="/docs/5.3/notifications#broadcast-notifications">the broadcast notification channel</a>.</p>
    <p>Once you have configured a notification to use the broadcast channel, you may listen for the broadcast events using Echo's <code class=" language-php">notification</code> method. Remember, the channel name should match the class name of the entity receiving the notifications:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">Echo</span><span class="token punctuation">.</span><span class="token keyword">private</span><span class="token punctuation">(</span><span class="token string">'App.User.'</span> <span class="token operator">+</span> userId<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">notification<span class="token punctuation">(</span></span><span class="token punctuation">(</span>notification<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>notification<span class="token punctuation">.</span>type<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>In this example, all notifications sent to <code class=" language-php">App\<span class="token package">User</span></code> instances via the <code class=" language-php">broadcast</code> channel would be received by the callback. A channel authorization callback for the <code class=" language-php">App<span class="token punctuation">.</span>User<span class="token punctuation">.</span><span class="token operator">*</span></code> channel is included in the default <code class=" language-php">BroadcastServiceProvider</code> that ships with the Laravel framework.</p>
    <div>Nguồn: <a href="https://laravel.com/docs/5.3/broadcasting">https://laravel.com/docs/5.3/broadcasting</a></div>
</article>
@endsection