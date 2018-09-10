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
      | staff_id | first_name | last_name | address_id | store_id | username |
      | 1        | Joe        | Doe       | 1          | 1        | joedoe   |
      | 2        | Jane       | Doe       | 1          | 2        | janedoe  |
      | 3        | Jake       | Doe       | 1          | 3        | jakedoe  |
      | 4        | Jo         | Doe       | 1          | 4        | jodoe    |

  @repository @disableForeignKeys
  Scenario: Fetch a store data
    When I send a GET request to "api/stores/1"
    Then the response code should be 200
    And the JSON response should contain:
      | storeId | managerStaffId | addressId |
      | 1       | 1              | 1         |

  @repository @disableForeignKeys
  Scenario: Fetch all stores
    When I send a GET request to "api/stores"
    Then the response code should be 200
    And the JSON response should contain:
      | storeId | managerStaffId | addressId |
      | 1       | 1              | 1         |
      | 2       | 2              | 2         |
      | 3       | 3              | 3         |
      | 4       | 4              | 4         |

  @repository @disableForeignKeys
  Scenario: Fetch all stores with pagination
    When I send a GET request to "api/stores?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | storeId | managerStaffId | addressId |
      | 3       | 3              | 3         |
      | 4       | 4              | 4         |

#    todo: implement
#  @repository
#  Scenario: Create a new store
#    When I send a POST request to "api/stores":
#
#    Then the response code should be 201
#    And the JSON response should contain:
#
#    And the following store should be saved:

  @repository @disableForeignKeys
  Scenario: Update an existing actor
    When I send a PUT request to "api/stores/4":
      | storeId | managerStaffId | addressId |
      | 4       | 4              | 5         |
    Then the response code should be 200
    And the JSON response should contain:
      | storeId | managerStaffId | addressId |
      | 4       | 4              | 5         |
    And the following store should be saved:
      | store_id | manager_staff_id | address_id |
      | 4        | 4                | 5          |
    When I send a GET request to "api/stores/1"
    Then the response code should be 200
    And the JSON response should contain:
      | storeId | managerStaffId | addressId |
      | 1       | 1              | 1         |

  @repository @disableForeignKeys
  Scenario: Remove an actor
    When I send a DELETE request to "api/stores/3"
    Then the response code should be 200
    And the following store should not be saved:
      | store_id | manager_staff_id | address_id |
      | 3        | 3                | 3          |
    When I send a GET request to "api/stores/1"
    Then the response code should be 200
    And the JSON response should contain:
      | storeId | managerStaffId | addressId |
      | 1       | 1              | 1         |

