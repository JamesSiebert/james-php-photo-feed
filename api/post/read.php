<?php
// Headers - Open access to anybody
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Posts.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate post object
$post = new Post($db);

// post query
$result = $post->read();

// Get row count
$num = $result->rowCount();

// Check if we have any posts
if($num > 0) {
    // Post array
    $post_arr = array();
    $posts_arr['data'] = array();

    // Consideration for: Pagination, version info, etc
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'filename' => $image_filename,
            'ip_address' => $ip_address
        );

        // Push to "data"
        array_push($posts_arr['data'], $post_item);
    }

    // Convert to JSON and output
    echo json_encode($posts_arr);

} else {

    // No Posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}
