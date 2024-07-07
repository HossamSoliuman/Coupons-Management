<!DOCTYPE html>
<html>

<head>
    <title>Marketer Data Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Marketer Data Form</h2>
        <form id="marketerForm">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required />
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required />
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required />
            </div>
            <div class="form-group">
                <label for="company">Company:</label>
                <input type="text" class="form-control" id="company" name="company" required />
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" class="form-control" id="subject" name="subject" required />
            </div>
            <div class="form-group">
                <label for="body">Message:</label>
                <textarea class="form-control" id="body" name="body" rows="4" required></textarea>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Send a message</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('marketerForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var name = encodeURIComponent(document.getElementById('name').value);
            var email = encodeURIComponent(document.getElementById('email').value);
            var phone = encodeURIComponent(document.getElementById('phone').value);
            var company = encodeURIComponent(document.getElementById('company').value);
            var subject = encodeURIComponent(document.getElementById('subject').value);
            var body = encodeURIComponent(document.getElementById('body').value);

            var mailtoLink = 'mailto:hossamsoliuman@gmail.com' +
                '?subject=' + subject +
                '&body=' + 'Name: ' + name + '%0A' +
                'Email: ' + email + '%0A' +
                'Phone: ' + phone + '%0A' +
                'Company: ' + company + '%0A' +
                'Message: ' + body;

            window.location.href = mailtoLink;
        });
    </script>
</body>

</html>
