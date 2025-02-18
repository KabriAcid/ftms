CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    birth_date DATE DEFAULT NULL,
    address TEXT DEFAULT NULL,
    role ENUM('Admin', 'User') DEFAULT 'User',
    email_verified_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Family Members Table
CREATE TABLE family_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    birth_date DATE DEFAULT NULL,
    death_date DATE DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Relationships Table
CREATE TABLE relationships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member1_id INT NOT NULL,
    member2_id INT NOT NULL,
    relation_type ENUM('Parent', 'Child', 'Sibling', 'Spouse', 'Cousin', 'Grandparent', 'Grandchild') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member1_id) REFERENCES family_members(id) ON DELETE CASCADE,
    FOREIGN KEY (member2_id) REFERENCES family_members(id) ON DELETE CASCADE
);

-- Events Table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    event_type ENUM('Birth', 'Marriage', 'Death', 'Anniversary', 'Other') NOT NULL,
    event_date DATE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES family_members(id) ON DELETE CASCADE
);

-- Media Table
CREATE TABLE media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type ENUM('Image', 'Document', 'Other') NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (member_id) REFERENCES family_members(id) ON DELETE CASCADE
);
