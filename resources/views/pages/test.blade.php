<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <script>
        
        document.addEventListener('DOMContentLoaded', (e)=>{
            $ajax({
                url: url('/api/trial'),
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: JSON.stringify({
                    'email': 'iba@gmail.com',
                    'password': 'ibacodeur',
                }),

                success: function(response){
                    console.log(response);
                },
                error: function(erreurs){
                    console.log(erreurs);
                }

            })
        });
    </script>
    
</body>
</html>