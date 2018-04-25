Feature: The category API's endpoint
  In order to manipulate categories data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  @repository
  Scenario: Fetch an category data
    Given the following category(s) exist:
      | category_id | name   |
      | 1           | Action |
      | 2           | Comedy |
      | 3           | Drama  |
      | 4           | Horror |
      | 5           | Family |
    When I send a GET request to "api/categories/3"
    Then the response code should be 200
    And the JSON response should contain:
      | categoryId | name  |
      | 3          | Drama |

  @repository
  Scenario: Fetch all categories
    Given the following category(s) exist:
      | category_id | name   |
      | 1           | Action |
      | 2           | Comedy |
      | 3           | Drama  |
      | 4           | Horror |
      | 5           | Family |
    When I send a GET request to "api/categories"
    Then the response code should be 200
    And the JSON response should contain:
      | categoryId | name   |
      | 1          | Action |
      | 2          | Comedy |
      | 3          | Drama  |
      | 4          | Horror |
      | 5          | Family |

  @repository
  Scenario: Fetch all categories with pagination
    Given the following category(s) exist:
      | category_id | name   |
      | 1           | Action |
      | 2           | Comedy |
      | 3           | Drama  |
      | 4           | Horror |
      | 5           | Family |
    When I send a GET request to "api/categories?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | categoryId | name   |
      | 3          | Drama  |
      | 4          | Horror |

  @repository
  Scenario: Create a new category
    Given the following category(s) exist:
      | category_id | name   |
      | 1           | Action |
      | 2           | Comedy |
      | 3           | Drama  |
      | 4           | Horror |
      | 5           | Family |
    When I send a POST request to "api/categories":
      | name        |
      | Documentary |
    Then the response code should be 201
    And the JSON response should contain:
      | categoryId | name        |
      | 6          | Documentary |
    And the following category should be saved:
      | category_id | name        |
      | 6           | Documentary |

  @repository
  Scenario: Update an existing category
    Given the following category(s) exist:
      | category_id | name   |
      | 1           | Action |
      | 2           | Comedy |
      | 3           | Drama  |
      | 4           | Horor  |
      | 5           | Family |
    When I send a PUT request to "api/categories/4":
      | name   |
      | Horror |
    Then the response code should be 200
    And the JSON response should contain:
      | categoryId | name   |
      | 4          | Horror |
    And the following category should be saved:
      | category_id | name   |
      | 4           | Horror |
    When I send a GET request to "api/categories/1"
    Then the response code should be 200
    And the JSON response should contain:
      | categoryId | name   |
      | 1          | Action |

  @repository
  Scenario: Remove an category
    Given the following category(s) exist:
      | category_id | name   |
      | 1           | Action |
      | 2           | Comedy |
      | 3           | Drama  |
      | 4           | Horror |
      | 5           | Family |
    When I send a DELETE request to "api/categories/3"
    Then the response code should be 200
    And the following category should not be saved:
      | category_id | name   |
      | 3           | Comedy |
    When I send a GET request to "api/categories/1"
    Then the response code should be 200
    And the JSON response should contain:
      | categoryId | name   |
      | 1          | Action |
