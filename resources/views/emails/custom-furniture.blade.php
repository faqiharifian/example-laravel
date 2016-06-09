<html>
<head></head>
<body>
    <h3>You got new custom furniture request</h3>
    <div class="sender">
        <h4>Request Sender:</h4>
        <table border="0">
            <tr>
                <td style="padding-right: 20px;">Name</td>
                <td>: {{ $name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: {{ $email }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>: {{ $phone }}</td>
            </tr>
        </table>
    </div>
    <div class="specification">
        <h5>Dimensions: </h5>
        <p>{{ $specification }}</p>
        <h5>Details: </h5>
        <p>{{ $detail }}</p>
    </div>
</body>
</html>