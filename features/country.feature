Feature: The country API's endpoint
  In order to manipulate countries data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  @repository
  Scenario: Fetch an country data
    Given the following country(s) exist:
      | country_id | country |
      | 1          | Brazil  |
      | 2          | Greece  |
      | 3          | France  |
      | 4          | Nepal   |
      | 5          | Peru    |
    When I send a GET request to "api/countries/3"
    Then the response code should be 200
    And the JSON response should contain:
      | countryId | country |
      | 3         | France  |

  @repository
  Scenario: Fetch all countries
    Given the following country(s) exist:
      | country_id | country |
      | 1          | Brazil  |
      | 2          | Greece  |
      | 3          | France  |
      | 4          | Nepal   |
      | 5          | Peru    |
    When I send a GET request to "api/countries"
    Then the response code should be 200
    And the JSON response should contain:
      | countryId | country |
      | 1         | Brazil  |
      | 2         | Greece  |
      | 3         | France  |
      | 4         | Nepal   |
      | 5         | Peru    |

  @repository
  Scenario: Fetch all countries with pagination
    Given the following country(s) exist:
      | country_id | country |
      | 1          | Brazil  |
      | 2          | Greece  |
      | 3          | France  |
      | 4          | Nepal   |
      | 5          | Peru    |
    When I send a GET request to "api/countries?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | countryId | country |
      | 3         | France  |
      | 4         | Nepal   |

  @repository
  Scenario: Create a new country
    Given the following country(s) exist:
      | country_id | country |
      | 1          | Brazil  |
      | 2          | Greece  |
      | 3          | France  |
      | 4          | Nepal   |
      | 5          | Peru    |
    When I send a POST request to "api/countries":
      | country |
      | Spain   |
    Then the response code should be 201
    And the JSON response should contain:
      | countryId | country |
      | 6         | Spain   |
    And the following country should be saved:
      | country_id | country |
      | 6          | Spain   |

  @repository
  Scenario: Update an existing country
    Given the following country(s) exist:
      | country_id | country |
      | 1          | Brazil  |
      | 2          | Greece  |
      | 3          | France  |
      | 4          | Nepall  |
      | 5          | Peru    |
    When I send a PUT request to "api/countries/4":
      | country |
      | Nepal   |
    Then the response code should be 200
    And the JSON response should contain:
      | countryId | country |
      | 4         | Nepal   |
    And the following country should be saved:
      | country_id | country |
      | 4          | Nepal   |
    When I send a GET request to "api/countries/1"
    Then the response code should be 200
    And the JSON response should contain:
      | countryId | country |
      | 1         | Brazil  |

  @repository
  Scenario: Remove an country
    Given the following country(s) exist:
      | country_id | country |
      | 1          | Brazil  |
      | 2          | Greece  |
      | 3          | France  |
      | 4          | Nepal   |
      | 5          | Peru    |
    When I send a DELETE request to "api/countries/3"
    Then the response code should be 200
    And the following country should not be saved:
      | country_id | country |
      | 3          | France  |
    When I send a GET request to "api/countries/1"
    Then the response code should be 200
    And the JSON response should contain:
      | countryId | country |
      | 1         | Brazil  |
