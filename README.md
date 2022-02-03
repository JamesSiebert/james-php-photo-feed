



**Make sure to:**

Comments

Descriptions

Use PSR - PHP Standards Recommendations

Time track - GitHub?





#### Environmental Variables

phpdotenv



#### MySQL Migration File



#### PUBLIC INDEX PAGE

GET api/posts/read.php

JSON of all images

Show all images

- Bootstrap 5
- Later improvement - PAGINATION



#### UPLOAD FORM

USE CSRF

| Field                        | Value          |
| ---------------------------- | -------------- |
| Name (unique unless same IP) | My Tree        |
| **Description**              | This is a tree |
| **File** (.jpg or .png only) | my-file.jpg    |



#### VALIDATION

name: REQUIRED - min & max length, no tags, no special chars

desc: REQUIRED - min & max length, no tags, no special chars

file: REQUIRED - mime type(jpg, png), min size(50kb), max size(10mb)

Check CSRF, Post size limits, too many attempts, upload timeouts, posted timestamp vs current time, CSRF expiry (for leaks)



**CHECK:**

Does name exist in posts table?
YES -
Does uploader_ip = post_ip?
YES - Append current image to clean up list - Call UPDATE IMAGE
NO - REJECT - response 'Please choose another name'

CREATE POST



#### Model

**Sanitise Data**

**CreatePost** (name, description, file, image_uuid)

​	**Create new Image** (imageName)
​	returns Image UUID

returns true / false



**UpdateImage**(post_id)

​	deleteImageUUID = current image_id

​	**Create new Image**(imageName)
​	returns Image UUID

​	Update post image UUID

​	Delete Image (deleteImageUUID)
​	Considerations - if failure - time delayed queue for backup purposes.

returns true / false



**ReadPosts**

​	returns all posts, left join, order by updated_at



**POST**

| ID   | Name (Unique) | Desc           | IP            | IMG ID (FK)     | created_at | updated_at |
| ---- | ------------- | -------------- | ------------- | --------------- | ---------- | ---------- |
| 1    | Park          | this is a park | 123.123.123.1 | abc-123-abc-123 | dateTime   | dateTime   |
| 2    | Tree          | this is a tree | 123.123.123.2 | abc-123-abc-456 | dateTime   | dateTime   |
|      |               |                |               |                 |            |            |



**IMAGE**

- Consideration for resolution and thumbs, exif reads also possible if needed.

| ID (UUID)       | full                | created_at | updated_at |
| --------------- | ------------------- | ---------- | ---------- |
| abc-123-abc-123 | abc-123-abc-123.jpg | dateTime   | dateTime   |
| abc-123-abc-456 | abc-123-abc-123.jpg | dateTime   | dateTime   |



**Future Considerations**

Script run timeouts

Too many uploads / throttling

Request throttling DDOS

Automated code checks for standard coding practices PSR
example https://www.php-fig.org/psr/psr-2/
