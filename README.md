# Room Service

Service that navigates an imaginary robotic hoover through an imaginary room.

Requirements
------------
- [Docker](https://docs.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

Installation
-----------------------

Install and run the application:
```
make install
```

### Useful Commands
Running the application (after installation):
```
make up
```

Stopping the application:
```
make down
```

Running tests:
```
make test
```

Updating the project dependencies, e.g. composer
```
make update
```


Implementation Overview
-----------------------

### Application
[Laravel](https://github.com/laravel/laravel) has been used as the framework for routing, application code and testing.

#### Web Service

##### OpenAPI Specification
- Interact with the service using the [Swagger-UI](http://localhost:8080).
- View the [OAS documentation](./public/openapi/roomservice.yml)

##### Endpoint
- The `/api/room/hoover` endpoint is handled by the [controller](./app/Http/Controllers/RoomController.php)
- The JSON payload is validated against a [JSON Schema](./resources/jsonschema/room.hoover.request.json)
  by the [room.hoover.validate](./app/Http/Middleware/RoomHooverRequestValidator.php) middleware

#### Application Code
The classes that deal with moving the hoover around the room can be found in the [App\RoomService](./app/RoomService) namespace.

- [App\RoomService\Area](./app/RoomService/Area) deals with the room area and coordinates
- [App\RoomService\Device](./app/RoomService/Device) deals with the device being moved around the room

#### Request Log
All request inputs/outputs are logged using the [ApiRequest](./app/ApiRequest.php) model.

The log can be viewed at <http://localhost:8080/log>

### Testing
Tests can be found in the [tests](./tests/) directory.

- [HooverRoomRequestTest](./tests/Feature/HooverRoomRequestTest.php) tests the input/output of the API request.
- [PHPUnit tests](./tests/Unit) cover the input/output of the application class methods.

### Docker
Docker has been used to containerise the application.

- [Makefile](./Makefile) provides useful commands to install/start/stop/test
- [Docker Compose](./docker-compose.yml) defines the [app](./app.dockerfile), [web](web.dockerfile) and 
  database services required to run the application 

Code Examples
-------------

### PHP

```php
$json_data = json_encode([
  'roomSize' => [5, 5],
  'coords' => [1, 2],
  'patches' => [
    [1, 0],
    [2, 2],
    [2, 3],
  ],
  'instructions' => 'NNESEESWNWW',
]);

$ch = curl_init('http://localhost:8080/api/room/hoover');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  'Accept: application/json',
  'Content-Type: application/json'
]);

$result = curl_exec($ch);

var_dump($result);
```

### curl

```
curl -X POST "http://localhost:8080/api/room/hoover" -H "accept: application/json" -H "Content-Type: application/json" -d "{\"roomSize\":[5,5],\"coords\":[1,2],\"patches\":[[1,0],[2,2],[2,3]],\"instructions\":\"NNESEESWNWW\"}"
```
