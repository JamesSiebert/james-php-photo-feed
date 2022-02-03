CREATE TABLE `images` (
    `id` varchar(255) NOT NULL,
    `filename` varchar(255) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

INSERT INTO `images` (`id`, `filename`) VALUES
    ('dc885a57-8482-11ec-91f7-00155d5e9ef6', 'test-img-1.jpg'),
    ('dc8869e6-8482-11ec-91f7-00155d5e9ef6', 'test-img-2.jpg'),
    ('dc886a5f-8482-11ec-91f7-00155d5e9ef6', 'test-img-3.jpg')
;

CREATE TABLE `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `image_id` varchar(255),
    `ip_address` varchar(255),
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

INSERT INTO `posts` (`id`, `name`, `description`, `image_id`, `ip_address`) VALUES
    (1, 'Big Tree', 'A beautiful tree on a hill.', 'dc885a57-8482-11ec-91f7-00155d5e9ef6', '192.168.1.1'),
    (2, 'Big House', 'A massive house.', 'dc8869e6-8482-11ec-91f7-00155d5e9ef6', '192.168.1.2'),
    (3, 'Ocean Sunrise', 'A beautiful ocean sunrise', 'dc886a5f-8482-11ec-91f7-00155d5e9ef6', '192.168.1.3')
;
