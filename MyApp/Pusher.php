<?php
namespace MyApp;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\WampServerInterface;
//Press Win+R, enter following command:
//
//notepad.exe %windir%\system32\drivers\etc\hosts
//
//Then you can check if the domain is already in that file. If it is and with a beginning of "#", remove the "#". If not, enter the following:
//
//127.0.0.1 [your domain name]
class Pusher implements WampServerInterface {
     /**
     * A lookup of all the topics clients have subscribed to
     */
    protected $subscribedTopics = array();
    
    public function onCall(ConnectionInterface $conn, $id, $topic, array $params) {
         // In this application if clients send data it's because the user hacked around in console
        $conn->callError($id, $topic, 'You are not allowed to make calls')->close();
    }

    public function onClose(ConnectionInterface $conn) {
        echo "anh Close";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        
    }

    public function onOpen(ConnectionInterface $conn) {
        echo "anh Open";
    }

    public function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible) {
         // In this application if clients send data it's because the user hacked around in console
        $conn->close();
    }

    public function onSubscribe(ConnectionInterface $conn, $topic) {
        $this->subscribedTopics[$topic->getId()] = $topic;
    }

    public function onUnSubscribe(ConnectionInterface $conn, $topic) {
        
    }
     /**
     * @param string JSON'ified string we'll receive from ZeroMQ
     */
    public function onBlogEntry($entry) {
        $entryData = json_decode($entry, true);
        echo $entry;
        // If the lookup topic object isn't set there is no one to publish to
        if (!array_key_exists($entryData['category'], $this->subscribedTopics)) {
            return;
        }
        

        $topic = $this->subscribedTopics[$entryData['category']];

        // re-send the data to all the clients subscribed to that category
        $topic->broadcast($entryData);
    }

}
