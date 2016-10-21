@extends('documents.laravel53.layout')

@section('content')
<article>
    <h1>Task Scheduling</h1>
    <ul>
        <li><a href="#introduction">Introduction</a>
        </li>
        <li><a href="#defining-schedules">Defining Schedules</a>
            <ul>
                <li><a href="#schedule-frequency-options">Schedule Frequency Options</a>
                </li>
                <li><a href="#preventing-task-overlaps">Preventing Task Overlaps</a>
                </li>
            </ul>
        </li>
        <li><a href="#task-output">Task Output</a>
        </li>
        <li><a href="#task-hooks">Task Hooks</a>
        </li>
    </ul>
    <p>
        <a name="introduction"></a>
    </p>
    <h2><a href="#introduction">Introduction</a></h2>
    <p>In the past, you may have generated a Cron entry for each task you needed to schedule on your server. However, this can quickly become a pain, because your task schedule is no longer in source control and you must SSH into your server to add additional Cron entries.</p>
    <p>Laravel's command scheduler allows you to fluently and expressively define your command schedule within Laravel itself. When using the scheduler, only a single Cron entry is needed on your server. Your task schedule is defined in the <code class=" language-php">app<span class="token operator">/</span>Console<span class="token operator">/</span>Kernel<span class="token punctuation">.</span>php</code> file's <code class=" language-php">schedule</code> method. To help you get started, a simple example is defined within the method.</p>
    <h3>Starting The Scheduler</h3>
    <p>When using the scheduler, you only need to add the following Cron entry to your server. If you do not know how to add Cron entries to your server, consider using a service such as <a href="https://forge.laravel.com">Laravel Forge</a> which can manage the Cron entries for you:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token operator">*</span> <span class="token operator">*</span> <span class="token operator">*</span> <span class="token operator">*</span> <span class="token operator">*</span> php <span class="token operator">/</span>path<span class="token operator">/</span>to<span class="token operator">/</span>artisan schedule<span class="token punctuation">:</span>run <span class="token operator">&gt;</span><span class="token operator">&gt;</span> <span class="token operator">/</span>dev<span class="token operator">/</span><span class="token keyword">null</span> <span class="token number">2</span><span class="token operator">&gt;</span><span class="token operator">&amp;</span><span class="token number">1</span></code></pre>
    <p>This Cron will call the Laravel command scheduler every minute. When the <code class=" language-php">schedule<span class="token punctuation">:</span>run</code> command is executed, Laravel will evaluate your scheduled tasks and runs the tasks that are due.</p>
    <p>
        <a name="defining-schedules"></a>
    </p>
    <h2><a href="#defining-schedules">Defining Schedules</a></h2>
    <p>You may define all of your scheduled tasks in the <code class=" language-php">schedule</code> method of the <code class=" language-php">App\<span class="token package">Console<span class="token punctuation">\</span>Kernel</span></code> class. To get started, let's look at an example of scheduling a task. In this example, we will schedule a <code class=" language-php">Closure</code> to be called every day at midnight. Within the <code class=" language-php">Closure</code> we will execute a database query to clear a table:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token delimiter">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\</span>Console</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">DB</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Console<span class="token punctuation">\</span>Scheduling<span class="token punctuation">\</span>Schedule</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\</span>Foundation<span class="token punctuation">\</span>Console<span class="token punctuation">\</span>Kernel</span> <span class="token keyword">as</span> ConsoleKernel<span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name">Kernel</span> <span class="token keyword">extends</span> <span class="token class-name">ConsoleKernel</span>
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">/**
     * The Artisan commands provided by your application.
     *
     * @var array
     */</span>
    <span class="token keyword">protected</span> <span class="token variable">$commands</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
        \<span class="token scope">App<span class="token punctuation">\</span>Console<span class="token punctuation">\</span>Commands<span class="token punctuation">\</span>Inspire<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">/**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */</span>
    <span class="token keyword">protected</span> <span class="token keyword">function</span> <span class="token function">schedule<span class="token punctuation">(</span></span>Schedule <span class="token variable">$schedule</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">call<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token scope">DB<span class="token punctuation">::</span></span><span class="token function">table<span class="token punctuation">(</span></span><span class="token string">'recent_users'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">delete<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span></code></pre>
    <p>In addition to scheduling <code class=" language-php">Closure</code> calls, you may also schedule <a href="/docs/5.3/artisan">Artisan commands</a> and operating system commands. For example, you may use the <code class=" language-php">command</code> method to schedule an Artisan command using either the command's name or class:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'emails:send --force'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token scope">EmailsCommand<span class="token punctuation">::</span></span><span class="token keyword">class</span><span class="token punctuation">,</span> <span class="token punctuation">[</span><span class="token string">'--force'</span><span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">exec</code> command may be used to issue a command to the operating system:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">exec<span class="token punctuation">(</span></span><span class="token string">'node /home/forge/script.js'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>
        <a name="schedule-frequency-options"></a>
    </p>
    <h3>Schedule Frequency Options</h3>
    <p>Of course, there are a variety of schedules you may assign to your task:</p>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">cron<span class="token punctuation">(</span></span><span class="token string">'* * * * * *'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task on a custom Cron schedule</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">everyMinute<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every minute</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">everyFiveMinutes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every five minutes</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">everyTenMinutes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every ten minutes</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">everyThirtyMinutes<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every thirty minutes</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hourly<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every hour</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every day at midnight</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">dailyAt<span class="token punctuation">(</span></span><span class="token string">'13:00'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every day at 13:00</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">twiceDaily<span class="token punctuation">(</span></span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">13</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task daily at 1:00 &amp; 13:00</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">weekly<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every week</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">monthly<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every month</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">monthlyOn<span class="token punctuation">(</span></span><span class="token number">4</span><span class="token punctuation">,</span> <span class="token string">'15:00'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every month on the 4th at 15:00</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">quarterly<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every quarter</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">yearly<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Run the task every year</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timezone<span class="token punctuation">(</span></span><span class="token string">'America/New_York'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Set the timezone</td>
            </tr>
        </tbody>
    </table>
    <p>These methods may be combined with additional constraints to create even more finely tuned schedules that only run on certain days of the week. For example, to schedule a command to run weekly on Monday:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token comment" spellcheck="true">// Run once per week on Monday at 1 PM...
</span><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">call<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
   <span class="token comment" spellcheck="true"> //
</span><span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">weekly<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">mondays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">at<span class="token punctuation">(</span></span><span class="token string">'13:00'</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">
// Run hourly from 8 AM to 5 PM on weekdays...
</span><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">weekdays<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hourly<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">timezone<span class="token punctuation">(</span></span><span class="token string">'America/Chicago'</span><span class="token punctuation">)</span>
          <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">between<span class="token punctuation">(</span></span><span class="token string">'8:00'</span><span class="token punctuation">,</span> <span class="token string">'17:00'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Below is a list of the additional schedule constraints:</p>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">weekdays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to weekdays</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sundays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to Sunday</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">mondays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to Monday</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">tuesdays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to Tuesday</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">wednesdays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to Wednesday</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">thursdays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to Thursday</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">fridays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to Friday</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">saturdays<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to Saturday</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">between<span class="token punctuation">(</span></span><span class="token variable">$start</span><span class="token punctuation">,</span> <span class="token variable">$end</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task to run between start and end times</td>
            </tr>
            <tr>
                <td><code class=" language-php"><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">when<span class="token punctuation">(</span></span>Closure<span class="token punctuation">)</span><span class="token punctuation">;</span></code>
                </td>
                <td>Limit the task based on a truth test</td>
            </tr>
        </tbody>
    </table>
    <h4>Between Time Constraints</h4>
    <p>The <code class=" language-php">between</code> method may be used to limit the execution of a task based on the time of day:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'reminders:send'</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hourly<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">between<span class="token punctuation">(</span></span><span class="token string">'7:00'</span><span class="token punctuation">,</span> <span class="token string">'22:00'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Similarly, the <code class=" language-php">unlessBetween</code> method can be used to exclude the execution of a task for a period of time:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'reminders:send'</span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">hourly<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
                    <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">unlessBetween<span class="token punctuation">(</span></span><span class="token string">'23:00'</span><span class="token punctuation">,</span> <span class="token string">'4:00'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Truth Test Constraints</h4>
    <p>The <code class=" language-php">when</code> method may be used to limit the execution of a task based on the result of a given truth test. In other words, if the given <code class=" language-php">Closure</code> returns <code class=" language-php"><span class="token boolean">true</span></code>, the task will execute as long as no other constraining conditions prevent the task from running:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'emails:send'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">when<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token boolean">true</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>The <code class=" language-php">skip</code> method may be seen as the inverse of <code class=" language-php">when</code>. If the <code class=" language-php">skip</code> method returns <code class=" language-php"><span class="token boolean">true</span></code>, the scheduled task will not be executed:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'emails:send'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">skip<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token boolean">true</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>When using chained <code class=" language-php">when</code> methods, the scheduled command will only execute if all <code class=" language-php">when</code> conditions return <code class=" language-php"><span class="token boolean">true</span></code>.</p>
    <p>
        <a name="preventing-task-overlaps"></a>
    </p>
    <h3>Preventing Task Overlaps</h3>
    <p>By default, scheduled tasks will be run even if the previous instance of the task is still running. To prevent this, you may use the <code class=" language-php">withoutOverlapping</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'emails:send'</span><span class="token punctuation">)</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">withoutOverlapping<span class="token punctuation">(</span></span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>In this example, the <code class=" language-php">emails<span class="token punctuation">:</span>send</code> <a href="/docs/5.3/artisan">Artisan command</a> will be run every minute if it is not already running. The <code class=" language-php">withoutOverlapping</code> method is especially useful if you have tasks that vary drastically in their execution time, preventing you from predicting exactly how long a given task will take.</p>
    <p>
        <a name="task-output"></a>
    </p>
    <h2><a href="#task-output">Task Output</a></h2>
    <p>The Laravel scheduler provides several convenient methods for working with the output generated by scheduled tasks. First, using the <code class=" language-php">sendOutputTo</code> method, you may send the output to a file for later inspection:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'emails:send'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sendOutputTo<span class="token punctuation">(</span></span><span class="token variable">$filePath</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>If you would like to append the output to a given file, you may use the <code class=" language-php">appendOutputTo</code> method:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'emails:send'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">appendOutputTo<span class="token punctuation">(</span></span><span class="token variable">$filePath</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Using the <code class=" language-php">emailOutputTo</code> method, you may e-mail the output to an e-mail address of your choice. Note that the output must first be sent to a file using the <code class=" language-php">sendOutputTo</code> method. Before e-mailing the output of a task, you should configure Laravel's <a href="/docs/5.3/mail">e-mail services</a>:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'foo'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">sendOutputTo<span class="token punctuation">(</span></span><span class="token variable">$filePath</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">emailOutputTo<span class="token punctuation">(</span></span><span class="token string">'foo@example.com'</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <blockquote class="has-icon note">
        <p>
            <div class="flag"><span class="svg"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" version="1.1" x="0px" y="0px" width="90px" height="90px" viewBox="0 0 90 90" enable-background="new 0 0 90 90" xml:space="preserve"><path fill="#FFFFFF" d="M45 0C20.1 0 0 20.1 0 45s20.1 45 45 45 45-20.1 45-45S69.9 0 45 0zM45 74.5c-3.6 0-6.5-2.9-6.5-6.5s2.9-6.5 6.5-6.5 6.5 2.9 6.5 6.5S48.6 74.5 45 74.5zM52.1 23.9l-2.5 29.6c0 2.5-2.1 4.6-4.6 4.6 -2.5 0-4.6-2.1-4.6-4.6l-2.5-29.6c-0.1-0.4-0.1-0.7-0.1-1.1 0-4 3.2-7.2 7.2-7.2 4 0 7.2 3.2 7.2 7.2C52.2 23.1 52.2 23.5 52.1 23.9z"></path></svg></span>
            </div> The <code class=" language-php">emailOutputTo</code>, <code class=" language-php">sendOutputTo</code> and <code class=" language-php">appendOutputTo</code> methods are exclusive to the <code class=" language-php">command</code> method and are not supported for <code class=" language-php">call</code>.</p>
    </blockquote>
    <p>
        <a name="task-hooks"></a>
    </p>
    <h2><a href="#task-hooks">Task Hooks</a></h2>
    <p>Using the <code class=" language-php">before</code> and <code class=" language-php">after</code> methods, you may specify code to be executed before and after the scheduled task is complete:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'emails:send'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">before<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token comment" spellcheck="true"> // Task is about to start...
</span>         <span class="token punctuation">}</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">after<span class="token punctuation">(</span></span><span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token comment" spellcheck="true"> // Task is complete...
</span>         <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <h4>Pinging URLs</h4>
    <p>Using the <code class=" language-php">pingBefore</code> and <code class=" language-php">thenPing</code> methods, the scheduler can automatically ping a given URL before or after a task is complete. This method is useful for notifying an external service, such as <a href="https://envoyer.io">Laravel Envoyer</a>, that your scheduled task is commencing or has finished execution:</p>
    <pre class=" language-php"><code class=" language-php"><span class="token variable">$schedule</span><span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">command<span class="token punctuation">(</span></span><span class="token string">'emails:send'</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">daily<span class="token punctuation">(</span></span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">pingBefore<span class="token punctuation">(</span></span><span class="token variable">$url</span><span class="token punctuation">)</span>
         <span class="token operator">-</span><span class="token operator">&gt;</span><span class="token function">thenPing<span class="token punctuation">(</span></span><span class="token variable">$url</span><span class="token punctuation">)</span><span class="token punctuation">;</span></code></pre>
    <p>Using either the <code class=" language-php"><span class="token function">pingBefore<span class="token punctuation">(</span></span><span class="token variable">$url</span><span class="token punctuation">)</span></code> or <code class=" language-php"><span class="token function">thenPing<span class="token punctuation">(</span></span><span class="token variable">$url</span><span class="token punctuation">)</span></code> feature requires the Guzzle HTTP library. You can add Guzzle to your project using the Composer package manager:</p>
    <pre class=" language-php"><code class=" language-php">composer <span class="token keyword">require</span> guzzlehttp<span class="token operator">/</span>guzzle</code></pre>

    <div>Nguồn: <a href="https://laravel.com/docs/5.3/scheduling">https://laravel.com/docs/5.3/scheduling</a></div>
</article>
@endsection