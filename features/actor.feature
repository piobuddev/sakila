Feature: The actor API's endpoint
  In order to manipulate actors data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  Background:
    Given the following actor(s) exist:
      | actor_id | first_name | last_name |
      | 1        | Anthony    | Hopkins   |
      | 2        | Audrey     | Tautou    |
      | 3        | Leonardo   | DiCaprio  |
      | 4        | Natalie    | Portman   |
      | 5        | Christian  | Bale      |
      | 6        | Monica     | Bellucci  |

  @repository
  Scenario: Fetch an actor data
    When I send a GET request to "api/actors/1"
    Then the response code should be 200
    And the JSON response should contain:
      | actorId | firstName | lastName |
      | 1       | Anthony   | Hopkins  |

  @repository
  Scenario: Fetch all actors
    When I send a GET request to "api/actors"
    Then the response code should be 200
    And the JSON response should contain:
      | actorId | firstName | lastName |
      | 1       | Anthony   | Hopkins  |
      | 2       | Audrey    | Tautou   |
      | 3       | Leonardo  | DiCaprio |
      | 4       | Natalie   | Portman  |
      | 5       | Christian | Bale     |
      | 6       | Monica    | Bellucci |

  @repository
  Scenario: Fetch all actors with pagination
    When I send a GET request to "api/actors?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | actorId | firstName | lastName |
      | 3       | Leonardo  | DiCaprio |
      | 4       | Natalie   | Portman  |

  @repository
  Scenario: Create a new actor
    When I send a POST request to "api/actors":
      | firstName | lastName |
      | Tom       | Hardy    |
    Then the response code should be 201
    And the JSON response should contain:
      | actorId | firstName | lastName |
      | 7       | Tom       | Hardy    |
    And the following actor should be saved:
      | actor_id | first_name | last_name |
      | 7        | Tom        | Hardy     |

  @repository
  Scenario: Update an existing actor
    When I send a PUT request to "api/actors/6":
      | firstName | lastName |
      | Monica    | Bellucci |
    Then the response code should be 200
    And the JSON response should contain:
      | actorId | firstName | lastName |
      | 6       | Monica    | Bellucci |
    And the following actor should be saved:
      | actor_id | first_name | last_name |
      | 6        | Monica     | Bellucci  |
    When I send a GET request to "api/actors/1"
    Then the response code should be 200
    And the JSON response should contain:
      | actorId | firstName | lastName |
      | 1       | Anthony   | Hopkins  |

  @repository
  Scenario: Remove an actor
    When I send a DELETE request to "api/actors/3"
    Then the response code should be 200
    And the following actor should not be saved:
      | actor_id | first_name | last_name |
      | 3        | Leonardo   | DiCaprio  |
    When I send a GET request to "api/actors/1"
    Then the response code should be 200
    And the JSON response should contain:
      | actorId | firstName | lastName |
      | 1       | Anthony   | Hopkins  |
