<?php
class Image
{
    private $conn;

    // Properties
    public string $id;
    public string $filename;
    public string $created_at;
    public string $updated_at;

    // Constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create an Image
    public function create(): bool
    {
        // Query
        $query = 'INSERT INTO images SET id = :id, filename = :filename';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':filename', $this->filename);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print errors
        printf("Error: %s. \n", $stmt->errors);
        return false;
    }
}
