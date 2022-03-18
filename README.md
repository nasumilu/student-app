# nasumilu/student-app

This is a quick example of a PHP app using [OpenSwoole][1] which provides a simple to navigate API

## Endpoints

| Path                         | Arguments | Description                                                         |
|------------------------------|-----------|---------------------------------------------------------------------|
| /students                    | none      | Gets a list of all students                                         |
| /student-{id}                | int       | Gets a student's information by their unique student id             | 
| /student-{id}/grades         | int       | Gets a student's grades by their unique student id                  |
| /student-{id}/grades/stats   | int       | Gets a student's grading stats by their unique student id           |
| /student-{id}/grades/average | int       | Gets a student's grade point average by there unique student id     |
| /student-{id}/grades/maximum | int       | Gets a student's maximum (highest) grade by their unique student id |
| /student-{id}/grades/minimum | int       | Gets a student's minimum (lowes) grade by their unique student id   |
| /student-{id}/grades/count   | int       | Gets the number of grades assigned by their unique student id       |

## Response

All responses are `application/json` with a `status` and `data` property.

### Examples

### /students

```json
{
  "status": 200,
  "data": [
    {
      "id": 1,
      "name": "Test Student One",
     "grades": [
      100,
      ...
     ]
    }, ...
  ]
}
```

### /student-{id}

```json
{
  "status": 200,
  "data": {
    "id": 1,
    "name": "Test Student One",
    "grades": [
      100,
     ...
    ]
  }
}
```

### /student-{id}/grades
```json
{
 "status": 200,
 "data": [
  100,
  ...
 ]
}
```

### /student-{id}/grades/stats

```json
{
  "status": 200,
  "data": {
    "sum": 556.6,
    "average": 92.8,
    "maximum": 100,
    "minimum": 78.4,
    "count": 6
  }
}
```

### /student-{id}/grades/average

```json
{
  "status": 200,
  "data": 92.8
}
```

### /student-{id}/grades/maximum

```json
{
 "status": 200,
 "data": 100
}
```

### /student-{id}/grades/minimum
```json
{
  "status": 200,
  "data": 78.4
}
```

### /student-{id}/grades/count

```json
{
  "status": 200,
  "data": 6
}
```

### Exceptions and Errors

Any errors will respond with the appropriate HTTP status code.

### 404 Not Found

```json
{
  "status": 404,
  "message": "Not Found!"
}
```

### 405 Method Not Allowed

```json
{
    "status": 405,
    "message": "Method Not Allowed"
}
```

### 500 Internal Server Error

```json
{
    "status": 405,
    "message": "Internal Server Error"
}
```


[1]: https://openswoole.com/