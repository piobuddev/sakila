Feature: The city API's endpoint
  In order to manipulate cities data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  @repository
  Scenario: Fetch a city data
    Given the following country(s) exist:
      | country_id | country        |
      | 1          | United Kingdom |
      | 2          | Italy          |
      | 3          | Peru           |
      | 4          | Nepal          |
      | 5          | France         |
    And the following city(s) exist:
      | city_id | city   | country_id |
      | 1       | London | 1          |
      | 2       | York   | 1          |
      | 3       | Rome   | 2          |
      | 4       | Lyon   | 5          |
      | 5       | Paris  | 5          |
    When I send a GET request to "api/cities/3"
    Then the response code should be 200
    And the JSON response should contain:
      | cityId | city | countryId |
      | 3      | Rome | 2         |

  @repository
  Scenario: Fetch a city data and include a country
    Given the following country(s) exist:
      | country_id | country        |
      | 1          | United Kingdom |
      | 2          | Italy          |
      | 3          | Peru           |
      | 4          | Nepal          |
      | 5          | France         |
    And the following city(s) exist:
      | city_id | city   | country_id |
      | 1       | London | 1          |
      | 2       | York   | 1          |
      | 3       | Rome   | 2          |
      | 4       | Lyon   | 5          |
      | 5       | Paris  | 5          |
    When I send a GET request to "api/cities/3?include=country"
    Then the response code should be 200
    And the JSON response should be equal:
    """
  {"cityId":3,"city":"Rome","countryId":2,"country":{"countryId":2,"country":"Italy"}}
    """


  @repository
  Scenario: Fetch all cities
    Given the following country(s) exist:
      | country_id | country        |
      | 1          | United Kingdom |
      | 2          | Italy          |
      | 3          | Peru           |
      | 4          | Nepal          |
      | 5          | France         |
    And the following city(s) exist:
      | city_id | city   | country_id |
      | 1       | London | 1          |
      | 2       | York   | 1          |
      | 3       | Rome   | 2          |
      | 4       | Lyon   | 5          |
      | 5       | Paris  | 5          |
    When I send a GET request to "api/cities"
    Then the response code should be 200
    And the JSON response should contain:
      | cityId | city   | countryId |
      | 1      | London | 1         |
      | 2      | York   | 1         |
      | 3      | Rome   | 2         |
      | 4      | Lyon   | 5         |
      | 5      | Paris  | 5         |

  @repository
  Scenario: Fetch all cities with pagination
    Given the following country(s) exist:
      | country_id | country        |
      | 1          | United Kingdom |
      | 2          | Italy          |
      | 3          | Peru           |
      | 4          | Nepal          |
      | 5          | France         |
    And the following city(s) exist:
      | city_id | city   | country_id |
      | 1       | London | 1          |
      | 2       | York   | 1          |
      | 3       | Rome   | 2          |
      | 4       | Lyon   | 5          |
      | 5       | Paris  | 5          |
    When I send a GET request to "api/cities?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | cityId | city | countryId |
      | 3      | Rome | 2         |
      | 4      | Lyon | 5         |

  @repository
  Scenario: Create a new city
    Given the following country(s) exist:
      | country_id | country        |
      | 1          | United Kingdom |
      | 2          | Italy          |
      | 3          | Peru           |
      | 4          | Nepal          |
      | 5          | France         |
    And the following city(s) exist:
      | city_id | city   | country_id |
      | 1       | London | 1          |
      | 2       | York   | 1          |
      | 3       | Rome   | 2          |
      | 4       | Lyon   | 5          |
      | 5       | Paris  | 5          |
    When I send a POST request to "api/cities":
      | city    | countryId |
      | Bristol | 1         |
    Then the response code should be 201
    And the JSON response should contain:
      | cityId | city    | countryId |
      | 6      | Bristol | 1         |
    And the following city should be saved:
      | city_id | city    | country_id |
      | 6       | Bristol | 1          |

  @repository
  Scenario: Update an existing city
    Given the following country(s) exist:
      | country_id | country        |
      | 1          | United Kingdom |
      | 2          | Italy          |
      | 3          | Peru           |
      | 4          | Nepal          |
      | 5          | France         |
    And the following city(s) exist:
      | city_id | city   | country_id |
      | 1       | London | 1          |
      | 2       | York   | 1          |
      | 3       | Rome   | 2          |
      | 4       | Lyonn  | 5          |
      | 5       | Paris  | 5          |
    When I send a PUT request to "api/cities/4":
      | city |
      | Lyon |
    Then the response code should be 200
    And the JSON response should contain:
      | cityId | city | countryId |
      | 4      | Lyon | 5         |
    And the following city should be saved:
      | city_id | city | country_id |
      | 4       | Lyon | 5          |
    When I send a GET request to "api/cities/1"
    Then the response code should be 200
    And the JSON response should contain:
      | cityId | city   | countryId |
      | 1      | London | 1         |

  @repository
  Scenario: Remove an city
    Given the following country(s) exist:
      | country_id | country        |
      | 1          | United Kingdom |
      | 2          | Italy          |
      | 3          | Peru           |
      | 4          | Nepal          |
      | 5          | France         |
    And the following city(s) exist:
      | city_id | city   | country_id |
      | 1       | London | 1          |
      | 2       | York   | 1          |
      | 3       | Rome   | 2          |
      | 4       | Lyon   | 5          |
      | 5       | Paris  | 5          |
    When I send a DELETE request to "api/cities/3"
    Then the response code should be 200
    And the following city should not be saved:
      | city_id | city |
      | 3       | Rome |
    When I send a GET request to "api/cities/1"
    Then the response code should be 200
    And the JSON response should contain:
      | cityId | city   | countryId |
      | 1      | London | 1         |
