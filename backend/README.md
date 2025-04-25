
## Running Pest Tests

To run the Pest tests for **Authors** and **Books**, follow these steps:

1. Ensure you have Composer and the necessary dependencies installed.
2. Run the following command to execute the Pest tests:

   ```bash
    ./vendor/bin/pest tests/Feature/AuthorTest.php
   ```

   This will run the tests related to the **Author** model. For the **Book** model, run:

   ```bash
    ./vendor/bin/pest tests/Feature/BookTest.php
   ```

   These tests will cover the functionality and validation rules implemented for both the **Author** and **Book** resources.


## Endpoints

### Authors

- **Get All Authors**  
  **Method**: `GET`  
  **Endpoint**: `/api/authors`  
  **Description**: Retrieves a list of all authors.  
  **Query parameters**:  
  - `search`: Search term (optional)  
  - `sort_by`: Field to sort by (optional)  
  - `order`: Sorting order (`asc` or `desc`, optional)

- **Get Author by ID**  
  **Method**: `GET`  
  **Endpoint**: `/api/authors/{id}`  
  **Description**: Retrieves details for a specific author.

- **Create a New Author**  
  **Method**: `POST`  
  **Endpoint**: `/api/authors`  
  **Request body**:  
  ```json
  {
    "name": "Author Name",
    "biography": "Short biography",
    "birthdate": "YYYY-MM-DD"
  }
  ```
  **Description**: Creates a new author with the provided details.

- **Update Author**  
  **Method**: `PUT`  
  **Endpoint**: `/api/authors/{id}`  
  **Request body**:  
  ```json
  {
    "name": "Updated Author Name",
    "biography": "Updated biography",
    "birthdate": "Updated birthdate"
  }
  ```
  **Description**: Updates an existing author’s details.

- **Delete Author**  
  **Method**: `DELETE`  
  **Endpoint**: `/api/authors/{id}`  
  **Description**: Deletes a specific author by ID.

### Books

- **Get All Books**  
  **Method**: `GET`  
  **Endpoint**: `/api/books`  
  **Description**: Retrieves a list of all books.  
  **Query parameters**:  
  - `search`: Search term (optional)  
  - `author`: Filter by author ID (optional)  
  - `year`: Filter by publication year (optional)  
  - `sort_by`: Field to sort by (optional)  
  - `order`: Sorting order (`asc` or `desc`, optional)

- **Get Book by ID**  
  **Method**: `GET`  
  **Endpoint**: `/api/books/{id}`  
  **Description**: Retrieves details for a specific book.

- **Create a New Book**  
  **Method**: `POST`  
  **Endpoint**: `/api/books`  
  **Request body**:  
  ```json
  {
    "author_id": 1,
    "title": "Book Title",
    "isbn": "123-456-789",
    "description": "Book description",
    "published_date": "YYYY-MM-DD",
    "cover_url": "http://example.com/cover.jpg"
  }
  ```
  **Description**: Creates a new book with the provided details.

