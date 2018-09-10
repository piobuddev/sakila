Feature: The payment API's endpoint
  In order to manipulate payments data
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
      | 5            | 1        | 5       |
    And the following rental(s) exist:
      | rental_id | rental_date         | inventory_id | customer_id | return_date         | staff_id |
      | 1         | 2018-05-24 22:53:30 | 1            | 1           | 2018-10-24 22:53:30 | 1        |
      | 2         | 2018-05-24 22:53:30 | 2            | 1           | 2018-10-24 22:53:30 | 1        |
      | 3         | 2018-05-24 22:53:30 | 3            | 2           | 2018-10-24 22:53:30 | 1        |
      | 4         | 2018-05-24 22:53:30 | 4            | 3           | 2018-10-24 22:53:30 | 1        |
      | 5         | 2018-05-24 22:53:30 | 5            | 4           | 2018-10-24 22:53:30 | 1        |
    And the following payment(s) exist:
      | payment_id | customer_id | staff_id | rental_id | amount | payment_date        |
      | 1          | 1           | 1        | 1         | 10.00  | 2018-10-28 12:45:00 |
      | 2          | 1           | 1        | 2         | 9.00   | 2018-10-28 12:47:00 |
      | 3          | 2           | 1        | 3         | 8.99   | 2018-10-28 12:48:00 |
      | 4          | 3           | 1        | 4         | 3.50   | 2018-11-28 12:49:00 |
      | 5          | 4           | 1        | 5         | 11.99  | 2018-11-29 12:55:00 |

  @repository @disableForeignKeys
  Scenario: Fetch a payment data
    When I send a GET request to "api/payments/1"
    Then the response code should be 200
    And the JSON response should contain:
      | paymentId | customerId | staffId | rentalId | amount | paymentDate         |
      | 1         | 1          | 1       | 1        | 10.00  | 2018-10-28 12:45:00 |

  @repository @disableForeignKeys
  Scenario: Fetch all payments
    When I send a GET request to "api/payments"
    Then the response code should be 200
    And the JSON response should contain:
      | paymentId | customerId | staffId | rentalId | amount | paymentDate         |
      | 1         | 1          | 1       | 1        | 10.00  | 2018-10-28 12:45:00 |
      | 2         | 1          | 1       | 2        | 9.00   | 2018-10-28 12:47:00 |
      | 3         | 2          | 1       | 3        | 8.99   | 2018-10-28 12:48:00 |
      | 4         | 3          | 1       | 4        | 3.50   | 2018-11-28 12:49:00 |
      | 5         | 4          | 1       | 5        | 11.99  | 2018-11-29 12:55:00 |

  @repository @disableForeignKeys
  Scenario: Fetch all payments with pagination
    When I send a GET request to "api/payments?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | paymentId | customerId | staffId | rentalId | amount | paymentDate         |
      | 3         | 2          | 1       | 3        | 8.99   | 2018-10-28 12:48:00 |
      | 4         | 3          | 1       | 4        | 3.50   | 2018-11-28 12:49:00 |

  @repository @disableForeignKeys
  Scenario: Create a new payment
    When I send a POST request to "api/payments":
      | customerId | staffId | rentalId | amount | paymentDate         |
      | 2          | 1       | 5        | 8.99   | 2018-10-28 12:48:00 |
    Then the response code should be 201
    And the JSON response should contain:
      | paymentId | customerId | staffId | rentalId | amount | paymentDate         |
      | 6         | 2          | 1       | 5        | 8.99   | 2018-10-28 12:48:00 |
    And the following payment should be saved:
      | payment_id | customer_id | staff_id | rental_id | amount | payment_date        |
      | 6          | 2           | 1        | 5         | 8.99   | 2018-10-28 12:48:00 |

  @repository @disableForeignKeys
  Scenario: Update an existing payment
    When I send a PUT request to "api/payments/5":
      | paymentId | customerId | staffId | rentalId | amount | paymentDate         |
      | 5         | 4          | 1       | 5        | 12.00  | 2018-11-29 12:55:00 |
    Then the response code should be 200
    And the JSON response should contain:
      | paymentId | customerId | staffId | rentalId | amount | paymentDate         |
      | 5         | 4          | 1       | 5        | 12.00  | 2018-11-29 12:55:00 |
    And the following payment should be saved:
      | payment_id | customer_id | staff_id | rental_id | amount | payment_date        |
      | 5          | 4           | 1        | 5         | 12.00  | 2018-11-29 12:55:00 |
    When I send a GET request to "api/payments/1"
    Then the response code should be 200
    And the JSON response should contain:
      | paymentId | customerId | staffId | rentalId | amount | paymentDate         |
      | 1         | 1          | 1       | 1        | 10.00  | 2018-10-28 12:45:00 |

  @repository @disableForeignKeys
  Scenario: Remove a payment
    When I send a DELETE request to "api/payments/3"
    Then the response code should be 200
    And the following payment should not be saved:
      | payment_id | customer_id | staff_id | rental_id | amount | payment_date        |
      | 3          | 2           | 1        | 3         | 8.99   | 2018-10-28 12:48:00 |
    When I send a GET request to "api/payments/1"
    Then the response code should be 200
    And the JSON response should contain:
      | paymentId | customerId | staffId | rentalId | amount | paymentDate         |
      | 1         | 1          | 1       | 1        | 10.00  | 2018-10-28 12:45:00 |
