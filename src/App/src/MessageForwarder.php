<?php
namespace App;

use Laminas\Http\Client;

class MessageForwarder
{
    protected $client;
    protected $vuowmaUrl;
    protected $webhookUrl;

    public function __construct(array $options = [])
    {
        if (!isset($options['base_url']) || !isset($options['webhook_url'])) {
            throw new \Exception('base_url and webhook_url settings are both required!');
        }
        $this->vuowmaUrl = $options['base_url'];
        $this->webhookUrl = $options['webhook_url'];
        $this->client = $options['client'] ?? new Client();
    }

    public function forward(array $messages, $batch_id)
    {
        $message = json_decode($messages[0]['data'], true);
        if (count($messages) > 1) {
            $message['text'] = count($messages) . " log messages in [batch $batch_id](" . $this->vuowmaUrl . '?batch=' . $batch_id . ")\nFirst message: " . $message['text'];
        }
        $this->client->setUri($this->webhookUrl);
        $this->client->setMethod('POST');
        $this->client->setEncType('application/json');
        $this->client->setRawBody(json_encode($message));
        $response = $this->client->send();
        if (!$response->isSuccess()) {
            throw new \Exception('Problem sending message.');
        }
    }
}
