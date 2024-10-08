-- Creating the databse if not exists
CREATE DATABASE IF NOT EXISTS homeland;

-- Using the database
USE homeland;


-- Creating the necessary tables for the project
--
--
--

-- The `users` table:
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    avatar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Insert random users into the users table

INSERT INTO users (full_name, username, email, password, phone, address, avatar)
VALUES 
    ('John Doe', 'johndoe', 'john.doe@example.com', sha2('password123',256), '123-456-7890', '123 Elm Street, Springfield', 'avatars/johndoe.png'),
    ('Jane Smith', 'janesmith', 'jane.smith@example.com', sha2('password456',256), '987-654-3210', '456 Oak Avenue, Springfield', 'avatars/janesmith.png'),
    ('Robert Brown', 'robertbrown', 'robert.brown@example.com', sha2('password789',256), '555-555-5555', '789 Maple Drive, Springfield', 'avatars/robertbrown.png'),
    ('Emily Davis', 'emilydavis', 'emily.davis@example.com', sha2('password101',256), '444-444-4444', '101 Pine Lane, Springfield', 'avatars/emilydavis.png'),
    ('Mamed Johnson', 'mamado', 'mamed.johnson@example.com', sha2('password202',256), '333-333-3333', '202 Birch Road, Springfield', 'avatars/mamado.png');


-- The `admins` table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, 
    full_name VARCHAR(255),
    phone VARCHAR(20),
    address VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert random admins
INSERT INTO admins (username, email, password, full_name, phone, image) 
VALUES
    ('admin1', 'admin1@example.com', SHA2('password1', 256), 'John Doe', '+1234567890', 'admins/admin1.png'),
    ('admin2', 'admin2@example.com', SHA2('password2', 256), 'Jane Smith', '+0987654321', 'admins/admin2.png'),
    ('admin3', 'admin3@example.com', SHA2('password3', 256), 'Alice Johnson', '+1122334455', 'admins/admin3.png'),
    ('admin4', 'admin4@example.com', SHA2('password4', 256), 'Bob Brown', '+5566778899', 'admins/admin4.png');


-- the properties table:

CREATE TABLE IF NOT EXISTS properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(15, 2),
    street_address VARCHAR(255),  -- Street address without unit number
    unit VARCHAR(50),  -- Unit number if applicable
    city VARCHAR(255),
    state VARCHAR(255),
    zip_code VARCHAR(20),
    size_sqft DECIMAL(10, 2) NOT NULL,
    price_sqft DECIMAL(10,2) NOT NULL,
    bedrooms INT,
    bathrooms INT,
    garage_spaces INT DEFAULT 0,
    area DECIMAL(10, 2), -- Area in square meters or relevant unit
    year_built YEAR,
    features TEXT,
    status ENUM('Available', 'Sold') DEFAULT 'Available',
    property_type VARCHAR(255) NOT NULL UNIQUE,
    property_status ENUM('For Rent', 'For Sale', 'For Lease', 'For Rent or Sale', 'For Rent or Lease', 'For Sale or Lease', 'For Rent, Sale, or Lease') NOT NULL,
    image VARCHAR(255),
    admin_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id)
);

-- Property types : 
    -- 'Condo', 
    -- 'Property Land', 
    -- 'Commercial Building', 
    -- 'House', 
    -- 'Apartment', 
    -- 'Office', 
    -- 'Retail', 
    -- 'Warehouse'
    -- ...




-- Insert sample data into properties

INSERT INTO properties (
    title, description, price, street_address, unit, city, state, zip_code,
    size_sqft, price_sqft, bedrooms, bathrooms, garage_spaces, area, year_built,
    features, status, property_type, property_status, image, admin_id
) 
VALUES
    ('Luxurious Condo with Sea View', 'A luxurious condo with stunning sea views and modern amenities.', 150000, '625 S. Berendo St', 'Unit 607', 'Los Angeles', 'CA', '90005',
    1200, 125, 3, 2, 2, 111.48, 2020, 'Sea view, pool, gym', 'Available', 'Condo', 'For Sale', 'property1.jpg', 1),
    ('Prime Land for Development', 'Prime land available in a growing area, perfect for new projects.', 500000, '456 Country Road', 'Unit 43E', 'Orlando', 'FL', '32801',
    20000, 25, 3, 3, 2, 300, 2019, 'Flat terrain, near highway', 'Available', 'Property Land', 'For Sale', 'property2.jpg', 2),
    ('Modern Family House', 'Spacious family house with a large garden and modern interior.', 253000, '789 Suburbia Lane', 'Unit D09', 'Tampa', 'FL', '33606',
    2200, 115, 4, 3, 2, 204.39, 2015, 'Garden, garage, modern kitchen', 'Available', 'House', 'For Rent', 'property3.jpg', 3),
    ('Downtown Office Space', 'Office space in the heart of the city, ideal for businesses.', 351000, '101 Business St', 'Unit 40C', 'Jacksonville', 'FL', '32202',
    3000, 117, 1, 2, 1, 278.71, 2018, 'High-speed internet, conference rooms', 'Available', 'Office', 'For Rent or Lease', 'property4.jpg', 4),
    ('Stylish Apartment with Balcony', 'Chic apartment with a balcony and panoramic city views.', 179550, '123 Urban Ave', 'Unit 5B', 'Miami', 'FL', '33130',
    950, 189, 2, 1, 1, 88.26, 2021, 'Balcony, city view', 'Available', 'Apartment', 'For Sale', 'property5.jpg', 1);



-- The categories table:
CREATE TABLE IF NOT EXISTS categories(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    property_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data into the categories table
INSERT INTO categories (name, description, property_count) 
VALUES
    ('Condo', 'Residential units, typically within multi-unit buildings.', 1),
    ('Commercial Building', 'Buildings used for business activities.', 0),
    ('Property Land', 'Vacant land available for development.', 1),
    ('Office', 'Commercial spaces for office use.', 1),
    ('Apartment', 'Individual residential units within a larger building.', 1),
    ('Retail', 'Spaces used for retail businesses and shops.', 0),
    ('Warehouse', 'Large buildings used for storage and distribution.', 0);


-- The galleries table:
CREATE TABLE IF NOT EXISTS galleries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id)
);

-- Insert sample data to the galleries tabele:
INSERT INTO galleries (property_id, image_url)
VALUES
    (1, 'property1_image1.jpg'),
    (1, 'property1_image2.jpg'),
    (1, 'property1_image3.jpg'),
    (2, 'property2_image1.jpg'),
    (2, 'property2_image2.jpg'),
    (2, 'property2_image3.jpg'),
    (3, 'property3_image1.jpg'),
    (3, 'property3_image2.jpg'),
    (3, 'property3_image3.jpg'),
    (4, 'property4_image1.jpg'),
    (4, 'property4_image2.jpg'),
    (4, 'property4_image3.jpg'),
    (5, 'property5_image1.jpg'),
    (5, 'property5_image2.jpg'),
    (5, 'property5_image3.jpg');



-- The favorites table:
CREATE TABLE IF NOT EXISTS favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_id INT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE (property_id, user_id) -- Prevent duplicate entries
);


CREATE TABLE IF NOT EXISTS requests (
    id INT AUTO_INCREMENT PRIMARY KEY,       
    name VARCHAR(255) NOT NULL,              
    email VARCHAR(255) NOT NULL,             
    phone VARCHAR(20),                       
    user_id INT,                             -- ID of the user making the request (foreign key)
    property_id INT,                         -- ID of the property related to the request (foreign key)
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, 
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE,
    UNIQUE (property_id, user_id) -- Prevent duplicate entries
);


-- The user_details table:
CREATE TABLE IF NOT EXISTS user_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    job VARCHAR(100) DEFAULT NULL,
    facebook VARCHAR(100) DEFAULT NULL UNIQUE,
    instagram VARCHAR(100) DEFAULT NULL UNIQUE,
    twitter VARCHAR(100) DEFAULT NULL UNIQUE,
    github VARCHAR(100) DEFAULT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Inserting random data

INSERT INTO user_details (user_id, job, facebook, instagram, twitter, github)
VALUES 
    (1, 'Software Engineer', 'facebook.com/adamo', 'instagram.com/adamo', 'twitter.com/adamo', 'github.com/adamo'),
    (2, 'Software Developer', 'facebook.com/johndoe', 'instagram.com/johndoe', 'twitter.com/johndoe', 'github.com/johndoe'),
    (3, 'Marketing Specialist', 'facebook.com/janesmith', 'instagram.com/janesmith', 'twitter.com/janesmith', 'github.com/janesmith'),
    (4, 'Graphic Designer', 'facebook.com/robertbrown', 'instagram.com/robertbrown', 'twitter.com/robertbrown', 'github.com/robertbrown'),
    (5, 'Content Writer', 'facebook.com/emilydavis', 'instagram.com/emilydavis', 'twitter.com/emilydavis', 'github.com/emilydavis'),
    (6, 'Data Analyst', 'facebook.com/mamado', 'instagram.com/mamado', 'twitter.com/mamado', 'github.com/mamado');





