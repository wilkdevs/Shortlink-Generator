<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Redirecting...</title>
</head>
<body>
    <script>
        const short_url = "{{ $short_url }}";

        fetch('https://api.bigdatacloud.net/data/client-ip')
            .then(response => response.json())
            .then(data => {
                const clientIp = data.ipString || '';

                fetch('/' + short_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        ip: clientIp,
                        short_url: short_url
                    })
                })
                .then(res => res.json())
                .then(resData => {
                    if(resData.url) {
                        window.location.href = resData.url;
                    }
                })
                .catch(err => console.error('Failed to post IP:', err));
            })
            .catch(err => console.error("Failed to get IP:", err));
    </script>
</body>
</html>
