# VuOwma - Outlook365 Webhook Message Aggregator

This tool was developed at Villanova University to aggregate O365 webhook messages coming from VuFind's logger. This prevents heavy traffic from triggering rate limits on the O365 platform.

## Theory of Operation

VuOwma is a web service and set of command line tools. The web service collects messages and
allows viewing of collected messages. The command line utilities forward batches of messages
to O365 so that notifications can be distributed, and clean up old stored data.

## Installation / Configuration

1. Clone this Git repository to your server.

2. Create a new MySQL database and user:

<pre>
CREATE DATABASE vuowma;
GRANT ALL ON vuowma.* TO 'vuowma-username'@'localhost' IDENTIFIED BY 'vuowma-password';
</pre>

3. Populate the database with the contents of the `mysql.sql` file in this repository:

<pre>
mysql -uvuowma-username -p vuowma &lt; mysql.sql
</pre>

4. Run `composer install` to load dependencies.

5. Make the `public` subdirectory of the repository visible through your web server
(for example, by symbolically linking it beneath your web root). Be sure to apply
appropriate access restrictions!

6. Copy `config/autoload/local.php.dist` to `config/autoload/local.php`, and edit the
resulting file. Be sure to set the correct username and password for access to the
database you created in step 2, and set base_url to the URL where you exposed the
web content in step 5. The webhook_url should be the Office 365 Webhook URL.

7. Configure your other application(s) to point to the VuOwma endpoint instead of
the Office 365 Webhook URL; now it will begin collecting messages for you.

8. Set up cron jobs to run `bin/send-batch.php` and `bin/expire-batches.php`. You should
run `send-batch.php` frequently (every 1-5 minutes) to ensure that you receive notifications
in a timely fashion. You can run `expire-batches.php` less frequently (once per day),
as it is only a cleanup routine. By default, messages will be deleted 30 days after they
are received, but you can specify a different expiration period (in days) on the
`expire-batches.php` command line.