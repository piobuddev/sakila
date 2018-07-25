Feature: The address API's endpoint
  In order to manipulate addresses data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  Background:
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
    And the following address(s) exist:
      | address_id | address                   | district | city_id | postal_code | phone       |
      | 1          | 47 MySakila     Drive     | Alberta  | 1       |             |             |
      | 2          | 28 MySQL        Boulevard | QLD      | 1       |             |             |
      | 3          | 23 Workhaven    Lane      | Alberta  | 2       |             | 14033335568 |
      | 4          | 1411 Lillydale  Drive     | QLD      | 3       |             | 6172235589  |
      | 5          | 1913 Hanoi      Way       | Nagasaki | 4       | 35200       | 28303384290 |

  @repository
  Scenario: Fetch a address data
    When I send a GET request to "api/addresses/3"
    Then the response code should be 200
    And the JSON response should contain:
      | id | address              | address2 | district | cityId | postalCode | phone       |
      | 3  | 23 Workhaven    Lane |          | Alberta  | 2      |            | 14033335568 |

  @repository
  Scenario: Fetch a address data and include city
    When I send a GET request to "api/addresses/3?include=city"
    Then the response code should be 200
    And the JSON response should be equal:
    """
{"id":3,"address":"23 Workhaven    Lane","address2":null,"district":"Alberta","cityId":2,"postalCode":"","phone":"14033335568","city":{"cityId":2,"city":"York","countryId":1}}
    """

  @repository
  Scenario: Fetch all addresses
    When I send a GET request to "api/addresses"
    Then the response code should be 200
    And the JSON response should contain:
      | id | address                   | address2 | district | cityId | postalCode | phone       |
      | 1  | 47 MySakila     Drive     |          | Alberta  | 1      |            |             |
      | 2  | 28 MySQL        Boulevard |          | QLD      | 1      |            |             |
      | 3  | 23 Workhaven    Lane      |          | Alberta  | 2      |            | 14033335568 |
      | 4  | 1411 Lillydale  Drive     |          | QLD      | 3      |            | 6172235589  |
      | 5  | 1913 Hanoi      Way       |          | Nagasaki | 4      | 35200      | 28303384290 |

  @repository
  Scenario: Fetch all addresses with pagination
    When I send a GET request to "api/addresses?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | id | address               | address2 | district | cityId | postalCode | phone       |
      | 3  | 23 Workhaven    Lane  |          | Alberta  | 2      |            | 14033335568 |
      | 4  | 1411 Lillydale  Drive |          | QLD      | 3      |            | 6172235589  |


  @repository
  Scenario: Create a new address
    When I send a POST request to "api/addresses":
      | address           | district | cityId | phone       |
      | 25 Workhaven Lane | Alberta  | 2      | 14033335568 |
    Then the response code should be 201
    And the JSON response should contain:
      | id | address           | address2 | district | cityId | postalCode | phone       |
      | 6  | 25 Workhaven Lane |          | Alberta  | 2      |            | 14033335568 |
    And the following address should be saved:
      | address_id | address           | district | city_id | phone       |
      | 6          | 25 Workhaven Lane | Alberta  | 2       | 14033335568 |

  @repository
  Scenario: Update an existing address
    When I send a PUT request to "api/addresses/4":
      | address               | address2 | district | cityId | postalCode | phone      |
      | 1411 Lillydale  Drive |          | QLD      | 3      | abc        | 6172235589 |
    Then the response code should be 200
    And the JSON response should contain:
      | id | address               | address2 | district | cityId | postalCode | phone      |
      | 4  | 1411 Lillydale  Drive |          | QLD      | 3      | abc        | 6172235589 |
    And the following address should be saved:
      | address_id | address               | district | city_id | postal_code | phone      |
      | 4          | 1411 Lillydale  Drive | QLD      | 3       | abc         | 6172235589 |
    When I send a GET request to "api/addresses/1"
    Then the response code should be 200
    And the JSON response should contain:
      | id | address               | address2 | district | cityId | postalCode | phone |
      | 1  | 47 MySakila     Drive |          | Alberta  | 1      |            |       |

  @repository
  Scenario: Remove an address
    When I send a DELETE request to "api/addresses/3"
    Then the response code should be 200
    And the following address should not be saved:
      | address_id | address              | district | city_id | postal_code | phone       |
      | 3          | 23 Workhaven    Lane | Alberta  | 2       |             | 14033335568 |
    When I send a GET request to "api/addresses/1"
    Then the response code should be 200
    And the JSON response should contain:
      | id | address               | address2 | district | cityId | postalCode | phone |
      | 1  | 47 MySakila     Drive |          | Alberta  | 1      |            |       |
