Feature: The language API's endpoint
  In order to manipulate languages data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  @repository
  Scenario: Fetch a language data
    Given the following language(s) exist:
      | language_id | name     |
      | 1           | English  |
      | 2           | Italian  |
      | 3           | Japanese |
      | 4           | Mandarin |
      | 5           | French   |
    When I send a GET request to "api/languages/3"
    Then the response code should be 200
    And the JSON response should contain:
      | languageId | name     |
      | 3          | Japanese |

  @repository
  Scenario: Fetch all languages
    Given the following language(s) exist:
      | language_id | name     |
      | 1           | English  |
      | 2           | Italian  |
      | 3           | Japanese |
      | 4           | Mandarin |
      | 5           | French   |
    When I send a GET request to "api/languages"
    Then the response code should be 200
    And the JSON response should contain:
      | languageId | name     |
      | 1          | English  |
      | 2          | Italian  |
      | 3          | Japanese |
      | 4          | Mandarin |
      | 5          | French   |

  @repository
  Scenario: Fetch all languages with pagination
    Given the following language(s) exist:
      | language_id | name     |
      | 1           | English  |
      | 2           | Italian  |
      | 3           | Japanese |
      | 4           | Mandarin |
      | 5           | French   |
    When I send a GET request to "api/languages?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | languageId | name     |
      | 3          | Japanese |
      | 4          | Mandarin |

  @repository
  Scenario: Create a new language
    Given the following language(s) exist:
      | language_id | name     |
      | 1           | English  |
      | 2           | Italian  |
      | 3           | Japanese |
      | 4           | Mandarin |
      | 5           | French   |
    When I send a POST request to "api/languages":
      | name    |
      | Spanish |
    Then the response code should be 201
    And the JSON response should contain:
      | languageId | name    |
      | 6          | Spanish |
    And the following language should be saved:
      | language_id | name    |
      | 6           | Spanish |

  @repository
  Scenario: Update an existing language
    Given the following language(s) exist:
      | language_id | name      |
      | 1           | English   |
      | 2           | Italian   |
      | 3           | Japanesee |
      | 4           | Mandarin  |
      | 5           | French    |
    When I send a PUT request to "api/languages/4":
      | name     |
      | Japanese |
    Then the response code should be 200
    And the JSON response should contain:
      | languageId | name     |
      | 4          | Japanese |
    And the following language should be saved:
      | language_id | name     |
      | 4           | Japanese |
    When I send a GET request to "api/languages/1"
    Then the response code should be 200
    And the JSON response should contain:
      | languageId | name    |
      | 1          | English |

  @repository
  Scenario: Remove an language
    Given the following language(s) exist:
      | language_id | name     |
      | 1           | English  |
      | 2           | Italian  |
      | 3           | Japanese |
      | 4           | Mandarin |
      | 5           | French   |
    When I send a DELETE request to "api/languages/3"
    Then the response code should be 200
    And the following language should not be saved:
      | language_id | name     |
      | 3           | Japanese |
    When I send a GET request to "api/languages/1"
    Then the response code should be 200
    And the JSON response should contain:
      | languageId | name    |
      | 1          | English |
