<?php
require 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class Message implements MessageComponentInterface {
    protected $clients;
    protected $mysqli;

    public function __construct() {
        $this->clients = new \SplObjectStorage;

        // Connect to the MySQL database
        $this->mysqli = new mysqli("localhost", "root", "", "metalink_db");

        // Check for a connection error
        if ($this->mysqli->connect_error) {
            die("Database connection failed: " . $this->mysqli->connect_error);
        }
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    
        $connectionId = $conn->resourceId;
        echo "Connection ID: $connectionId\n";
        
        // Parse the query string to get the username
        $queryParams = [];
        parse_str($conn->httpRequest->getUri()->getQuery(), $queryParams);
    
        $userId = $queryParams['username'] ?? null;
        $last_time = date("h:i");
        foreach ($this->clients as $client) {
            
            $message = json_encode([
                "who"=>$userId,
                "status"=>'online'
            ]);
            $client->send($message);
        
        }

        if ($userId) {
            // Update the database with the new connection ID
            $last=mysqli_query($this->mysqli,"UPDATE users SET last_time='$last_time' WHERE username =  '$userId'");
            $stmt = $this->mysqli->prepare("UPDATE users SET ws = ?, status = 'online' WHERE username = ?");
            $stmt->bind_param("ss", $connectionId, $userId);
            if ($stmt->execute()) {
                echo "Database updated for connection {$connectionId}.\n";
            } else {
                echo "Error updating database: " . $stmt->error . "\n";
            }
            $stmt->close();
        } else {
            echo "No user ID found in query parameters.\n";
        }
    }
    

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg);
        //sender Websocket resource id


        //check window
            //get window
        $window=mysqli_query($this->mysqli,"SELECT user_window FROM users WHERE username = '$data->receiver'");
        $row=$window->fetch_assoc();
        $window=$row['user_window'];
        print_r($window);

        //user window = $window
        if($window!=$data->sender){
                        // increment un_read
                        // Increment unread count securely
            $stmt = $this->mysqli->prepare("UPDATE friends SET un_read = un_read + 1 WHERE name = ? AND myfriend = ?");
            $stmt->bind_param("ss", $data->receiver, $data->sender);
            $inc = $stmt->execute();
            $stmt->close();

            if ($inc) {
                // Retrieve WebSocket ID securely
                $stmt = $this->mysqli->prepare("SELECT ws FROM users WHERE username = ?");
                $stmt->bind_param("s", $data->receiver);
                $stmt->execute();
                $result = $stmt->get_result();
                $ws_id = $result->fetch_assoc()['ws'];
                $stmt->close();

                

                // Retrieve the updated unread count securely
                $stmt = $this->mysqli->prepare("SELECT un_read FROM friends WHERE name = ? AND myfriend = ?");
                $stmt->bind_param("ss", $data->receiver, $data->sender);
                $stmt->execute();
                $result = $stmt->get_result();
                $un = $result->fetch_assoc()['un_read'];
                $stmt->close();

                echo "\n$un\n";
                $all_un=mysqli_query($this->mysqli,"SELECT un_read FROM friends WHERE name='".$data->receiver."'");
                $total_unread=0;
                while($row=$all_un->fetch_assoc()){
                    $total_unread+=$row['un_read'];
                }
                $update_user = mysqli_query($this->mysqli,"UPDATE users SET un_read_messages = '$total_unread' WHERE username='".$data->receiver."'");
                foreach ($this->clients as $client) {
                    if ($client->resourceId == $ws_id) {
                        $message = json_encode([
                            'replace' => $data->sender,
                            'number' => $un,
                            'total'=>$total_unread
                        ]);
                        $client->send($message);
                        echo "\nMessage sent: $message\n";
                    }
                }
            }

        }else{
            echo "not";
        }


        $insert = mysqli_query($this->mysqli,"INSERT INTO messages(sender,reciver,Message,time) values('$data->sender','$data->receiver','$data->message','$data->time')");
        $ws_sender_res = mysqli_query($this->mysqli,"SELECT ws FROM users where username =  '$data->sender'");
        $row=$ws_sender_res->fetch_assoc();
        $ws_sender=$row['ws'];
        print_r($ws_sender);

        //websocket receiver id
        $ws_receiver_res = mysqli_query($this->mysqli,"SELECT ws FROM users where username =  '$data->receiver'");
        $row=$ws_receiver_res->fetch_assoc();
        $ws_receiver=$row['ws'];
        print_r($ws_receiver);
        foreach ($this->clients as $client) {
            if ($client->resourceId == $ws_receiver || $client->resourceId == $ws_sender) {
                $client->send($msg);
            }
            
         }



        print_r($data);
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        $connectionId = $conn->resourceId;

        $user=mysqli_query($this->mysqli,"SELECT username FROM users WHERE ws = '$connectionId'");
        $row=$user->fetch_assoc();
        $user=$row['username'];

        $stmt = $this->mysqli->prepare("UPDATE users SET ws = '',user_window='', status='offline' WHERE ws = ?");
        $stmt->bind_param("s", $connectionId);
        
        foreach ($this->clients as $client) {
            
            $message = json_encode([
                "who"=>$user,
                "status"=>'offline'
            ]);
            $client->send($message);
        
        }

        if ($stmt->execute()) {
            echo "Database cleared for closed connection {$connectionId}.\n";
        } else {
            echo "Error updating database: " . $stmt->error . "\n";
        }
        $stmt->close();
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}

// Run the WebSocket server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new message
        )
    ),
    8000,
    '0.0.0.0'  // Bind to all network interfaces for local network access
);


$server->run();
