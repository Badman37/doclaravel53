@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Application Testing</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#interacting-with-your-application">Interacting With Your Application</a>
            <ul>
                <li><a href="#interacting-with-links">Interacting With Links</a>
                </li>
                <li><a href="#interacting-with-forms">Interacting With Forms</a>
                </li>
            </ul>
        </li>
        <li><a href="#testing-json-apis">Testing JSON APIs</a>
            <ul>
                <li><a href="#verifying-exact-match">Verifying Exact Match</a>
                </li>
                <li><a href="#verifying-structural-match">Verifying Structural Match</a>
                </li>
            </ul>
        </li>
        <li><a href="#sessions-and-authentication">Sessions / Authentication</a>
        </li>
        <li><a href="#disabling-middleware">Disabling Middleware</a>
        </li>
        <li><a href="#custom-http-requests">Custom HTTP Requests</a>
        </li>
        <li><a href="#phpunit-assertions">PHPUnit Assertions</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel provides a very fluent API for making HTTP requests to your application, examining the output, and even filling out forms. For example, take a look at the test defined below:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>WithoutMiddleware</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseTransactions</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * A basic functional test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'Laravel 5'</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">dontSee<span class="token punctuation">(</span></span><span class="token string">'Rails'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>The <code class=" language-php">visit</code> method makes a <code class=" language-php"><span class="token constant">GET</span></code> request into the application. The <code class=" language-php">see</code> method asserts that we should see the given text in the response returned by the application. The <code class=" language-php">dontSee</code> method asserts that the given text is not returned in the application response. This is the most basic application test available in Laravel.</p>
    <p>You may also use the 'visitRoute' method to make a 'GET' request via a named route:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visitRoute<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visitRoute<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'user'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="interacting-with-your-application"></a>
    </p>
    <h2><a href="#interacting-with-your-application">Interacting With Your Application</a></h2>
    <p>Of course, you can do much more than simply assert that text appears in a given response. Let's take a look at some examples of clicking links and filling out forms:</p>
    <p>
        <a name="interacting-with-links"></a>
    </p>
    <h3>Interacting With Links</h3>
    <p>In this test, we will make a request to the application, "click" a link in the returned response, and then assert that we landed on a given URI. For example, let's assume there is a link in our response that has a text value of "About Us":</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>a</span> <span class="token attr-name">href</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>/about-us<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>About Us<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>a</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>Now, let's write a test that clicks the link and asserts the user lands on the correct page:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">click<span class="token punctuation">(</span></span><span class="token string">'About Us'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seePageIs<span class="token punctuation">(</span></span><span class="token string">'/about-us'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>You may also check that the user has arrived at the correct named route using the <code class=" language-php">seeRouteIs</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seeRouteIs<span class="token punctuation">(</span></span><span class="token string">'profile'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'user'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token number">1</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="interacting-with-forms"></a>
    </p>
    <h3>Interacting With Forms</h3>
    <p>Laravel also provides several methods for testing forms. The <code class=" language-php">type</code>, <code class=" language-php">select</code>, <code class=" language-php">check</code>, <code class=" language-php">attach</code>, and <code class=" language-php">press</code> methods allow you to interact with all of your form's inputs. For example, let's imagine this form exists on the application's registration page:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>form</span> <span class="token attr-name">action</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>/register<span class="token punctuation">"</span></span> <span class="token attr-name">method</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>POST<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
    <span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token function">csrf_field<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span>

    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span><span class="token punctuation">&gt;</span></span></span>
        Name<span class="token punctuation">:</span> <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>input</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>text<span class="token punctuation">"</span></span> <span class="token attr-name">name</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>name<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>

    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span><span class="token punctuation">&gt;</span></span></span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>input</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>checkbox<span class="token punctuation">"</span></span> <span class="token attr-name">value</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>yes<span class="token punctuation">"</span></span> <span class="token attr-name">name</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>terms<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span> Accept Terms
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>

    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span><span class="token punctuation">&gt;</span></span></span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>input</span> <span class="token attr-name">type</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>submit<span class="token punctuation">"</span></span> <span class="token attr-name">value</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>Register<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span></span>
    <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span></span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>form</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>We can write a test to complete this form and inspect the result:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testNewUserRegistration<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/register'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">type<span class="token punctuation">(</span></span><span class="token string">'Taylor'</span><span class="token punctuation">,</span> <span class="token string">'name'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">check<span class="token punctuation">(</span></span><span class="token string">'terms'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">press<span class="token punctuation">(</span></span><span class="token string">'Register'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seePageIs<span class="token punctuation">(</span></span><span class="token string">'/dashboard'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Of course, if your form contains other inputs such as radio buttons or drop-down boxes, you may easily fill out those types of fields as well. Here is a list of each form manipulation method:</p>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">type<span class="token punctuation">(</span></span><span class="token variable">$text</span><span class="token punctuation">,</span> <span class="token variable">$elementName</span><span class="token punctuation">)</span></code>
                </td>
                <td>"Type" text into a given field.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">select<span class="token punctuation">(</span></span><span class="token variable">$value</span><span class="token punctuation">,</span> <span class="token variable">$elementName</span><span class="token punctuation">)</span></code>
                </td>
                <td>"Select" a radio button or drop-down field.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">check<span class="token punctuation">(</span></span><span class="token variable">$elementName</span><span class="token punctuation">)</span></code>
                </td>
                <td>"Check" a checkbox field.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">uncheck<span class="token punctuation">(</span></span><span class="token variable">$elementName</span><span class="token punctuation">)</span></code>
                </td>
                <td>"Uncheck" a checkbox field.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach<span class="token punctuation">(</span></span><span class="token variable">$pathToFile</span><span class="token punctuation">,</span> <span class="token variable">$elementName</span><span class="token punctuation">)</span></code>
                </td>
                <td>"Attach" a file to the form.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">press<span class="token punctuation">(</span></span><span class="token variable">$buttonTextOrElementName</span><span class="token punctuation">)</span></code>
                </td>
                <td>"Press" a button with the given text or name.</td>
            </tr>
        </tbody>
    </table>
    <p>
        <a name="file-inputs"></a>
    </p>
    <h4>File Inputs</h4>
    <p>If your form contains <code class=" language-php">file</code> inputs, you may attach files to the form using the <code class=" language-php">attach</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testPhotoCanBeUploaded<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/upload'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">attach<span class="token punctuation">(</span></span><span class="token variable">$pathToFile</span><span class="token punctuation">,</span> <span class="token string">'photo'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">press<span class="token punctuation">(</span></span><span class="token string">'Upload'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'Upload Successful!'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="testing-json-apis"></a>
    </p>
    <h3>Testing JSON APIs</h3>
    <p>Laravel also provides several helpers for testing JSON APIs and their responses. For example, the <code class=" language-php">json</code>, <code class=" language-php">get</code>, <code class=" language-php">post</code>, <code class=" language-php">put</code>, <code class=" language-php">patch</code>, and <code class=" language-php">delete</code> methods may be used to issue requests with various HTTP verbs. You may also easily pass data and headers to these methods. To get started, let's write a test to make a <code class=" language-php"><span class="token constant">POST</span></code> request to <code class=" language-php"><span class="token operator">/</span>user</code> and assert that the expected data was returned:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * A basic functional test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">json<span class="token punctuation">(</span></span><span class="token string">'POST'</span><span class="token punctuation">,</span> <span class="token string">'/user'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Sally'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seeJson<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
                 <span class="token string">'created'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">,</span>
             <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> The <code class=" language-php">seeJson</code> method converts the given array into JSON, and then verifies that the JSON fragment occurs <strong>anywhere</strong> within the entire JSON response returned by the application. So, if there are other properties in the JSON response, this test will still pass as long as the given fragment is present.</p>
    </blockquote>
    <p>
        <a name="verifying-exact-match"></a>
    </p>
    <h3>Verifying Exact Match</h3>
    <p>If you would like to verify that the given array is an <strong>exact</strong> match for the JSON returned by the application, you should use the <code class=" language-php">seeJsonEquals</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * A basic functional test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">json<span class="token punctuation">(</span></span><span class="token string">'POST'</span><span class="token punctuation">,</span> <span class="token string">'/user'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Sally'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seeJsonEquals<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
                 <span class="token string">'created'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">,</span>
             <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="verifying-structural-match"></a>
    </p>
    <h3>Verifying Structural Match</h3>
    <p>It is also possible to verify that a JSON response adheres to a specific structure. In this scenario, you should use the <code class=" language-php">seeJsonStructure</code> method and pass it your expected JSON structure:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * A basic functional test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/user/1'</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seeJsonStructure<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
                 <span class="token string">'name'</span><span class="token punctuation">,</span>
                 <span class="token string">'pet'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
                     <span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'age'</span>
                 <span class="token punctuation">]</span>
             <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>The above example illustrates an expectation of receiving a <code class=" language-php">name</code> attribute and a nested <code class=" language-php">pet</code> object with its own <code class=" language-php">name</code> and <code class=" language-php">age</code> attributes. <code class=" language-php">seeJsonStructure</code> will not fail if additional keys are present in the response. For example, the test would still pass if the <code class=" language-php">pet</code> had a <code class=" language-php">weight</code> attribute.</p>
    <p>You may use the <code class=" language-php"><span class="token operator">*</span></code> to assert that the returned JSON structure has a list where each list item contains at least the attributes found in the set of values:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * A basic functional test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Assert that each user in the list has at least an id, name and email attribute.
</span>        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/users'</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seeJsonStructure<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
                 <span class="token string">'*'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
                     <span class="token string">'id'</span><span class="token punctuation">,</span> <span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'email'</span>
                 <span class="token punctuation">]</span>
             <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>You may also nest the <code class=" language-php"><span class="token operator">*</span></code> notation. In this case, we will assert that each user in the JSON response contains a given set of attributes and that each pet on each user also contains a given set of attributes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/users'</span><span class="token punctuation">)</span>
     <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">seeJsonStructure<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
         <span class="token string">'*'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
             <span class="token string">'id'</span><span class="token punctuation">,</span> <span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'email'</span><span class="token punctuation">,</span> <span class="token string">'pets'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
                 <span class="token string">'*'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
                     <span class="token string">'name'</span><span class="token punctuation">,</span> <span class="token string">'age'</span>
                 <span class="token punctuation">]</span>
             <span class="token punctuation">]</span>
         <span class="token punctuation">]</span>
     <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="sessions-and-authentication"></a>
    </p>
    <h3>Sessions / Authentication</h3>
    <p>Laravel provides several helpers for working with the session during testing. First, you may set the session data to a given array using the <code class=" language-php">withSession</code> method. This is useful for loading the session with data before issuing a request to your application:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testApplication<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withSession<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'foo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'bar'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Of course, one common use of the session is for maintaining state for the authenticated user. The <code class=" language-php">actingAs</code> helper method provides a simple way to authenticate a given user as the current user. For example, we may use a <a href="/docs/5.3/database-testing#model-factories">model factory</a> to generate and authenticate a user:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testApplication<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$user</span> <span class="token operator">=</span> <span class="token function">factory<span class="token punctuation">(</span></span><span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">actingAs<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withSession<span class="token punctuation">(</span></span><span class="token punctuation">[</span><span class="token string">'foo'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'bar'</span><span class="token punctuation">]</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'Hello, '</span><span class="token punctuation">.</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">name</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>You may also specify which guard should be used to authenticate the given user by passing the guard name as the second argument to the <code class=" language-php">actingAs</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">actingAs<span class="token punctuation">(</span></span><span class="token variable">$user</span><span class="token punctuation">,</span> <span class="token string">'api'</span><span class="token punctuation">)</span></code></pre>
    <p>
        <a name="disabling-middleware"></a>
    </p>
    <h3>Disabling Middleware</h3>
    <p>When testing your application, you may find it convenient to disable <a href="/docs/5.3/middleware">middleware</a> for some of your tests. This will allow you to test your routes and controller in isolation from any middleware concerns. Laravel includes a simple <code class=" language-php">WithoutMiddleware</code> trait that you can use to automatically disable all middleware for the test class:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>WithoutMiddleware</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseMigrations</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Testing<span class="token punctuation">\</span>DatabaseTransactions</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">WithoutMiddleware</span><span class="token punctuation">;</span>

   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>If you would like to only disable middleware for a few test methods, you may call the <code class=" language-php">withoutMiddleware</code> method from within the test methods:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">class</span> <span class="token class-name">ExampleTest</span> <span class="token keyword">extends</span> <span class="token class-name">TestCase</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * A basic functional test example.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testBasicExample<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withoutMiddleware<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">visit<span class="token punctuation">(</span></span><span class="token string">'/'</span><span class="token punctuation">)</span>
             <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">see<span class="token punctuation">(</span></span><span class="token string">'Laravel 5'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="custom-http-requests"></a>
    </p>
    <h3>Custom HTTP Requests</h3>
    <p>If you would like to make a custom HTTP request into your application and get the full <code class=" language-php">Illuminate\<span class="token package">Http<span class="token punctuation">\</span>Response</span></code> object, you may use the <code class=" language-php">call</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">testApplication<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token variable">$response</span> <span class="token operator">=</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">call<span class="token punctuation">(</span></span><span class="token string">'GET'</span><span class="token punctuation">,</span> <span class="token string">'/'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertEquals<span class="token punctuation">(</span></span><span class="token number">200</span><span class="token punctuation">,</span> <span class="token variable">$response</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">status<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>If you are making <code class=" language-php"><span class="token constant">POST</span></code>, <code class=" language-php"><span class="token constant">PUT</span></code>, or <code class=" language-php"><span class="token constant">PATCH</span></code> requests you may pass an array of input data with the request. Of course, this data will be available in your routes and controller via the <a href="/docs/5.3/requests">Request instance</a>:</p>
    <pre class=" language-php"><code class=" language-php">   <span class="token variable">$response</span> <span class="token operator">=</span> <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">call<span class="token punctuation">(</span></span><span class="token string">'POST'</span><span class="token punctuation">,</span> <span class="token string">'/user'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'name'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Taylor'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="phpunit-assertions"></a>
    </p>
    <h3>PHPUnit Assertions</h3>
    <p>Laravel provides a variety of custom assertion methods for <a href="https://phpunit.de/">PHPUnit</a> tests:</p>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertResponseOk<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the client response has an OK status code.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertResponseStatus<span class="token punctuation">(</span></span><span class="token variable">$code</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the client response has a given code.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertViewHas<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">,</span> <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token keyword">null</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the response view has a given piece of bound data.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertViewHasAll<span class="token punctuation">(</span></span><span class="token keyword">array</span> <span class="token variable">$bindings</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the view has a given list of bound data.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertViewMissing<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the response view is missing a piece of bound data.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertRedirectedTo<span class="token punctuation">(</span></span><span class="token variable">$uri</span><span class="token punctuation">,</span> <span class="token variable">$with</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert whether the client was redirected to a given URI.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertRedirectedToRoute<span class="token punctuation">(</span></span><span class="token variable">$name</span><span class="token punctuation">,</span> <span class="token variable">$parameters</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token variable">$with</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert whether the client was redirected to a given route.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertRedirectedToAction<span class="token punctuation">(</span></span><span class="token variable">$name</span><span class="token punctuation">,</span> <span class="token variable">$parameters</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token variable">$with</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert whether the client was redirected to a given action.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertSessionHas<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">,</span> <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token keyword">null</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the session has a given value.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertSessionHasAll<span class="token punctuation">(</span></span><span class="token keyword">array</span> <span class="token variable">$bindings</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the session has a given list of values.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertSessionHasErrors<span class="token punctuation">(</span></span><span class="token variable">$bindings</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token variable">$format</span> <span class="token operator">=</span> <span class="token keyword">null</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the session has errors bound.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertHasOldInput<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the session has old input.</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">assertSessionMissing<span class="token punctuation">(</span></span><span class="token variable">$key</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Assert that the session is missing a given key.</td>
            </tr>
        </tbody>
    </table>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/aplication-testing">https://laravel.com/docs/5.3/application-testing</a></div>
</article>
@endsection