<?php
class Post {
    // Database
    private $conn;

    // Post properties
    public int $id;
    public string $name;
    public string $description;
    public string $image_id;
    public string $ip_address;
    public string $created_at;
    public string $updated_at;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read posts - for feed display
    public function read() {
        $query = '
                SELECT
                    i.filename as image_filename,
                    i.updated_at as image_updated_at,
                    p.id,
                    p.name,
                    p.description,
                    p.image_id,
                    p.ip_address,
                    p.created_at,
                    p.updated_at
                FROM
                    posts p
                LEFT JOIN
                    images i ON p.image_id = i.id
                ORDER BY
                    p.created_at DESC
        ';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }


    // Create post
    public function create(): bool
    {
        // query to check a specific post title
        $checkQuery = '
                SELECT
                    p.id,
                    p.name, 
                    p.description,
                    p.image_id,
                    p.ip_address,
                    p.created_at,
                    p.updated_at
                FROM
                    posts p
                WHERE
                    p.name = :name
                LIMIT 0,1
        ';

        // Run check query
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindParam(':name', $this->name);
        $checkStmt->execute();
        $checkRow = $checkStmt->fetch(PDO::FETCH_ASSOC);

        // Used to select between create and update
        $runUpdate = false;

        if($checkRow) {
            // a post with the same name exists

            if($checkRow['ip_address'] == $this->ip_address) {

                $runUpdate = true;

                // IP address match - Use update query
                $query = '
                        UPDATE posts
                        SET
                            name = :name,
                            description = :description,
                            image_id = :image_id,
                            ip_address = :ip_address
                        WHERE
                            id = :id
                ';

                // TODO Consideration here for deleting the old image
            } else {
                // Different IP address - tell user to choose a new title
                return false;
            }
        } else {

            // No posts with same title exist - use create query
            $query = '
                INSERT INTO posts
                SET
                    name = :name,
                    description = :description,
                    image_id = :image_id,
                    ip_address = :ip_address
            ';
        }

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data - sanitise
        $this->name = sanitiseBasic($this->name);
        $this->description = sanitiseBasic($this->description);
        $this->image_id = sanitiseBasic($this->image_id);
        $this->ip_address = sanitiseBasic($this->ip_address);

        // Bind data
        if($runUpdate){
            $stmt->bindParam(':id', $checkRow['id']);
        }
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image_id', $this->image_id);
        $stmt->bindParam(':ip_address', $this->ip_address);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print errors
        printf("Error: %s. \n", $stmt->error);
        return false;
    }

}
