# Social Network Database

This project contains SQL scripts to create a relational database schema for a social network. It includes tables for users, posts, followers, messages, likes, comments, and friend requests.

## Getting Started

To use this database schema, follow these steps:

1. **Create Database**: Execute the `CREATE DATABASE` statement to create a new database named `social_network_db`.

2. **Use Database**: Switch to the `social_network_db` using the `USE` statement.

3. **Create Tables**: Execute the provided SQL scripts to create the necessary tables for the social network schema.

4. **Insert Sample Data**: Optionally, insert sample data into the `users` table using the provided INSERT statements.

5. **Customization**: Modify the schema or data according to your specific requirements.

## Database Structure

The database schema includes the following tables:

- `users`: Contains information about registered users, including usernames, emails, profile picture URLs, phone numbers, and creation timestamps.
- `posts`: Stores posts made by users, including their content, post types (tweet or blog), titles (for blogs), post images, and creation timestamps.
- `followers`: Manages the relationship between users and their followers.
- `messages`: Stores private messages sent between users.
- `likes`: Tracks likes on posts.
- `comments`: Stores comments made on posts.

## File Description

- `social_network_db_schema.sql`: Contains the SQL scripts to create the database schema.
- `sample_data.sql`: Contains sample data insertion queries for the `users` table.

## Author

[SMRUTI RANJAN BHUYAN]

