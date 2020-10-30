<?php
namespace App;

class MessageForwarder
{
    protected $vuowmaUrl;
    protected $webhookUrl;

    public function __construct(array $options = [])
    {
        if (!isset($options['base_url']) || !isset($options['webhook_url'])) {
            throw new \Exception('base_url and webhook_url settings are both required!');
        }
        $this->vuowmaUrl = $options['base_url'];
        $this->webhookUrl = $options['webhook_url'];
    }

    public function forward(array $messages)
    {
        // TODO: actually forward the messages
    }
}
