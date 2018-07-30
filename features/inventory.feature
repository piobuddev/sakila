Feature: The store API's endpoint
  In order to manipulate stores data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  Background:
    Given the following country(s) exist:
      | country_id | country        |
      | 1          | United Kingdom |
    And the following city(s) exist:
      | city_id | city   | country_id |
      | 1       | London | 1          |
    And the following address(s) exist:
      | address_id | address           | district | city_id | postal_code | phone |
      | 1          | 47 MySakila Drive | Alberta  | 1       |             |       |
    And the following store(s) exist:
      | store_id | manager_staff_id | address_id |
      | 1        | 1                | 1          |
    And the following staff(s) exist:
      | staff_id | first_name | last_name | address_id | store_id | username |
      | 1        | Joe        | Doe       | 1          | 1        | joedoe   |
    And the following language(s) exist:
      | language_id | name    |
      | 1           | English |
    And the following film(s) exist:
      | film_id | title            | description                                                                                                           | release_year | language_id | original_language_id | rental_duration | rental_rate | length | replacement_cost | rating |
      | 1       | ACADEMY DINOSAUR | A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies                      | 2006         | 1           | null                 | 6               | 0.99        | 86     | 20.99            | PG     |
      | 2       | ACE GOLDFINGER   | A Astounding Epistle of a Database Administrator And a Explorer who must Find a Car in Ancient China                  | 2006         | 1           | null                 | 3               | 4.99        | 48     | 12.99            | G      |
      | 3       | ADAPTATION HOLES | A Astounding Reflection of a Lumberjack And a Car who must Sink a Lumberjack in A Baloon Factory                      | 2006         | 1           | null                 | 7               | 2.99        | 50     | 18.99            | NC-17  |
      | 4       | AFFAIR PREJUDICE | A Fanciful Documentary of a Frisbee And a Lumberjack who must Chase a Monkey in A Shark Tank                          | 2006         | 1           | null                 | 5               | 2.99        | 117    | 26.99            | G      |
      | 5       | AFRICAN EGG      | A Fast-Paced Documentary of a Pastry Chef And a Dentist who must Pursue a Forensic Psychologist in The Gulf of Mexico | 2006         | 1           | null                 | 6               | 2.99        | 130    | 22.99            | G      |
    And the following inventory(s) exist:
      | inventory_id | store_id | film_id |
      | 1            | 1        | 1       |
      | 2            | 1        | 2       |
      | 3            | 1        | 3       |
      | 4            | 1        | 4       |

  @repository @disableForeignKeys
  Scenario: Fetch an inventory data
    When I send a GET request to "api/inventory/1"
    Then the response code should be 200
    And the JSON response should contain:
      | inventoryId | storeId | filmId |
      | 1           | 1       | 1      |

  @repository @disableForeignKeys
  Scenario: Fetch all inventory
    When I send a GET request to "api/inventory"
    Then the response code should be 200
    And the JSON response should contain:
      | inventoryId | storeId | filmId |
      | 1           | 1       | 1      |
      | 2           | 1       | 2      |
      | 3           | 1       | 3      |
      | 4           | 1       | 4      |


  @repository @disableForeignKeys
  Scenario: Fetch all inventory with pagination
    When I send a GET request to "api/inventory?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | inventoryId | storeId | filmId |
      | 3           | 1       | 3      |
      | 4           | 1       | 4      |

  @repository @disableForeignKeys
  Scenario: Create a new inventory
    When I send a POST request to "api/inventory":
      | storeId | filmId |
      | 1       | 5      |
    Then the response code should be 201
    And the JSON response should contain:
      | inventoryId | storeId | filmId |
      | 5           | 1       | 5      |
    And the following inventory should be saved:
      | inventory_id | store_id | film_id |
      | 5            | 1        | 5       |

  @repository @disableForeignKeys
  Scenario: Update an existing inventory
    When I send a PUT request to "api/inventory/4":
      | filmId |
      | 5      |
    Then the response code should be 200
    And the JSON response should contain:
      | inventoryId | storeId | filmId |
      | 4           | 1       | 5      |
    And the following inventory should be saved:
      | inventory_id | store_id | film_id |
      | 4            | 1        | 5       |
    When I send a GET request to "api/inventory/1"
    Then the response code should be 200
    And the JSON response should contain:
      | inventoryId | storeId | filmId |
      | 1           | 1       | 1      |

  @repository @disableForeignKeys
  Scenario: Remove an inventory
    When I send a DELETE request to "api/inventory/3"
    Then the response code should be 200
    And the following inventory should not be saved:
      | inventory_id | store_id | film_id |
      | 3            | 1        | 3       |
    When I send a GET request to "api/inventory/1"
    Then the response code should be 200
    And the JSON response should contain:
      | inventoryId | storeId | filmId |
      | 1           | 1       | 1      |

