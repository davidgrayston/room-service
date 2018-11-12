# Room Service

Service that navigates an imaginary robotic hoover through an imaginary room.

Installation
-----------------------

Install and run the application:
```
make install
```

Run the application after installation:
```
make up
```

Stop the application:
```
make down
```

Run tests:
```
make test
```

Update the project dependencies, e.g. composer
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
- The `/room/hoover` endpoint is handled by the [controller](./app/Http/Controllers/RoomController.php)
- The JSON payload is validated against a [JSON Schema](./resources/jsonschema/room.hoover.request.json)
  by the [room.hoover.validate](./app/Http/Middleware/RoomHooverRequestValidator.php) middleware

#### Application Code
The classes that deal with moving the hoover around the room can be found in the [App\RoomService](./app/RoomService) namespace.
- `App\RoomService\Area` deals with the room area and coordinates
- `App\RoomService\Device` deals with the device being moved around the room

#### Request Log
All request inputs/outputs are logged using the [ApiRequest](./app/ApiRequest.php) model.

The log can be viewed at <http://localhost:8080/log>

### Testing
Tests can be found in the [tests](./tests/) directory
- [HooverRoomRequestTest](./tests/Feature/HooverRoomRequestTest.php) tests the input/output of the API request.
- [PHPUnit tests](./tests/Unit) cover the input/output of the application class methods.

### Docker
Docker has been used to containerise the application:
- [Makefile](./Makefile) provides useful commands to install/start/stop/test
- [Docker Compose](./docker-compose.yml) defines the [app](./app.dockerfile), [web](web.dockerfile) and 
  database services required to run the application 
