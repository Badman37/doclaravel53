@extends('documents.laravel53.layout')

@section('content')

<article>
    <h1>API Authentication (Passport)</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#installation">Installation</a>
            <ul>
                <li><a href="#frontend-quickstart">Frontend Quickstart</a>
                </li>
            </ul>
        </li>
        <li><a href="#configuration">Configuration</a>
            <ul>
                <li><a href="#token-lifetimes">Token Lifetimes</a>
                </li>
                <li><a href="#pruning-revoked-tokens">Pruning Revoked Tokens</a>
                </li>
            </ul>
        </li>
        <li><a href="#issuing-access-tokens">Issuing Access Tokens</a>
            <ul>
                <li><a href="#managing-clients">Managing Clients</a>
                </li>
                <li><a href="#requesting-tokens">Requesting Tokens</a>
                </li>
                <li><a href="#refreshing-tokens">Refreshing Tokens</a>
                </li>
            </ul>
        </li>
        <li><a href="#password-grant-tokens">Password Grant Tokens</a>
            <ul>
                <li><a href="#creating-a-password-grant-client">Creating A Password Grant Client</a>
                </li>
                <li><a href="#requesting-password-grant-tokens">Requesting Tokens</a>
                </li>
                <li><a href="#requesting-all-scopes">Requesting All Scopes</a>
                </li>
            </ul>
        </li>
        <li><a href="#personal-access-tokens">Personal Access Tokens</a>
            <ul>
                <li><a href="#creating-a-personal-access-client">Creating A Personal Access Client</a>
                </li>
                <li><a href="#managing-personal-access-tokens">Managing Personal Access Tokens</a>
                </li>
            </ul>
        </li>
        <li><a href="#protecting-routes">Protecting Routes</a>
            <ul>
                <li><a href="#via-middleware">Via Middleware</a>
                </li>
                <li><a href="#passing-the-access-token">Passing The Access Token</a>
                </li>
            </ul>
        </li>
        <li><a href="#token-scopes">Token Scopes</a>
            <ul>
                <li><a href="#defining-scopes">Defining Scopes</a>
                </li>
                <li><a href="#assigning-scopes-to-tokens">Assigning Scopes To Tokens</a>
                </li>
                <li><a href="#checking-scopes">Checking Scopes</a>
                </li>
            </ul>
        </li>
        <li><a href="#consuming-your-api-with-javascript">Consuming Your API With JavaScript</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel already makes it easy to perform authentication via traditional login forms, but what about APIs? APIs typically use tokens to authenticate users and do not maintain session state between requests. Laravel makes API authentication a breeze using Laravel Passport, which provides a full OAuth2 server implementation for your Laravel application in a matter of minutes. Passport is built on top of the <a href="https://github.com/thephpleague/oauth2-server">League OAuth2 server</a> that is maintained by Alex Bilbie.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> This documentation assumes you are already familiar with OAuth2. If you do not know anything about OAuth2, consider familiarizing yourself with the general terminology and features of OAuth2 before continuing.</p>
    </blockquote>
    <p>
        <a name="installation"></a>
    </p>
    <h2><a href="#installation">Installation</a></h2>
    <p>To get started, install Passport via the Composer package manager:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> laravel<span class="token operator">/</span>passport</code></pre>
    <p>Next, register the Passport service provider in the <code class=" language-php">providers</code> array of your <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> configuration file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Laravel<span class="token punctuation">\</span>Passport<span class="token punctuation">\</span>PassportServiceProvider<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span></code></pre>
    <p>The Passport service provider registers its own database migration directory with the framework, so you should migrate your database after registering the provider. The Passport migrations will create the tables your application needs to store clients and access tokens:</p>
    <pre class=" language-php"><code class=" language-php">php artisan migrate</code></pre>
    <p>Next, you should run the <code class=" language-php">passport<span class="token punctuation">:</span>install</code> command. This command will create the encryption keys needed to generate secure access tokens. In addition, the command will create "personal access" and "password grant" clients which will be used to generate access tokens:</p>
    <pre class=" language-php"><code class=" language-php">php artisan passport<span class="token punctuation">:</span>install</code></pre>
    <p>After running this command, add the <code class=" language-php">Laravel\<span class="token package">Passport<span class="token punctuation">\</span>HasApiTokens</span></code> trait to your <code class=" language-php">App\<span class="token package">User</span></code> model. This trait will provide a few helper methods to your model which allow you to inspect the authenticated user's token and scopes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Passport<span class="token punctuation">\</span>HasApiTokens</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Notifications<span class="token punctuation">\</span>Notifiable</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Auth<span class="token punctuation">\</span>User</span> <span class="token keyword">as</span> Authenticatable<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Authenticatable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">HasApiTokens</span><span class="token punctuation">,</span> Notifiable<span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>Next, you should call the <code class=" language-php"><span class="token scope">Passport<span class="token punctuation">::</span></span>routes</code> method within the <code class=" language-php">boot</code> method of your <code class=" language-php">AuthServiceProvider</code>. This method will register the routes necessary to issue access tokens and revoke access tokens, clients, and personal access tokens:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Passport<span class="token punctuation">\</span>Passport</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Facades<span class="token punctuation">\</span>Gate</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Support<span class="token punctuation">\</span>Providers<span class="token punctuation">\</span>AuthServiceProvider</span> <span class="token keyword">as</span> ServiceProvider<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">AuthServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The policy mappings for the application.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$policies</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
        <span class="token string">'App\Model'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'App\Policies\ModelPolicy'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Register any authentication / authorization services.
     *
     * @return void
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">registerPolicies<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token scope">Passport<span class="token punctuation">::</span></span><span class="token function">routes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>Finally, in your <code class=" language-php">config<span class="token operator">/</span>auth<span class="token punctuation">.</span>php</code> configuration file, you should set the <code class=" language-php">driver</code> option of the <code class=" language-php">api</code> authentication guard to <code class=" language-php">passport</code>. This will instruct your application to use Passport's <code class=" language-php">TokenGuard</code> when authenticating incoming API requests:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'guards'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'web'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'driver'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'session'</span><span class="token punctuation">,</span>
        <span class="token string">'provider'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'users'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string">'api'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'driver'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'passport'</span><span class="token punctuation">,</span>
        <span class="token string">'provider'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'users'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="frontend-quickstart"></a>
    </p>
    <h3>Frontend Quickstart</h3>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> In order to use the Passport Vue components, you must be using the <a href="https://vuejs.org">Vue</a> JavaScript framework. These components also use the Bootstrap CSS framework. However, even if you are not using these tools, the components serve as a valuable reference for your own frontend implementation.</p>
    </blockquote>
    <p>Passport ships with a JSON API that you may use to allow your users to create clients and personal access tokens. However, it can be time consuming to code a frontend to interact with these APIs. So, Passport also includes pre-built <a href="https://vuejs.org">Vue</a> components you may use as an example implementation or starting point for your own implementation.</p>
    <p>To publish the Passport Vue components, use the <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> Artisan command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan vendor<span class="token punctuation">:</span>publish <span class="token operator">--</span>tag<span class="token operator">=</span>passport<span class="token operator">-</span>components</code></pre>
    <p>The published components will be placed in your <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js<span class="token operator">/</span>components</code> directory. Once the components have been published, you should register them in your <code class=" language-php">resources<span class="token operator">/</span>assets<span class="token operator">/</span>js<span class="token operator">/</span>app<span class="token punctuation">.</span>js</code> file:</p>
    <pre class=" language-php"><code class=" language-php">Vue<span class="token punctuation">.</span><span class="token function">component<span class="token punctuation">(</span></span>
    <span class="token string">'passport-clients'</span><span class="token punctuation">,</span>
    <span class="token keyword">require</span><span class="token punctuation">(</span><span class="token string">'./components/passport/Clients.vue'</span><span class="token punctuation">)</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span>

Vue<span class="token punctuation">.</span><span class="token function">component<span class="token punctuation">(</span></span>
    <span class="token string">'passport-authorized-clients'</span><span class="token punctuation">,</span>
    <span class="token keyword">require</span><span class="token punctuation">(</span><span class="token string">'./components/passport/AuthorizedClients.vue'</span><span class="token punctuation">)</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span>

Vue<span class="token punctuation">.</span><span class="token function">component<span class="token punctuation">(</span></span>
    <span class="token string">'passport-personal-access-tokens'</span><span class="token punctuation">,</span>
    <span class="token keyword">require</span><span class="token punctuation">(</span><span class="token string">'./components/passport/PersonalAccessTokens.vue'</span><span class="token punctuation">)</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Once the components have been registered, you may drop them into one of your application's templates to get started creating clients and personal access tokens:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>passport-clients</span><span class="token punctuation">&gt;</span></span></span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>passport-clients</span><span class="token punctuation">&gt;</span></span></span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>passport-authorized-clients</span><span class="token punctuation">&gt;</span></span></span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>passport-authorized-clients</span><span class="token punctuation">&gt;</span></span></span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>passport-personal-access-tokens</span><span class="token punctuation">&gt;</span></span></span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>passport-personal-access-tokens</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="configuration"></a>
    </p>
    <h2><a href="#configuration">Configuration</a></h2>
    <p>
        <a name="token-lifetimes"></a>
    </p>
    <h3>Token Lifetimes</h3>
    <p>By default, Passport issues long-lived access tokens that never need to be refreshed. If you would like to configure a shorter token lifetime, you may use the <code class=" language-php">tokensExpireIn</code> and <code class=" language-php">refreshTokensExpireIn</code> methods. These methods should be called from the <code class=" language-php">boot</code> method of your <code class=" language-php">AuthServiceProvider</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Carbon<span class="token punctuation">\</span>Carbon</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">/**
 * Register any authentication / authorization services.
 *
 * @return void
 */</span>
<span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">boot<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token this">$this</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">registerPolicies<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token scope">Passport<span class="token punctuation">::</span></span><span class="token function">routes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token scope">Passport<span class="token punctuation">::</span></span><span class="token function">tokensExpireIn<span class="token punctuation">(</span></span><span class="token scope">Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">addDays<span class="token punctuation">(</span></span><span class="token number">15</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token scope">Passport<span class="token punctuation">::</span></span><span class="token function">refreshTokensExpireIn<span class="token punctuation">(</span></span><span class="token scope">Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">addDays<span class="token punctuation">(</span></span><span class="token number">30</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="pruning-revoked-tokens"></a>
    </p>
    <h3>Pruning Revoked Tokens</h3>
    <p>By default, Passport does not delete your revoked access tokens from the database. Over time, a large number of these tokens can accumulate in your database. If you would like Passport to automatically delete your revoked tokens, you should call the <code class=" language-php">pruneRevokedTokens</code> method from the <code class=" language-php">boot</code> method of your <code class=" language-php">AuthServiceProvider</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Passport<span class="token punctuation">\</span>Passport</span><span class="token punctuation">;</span>

<span class="token scope">Passport<span class="token punctuation">::</span></span><span class="token function">pruneRevokedTokens<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>This method will not delete all revoked tokens immediately. Instead, revoked tokens will be deleted when a user requests a new access token or refreshes an existing token.</p>
    <p>
        <a name="issuing-access-tokens"></a>
    </p>
    <h2><a href="#issuing-access-tokens">Issuing Access Tokens</a></h2>
    <p>Using OAuth2 with authorization codes is how most developers are familiar with OAuth2. When using authorization codes, a client application will redirect a user to your server where they will either approve or deny the request to issue an access token to the client.</p>
    <p>
        <a name="managing-clients"></a>
    </p>
    <h3>Managing Clients</h3>
    <p>First, developers building applications that need to interact with your application's API will need to register their application with yours by creating a "client". Typically, this consists of providing the name of their application and a URL that your application can redirect to after users approve their request for authorization.</p>
    <h4>The <code class=" language-php">passport<span class="token punctuation">:</span>client</code> Command</h4>
    <p>The simplest way to create a client is using the <code class=" language-php">passport<span class="token punctuation">:</span>client</code> Artisan command. This command may be used to create your own clients for testing your OAuth2 functionality. When you run the <code class=" language-php">client</code> command, Passport will prompt you for more information about your client and will provide you with a client ID and secret:</p>
    <pre class=" language-php"><code class=" language-php">php artisan passport<span class="token punctuation">:</span>client</code></pre>
    <h4>JSON API</h4>
    <p>Since your users will not be able to utilize the <code class=" language-php">client</code> command, Passport provides a JSON API that you may use to create clients. This saves you the trouble of having to manually code controllers for creating, updating, and deleting clients.</p>
    <p>However, you will need to pair Passport's JSON API with your own frontend to provide a dashboard for your users to manage their clients. Below, we'll review all of the API endpoints for managing clients. For convenience, we'll use <a href="https://vuejs.org">Vue</a> to demonstrate making HTTP requests to the endpoints.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> If you don't want to implement the entire client management frontend yourself, you can use the <a href="#frontend-quickstart">frontend quickstart</a> to have a fully functional frontend in a matter of minutes.</p>
    </blockquote>
    <h4><code class=" language-php"><span class="token constant">GET</span> <span class="token operator">/</span>oauth<span class="token operator">/</span>clients</code></h4>
    <p>This route returns all of the clients for the authenticated user. This is primarily useful for listing all of the user's clients so that they may edit or delete them:</p>
    <pre class=" language-php"><code class=" language-php">this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/oauth/clients'</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span>response <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>response<span class="token punctuation">.</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4><code class=" language-php"><span class="token constant">POST</span> <span class="token operator">/</span>oauth<span class="token operator">/</span>clients</code></h4>
    <p>This route is used to create new clients. It requires two pieces of data: the client's <code class=" language-php">name</code> and a <code class=" language-php">redirect</code> URL. The <code class=" language-php">redirect</code> URL is where the user will be redirected after approving or denying a request for authorization.</p>
    <p>When a client is created, it will be issued a client ID and client secret. These values will be used when requesting access tokens from your application. The client creation route will return the new client instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">const</span> data <span class="token operator">=</span> <span class="token punctuation">{</span>
    name<span class="token punctuation">:</span> <span class="token string">'Client Name'</span><span class="token punctuation">,</span>
    redirect<span class="token punctuation">:</span> <span class="token string">'http://example.com/callback'</span>
<span class="token punctuation">}</span><span class="token punctuation">;</span>

this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'/oauth/clients'</span><span class="token punctuation">,</span> data<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span>response <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>response<span class="token punctuation">.</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token keyword">catch</span> <span class="token punctuation">(</span><span class="token class-name">response</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // List errors on response...
</span>    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4><code class=" language-php"><span class="token constant">PUT</span> <span class="token operator">/</span>oauth<span class="token operator">/</span>clients<span class="token operator">/</span><span class="token punctuation">{</span>client<span class="token operator">-</span>id<span class="token punctuation">}</span></code></h4>
    <p>This route is used to update clients. It requires two pieces of data: the client's <code class=" language-php">name</code> and a <code class=" language-php">redirect</code> URL. The <code class=" language-php">redirect</code> URL is where the user will be redirected after approving or denying a request for authorization. The route will return the updated client instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">const</span> data <span class="token operator">=</span> <span class="token punctuation">{</span>
    name<span class="token punctuation">:</span> <span class="token string">'New Client Name'</span><span class="token punctuation">,</span>
    redirect<span class="token punctuation">:</span> <span class="token string">'http://example.com/callback'</span>
<span class="token punctuation">}</span><span class="token punctuation">;</span>

this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">put<span class="token punctuation">(</span></span><span class="token string">'/oauth/clients/'</span> <span class="token operator">+</span> clientId<span class="token punctuation">,</span> data<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span>response <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>response<span class="token punctuation">.</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token keyword">catch</span> <span class="token punctuation">(</span><span class="token class-name">response</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // List errors on response...
</span>    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4><code class=" language-php"><span class="token constant">DELETE</span> <span class="token operator">/</span>oauth<span class="token operator">/</span>clients<span class="token operator">/</span><span class="token punctuation">{</span>client<span class="token operator">-</span>id<span class="token punctuation">}</span></code></h4>
    <p>This route is used to delete clients:</p>
    <pre class=" language-php"><code class=" language-php">this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">delete<span class="token punctuation">(</span></span><span class="token string">'/oauth/clients/'</span> <span class="token operator">+</span> clientId<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span>response <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="requesting-tokens"></a>
    </p>
    <h3>Requesting Tokens</h3>
    <h4>Redirecting For Authorization</h4>
    <p>Once a client has been created, developers may use their client ID and secret to request an authorization code and access token from your application. First, the consuming application should make a redirect request to your application's <code class=" language-php"><span class="token operator">/</span>oauth<span class="token operator">/</span>authorize</code> route like so:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/redirect'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span> <span class="token operator">=</span> <span class="token function">http_build_query<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
        <span class="token string">'client_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-id'</span><span class="token punctuation">,</span>
        <span class="token string">'redirect_uri'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'http://example.com/callback'</span><span class="token punctuation">,</span>
        <span class="token string">'response_type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'code'</span><span class="token punctuation">,</span>
        <span class="token string">'scope'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">''</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'http://your-app.com/oauth/authorize?'</span><span class="token punctuation">.</span><span class="token variable">$query</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Remember, the <code class=" language-php"><span class="token operator">/</span>oauth<span class="token operator">/</span>authorize</code> route is already defined by the <code class=" language-php"><span class="token scope">Passport<span class="token punctuation">::</span></span>routes</code> method. You do not need to manually define this route.</p>
    </blockquote>
    <h4>Approving The Request</h4>
    <p>When receiving authorization requests, Passport will automatically display a template to the user allowing them to approve or deny the authorization request. If they approve the request, they will be redirected back to the <code class=" language-php">redirect_uri</code> that was specified by the consuming application. The <code class=" language-php">redirect_uri</code> must match the <code class=" language-php">redirect</code> URL that was specified when the client was created.</p>
    <p>If you would like to customize the authorization approval screen, you may publish Passport's views using the <code class=" language-php">vendor<span class="token punctuation">:</span>publish</code> Artisan command. The published views will be placed in <code class=" language-php">resources<span class="token operator">/</span>views<span class="token operator">/</span>vendor<span class="token operator">/</span>passport</code>:</p>
    <pre class=" language-php"><code class=" language-php">php artisan vendor<span class="token punctuation">:</span>publish <span class="token operator">--</span>tag<span class="token operator">=</span>passport<span class="token operator">-</span>views</code></pre>
    <h4>Converting Authorization Codes To Access Tokens</h4>
    <p>If the user approves the authorization request, they will be redirected back to the consuming application. The consumer should then issue a <code class=" language-php"><span class="token constant">POST</span></code> request to your application to request an access token. The request should include the authorization code that was issued by when the user approved the authorization request. In this example, we'll use the Guzzle HTTP library to make the <code class=" language-php"><span class="token constant">POST</span></code> request:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/callback'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span>Request <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$http</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">GuzzleHttp<span class="token punctuation">\</span>Client</span><span class="token punctuation">;</span>

    <span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$http</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'http://your-app.com/oauth/token'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
        <span class="token string">'form_params'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
            <span class="token string">'grant_type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'authorization_code'</span><span class="token punctuation">,</span>
            <span class="token string">'client_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-id'</span><span class="token punctuation">,</span>
            <span class="token string">'client_secret'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-secret'</span><span class="token punctuation">,</span>
            <span class="token string">'redirect_uri'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'http://example.com/callback'</span><span class="token punctuation">,</span>
            <span class="token string">'code'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">code</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token keyword">return</span> <span class="token function">json_decode<span class="token punctuation">(</span></span><span class="token punctuation">(</span>string<span class="token punctuation">)</span> <span class="token variable">$response</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">getBody<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>This <code class=" language-php"><span class="token operator">/</span>oauth<span class="token operator">/</span>token</code> route will return a JSON response containing <code class=" language-php">access_token</code>, <code class=" language-php">refresh_token</code>, and <code class=" language-php">expires_in</code> attributes. The <code class=" language-php">expires_in</code> attribute contains the number of seconds until the access token expires.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Like the <code class=" language-php"><span class="token operator">/</span>oauth<span class="token operator">/</span>authorize</code> route, the <code class=" language-php"><span class="token operator">/</span>oauth<span class="token operator">/</span>token</code> route is defined for you by the <code class=" language-php"><span class="token scope">Passport<span class="token punctuation">::</span></span>routes</code> method. There is no need to manually define this route.</p>
    </blockquote>
    <p>
        <a name="refreshing-tokens"></a>
    </p>
    <h3>Refreshing Tokens</h3>
    <p>If your application issues short-lived access tokens, users will need to refresh their access tokens via the refresh token that was provided to them when the access token was issued. In this example, we'll use the Guzzle HTTP library to refresh the token:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$http</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">GuzzleHttp<span class="token punctuation">\</span>Client</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$http</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'http://your-app.com/oauth/token'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'form_params'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'grant_type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'refresh_token'</span><span class="token punctuation">,</span>
        <span class="token string">'refresh_token'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'the-refresh-token'</span><span class="token punctuation">,</span>
        <span class="token string">'client_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-id'</span><span class="token punctuation">,</span>
        <span class="token string">'client_secret'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-secret'</span><span class="token punctuation">,</span>
        <span class="token string">'scope'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">''</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">json_decode<span class="token punctuation">(</span></span><span class="token punctuation">(</span>string<span class="token punctuation">)</span> <span class="token variable">$response</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">getBody<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>This <code class=" language-php"><span class="token operator">/</span>oauth<span class="token operator">/</span>token</code> route will return a JSON response containing <code class=" language-php">access_token</code>, <code class=" language-php">refresh_token</code>, and <code class=" language-php">expires_in</code> attributes. The <code class=" language-php">expires_in</code> attribute contains the number of seconds until the access token expires.</p>
    <p>
        <a name="password-grant-tokens"></a>
    </p>
    <h2><a href="#password-grant-tokens">Password Grant Tokens</a></h2>
    <p>The OAuth2 password grant allows your other first-party clients, such as a mobile application, to obtain an access token using an e-mail address / username and password. This allows you to issue access tokens securely to your first-party clients without requiring your users to go through the entire OAuth2 authorization code redirect flow.</p>
    <p>
        <a name="creating-a-password-grant-client"></a>
    </p>
    <h3>Creating A Password Grant Client</h3>
    <p>Before your application can issue tokens via the password grant, you will need to create a password grant client. You may do this using the <code class=" language-php">passport<span class="token punctuation">:</span>client</code> command with the <code class=" language-php"><span class="token operator">--</span>password</code> option. If you have already run the <code class=" language-php">passport<span class="token punctuation">:</span>install</code> command, you do not need to run this command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan passport<span class="token punctuation">:</span>client <span class="token operator">--</span>password</code></pre>
    <p>
        <a name="requesting-password-grant-tokens"></a>
    </p>
    <h3>Requesting Tokens</h3>
    <p>Once you have created a password grant client, you may request an access token by issuing a <code class=" language-php"><span class="token constant">POST</span></code> request to the <code class=" language-php"><span class="token operator">/</span>oauth<span class="token operator">/</span>token</code> route with the user's email address and password. Remember, this route is already registered by the <code class=" language-php"><span class="token scope">Passport<span class="token punctuation">::</span></span>routes</code> method so there is no need to define it manually. If the request is successful, you will receive an <code class=" language-php">access_token</code> and <code class=" language-php">refresh_token</code> in the JSON response from the server:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$http</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">GuzzleHttp<span class="token punctuation">\</span>Client</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$http</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'http://your-app.com/oauth/token'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'form_params'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'grant_type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'password'</span><span class="token punctuation">,</span>
        <span class="token string">'client_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-id'</span><span class="token punctuation">,</span>
        <span class="token string">'client_secret'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-secret'</span><span class="token punctuation">,</span>
        <span class="token string">'username'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'taylor@laravel.com'</span><span class="token punctuation">,</span>
        <span class="token string">'password'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'my-password'</span><span class="token punctuation">,</span>
        <span class="token string">'scope'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">''</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token function">json_decode<span class="token punctuation">(</span></span><span class="token punctuation">(</span>string<span class="token punctuation">)</span> <span class="token variable">$response</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">getBody<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> Remember, access tokens are long-lived by default. However, you are free to <a href="#configuration">configure your maximum access token lifetime</a> if needed.</p>
    </blockquote>
    <p>
        <a name="requesting-all-scopes"></a>
    </p>
    <h3>Requesting All Scopes</h3>
    <p>When using the password grant, you may wish to authorize the token for all of the scopes supported by your application. You can do this by requesting the <code class=" language-php"><span class="token operator">*</span></code> scope. If you request the <code class=" language-php"><span class="token operator">*</span></code> scope, the <code class=" language-php">can</code> method on the token instance will always return <code class=" language-php"><span class="token boolean">true</span></code>. This scope may only be assigned to a token that is issued using the <code class=" language-php">password</code> grant:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$http</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'http://your-app.com/oauth/token'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'form_params'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'grant_type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'password'</span><span class="token punctuation">,</span>
        <span class="token string">'client_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-id'</span><span class="token punctuation">,</span>
        <span class="token string">'username'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'taylor@laravel.com'</span><span class="token punctuation">,</span>
        <span class="token string">'password'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'my-password'</span><span class="token punctuation">,</span>
        <span class="token string">'scope'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'*'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="personal-access-tokens"></a>
    </p>
    <h2><a href="#personal-access-tokens">Personal Access Tokens</a></h2>
    <p>Sometimes, your users may want to issue access tokens to themselves without going through the typical authorization code redirect flow. Allowing users to issue tokens to themselves via your application's UI can be useful for allowing users to experiment with your API or may serve as a simpler approach to issuing access tokens in general.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Personal access tokens are always long-lived. Their lifetime is not modified when using the <code class=" language-php">tokensExpireIn</code> or <code class=" language-php">refreshTokensExpireIn</code> methods.</p>
    </blockquote>
    <p>
        <a name="creating-a-personal-access-client"></a>
    </p>
    <h3>Creating A Personal Access Client</h3>
    <p>Before your application can issue personal access tokens, you will need to create a personal access client. You may do this using the <code class=" language-php">passport<span class="token punctuation">:</span>client</code> command with the <code class=" language-php"><span class="token operator">--</span>personal</code> option. If you have already run the <code class=" language-php">passport<span class="token punctuation">:</span>install</code> command, you do not need to run this command:</p>
    <pre class=" language-php"><code class=" language-php">php artisan passport<span class="token punctuation">:</span>client <span class="token operator">--</span>personal</code></pre>
    <p>
        <a name="managing-personal-access-tokens"></a>
    </p>
    <h3>Managing Personal Access Tokens</h3>
    <p>Once you have created a personal access client, you may issue tokens for a given user using the <code class=" language-php">createToken</code> method on the <code class=" language-php">User</code> model instance. The <code class=" language-php">createToken</code> method accepts the name of the token as its first argument and an optional array of <a href="#token-scopes">scopes</a> as its second argument:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Creating a token without scopes...
</span><span class="token variable">$token</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">createToken<span class="token punctuation">(</span></span><span class="token string">'Token Name'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">accessToken</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Creating a token with scopes...
</span><span class="token variable">$token</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">createToken<span class="token punctuation">(</span></span><span class="token string">'My Token'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'place-orders'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">accessToken</span><span class="token punctuation">;</span></code></pre>
    <h4>JSON API</h4>
    <p>Passport also includes a JSON API for managing personal access tokens. You may pair this with your own frontend to offer your users a dashboard for managing personal access tokens. Below, we'll review all of the API endpoints for managing personal access tokens. For convenience, we'll use <a href="https://vuejs.org">Vue</a> to demonstrate making HTTP requests to the endpoints.</p>
    <blockquote class="has-icon tip">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="56.6px" height="87.5px" viewBox="0 0 56.6 87.5" enable-background="new 0 0 56.6 87.5" xml:space="preserve"><path fill="#FFFFFF" d="M28.7 64.5c-1.4 0-2.5-1.1-2.5-2.5v-5.7 -5V41c0-1.4 1.1-2.5 2.5-2.5s2.5 1.1 2.5 2.5v10.1 5 5.8C31.2 63.4 30.1 64.5 28.7 64.5zM26.4 0.1C11.9 1 0.3 13.1 0 27.7c-0.1 7.9 3 15.2 8.2 20.4 0.5 0.5 0.8 1 1 1.7l3.1 13.1c0.3 1.1 1.3 1.9 2.4 1.9 0.3 0 0.7-0.1 1.1-0.2 1.1-0.5 1.6-1.8 1.4-3l-2-8.4 -0.4-1.8c-0.7-2.9-2-5.7-4-8 -1-1.2-2-2.5-2.7-3.9C5.8 35.3 4.7 30.3 5.4 25 6.7 14.5 15.2 6.3 25.6 5.1c13.9-1.5 25.8 9.4 25.8 23 0 4.1-1.1 7.9-2.9 11.2 -0.8 1.4-1.7 2.7-2.7 3.9 -2 2.3-3.3 5-4 8L41.4 53l-2 8.4c-0.3 1.2 0.3 2.5 1.4 3 0.3 0.2 0.7 0.2 1.1 0.2 1.1 0 2.2-0.8 2.4-1.9l3.1-13.1c0.2-0.6 0.5-1.2 1-1.7 5-5.1 8.2-12.1 8.2-19.8C56.4 12 42.8-1 26.4 0.1zM43.7 69.6c0 0.5-0.1 0.9-0.3 1.3 -0.4 0.8-0.7 1.6-0.9 2.5 -0.7 3-2 8.6-2 8.6 -1.3 3.2-4.4 5.5-7.9 5.5h-4.1H28h-0.5 -3.6c-3.5 0-6.7-2.4-7.9-5.7l-0.1-0.4 -1.8-7.8c-0.4-1.1-0.8-2.1-1.2-3.1 -0.1-0.3-0.2-0.5-0.2-0.9 0.1-1.3 1.3-2.1 2.6-2.1H41C42.4 67.5 43.6 68.2 43.7 69.6zM37.7 72.5H26.9c-4.2 0-7.2 3.9-6.3 7.9 0.6 1.3 1.8 2.1 3.2 2.1h4.1 0.5 0.5 3.6c1.4 0 2.7-0.8 3.2-2.1L37.7 72.5z"></path></svg></span>
            </div> If you don't want to implement the personal access token frontend yourself, you can use the <a href="#frontend-quickstart">frontend quickstart</a> to have a fully functional frontend in a matter of minutes.</p>
    </blockquote>
    <h4><code class=" language-php"><span class="token constant">GET</span> <span class="token operator">/</span>oauth<span class="token operator">/</span>scopes</code></h4>
    <p>This route returns all of the <a href="#token-scopes">scopes</a> defined for your application. You may use this route to list the scopes a user may assign to a personal access token:</p>
    <pre class=" language-php"><code class=" language-php">this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/oauth/scopes'</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span>response <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>response<span class="token punctuation">.</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4><code class=" language-php"><span class="token constant">GET</span> <span class="token operator">/</span>oauth<span class="token operator">/</span>personal<span class="token operator">-</span>access<span class="token operator">-</span>tokens</code></h4>
    <p>This route returns all of the personal access tokens that the authenticated user has created. This is primarily useful for listing all of the user's token so that they may edit or delete them:</p>
    <pre class=" language-php"><code class=" language-php">this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/oauth/personal-access-tokens'</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span>response <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>response<span class="token punctuation">.</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4><code class=" language-php"><span class="token constant">POST</span> <span class="token operator">/</span>oauth<span class="token operator">/</span>personal<span class="token operator">-</span>access<span class="token operator">-</span>tokens</code></h4>
    <p>This route creates new personal access tokens. It requires two pieces of data: the token's <code class=" language-php">name</code> and the <code class=" language-php">scopes</code> that should be assigned to the token:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">const</span> data <span class="token operator">=</span> <span class="token punctuation">{</span>
    name<span class="token punctuation">:</span> <span class="token string">'Token Name'</span><span class="token punctuation">,</span>
    scopes<span class="token punctuation">:</span> <span class="token punctuation">[</span><span class="token punctuation">]</span>
<span class="token punctuation">}</span><span class="token punctuation">;</span>

this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">post<span class="token punctuation">(</span></span><span class="token string">'/oauth/personal-access-tokens'</span><span class="token punctuation">,</span> data<span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span>response <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>response<span class="token punctuation">.</span>data<span class="token punctuation">.</span>accessToken<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token keyword">catch</span> <span class="token punctuation">(</span><span class="token class-name">response</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // List errors on response...
</span>    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4><code class=" language-php"><span class="token constant">DELETE</span> <span class="token operator">/</span>oauth<span class="token operator">/</span>personal<span class="token operator">-</span>access<span class="token operator">-</span>tokens<span class="token operator">/</span><span class="token punctuation">{</span>token<span class="token operator">-</span>id<span class="token punctuation">}</span></code></h4>
    <p>This route may be used to delete personal access tokens:</p>
    <pre class=" language-php"><code class=" language-php">this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">delete<span class="token punctuation">(</span></span><span class="token string">'/oauth/personal-access-tokens/'</span> <span class="token operator">+</span> tokenId<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="protecting-routes"></a>
    </p>
    <h2><a href="#protecting-routes">Protecting Routes</a></h2>
    <p>
        <a name="via-middleware"></a>
    </p>
    <h3>Via Middleware</h3>
    <p>Passport includes an <a href="/docs/5.3/authentication#adding-custom-guards">authentication guard</a> that will validate access tokens on incoming requests. Once you have configured the <code class=" language-php">api</code> guard to use the <code class=" language-php">passport</code> driver, you only need to specify the <code class=" language-php">auth<span class="token punctuation">:</span>api</code> middleware on any routes that require a valid access token:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/user'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'auth:api'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="passing-the-access-token"></a>
    </p>
    <h3>Passing The Access Token</h3>
    <p>When calling routes that are protected by Passport, your application's API consumers should specify their access token as a <code class=" language-php">Bearer</code> token in the <code class=" language-php">Authorization</code> header of their request. For example, when using the Guzzle HTTP library:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">request<span class="token punctuation">(</span></span><span class="token string">'GET'</span><span class="token punctuation">,</span> <span class="token string">'/api/user'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'headers'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
        <span class="token string">'Accept'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'application/json'</span><span class="token punctuation">,</span>
        <span class="token string">'Authorization'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Bearer '</span><span class="token punctuation">.</span><span class="token variable">$accessToken</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="token-scopes"></a>
    </p>
    <h2><a href="#token-scopes">Token Scopes</a></h2>
    <p>
        <a name="defining-scopes"></a>
    </p>
    <h3>Defining Scopes</h3>
    <p>Scopes allow your API clients to request a specific set of permissions when requesting authorization to access an account. For example, if you are building an e-commerce application, not all API consumers will need the ability to place orders. Instead, you may allow the consumers to only request authorization to access order shipment statuses. In other words, scopes allow your application's users to limit the actions a third-party application can perform on their behalf.</p>
    <p>You may define your API's scopes using the <code class=" language-php"><span class="token scope">Passport<span class="token punctuation">::</span></span>tokensCan</code> method in the <code class=" language-php">boot</code> method of your <code class=" language-php">AuthServiceProvider</code>. The <code class=" language-php">tokensCan</code> method accepts an array of scope names and scope descriptions. The scope description may be anything you wish and will be displayed to users on the authorization approval screen:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Passport<span class="token punctuation">\</span>Passport</span><span class="token punctuation">;</span>

<span class="token scope">Passport<span class="token punctuation">::</span></span><span class="token function">tokensCan<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
    <span class="token string">'place-orders'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Place orders'</span><span class="token punctuation">,</span>
    <span class="token string">'check-status'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Check order status'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="assigning-scopes-to-tokens"></a>
    </p>
    <h3>Assigning Scopes To Tokens</h3>
    <h4>When Requesting Authorization Codes</h4>
    <p>When requesting an access token using the authorization code grant, consumers should specify their desired scopes as the <code class=" language-php">scope</code> query string parameter. The <code class=" language-php">scope</code> parameter should be a space-delimited list of scopes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/redirect'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$query</span> <span class="token operator">=</span> <span class="token function">http_build_query<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
        <span class="token string">'client_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'client-id'</span><span class="token punctuation">,</span>
        <span class="token string">'redirect_uri'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'http://example.com/callback'</span><span class="token punctuation">,</span>
        <span class="token string">'response_type'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'code'</span><span class="token punctuation">,</span>
        <span class="token string">'scope'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'place-orders check-status'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'http://your-app.com/oauth/authorize?'</span><span class="token punctuation">.</span><span class="token variable">$query</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>When Issuing Personal Access Tokens</h4>
    <p>If you are issuing personal access tokens using the <code class=" language-php">User</code> model's <code class=" language-php">createToken</code> method, you may pass the array of desired scopes as the second argument to the method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$token</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">createToken<span class="token punctuation">(</span></span><span class="token string">'My Token'</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'place-orders'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token property">accessToken</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="checking-scopes"></a>
    </p>
    <h3>Checking Scopes</h3>
    <p>Passport includes two middleware that may be used to verify that an incoming request is authenticated with a token that has been granted a given scope. To get started, add the following middleware to the <code class=" language-php"><span class="token variable">$routeMiddleware</span></code> property of your <code class=" language-php">app<span class="token operator">/</span>Http<span class="token operator">/</span>Kernel<span class="token punctuation">.</span>php</code> file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'scopes'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> \<span class="token scope">Laravel<span class="token punctuation">\</span>Passport<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>CheckScopes<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
<span class="token string">'scope'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> \<span class="token scope">Laravel<span class="token punctuation">\</span>Passport<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>CheckForAnyScope<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span></code></pre>
    <h4>Check For All Scopes</h4>
    <p>The <code class=" language-php">scopes</code> middleware may be assigned to a route to verify that the incoming request's access token has <em>all</em> of the listed scopes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/orders'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Access token has both "check-status" and "place-orders" scopes...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'scopes:check-status,place-orders'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Check For Any Scopes</h4>
    <p>The <code class=" language-php">scope</code> middleware may be assigned to a route to verify that the incoming request's access token has <em>at least one</em> of the listed scopes:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/orders'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // Access token has either "check-status" or "place-orders" scope...
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">middleware<span class="token punctuation">(</span></span><span class="token string">'scope:check-status,place-orders'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Checking Scopes On A Token Instance</h4>
    <p>Once an access token authenticated request has entered your application, you may still check if the token has a given scope using the <code class=" language-php">tokenCan</code> method on the authenticated <code class=" language-php">User</code> instance:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/orders'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span>Request <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">tokenCan<span class="token punctuation">(</span></span><span class="token string">'place-orders'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> //
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="consuming-your-api-with-javascript"></a>
    </p>
    <h2><a href="#consuming-your-api-with-javascript">Consuming Your API With JavaScript</a></h2>
    <p>When building an API, it can be extremely useful to be able to consume your own API from your JavaScript application. This approach to API development allows your own application to consume the same API that you are sharing with the world. The same API may be consumed by your web application, mobile applications, third-party applications, and any SDKs that you may publish on various package managers.</p>
    <p>Typically, if you want to consume your API from your JavaScript application, you would need to manually send an access token to the application and pass it with each request to your application. However, Passport includes a middleware that can handle this for you. All you need to do is add the <code class=" language-php">CreateFreshApiToken</code> middleware to your <code class=" language-php">web</code> middleware group:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'web'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
   <span class="token comment" spellcheck="true"> // Other middleware...
</span>    \<span class="token scope">Laravel<span class="token punctuation">\</span>Passport<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Middleware<span class="token punctuation">\</span>CreateFreshApiToken<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>This Passport middleware will attach a <code class=" language-php">laravel_token</code> cookie to your outgoing responses. This cookie contains an encrypted JWT that Passport will use to authenticate API requests from your JavaScript application. Now, you may make requests to your application's API without explicitly passing an access token:</p>
    <pre class=" language-php"><code class=" language-php">this<span class="token punctuation">.</span><span class="token variable">$http</span><span class="token punctuation">.</span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'/user'</span><span class="token punctuation">)</span>
    <span class="token punctuation">.</span><span class="token function">then<span class="token punctuation">(</span></span>response <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
        console<span class="token punctuation">.</span><span class="token function">log<span class="token punctuation">(</span></span>response<span class="token punctuation">.</span>data<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>When using this method of authentication, you will need to send the CSRF token with every request via the <code class=" language-php">X<span class="token operator">-</span><span class="token constant">CSRF</span><span class="token operator">-</span><span class="token constant">TOKEN</span></code> header. Laravel will automatically send this header if you are using the default <a href="https://vuejs.org">Vue</a> configuration that is included with the framework:</p>
    <pre class=" language-php"><code class=" language-php">Vue<span class="token punctuation">.</span>http<span class="token punctuation">.</span>interceptors<span class="token punctuation">.</span><span class="token function">push<span class="token punctuation">(</span></span><span class="token punctuation">(</span>request<span class="token punctuation">,</span> next<span class="token punctuation">)</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">{</span>
    request<span class="token punctuation">.</span>headers<span class="token punctuation">.</span><span class="token function">set<span class="token punctuation">(</span></span><span class="token string">'X-CSRF-TOKEN'</span><span class="token punctuation">,</span> Laravel<span class="token punctuation">.</span>csrfToken<span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token function">next<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> If you are using a different JavaScript framework, you should make sure it is configured to send this header with every outgoing request.</p>
    </blockquote>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/passport">https://laravel.com/docs/5.3/passport</a></div>
</article>

@endsection