# Test made by João Victor Fornitani Silva :)

## Start (Requirements):
- Have installed docker and docker-compose https://docs.docker.com/compose/install
- Inside the Project Use Command [docker-compose up -d db && sleep 10 && docker-compose up] (If the backend doesn't start, just run the docker-compose up command again)
- Use an endpoint query service("example:Postman") using localhost as a base
- Mysql local database
- Base url: localhost:80

## Documentation:

##### Swagger : https://editor.swagger.io/ and https://swagger.io/
- Coffee -> /src/Components/Coffee/swagger.yml
- API documentation is in swagger


## Endpoints:
#### POST (v1/coffee/espresso) - type Json
    - Example body {}

- Description: Endpoint to make an espresso

#### POST (v1/coffee/double-espresso) - type Json
    - Example body{}

- Description: Endpoint to make a double espresso

#### GET (v1/coffee/status) - Type Json
      - Example body{}

- Description: Endpoint to return current state of the machine


## Structure used

- Its main use is an Architecture based on DDD Domain-driven Design, which focuses on the division of the business rule and execution

- In addition to the use of metrics used in the Hexagonal Architecture, which distinguishes the infrastructure package from useCase, which is an orchestrator of executions when the rule is in the domain and the framework is in the infrastructure

- Use of some names of the MVC Framework

- With some Solid principles, such as Interface Segregation Principle and Dependency Inversion Principle
