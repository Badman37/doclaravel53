@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Laravel Cashier</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#configuration">Configuration</a>
            <ul>
                <li><a href="#stripe-configuration">Stripe</a>
                </li>
                <li><a href="#braintree-configuration">Braintree</a>
                </li>
                <li><a href="#currency-configuration">Currency Configuration</a>
                </li>
            </ul>
        </li>
        <li><a href="#subscriptions">Subscriptions</a>
            <ul>
                <li><a href="#creating-subscriptions">Creating Subscriptions</a>
                </li>
                <li><a href="#checking-subscription-status">Checking Subscription Status</a>
                </li>
                <li><a href="#changing-plans">Changing Plans</a>
                </li>
                <li><a href="#subscription-quantity">Subscription Quantity</a>
                </li>
                <li><a href="#subscription-taxes">Subscription Taxes</a>
                </li>
                <li><a href="#cancelling-subscriptions">Cancelling Subscriptions</a>
                </li>
                <li><a href="#resuming-subscriptions">Resuming Subscriptions</a>
                </li>
                <li><a href="#updating-credit-cards">Updating Credit Cards</a>
                </li>
            </ul>
        </li>
        <li><a href="#subscription-trials">Subscription Trials</a>
            <ul>
                <li><a href="#with-credit-card-up-front">With Credit Card Up Front</a>
                </li>
                <li><a href="#without-credit-card-up-front">Without Credit Card Up Front</a>
                </li>
            </ul>
        </li>
        <li><a href="#handling-stripe-webhooks">Handling Stripe Webhooks</a>
            <ul>
                <li><a href="#defining-webhook-event-handlers">Defining Webhook Event Handlers</a>
                </li>
                <li><a href="#handling-failed-subscriptions">Failed Subscriptions</a>
                </li>
            </ul>
        </li>
        <li><a href="#handling-braintree-webhooks">Handling Braintree Webhooks</a>
            <ul>
                <li><a href="#defining-braintree-webhook-event-handlers">Defining Webhook Event Handlers</a>
                </li>
                <li><a href="#handling-braintree-failed-subscriptions">Failed Subscriptions</a>
                </li>
            </ul>
        </li>
        <li><a href="#single-charges">Single Charges</a>
        </li>
        <li><a href="#invoices">Invoices</a>
            <ul>
                <li><a href="#generating-invoice-pdfs">Generating Invoice PDFs</a>
                </li>
            </ul>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>Laravel Cashier provides an expressive, fluent interface to <a href="https://stripe.com">Stripe's</a> and <a href="https://braintreepayments.com">Braintree's</a> subscription billing services. It handles almost all of the boilerplate subscription billing code you are dreading writing. In addition to basic subscription management, Cashier can handle coupons, swapping subscription, subscription "quantities", cancellation grace periods, and even generate invoice PDFs.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> If you're only performing "one-off" charges and do not offer subscriptions. You should not use Cashier. You should use the Stripe and Braintree SDKs directly.</p>
    </blockquote>
    <p>
        <a name="configuration"></a>
    </p>
    <h2><a href="#configuration">Configuration</a></h2>
    <p>
        <a name="stripe-configuration"></a>
    </p>
    <h3>Stripe</h3>
    <h4>Composer</h4>
    <p>First, add the Cashier package for Stripe to your <code class=" language-php">composer<span class="token punctuation">.</span>json</code> file and run the <code class=" language-php">composer update</code> command:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">"laravel/cashier"</span><span class="token punctuation">:</span> <span class="token string">"~7.0"</span></code></pre>
    <h4>Service Provider</h4>
    <p>Next, register the <code class=" language-php">Laravel\<span class="token package">Cashier<span class="token punctuation">\</span>CashierServiceProvider</span></code> <a href="/docs/5.3/providers">service provider</a> in your <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> configuration file.</p>
    <h4>Database Migrations</h4>
    <p>Before using Cashier, we'll also need to <a href="/docs/5.3/migrations">prepare the database</a>. We need to add several columns to your <code class=" language-php">users</code> table and create a new <code class=" language-php">subscriptions</code> table to hold all of our customer's subscriptions:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Schema<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$table</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'stripe_id'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'card_brand'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'card_last_four'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamp<span class="token punctuation">(</span></span><span class="token string">'trial_ends_at'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Schema<span class="token punctuation">::</span></span><span class="token function">create<span class="token punctuation">(</span></span><span class="token string">'subscriptions'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$table</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">increments<span class="token punctuation">(</span></span><span class="token string">'id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">integer<span class="token punctuation">(</span></span><span class="token string">'user_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'stripe_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'stripe_plan'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">integer<span class="token punctuation">(</span></span><span class="token string">'quantity'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamp<span class="token punctuation">(</span></span><span class="token string">'trial_ends_at'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamp<span class="token punctuation">(</span></span><span class="token string">'ends_at'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamps<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Once the migrations have been created, run the <code class=" language-php">migrate</code> Artisan command.</p>
    <h4>Billable Model</h4>
    <p>Next, add the <code class=" language-php">Billable</code> trait to your model definition. This trait provides various methods to allow you to perform common billing tasks, such as creating subscriptions, applying coupons, and updating credit card information:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Cashier<span class="token punctuation">\</span>Billable</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Authenticatable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">Billable</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>API Keys</h4>
    <p>Finally, you should configure your Stripe key in your <code class=" language-php">services<span class="token punctuation">.</span>php</code> configuration file. You can retrieve your Stripe API keys from the Stripe control panel:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'stripe'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'model'</span>  <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token string">'secret'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'STRIPE_SECRET'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>
        <a name="braintree-configuration"></a>
    </p>
    <h3>Braintree</h3>
    <h4>Braintree Caveats</h4>
    <p>For many operations, the Stripe and Braintree implementations of Cashier function the same. Both services provide subscription billing with credit cards but Braintree also supports payments via PayPal. However, Braintree also lacks some features that are supported by Stripe. You should keep the following in mind when deciding to use Stripe or Braintree:</p>
    <div class="content-list">
        <ul>
            <li>Braintree supports PayPal while Stripe does not.</li>
            <li>Braintree does not support the <code class=" language-php">increment</code> and <code class=" language-php">decrement</code> methods on subscriptions. This is a Braintree limitation, not a Cashier limitation.</li>
            <li>Braintree does not support percentage based discounts. This is a Braintree limitation, not a Cashier limitation.</li>
        </ul>
    </div>
    <h4>Composer</h4>
    <p>First, add the Cashier package for Braintree to your <code class=" language-php">composer<span class="token punctuation">.</span>json</code> file and run the <code class=" language-php">composer update</code> command:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">"laravel/cashier-braintree"</span><span class="token punctuation">:</span> <span class="token string">"~2.0"</span></code></pre>
    <h4>Service Provider</h4>
    <p>Next, register the <code class=" language-php">Laravel\<span class="token package">Cashier<span class="token punctuation">\</span>CashierServiceProvider</span></code> <a href="/docs/5.3/providers">service provider</a> in your <code class=" language-php">config<span class="token operator">/</span>app<span class="token punctuation">.</span>php</code> configuration file.</p>
    <h4>Plan Credit Coupon</h4>
    <p>Before using Cashier with Braintree, you will need to define a <code class=" language-php">plan<span class="token operator">-</span>credit</code> discount in your Braintree control panel. This discount will be used to properly prorate subscriptions that change from yearly to monthly billing, or from monthly to yearly billing.</p>
    <p>The discount amount configured in the Braintree control panel can be any value you wish, as Cashier will simply override the defined amount with our own custom amount each time we apply the coupon. This coupon is needed since Braintree does not natively support prorating subscriptions across subscription frequencies.</p>
    <h4>Database Migrations</h4>
    <p>Before using Cashier, we'll need to <a href="/docs/5.3/migrations">prepare the database</a>. We need to add several columns to your <code class=" language-php">users</code> table and create a new <code class=" language-php">subscriptions</code> table to hold all of our customer's subscriptions:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Schema<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token string">'users'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$table</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'braintree_id'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'paypal_email'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'card_brand'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'card_last_four'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamp<span class="token punctuation">(</span></span><span class="token string">'trial_ends_at'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token scope">Schema<span class="token punctuation">::</span></span><span class="token function">create<span class="token punctuation">(</span></span><span class="token string">'subscriptions'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token variable">$table</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">increments<span class="token punctuation">(</span></span><span class="token string">'id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">integer<span class="token punctuation">(</span></span><span class="token string">'user_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'name'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'braintree_id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">string<span class="token punctuation">(</span></span><span class="token string">'braintree_plan'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">integer<span class="token punctuation">(</span></span><span class="token string">'quantity'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamp<span class="token punctuation">(</span></span><span class="token string">'trial_ends_at'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamp<span class="token punctuation">(</span></span><span class="token string">'ends_at'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">nullable<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token variable">$table</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timestamps<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Once the migrations have been created, simply run the <code class=" language-php">migrate</code> Artisan command.</p>
    <h4>Billable Model</h4>
    <p>Next, add the <code class=" language-php">Billable</code> trait to your model definition:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Cashier<span class="token punctuation">\</span>Billable</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">User</span> <span class="token keyword">extends</span> <span class="token class-name">Authenticatable</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">Billable</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <h4>API Keys</h4>
    <p>Next, You should configure the following options in your <code class=" language-php">services<span class="token punctuation">.</span>php</code> file:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token string">'braintree'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token punctuation">[</span>
    <span class="token string">'model'</span>  <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token string">'environment'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'BRAINTREE_ENV'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token string">'merchant_id'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'BRAINTREE_MERCHANT_ID'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token string">'public_key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'BRAINTREE_PUBLIC_KEY'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token string">'private_key'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token function">env<span class="token punctuation">(</span></span><span class="token string">'BRAINTREE_PRIVATE_KEY'</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span></code></pre>
    <p>Then you should add the following Braintree SDK calls to your <code class=" language-php">AppServiceProvider</code> service provider's <code class=" language-php">boot</code> method:</p>
    <pre class=" language-php"><code class=" language-php">\<span class="token scope">Braintree_Configuration<span class="token punctuation">::</span></span><span class="token function">environment<span class="token punctuation">(</span></span><span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'services.braintree.environment'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
\<span class="token scope">Braintree_Configuration<span class="token punctuation">::</span></span><span class="token function">merchantId<span class="token punctuation">(</span></span><span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'services.braintree.merchant_id'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
\<span class="token scope">Braintree_Configuration<span class="token punctuation">::</span></span><span class="token function">publicKey<span class="token punctuation">(</span></span><span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'services.braintree.public_key'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
\<span class="token scope">Braintree_Configuration<span class="token punctuation">::</span></span><span class="token function">privateKey<span class="token punctuation">(</span></span><span class="token function">config<span class="token punctuation">(</span></span><span class="token string">'services.braintree.private_key'</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="currency-configuration"></a>
    </p>
    <h3>Currency Configuration</h3>
    <p>The default Cashier currency is United States Dollars (USD). You can change the default currency by calling the <code class=" language-php"><span class="token scope">Cashier<span class="token punctuation">::</span></span>useCurrency</code> method from within the <code class=" language-php">boot</code> method of one of your service providers. The <code class=" language-php">useCurrency</code> method accepts two string parameters: the currency and the currency's symbol:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Cashier<span class="token punctuation">\</span>Cashier</span><span class="token punctuation">;</span>

<span class="token scope">Cashier<span class="token punctuation">::</span></span><span class="token function">useCurrency<span class="token punctuation">(</span></span><span class="token string">'eur'</span><span class="token punctuation">,</span> <span class="token string">'€'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="subscriptions"></a>
    </p>
    <h2><a href="#subscriptions">Subscriptions</a></h2>
    <p>
        <a name="creating-subscriptions"></a>
    </p>
    <h3>Creating Subscriptions</h3>
    <p>To create a subscription, first retrieve an instance of your billable model, which typically will be an instance of <code class=" language-php">App\<span class="token package">User</span></code>. Once you have retrieved the model instance, you may use the <code class=" language-php">newSubscription</code> method to create the model's subscription:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">newSubscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">,</span> <span class="token string">'monthly'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token variable">$creditCardToken</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The first argument passed to the <code class=" language-php">newSubscription</code> method should be the name of the subscription. If your application only offers a single subscription, you might call this <code class=" language-php">main</code> or <code class=" language-php">primary</code>. The second argument is the specific Stripe / Braintree plan the user is subscribing to. This value should correspond to the plan's identifier in Stripe or Braintree.</p>
    <p>The <code class=" language-php">create</code> method will begin the subscription as well as update your database with the customer ID and other relevant billing information.</p>
    <h4>Additional User Details</h4>
    <p>If you would like to specify additional customer details, you may do so by passing them as the second argument to the <code class=" language-php">create</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">newSubscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">,</span> <span class="token string">'monthly'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token variable">$creditCardToken</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'email'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$email</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>To learn more about the additional fields supported by Stripe or Braintree, check out Stripe's <a href="https://stripe.com/docs/api#create_customer">documentation on customer creation</a> or the corresponding <a href="https://developers.braintreepayments.com/reference/request/customer/create/php">Braintree documentation</a>.</p>
    <h4>Coupons</h4>
    <p>If you would like to apply a coupon when creating the subscription, you may use the <code class=" language-php">withCoupon</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">newSubscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">,</span> <span class="token string">'monthly'</span><span class="token punctuation">)</span>
     <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withCoupon<span class="token punctuation">(</span></span><span class="token string">'code'</span><span class="token punctuation">)</span>
     <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token variable">$creditCardToken</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="checking-subscription-status"></a>
    </p>
    <h3>Checking Subscription Status</h3>
    <p>Once a user is subscribed to your application, you may easily check their subscription status using a variety of convenient methods. First, the <code class=" language-php">subscribed</code> method returns <code class=" language-php"><span class="token boolean">true</span></code> if the user has an active subscription, even if the subscription is currently within its trial period:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscribed<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>The <code class=" language-php">subscribed</code> method also makes a great candidate for a <a href="/docs/5.3/middleware">route middleware</a>, allowing you to filter access to routes and controllers based on the user's subscription status:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handle<span class="token punctuation">(</span></span><span class="token variable">$request</span><span class="token punctuation">,</span> Closure <span class="token variable">$next</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
    <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token operator">&amp;&amp;</span> <span class="token operator">!</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscribed<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // This user is not a paying customer...
</span>        <span class="token keyword">return</span> <span class="token function">redirect<span class="token punctuation">(</span></span><span class="token string">'billing'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>If you would like to determine if a user is still within their trial period, you may use the <code class=" language-php">onTrial</code> method. This method can be useful for displaying a warning to the user that they are still on their trial period:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onTrial<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>The <code class=" language-php">subscribedToPlan</code> method may be used to determine if the user is subscribed to a given plan based on a given Stripe / Braintree plan ID. In this example, we will determine if the user's <code class=" language-php">main</code> subscription is actively subscribed to the <code class=" language-php">monthly</code> plan:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscribedToPlan<span class="token punctuation">(</span></span><span class="token string">'monthly'</span><span class="token punctuation">,</span> <span class="token string">'main'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h4>Cancelled Subscription Status</h4>
    <p>To determine if the user was once an active subscriber, but has cancelled their subscription, you may use the <code class=" language-php">cancelled</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cancelled<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>You may also determine if a user has cancelled their subscription, but are still on their "grace period" until the subscription fully expires. For example, if a user cancels a subscription on March 5th that was originally scheduled to expire on March 10th, the user is on their "grace period" until March 10th. Note that the <code class=" language-php">subscribed</code> method still returns <code class=" language-php"><span class="token boolean">true</span></code> during this time:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onGracePeriod<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="changing-plans"></a>
    </p>
    <h3>Changing Plans</h3>
    <p>After a user is subscribed to your application, they may occasionally want to change to a new subscription plan. To swap a user to a new subscription, pass the plan's identifier to the <code class=" language-php">swap</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">App<span class="token punctuation">\</span>User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">swap<span class="token punctuation">(</span></span><span class="token string">'provider-plan-id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If the user is on trial, the trial period will be maintained. Also, if a "quantity" exists for the subscription, that quantity will also be maintained.</p>
    <p>If you would like to swap plans and cancel any trial period the user is currently on, you may use the <code class=" language-php">skipTrial</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span>
        <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">skipTrial<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
        <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">swap<span class="token punctuation">(</span></span><span class="token string">'provider-plan-id'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="subscription-quantity"></a>
    </p>
    <h3>Subscription Quantity</h3>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Subscription quantities are only supported by the Stripe edition of Cashier. Braintree does not have a feature that corresponds to Stripe's "quantity".</p>
    </blockquote>
    <p>Sometimes subscriptions are affected by "quantity". For example, your application might charge $10 per month <strong>per user</strong> on an account. To easily increment or decrement your subscription quantity, use the <code class=" language-php">incrementQuantity</code> and <code class=" language-php">decrementQuantity</code> methods:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">incrementQuantity<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Add five to the subscription's current quantity...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">incrementQuantity<span class="token punctuation">(</span></span><span class="token number">5</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">decrementQuantity<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Subtract five to the subscription's current quantity...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">decrementQuantity<span class="token punctuation">(</span></span><span class="token number">5</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Alternatively, you may set a specific quantity using the <code class=" language-php">updateQuantity</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">updateQuantity<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>For more information on subscription quantities, consult the <a href="https://stripe.com/docs/guides/subscriptions#setting-quantities">Stripe documentation</a>.</p>
    <p>
        <a name="subscription-taxes"></a>
    </p>
    <h3>Subscription Taxes</h3>
    <p>To specify the tax percentage a user pays on a subscription, implement the <code class=" language-php">taxPercentage</code> method on your billable model, and return a numeric value between 0 and 100, with no more than 2 decimal places.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">taxPercentage<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token number">20</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
    <p>The <code class=" language-php">taxPercentage</code> method enables you to apply a tax rate on a model-by-model basis, which may be helpful for a user base that spans multiple countries and tax rates.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> The <code class=" language-php">taxPercentage</code> method only applies to subscription charges. If you use Cashier to make "one off" charges, you will need to manually specify the tax rate at that time.</p>
    </blockquote>
    <p>
        <a name="cancelling-subscriptions"></a>
    </p>
    <h3>Cancelling Subscriptions</h3>
    <p>To cancel a subscription, simply call the <code class=" language-php">cancel</code> method on the user's subscription:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cancel<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>When a subscription is cancelled, Cashier will automatically set the <code class=" language-php">ends_at</code> column in your database. This column is used to know when the <code class=" language-php">subscribed</code> method should begin returning <code class=" language-php"><span class="token boolean">false</span></code>. For example, if a customer cancels a subscription on March 1st, but the subscription was not scheduled to end until March 5th, the <code class=" language-php">subscribed</code> method will continue to return <code class=" language-php"><span class="token boolean">true</span></code> until March 5th.</p>
    <p>You may determine if a user has cancelled their subscription but are still on their "grace period" using the <code class=" language-php">onGracePeriod</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onGracePeriod<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>If you wish to cancel a subscription immediately, call the <code class=" language-php">cancelNow</code> method on the user's subscription:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cancelNow<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="resuming-subscriptions"></a>
    </p>
    <h3>Resuming Subscriptions</h3>
    <p>If a user has cancelled their subscription and you wish to resume it, use the <code class=" language-php">resume</code> method. The user <strong>must</strong> still be on their grace period in order to resume a subscription:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">resume<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If the user cancels a subscription and then resumes that subscription before the subscription has fully expired, they will not be billed immediately. Instead, their subscription will simply be re-activated, and they will be billed on the original billing cycle.</p>
    <p>
        <a name="updating-credit-cards"></a>
    </p>
    <h3>Updating Credit Cards</h3>
    <p>The <code class=" language-php">updateCard</code> method may be used to update a customer's credit card information. This method accepts a Stripe token and will assign the new credit card as the default billing source:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">updateCard<span class="token punctuation">(</span></span><span class="token variable">$creditCardToken</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="subscription-trials"></a>
    </p>
    <h2><a href="#subscription-trials">Subscription Trials</a></h2>
    <p>
        <a name="with-credit-card-up-front"></a>
    </p>
    <h3>With Credit Card Up Front</h3>
    <p>If you would like to offer trial periods to your customers while still collecting payment method information up front, You should use the <code class=" language-php">trialDays</code> method when creating your subscriptions:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">newSubscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">,</span> <span class="token string">'monthly'</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">trialDays<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span>
            <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token variable">$creditCardToken</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>This method will set the trial period ending date on the subscription record within the database, as well as instruct Stripe / Braintree to not begin billing the customer until after this date.</p>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> If the customer's subscription is not cancelled before the trial ending date they will be charged as soon as the trial expires, so you should be sure to notify your users of their trial ending date.</p>
    </blockquote>
    <p>You may determine if the user is within their trial period using either the <code class=" language-php">onTrial</code> method of the user instance, or the <code class=" language-php">onTrial</code> method of the subscription instance. The two examples below are identical:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onTrial<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">subscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onTrial<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <p>
        <a name="without-credit-card-up-front"></a>
    </p>
    <h3>Without Credit Card Up Front</h3>
    <p>If you would like to offer trial periods without collecting the user's payment method information up front, you may simply set the <code class=" language-php">trial_ends_at</code> column on the user record to your desired trial ending date. This is typically done during user registration:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">create<span class="token punctuation">(</span></span><span class="token punctuation">[</span>
   <span class="token comment" spellcheck="true"> // Populate other user properties...
</span>    <span class="token string">'trial_ends_at'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token scope">Carbon<span class="token punctuation">::</span></span><span class="token function">now<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">addDays<span class="token punctuation">(</span></span><span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Be sure to add a <a href="/docs/5.3/eloquent-mutators#date-mutators">date mutator</a> for <code class=" language-php">trial_ends_at</code> to your model definition.</p>
    </blockquote>
    <p>Cashier refers to this type of trial as a "generic trial", since it is not attached to any existing subscription. The <code class=" language-php">onTrial</code> method on the <code class=" language-php">User</code> instance will return <code class=" language-php"><span class="token boolean">true</span></code> if the current date is not past the value of <code class=" language-php">trial_ends_at</code>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onTrial<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // User is within their trial period...
</span><span class="token punctuation">}</span></code></pre>
    <p>You may also use the <code class=" language-php">onGenericTrial</code> method if you wish to know specifically that the user is within their "generic" trial period and has not created an actual subscription yet:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">onGenericTrial<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> // User is within their "generic" trial period...
</span><span class="token punctuation">}</span></code></pre>
    <p>Once you are ready to create an actual subscription for the user, you may use the <code class=" language-php">newSubscription</code> method as usual:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span> <span class="token operator">=</span> <span class="token scope">User<span class="token punctuation">::</span></span><span class="token function">find<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">newSubscription<span class="token punctuation">(</span></span><span class="token string">'main'</span><span class="token punctuation">,</span> <span class="token string">'monthly'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">create<span class="token punctuation">(</span></span><span class="token variable">$creditCardToken</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="handling-stripe-webhooks"></a>
    </p>
    <h2><a href="#handling-stripe-webhooks">Handling Stripe Webhooks</a></h2>
    <p>Both Stripe and Braintree can notify your application of a variety of events via webhooks. To handle Stripe webhooks, define a route that points to Cashier's webhook controller. This controller will handle all incoming webhook requests and dispatch them to the proper controller method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span>
    <span class="token string">'stripe/webhook'</span><span class="token punctuation">,</span>
    <span class="token string">'\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Once you have registered your route, be sure to configure the webhook URL in your Stripe control panel settings.</p>
    </blockquote>
    <p>By default, this controller will automatically handle cancelling subscriptions that have too many failed charges (as defined by your Stripe settings); however, as we'll soon discover, you can extend this controller to handle any webhook event you like.</p>
    <h4>Webhooks &amp; CSRF Protection</h4>
    <p>Since Stripe webhooks need to bypass Laravel's <a href="/docs/5.3/routing#csrf-protection">CSRF protection</a>, be sure to list the URI as an exception in your <code class=" language-php">VerifyCsrfToken</code> middleware or list the route outside of the <code class=" language-php">web</code> middleware group:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">protected</span> <span class="token variable">$except</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'stripe/*'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="defining-webhook-event-handlers"></a>
    </p>
    <h3>Defining Webhook Event Handlers</h3>
    <p>Cashier automatically handles subscription cancellation on failed charges, but if you have additional Stripe webhook events you would like to handle, simply extend the Webhook controller. Your method names should correspond to Cashier's expected convention, specifically, methods should be prefixed with <code class=" language-php">handle</code> and the "camel case" name of the Stripe webhook you wish to handle. For example, if you wish to handle the <code class=" language-php">invoice<span class="token punctuation">.</span>payment_succeeded</code> webhook, you should add a <code class=" language-php">handleInvoicePaymentSucceeded</code> method to the controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Cashier<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>WebhookController</span> <span class="token keyword">as</span> CashierController<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">WebhookController</span> <span class="token keyword">extends</span> <span class="token class-name">CashierController</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Handle a Stripe webhook.
     *
     * @param  array  $payload
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handleInvoicePaymentSucceeded<span class="token punctuation">(</span></span><span class="token variable">$payload</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Handle The Event
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="handling-failed-subscriptions"></a>
    </p>
    <h3>Failed Subscriptions</h3>
    <p>What if a customer's credit card expires? No worries - the Cashier webhook controller that can easily cancel the customer's subscription for you. As noted above, all you need to do is point a route to the controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span>
    <span class="token string">'stripe/webhook'</span><span class="token punctuation">,</span>
    <span class="token string">'\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>That's it! Failed payments will be captured and handled by the controller. The controller will cancel the customer's subscription when Stripe determines the subscription has failed (normally after three failed payment attempts).</p>
    <p>
        <a name="handling-braintree-webhooks"></a>
    </p>
    <h2><a href="#handling-braintree-webhooks">Handling Braintree Webhooks</a></h2>
    <p>Both Stripe and Braintree can notify your application of a variety of events via webhooks. To handle Braintree webhooks, define a route that points to Cashier's webhook controller. This controller will handle all incoming webhook requests and dispatch them to the proper controller method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span>
    <span class="token string">'braintree/webhook'</span><span class="token punctuation">,</span>
    <span class="token string">'\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> Once you have registered your route, be sure to configure the webhook URL in your Braintree control panel settings.</p>
    </blockquote>
    <p>By default, this controller will automatically handle cancelling subscriptions that have too many failed charges (as defined by your Braintree settings); however, as we'll soon discover, you can extend this controller to handle any webhook event you like.</p>
    <h4>Webhooks &amp; CSRF Protection</h4>
    <p>Since Braintree webhooks need to bypass Laravel's <a href="/docs/5.3/routing#csrf-protection">CSRF protection</a>, be sure to list the URI as an exception in your <code class=" language-php">VerifyCsrfToken</code> middleware or list the route outside of the <code class=" language-php">web</code> middleware group:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">protected</span> <span class="token variable">$except</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string">'braintree/*'</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="defining-braintree-webhook-event-handlers"></a>
    </p>
    <h3>Defining Webhook Event Handlers</h3>
    <p>Cashier automatically handles subscription cancellation on failed charges, but if you have additional Braintree webhook events you would like to handle, simply extend the Webhook controller. Your method names should correspond to Cashier's expected convention, specifically, methods should be prefixed with <code class=" language-php">handle</code> and the "camel case" name of the Braintree webhook you wish to handle. For example, if you wish to handle the <code class=" language-php">dispute_opened</code> webhook, you should add a <code class=" language-php">handleDisputeOpened</code> method to the controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Braintree<span class="token punctuation">\</span>WebhookNotification</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Laravel<span class="token punctuation">\</span>Cashier<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Controllers<span class="token punctuation">\</span>WebhookController</span> <span class="token keyword">as</span> CashierController<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">WebhookController</span> <span class="token keyword">extends</span> <span class="token class-name">CashierController</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * Handle a Braintree webhook.
     *
     * @param  WebhookNotification  $webhook
     * @return Response
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function">handleDisputeOpened<span class="token punctuation">(</span></span>WebhookNotification <span class="token variable">$notification</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
       <span class="token comment" spellcheck="true"> // Handle The Event
</span>    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>
        <a name="handling-braintree-failed-subscriptions"></a>
    </p>
    <h3>Failed Subscriptions</h3>
    <p>What if a customer's credit card expires? No worries - Cashier includes a Webhook controller that can easily cancel the customer's subscription for you. Just point a route to the controller:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">post<span class="token punctuation">(</span></span>
    <span class="token string">'braintree/webhook'</span><span class="token punctuation">,</span>
    <span class="token string">'\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook'</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>That's it! Failed payments will be captured and handled by the controller. The controller will cancel the customer's subscription when Braintree determines the subscription has failed (normally after three failed payment attempts). Don't forget: you will need to configure the webhook URI in your Braintree control panel settings.</p>
    <p>
        <a name="single-charges"></a>
    </p>
    <h2><a href="#single-charges">Single Charges</a></h2>
    <h3>Simple Charge</h3>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> When using Stripe, the <code class=" language-php">charge</code> method accepts the amount you would like to charge in the <strong>lowest denominator of the currency used by your application</strong>. However, when using Braintree, you should pass the full dollar amount to the <code class=" language-php">charge</code> method:</p>
    </blockquote>
    <p>If you would like to make a "one off" charge against a subscribed customer's credit card, you may use the <code class=" language-php">charge</code> method on a billable model instance.</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Stripe Accepts Charges In Cents...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">charge<span class="token punctuation">(</span></span><span class="token number">100</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Braintree Accepts Charges In Dollars...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">charge<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">charge</code> method accepts an array as its second argument, allowing you to pass any options you wish to the underlying Stripe / Braintree charge creation. Consult the Stripe or Braintree documentation regarding the options available to you when creating charges:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">charge<span class="token punctuation">(</span></span><span class="token number">100</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'custom_option'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$value</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">charge</code> method will throw an exception if the charge fails. If the charge is successful, the full Stripe / Braintree response will be returned from the method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">try</span> <span class="token punctuation">{</span>
    <span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">charge<span class="token punctuation">(</span></span><span class="token number">100</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span> <span class="token keyword">catch</span> <span class="token punctuation">(</span><span class="token class-name">Exception</span> <span class="token variable">$e</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span></code></pre>
    <h3>Charge With Invoice</h3>
    <p>Sometimes you may need to make a one-time charge but also generate an invoice for the charge so that you may offer a PDF receipt to your customer. The <code class=" language-php">invoiceFor</code> method lets you do just that. For example, let's invoice the customer $5.00 for a "One Time Fee":</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Stripe Accepts Charges In Cents...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">invoiceFor<span class="token punctuation">(</span></span><span class="token string">'One Time Fee'</span><span class="token punctuation">,</span> <span class="token number">500</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Braintree Accepts Charges In Dollars...
</span><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">invoiceFor<span class="token punctuation">(</span></span><span class="token string">'One Time Fee'</span><span class="token punctuation">,</span> <span class="token number">5</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The invoice will be charged immediately against the user's credit card. The <code class=" language-php">invoiceFor</code> method also accepts an array as its third argument, allowing you to pass any options you wish to the underlying Stripe / Braintree charge creation:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">invoiceFor<span class="token punctuation">(</span></span><span class="token string">'One Time Fee'</span><span class="token punctuation">,</span> <span class="token number">500</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string">'custom-option'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$value</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> The <code class=" language-php">invoiceFor</code> method will create a Stripe invoice which will retry failed billing attempts. If you do not want invoices to retry failed charges, you will need to close them using the Stripe API after the first failed charge.</p>
    </blockquote>
    <p>
        <a name="invoices"></a>
    </p>
    <h2><a href="#invoices">Invoices</a></h2>
    <p>You may easily retrieve an array of a billable model's invoices using the <code class=" language-php">invoices</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$invoices</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">invoices<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Include pending invoices in the results...
</span><span class="token variable">$invoices</span> <span class="token operator">=</span> <span class="token variable">$user</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">invoicesIncludingPending<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>When listing the invoices for the customer, you may use the invoice's helper methods to display the relevant invoice information. For example, you may wish to list every invoice in a table, allowing the user to easily download any of them:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>table</span><span class="token punctuation">&gt;</span></span></span>
    @<span class="token keyword">foreach</span> <span class="token punctuation">(</span><span class="token variable">$invoices</span> <span class="token keyword">as</span> <span class="token variable">$invoice</span><span class="token punctuation">)</span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span></span>
            <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span></span><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$invoice</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">date<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">toFormattedDateString<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span></span>
            <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span></span><span class="token punctuation">{</span><span class="token punctuation">{</span> <span class="token variable">$invoice</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">total<span class="token punctuation">(</span></span><span class="token punctuation">)</span> <span class="token punctuation">}</span><span class="token punctuation">}</span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span></span>
            <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span></span><span class="token markup">&lt;a href="/user/invoice/{{ $invoice-&gt;</span>id <span class="token punctuation">}</span><span class="token punctuation">}</span>"<span class="token operator">&gt;</span>Download<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>a</span><span class="token punctuation">&gt;</span></span></span><span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span></span>
        <span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span></span>
    @<span class="token keyword">endforeach</span>
<span class="token markup"><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>table</span><span class="token punctuation">&gt;</span></span></span></code></pre>
    <p>
        <a name="generating-invoice-pdfs"></a>
    </p>
    <h3>Generating Invoice PDFs</h3>
    <p>Before generating invoice PDFs, you need to install the <code class=" language-php">dompdf</code> PHP library:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> dompdf<span class="token operator">/</span>dompdf</code></pre>
    <p>Then, from within a route or controller, use the <code class=" language-php">downloadInvoice</code> method to generate a PDF download of the invoice. This method will automatically generate the proper HTTP response to send the download to the browser:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Http<span class="token punctuation">\</span>Request</span><span class="token punctuation">;</span>

<span class="token scope">Route<span class="token punctuation">::</span></span><span class="token function">get<span class="token punctuation">(</span></span><span class="token string">'user/invoice/{invoice}'</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span>Request <span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token variable">$invoiceId</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$request</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">user<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">downloadInvoice<span class="token punctuation">(</span></span><span class="token variable">$invoiceId</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
        <span class="token string">'vendor'</span>  <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Your Company'</span><span class="token punctuation">,</span>
        <span class="token string">'product'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token string">'Your Product'</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
<div>Nguồn: <a href="https://laravel.com/docs/5.3/billing">https://laravel.com/docs/5.3/billing</a></div>
</article>
@endsection