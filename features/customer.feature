Feature: The customer API's endpoint
  In order to manipulate customers data
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
    And the following store(s) exist:
      | store_id | manager_staff_id | address_id |
      | 1        | 1                | 1          |
    And the following staff(s) exist:
      | staff_id | first_name | last_name | address_id | store_id | username |
      | 1        | Joe        | Doe       | 1          | 1        | joedoe   |
    And the following customer(s) exist:
      | customer_id | store_id | first_name | last_name | email                  | address_id | create_date         |
      | 1           | 1        | Joe        | Doe       | joedoe@sakilatest.com  | 2          | 2358-02-14 22:04:36 |
      | 2           | 1        | Jane       | Doe       | janedoe@sakilatest.com | 2          | 2358-02-14 22:05:36 |
      | 3           | 1        | Jake       | Doe       | jakedoe@sakilatest.com | 2          | 2358-02-14 22:06:36 |
      | 4           | 1        | Jo         | Doe       | jodoe@sakilatest.com   | 2          | 2358-02-14 22:07:36 |

  @repository @disableForeignKeys
  Scenario: Fetch an customer data
    When I send a GET request to "api/customers/1"
    Then the response code should be 200
    And the JSON response should contain:
      | customerId | storeId | firstName | lastName | email                 | addressId | createDate          | active |
      | 1          | 1       | Joe       | Doe      | joedoe@sakilatest.com | 2         | 2358-02-14 22:04:36 | 1      |

  @repository @disableForeignKeys
  Scenario: Fetch all customers
    When I send a GET request to "api/customers"
    Then the response code should be 200
    And the JSON response should contain:
      | customerId | storeId | firstName | lastName | email                  | addressId | createDate          | active |
      | 1          | 1       | Joe       | Doe      | joedoe@sakilatest.com  | 2         | 2358-02-14 22:04:36 | 1      |
      | 2          | 1       | Jane      | Doe      | janedoe@sakilatest.com | 2         | 2358-02-14 22:05:36 | 1      |
      | 3          | 1       | Jake      | Doe      | jakedoe@sakilatest.com | 2         | 2358-02-14 22:06:36 | 1      |
      | 4          | 1       | Jo        | Doe      | jodoe@sakilatest.com   | 2         | 2358-02-14 22:07:36 | 1      |


  @repository  @disableForeignKeys
  Scenario: Fetch all customers with pagination
    When I send a GET request to "api/customers?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | customerId | storeId | firstName | lastName | email                  | addressId | createDate          | active |
      | 3          | 1       | Jake      | Doe      | jakedoe@sakilatest.com | 2         | 2358-02-14 22:06:36 | 1      |
      | 4          | 1       | Jo        | Doe      | jodoe@sakilatest.com   | 2         | 2358-02-14 22:07:36 | 1      |


  @repository @disableForeignKeys
  Scenario: Create a new customer
    When I send a POST request to "api/customers":
      | storeId | firstName | lastName | email                 | addressId | createDate          | active |
      | 1       | Jim       | Doe      | jimdoe@sakilatest.com | 2         | 2358-02-14 22:09:36 | 1      |
    Then the response code should be 201
    And the JSON response should contain:
      | customerId | storeId | firstName | lastName | email                 | addressId | createDate          | active |
      | 5          | 1       | Jim       | Doe      | jimdoe@sakilatest.com | 2         | 2358-02-14 22:09:36 | 1      |
    And the following customer should be saved:
      | customer_id | store_id | first_name | last_name | email                 | address_id | create_date         | active |
      | 5           | 1        | Jim        | Doe       | jimdoe@sakilatest.com | 2          | 2358-02-14 22:09:36 | 1      |

  @repository @disableForeignKeys
  Scenario: Update an existing customer
    When I send a PUT request to "api/customers/4":
      | active |
      | 0      |
    Then the response code should be 200
    And the JSON response should contain:
      | customerId | storeId | firstName | lastName | email                | addressId | createDate          | active |
      | 4          | 1       | Jo        | Doe      | jodoe@sakilatest.com | 2         | 2358-02-14 22:07:36 | 0      |
    And the following customer should be saved:
      | customer_id | store_id | first_name | last_name | email                | address_id | create_date         | active |
      | 4           | 1        | Jo         | Doe       | jodoe@sakilatest.com | 2          | 2358-02-14 22:07:36 | 0      |
    When I send a GET request to "api/customers/1"
    Then the response code should be 200
    And the JSON response should contain:
      | customerId | storeId | firstName | lastName | email                 | addressId | createDate          | active |
      | 1          | 1       | Joe       | Doe      | joedoe@sakilatest.com | 2         | 2358-02-14 22:04:36 | 1      |

  @repository @disableForeignKeys
  Scenario: Remove an customer
    When I send a DELETE request to "api/customers/3"
    Then the response code should be 200
    And the following customer should not be saved:
      | customer_id | store_id | first_name | last_name | email                  | address_id | create_date         | active |
      | 3           | 1        | Jake       | Doe       | jakedoe@sakilatest.com | 2          | 2358-02-14 22:06:36 | 1      |
    When I send a GET request to "api/customers/1"
    Then the response code should be 200
    And the JSON response should contain:
      | customerId | storeId | firstName | lastName | email                 | addressId | createDate          | active |
      | 1          | 1       | Joe       | Doe      | joedoe@sakilatest.com | 2         | 2358-02-14 22:04:36 | 1      |
