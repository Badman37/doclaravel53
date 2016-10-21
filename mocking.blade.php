@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Mocking</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#mocking-events">Events</a>
            <ul>
                <li><a href="#using-event-mocks">Using Mocks</a>
                </li>
                <li><a href="#using-event-fakes">Using Fakes</a>
                </li>
            </ul>
        </li>
        <li><a href="#mocking-jobs">Jobs</a>
            <ul>
                <li><a href="#using-job-mocks">Using Mocks</a>
                </li>
                <li><a href="#using-job-fakes">Using Fakes</a>
                </li>
            </ul>
        </li>
        <li><a href="#mail-fakes">Mail Fakes</a>
        </li>
        <li><a href="#notification-fakes">Notification Fakes</a>
        </li>
        <li><a href="#mocking-facades">Facades</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>When testing Laravel applications, you may wish to "mock" certain aspects of your application so they are not actually executed during a given test. For example, when testing a controller that fires an event, you may wish to mock the event listeners so they are not actually executed during the test. This allows you to only test the controller's HTTP response without worrying about the execution of the event listeners, since the event listeners can be tested in their own test case.</p>
    <p>Laravel provides helpers for mocking events, jobs, and facades out of the box. These helpers primarily provide a convenience layer over Mockery so you do not have to manually make complicated Mockery method calls. Of course, you are free to use <a href="http://docs.mockery.io/en/latest/">Mockery</a> or PHPUnit to create your own mocks or spies.</p>
    <p>
        <a name="mocking-events"></a>
    </p>
    <h2><a href="#mocking-events">Events</a></h2>
    <p>
        <a name="using-event-mocks"></a>
    </p>
    <h3>Using Mocks</h3>
    <p>If you are making heavy use of Laravel's event system, you may wish to silence or mock certain events while testing. For example, if you are testing user registration, you probably do not want all of a <code class=" language-php">UserRegistered</code> event's handlers firing, since the listeners may send "welcome" e-mails, etc.</p>
    <p>Laravel provides a convenient <code class=" language-php">expectsEvents</code> method which verifies the expected events are fired, but prevents any listeners for those events from executing:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>UserRegistered</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Test new user registration.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testUserRegistration<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">expectsEvents<span class="token punctuation">(</span></span><span class="token scope">UserRegistered<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Test user registration...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>You may use the <code class=" language-php">doesntExpectEvents</code> method to verify that the given events are not fired:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>OrderShipped</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>OrderFailedToShip</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Test order shipping.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testOrderShipping<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">expectsEvents<span class="token punctuation">(</span></span><span class="token scope">OrderShipped<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">doesntExpectEvents<span class="token punctuation">(</span></span><span class="token scope">OrderFailedToShip<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Test order shipping...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>If you would like to prevent all event listeners from running, you may use the <code class=" language-php">withoutEvents</code> method. When this method is called, all listeners for all events will be mocked:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testUserRegistration<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withoutEvents<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Test user registration code...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="using-event-fakes"></a>
    </p>
    <h3>Using Fakes</h3>
    <p>As an alternative to mocking, you may use the <code class=" language-php">Event</code> facade's <code class=" language-php">fake</code> method to prevent all event listeners from executing. You may then assert that events were fired and even inspect the data they received. When using fakes, assertions are made after the code under test is executed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>OrderShipped</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Events<span class="token punctuation">\</span>OrderFailedToShip</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Event</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Test order shipping.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testOrderShipping<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Event<span class="token punctuation">::</span></span><span class="token function">fake<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Perform order shipping...
</span>
        <span class="token scope">Event<span class="token punctuation">::</span></span><span class="token function">assertFired<span class="token punctuation">(</span></span><span class="token scope">OrderShipped<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$e</span><span class="token punctuation">)</span> <span class="token keyword">use</span> <span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$e</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token operator">===</span> <span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token scope">Event<span class="token punctuation">::</span></span><span class="token function">assertNotFired<span class="token punctuation">(</span></span><span class="token scope">OrderFailedToShip<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="mocking-jobs"></a>
    </p>
    <h2><a href="#mocking-jobs">Jobs</a></h2>
    <p>
        <a name="using-job-mocks"></a>
    </p>
    <h3>Using Mocks</h3>
    <p>Sometimes, you may wish to test that given jobs are dispatched when making requests to your application. This will allow you to test your routes and controllers in isolation without worrying about your job's logic. Of course, you should then test the job in a separate test case.</p>
    <p>Laravel provides the convenient <code class=" language-php">expectsJobs</code> method which will verify that the expected jobs are dispatched. However, the job itself will not be executed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>ShipOrder</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testOrderShipping<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">expectsJobs<span class="token punctuation">(</span></span><span class="token scope">ShipOrder<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Test order shipping...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> This method only detects jobs that are dispatched via the <code class=" language-php">DispatchesJobs</code> trait's dispatch methods or the <code class=" language-php">dispatch</code> helper function. It does not detect queued jobs that are sent directly to <code class=" language-php"><span class="token scope">Queue<span class="token punctuation">::</span></span>push</code>.</p>
    </blockquote>
    <p>Like the event mocking helpers, you may also test that a job is not dispatched using the <code class=" language-php">doesntExpectJobs</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>ShipOrder</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Test order cancellation.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testOrderCancellation<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">doesntExpectJobs<span class="token punctuation">(</span></span><span class="token scope">ShipOrder<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Test order cancellation...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Alternatively, you may ignore all dispatched jobs using the <code class=" language-php">withoutJobs</code> method. When this method is called within a test method, all jobs that are dispatched during that test will be discarded:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>ShipOrder</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Test order cancellation.
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testOrderCancellation<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withoutJobs<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Test order cancellation...
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="using-job-fakes"></a>
    </p>
    <h3>Using Fakes</h3>
    <p>As an alternative to mocking, you may use the <code class=" language-php">Queue</code> facade's <code class=" language-php">fake</code> method to prevent jobs from being queued. You may then assert that jobs were pushed to the queue and even inspect the data they received. When using fakes, assertions are made after the code under test is executed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Jobs<span class="token punctuation">\</span>ShipOrder</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Queue</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testOrderShipping<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Queue<span class="token punctuation">::</span></span><span class="token function">fake<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Perform order shipping...
</span>
        <span class="token scope">Queue<span class="token punctuation">::</span></span><span class="token function">assertPushed<span class="token punctuation">(</span></span><span class="token scope">ShipOrder<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$job</span><span class="token punctuation">)</span> <span class="token keyword">use</span> <span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$job</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token operator">===</span> <span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Assert a job was pushed to a given queue...
</span>        <span class="token scope">Queue<span class="token punctuation">::</span></span><span class="token function">assertPushedOn<span class="token punctuation">(</span></span><span class="token string">'queue-name'</span><span class="token punctuation">,</span> <span class="token scope">ShipOrder<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Assert a job was not pushed...
</span>        <span class="token scope">Queue<span class="token punctuation">::</span></span><span class="token function">assertNotPushed<span class="token punctuation">(</span></span><span class="token scope">AnotherJob<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="mail-fakes"></a>
    </p>
    <h2><a href="#mail-fakes">Mail Fakes</a></h2>
    <p>You may use the <code class=" language-php">Mail</code> facade's <code class=" language-php">fake</code> method to prevent mail from being sent. You may then assert that <a href="/docs/5.3/mail">mailables</a> were sent to users and even inspect the data they received. When using fakes, assertions are made after the code under test is executed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Mail<span class="token punctuation">\</span>OrderShipped</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Mail</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testOrderShipping<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">fake<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Perform order shipping...
</span>
        <span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">assertSent<span class="token punctuation">(</span></span><span class="token scope">OrderShipped<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$mail</span><span class="token punctuation">)</span> <span class="token keyword">use</span> <span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$mail</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token operator">===</span> <span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Assert a message was sent to the given users...
</span>        <span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">assertSentTo<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token variable">$user</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token scope">OrderShipped<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Assert a mailable was not sent...
</span>        <span class="token scope">Mail<span class="token punctuation">::</span></span><span class="token function">assertNotSent<span class="token punctuation">(</span></span><span class="token scope">AnotherMailable<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="notification-fakes"></a>
    </p>
    <h2><a href="#notification-fakes">Notification Fakes</a></h2>
    <p>You may use the <code class=" language-php">Notification</code> facade's <code class=" language-php">fake</code> method to prevent notifications from being sent. You may then assert that <a href="/docs/5.3/notifications">notifications</a> were sent to users and even inspect the data they received. When using fakes, assertions are made after the code under test is executed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\</span>Notifications<span class="token punctuation">\</span>OrderShipped</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Notification</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testOrderShipping<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Notification<span class="token punctuation">::</span></span><span class="token function">fake<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Perform order shipping...
</span>
        <span class="token scope">Notification<span class="token punctuation">::</span></span><span class="token function">assertSentTo<span class="token punctuation">(</span></span>
            <span class="token variable">$user</span><span class="token punctuation">,</span>
            <span class="token scope">OrderShipped<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$notification</span><span class="token punctuation">,</span> <span class="token variable">$channels</span><span class="token punctuation">)</span> <span class="token keyword">use</span> <span class="token punctuation">(</span><span class="token variable">$order</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
                <span class="token keyword">return</span> <span class="token variable">$notification</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span> <span class="token operator">===</span> <span class="token variable">$order</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">id</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span>
        <span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Assert a notification was sent to the given users...
</span>        <span class="token scope">Notification<span class="token punctuation">::</span></span><span class="token function">assertSentTo<span class="token punctuation">(</span></span>
            <span class="token punctuation">[</span><span class="token variable">$user</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token scope">OrderShipped<span class="token punctuation">::</span></span><span class="token keyword">class</span>
        <span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> // Assert a notification was not sent...
</span>        <span class="token scope">Notification<span class="token punctuation">::</span></span><span class="token function">assertNotSentTo<span class="token punctuation">(</span></span>
            <span class="token punctuation">[</span><span class="token variable">$user</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token scope">AnotherNotification<span class="token punctuation">::</span></span><span class="token keyword">class</span>
        <span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="mocking-facades"></a>
    </p>
    <h2><a href="#mocking-facades">Facades</a></h2>
    <p>Unlike traditional static method calls, <a href="/docs/5.3/facades">facades</a> may be mocked. This provides a great advantage over traditional static methods and grants you the same testability you would have if you were using dependency injection. When testing, you may often want to mock a call to a Laravel facade in one of your controllers. For example, consider the following controller action:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Cache</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">UserController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Show a list of all users of the application.
     *
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">index<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>We can mock the call to the <code class=" language-php">Cache</code> facade by using the <code class=" language-php">shouldReceive</code> method, which will return an instance of a <a href="https://github.com/padraic/mockery">Mockery</a> mock. Since facades are actually resolved and managed by the Laravel <a href="/docs/5.3/container">service container</a>, they have much more testability than a typical static class. For example, let's mock our call to the <code class=" language-php">Cache</code> facade's <code class=" language-php">get</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">FooTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testGetIndex<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token scope">Cache<span class="token punctuation">::</span></span><span class="token function">shouldReceive<span class="token punctuation">(</span></span><span class="token string">'get'</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">once<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">with<span class="token punctuation">(</span></span><span class="token string">'key'</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">andReturn<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'value'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> You should not mock the <code class=" language-php">Request</code> facade. Instead, pass the input you desire into the HTTP helper methods such as <code class=" language-php">call</code> and <code class=" language-php">post</code> when running your test.</p>
    </blockquote>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/mocking">https://laravel.com/docs/5.3/mocking</a></div>
</article>
@endsection