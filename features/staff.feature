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
      | 2          | 48 MySakila Drive | Alberta  | 1       |             |       |
      | 3          | 49 MySakila Drive | Alberta  | 1       |             |       |
      | 4          | 50 MySakila Drive | Alberta  | 1       |             |       |
      | 5          | 51 MySakila Drive | Alberta  | 1       |             |       |
    And the following store(s) exist:
      | store_id | manager_staff_id | address_id |
      | 1        | 1                | 1          |
      | 2        | 2                | 2          |
      | 3        | 3                | 3          |
      | 4        | 4                | 4          |
    And the following staff(s) exist:
      | staff_id | first_name | last_name | address_id | store_id | username | password |
      | 1        | Joe        | Doe       | 1          | 1        | joedoe   | mypass   |
      | 2        | Jane       | Doe       | 1          | 2        | janedoe  | mypass   |
      | 3        | Jake       | Doe       | 1          | 3        | jakedoe  | mypass   |
      | 4        | Jo         | Doe       | 1          | 4        | jodoe    | mypass   |

  @repository @disableForeignKeys
  Scenario: Fetch a staff data
    When I send a GET request to "api/staff/1"
    Then the response code should be 200
    And the JSON response should contain:
      | staffId | firstName | lastName | addressId | storeId | username | password | email | active |
      | 1       | Joe       | Doe      | 1         | 1       | joedoe   | mypass   |       | 1      |

  @repository @disableForeignKeys
  Scenario: Fetch all staff
    When I send a GET request to "api/staff"
    Then the response code should be 200
    And the JSON response should contain:
      | staffId | firstName | lastName | addressId | storeId | username | password | email | active |
      | 1       | Joe       | Doe      | 1         | 1       | joedoe   | mypass   |       | 1      |
      | 2       | Jane      | Doe      | 1         | 2       | janedoe  | mypass   |       | 1      |
      | 3       | Jake      | Doe      | 1         | 3       | jakedoe  | mypass   |       | 1      |
      | 4       | Jo        | Doe      | 1         | 4       | jodoe    | mypass   |       | 1      |

  @repository @disableForeignKeys
  Scenario: Fetch all staff with pagination
    When I send a GET request to "api/staff?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | staffId | firstName | lastName | addressId | storeId | username | password | email | active |
      | 3       | Jake      | Doe      | 1         | 3       | jakedoe  | mypass   |       | 1      |
      | 4       | Jo        | Doe      | 1         | 4       | jodoe    | mypass   |       | 1      |

#
##    todo: implement
##  @repository
##  Scenario: Create a new staff
##    When I send a POST request to "api/staff":
##
##    Then the response code should be 201
##    And the JSON response should contain:
##
##    And the following store should be saved:
#


  @repository @disableForeignKeys
  Scenario: Update an existing staff
    When I send a PUT request to "api/staff/4":
      | addressId |
      | 5         |
    Then the response code should be 200
    And the JSON response should contain:
      | staffId | firstName | lastName | addressId | storeId | username | password | email | active |
      | 4       | Jo        | Doe      | 5         | 4       | jodoe    | mypass   |       | 1      |
    And the following staff should be saved:
      | staff_id | first_name | last_name | address_id | store_id | username | password | active |
      | 4        | Jo         | Doe       | 5          | 4        | jodoe    | mypass   | 1      |
    When I send a GET request to "api/staff/1"
    Then the response code should be 200
    And the JSON response should contain:
      | staffId | firstName | lastName | addressId | storeId | username | password | email | active |
      | 1       | Joe       | Doe      | 1         | 1       | joedoe   | mypass   |       | 1      |

  @repository @disableForeignKeys
  Scenario: Remove a staff
    When I send a DELETE request to "api/staff/3"
    Then the response code should be 200
    And the following staff should not be saved:
      | staff_id | first_name | last_name | address_id | store_id | username | password | active |
      | 3        | Jake       | Doe       | 1          | 3        | jakedoe  | mypass   | 1      |
    When I send a GET request to "api/staff/1"
    Then the response code should be 200
    And the JSON response should contain:
      | staffId | firstName | lastName | addressId | storeId | username | password | email | active |
      | 1       | Joe       | Doe      | 1         | 1       | joedoe   | mypass   |       | 1      |

