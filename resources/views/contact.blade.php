<!-- resources/views/contact.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Form</title>
</head>
<body>
    <form action="{{ route('contact.send') }}" method="POST">
        @csrf
        <div>
            <input type="email" placeholder="email@example.com" name="email" required />
        </div>
        <div>
            <input type="text" placeholder="Subject" name="subject" required />
        </div>
        <div>
            <textarea placeholder="Your message" name="body" required></textarea>
        </div>
        <div>
            <button type="submit">Send a message</button>
        </div>
    </form>
</body>
</html>
