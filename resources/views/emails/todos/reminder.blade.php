{{-- UI Customization should be here --}}

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
  lang="en"
  xmlns="http://www.w3.org/1999/xhtml"
  xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office"
>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <title>TODO Rest</title>
  </head>
<body>
    <p>Hello {{$todo->user->email}}, this is a reminder that a todo's deadline has come</p>
    <h2>Todo's title: {{$todo->title}}</h2>
    <h2>Todo's description: {{$todo->description}}</h2>
    <h2>Todo's end date: {{$todo->end_date}}</h2>
</body>
</html>
