Feature: The film API's endpoint
  In order to manipulate films data
  as an API's client
  I want to be able to perform CRUD operations with the HTTP request

  Background:
    Given the following language(s) exist:
      | language_id | name     |
      | 1           | English  |
      | 2           | Italian  |
      | 3           | Japanese |
      | 4           | Mandarin |
      | 5           | French   |
    And the following actor(s) exist:
      | actor_id | first_name | last_name |
      | 1        | Anthony    | Hopkins   |
      | 2        | Audrey     | Tautou    |
      | 3        | Leonardo   | DiCaprio  |
      | 4        | Natalie    | Portman   |
      | 5        | Christian  | Bale      |
      | 6        | Monica     | Bellucci  |
    And the following category(s) exist:
      | category_id | name   |
      | 1           | Action |
      | 2           | Comedy |
      | 3           | Drama  |
      | 4           | Horror |
      | 5           | Family |
    And the following film(s) exist:
      | film_id | title            | description                                                                                                           | release_year | language_id | original_language_id | rental_duration | rental_rate | length | replacement_cost | rating |
      | 1       | ACADEMY DINOSAUR | A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies                      | 2006         | 1           | null                 | 6               | 0.99        | 86     | 20.99            | PG     |
      | 2       | ACE GOLDFINGER   | A Astounding Epistle of a Database Administrator And a Explorer who must Find a Car in Ancient China                  | 2006         | 1           | null                 | 3               | 4.99        | 48     | 12.99            | G      |
      | 3       | ADAPTATION HOLES | A Astounding Reflection of a Lumberjack And a Car who must Sink a Lumberjack in A Baloon Factory                      | 2006         | 1           | null                 | 7               | 2.99        | 50     | 18.99            | NC-17  |
      | 4       | AFFAIR PREJUDICE | A Fanciful Documentary of a Frisbee And a Lumberjack who must Chase a Monkey in A Shark Tank                          | 2006         | 1           | null                 | 5               | 2.99        | 117    | 26.99            | G      |
      | 5       | AFRICAN EGG      | A Fast-Paced Documentary of a Pastry Chef And a Dentist who must Pursue a Forensic Psychologist in The Gulf of Mexico | 2006         | 1           | null                 | 6               | 2.99        | 130    | 22.99            | G      |
    And the following film_actor(s) exist:
      | actor_id | film_id |
      | 1        | 1       |
      | 2        | 1       |
      | 3        | 1       |
      | 4        | 2       |
      | 5        | 2       |
      | 6        | 3       |
    And the following film_category(s) exist:
      | category_id | film_id |
      | 1           | 1       |
      | 2           | 1       |
      | 3           | 1       |
      | 4           | 2       |
      | 5           | 3       |

  @repository
  Scenario: Fetch an film data
    When I send a GET request to "api/films/1"
    Then the response code should be 200
    And the JSON response should contain:
      | filmId | title            | description                                                                                      | releaseYear | languageId | originalLanguageId | rentalDuration | rentalRate | length | replacementCost | rating | specialFeatures |
      | 1      | ACADEMY DINOSAUR | A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies | 2006        | 1          | null               | 6              | 0.99       | 86     | 20.99           | PG     | null            |

  @repository
  Scenario: Fetch a film data with actors
    When I send a GET request to "api/films/1?include=actors"
    Then the response code should be 200
    And the JSON response should be equal:
    """
{"filmId":1,"title":"ACADEMY DINOSAUR","description":"A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies","releaseYear":2006,"languageId":1,"originalLanguageId":null,"rentalDuration":6,"rentalRate":"0.99","length":86,"replacementCost":"20.99","rating":"PG","specialFeatures":null,"actors":{"data":[{"actorId":1,"firstName":"Anthony","lastName":"Hopkins"},{"actorId":2,"firstName":"Audrey","lastName":"Tautou"},{"actorId":3,"firstName":"Leonardo","lastName":"DiCaprio"}]}}
    """

  @repository
  Scenario: Fetch a film data with categories
    When I send a GET request to "api/films/1?include=categories"
    Then the response code should be 200
    And the JSON response should be equal:
    """
{"filmId":1,"title":"ACADEMY DINOSAUR","description":"A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies","releaseYear":2006,"languageId":1,"originalLanguageId":null,"rentalDuration":6,"rentalRate":"0.99","length":86,"replacementCost":"20.99","rating":"PG","specialFeatures":null,"categories":{"data":[{"categoryId":1,"name":"Action"},{"categoryId":2,"name":"Comedy"},{"categoryId":3,"name":"Drama"}]}}
    """

  @repository
  Scenario: Fetch all films
    When I send a GET request to "api/films"
    Then the response code should be 200
    And the JSON response should contain:
      | filmId | title            | description                                                                                                           | releaseYear | languageId | originalLanguageId | rentalDuration | rentalRate | length | replacementCost | rating | specialFeatures |
      | 1      | ACADEMY DINOSAUR | A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies                      | 2006        | 1          | null               | 6              | 0.99       | 86     | 20.99           | PG     | null            |
      | 2      | ACE GOLDFINGER   | A Astounding Epistle of a Database Administrator And a Explorer who must Find a Car in Ancient China                  | 2006        | 1          | null               | 3              | 4.99       | 48     | 12.99           | G      | null            |
      | 3      | ADAPTATION HOLES | A Astounding Reflection of a Lumberjack And a Car who must Sink a Lumberjack in A Baloon Factory                      | 2006        | 1          | null               | 7              | 2.99       | 50     | 18.99           | NC-17  | null            |
      | 4      | AFFAIR PREJUDICE | A Fanciful Documentary of a Frisbee And a Lumberjack who must Chase a Monkey in A Shark Tank                          | 2006        | 1          | null               | 5              | 2.99       | 117    | 26.99           | G      | null            |
      | 5      | AFRICAN EGG      | A Fast-Paced Documentary of a Pastry Chef And a Dentist who must Pursue a Forensic Psychologist in The Gulf of Mexico | 2006        | 1          | null               | 6              | 2.99       | 130    | 22.99           | G      | null            |

  @repository  @disableForeignKeys
  Scenario: Fetch all films with pagination
    When I send a GET request to "api/films?page=2&page_size=2"
    Then the response code should be 200
    And the JSON response should contain:
      | filmId | title            | description                                                                                      | releaseYear | languageId | originalLanguageId | rentalDuration | rentalRate | length | replacementCost | rating | specialFeatures |
      | 3      | ADAPTATION HOLES | A Astounding Reflection of a Lumberjack And a Car who must Sink a Lumberjack in A Baloon Factory | 2006        | 1          | null               | 7              | 2.99       | 50     | 18.99           | NC-17  | null            |
      | 4      | AFFAIR PREJUDICE | A Fanciful Documentary of a Frisbee And a Lumberjack who must Chase a Monkey in A Shark Tank     | 2006        | 1          | null               | 5              | 2.99       | 117    | 26.99           | G      | null            |

  @repository
  Scenario: Create a new film
    When I send a POST request to "api/films":
      | title     | description | releaseYear | languageId | originalLanguageId | rentalDuration | rentalRate | length | replacementCost | rating |
      | The movie | Great movie | 1990        | 1          | 1                  | 7              | 3.00       | 120    | 30.99           | G      |
    Then the response code should be 201
    And the JSON response should contain:
      | filmId | title     | description | releaseYear | languageId | originalLanguageId | rentalDuration | rentalRate | length | replacementCost | rating | specialFeatures |
      | 6      | The movie | Great movie | 1990        | 1          | 1                  | 7              | 3.00       | 120    | 30.99           | G      | null            |
    And the following film should be saved:
      | film_id | title     | description | release_year | language_id | original_language_id | rental_duration | rental_rate | length | replacement_cost | rating |
      | 6       | The movie | Great movie | 1990         | 1           | 1                    | 7               | 3.00        | 120    | 30.99            | G      |

  @repository
  Scenario: Update an existing film
    When I send a PUT request to "api/films/4":
      | releaseYear |
      | 2005        |
    Then the response code should be 200
    And the JSON response should contain:
      | filmId | title            | description                                                                                  | releaseYear | languageId | originalLanguageId | rentalDuration | rentalRate | length | replacementCost | rating | specialFeatures |
      | 4      | AFFAIR PREJUDICE | A Fanciful Documentary of a Frisbee And a Lumberjack who must Chase a Monkey in A Shark Tank | 2005        | 1          | null               | 5              | 2.99       | 117    | 26.99           | G      | null            |
    And the following film should be saved:
      | film_id | title            | description                                                                                  | release_year | language_id | rental_duration | rental_rate | length | replacement_cost | rating |
      | 4       | AFFAIR PREJUDICE | A Fanciful Documentary of a Frisbee And a Lumberjack who must Chase a Monkey in A Shark Tank | 2005         | 1           | 5               | 2.99        | 117    | 26.99            | G      |
    When I send a GET request to "api/films/1"
    Then the response code should be 200
    And the JSON response should contain:
      | filmId | title            | description                                                                                      | releaseYear | languageId | originalLanguageId | rentalDuration | rentalRate | length | replacementCost | rating | specialFeatures |
      | 1      | ACADEMY DINOSAUR | A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies | 2006        | 1          | null               | 6              | 0.99       | 86     | 20.99           | PG     | null            |

  @repository
  Scenario: Remove a film
    When I send a DELETE request to "api/films/3"
    Then the response code should be 200
    And the following film should not be saved:
      | film_id | title            | description                                                                                      | release_year | language_id | rental_duration | rental_rate | length | replacement_cost | rating |
      | 3       | ADAPTATION HOLES | A Astounding Reflection of a Lumberjack And a Car who must Sink a Lumberjack in A Baloon Factory | 2006         | 1           | 7               | 2.99        | 50     | 18.99            | NC-17  |
    When I send a GET request to "api/films/1"
    Then the response code should be 200
    And the JSON response should contain:
      | filmId | title            | description                                                                                      | releaseYear | languageId | originalLanguageId | rentalDuration | rentalRate | length | replacementCost | rating | specialFeatures |
      | 1      | ACADEMY DINOSAUR | A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies | 2006        | 1          | null               | 6              | 0.99       | 86     | 20.99           | PG     | null            |
