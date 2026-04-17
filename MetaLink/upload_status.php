<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Status</title>
    <style>
        form {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .video {
            color: white; /* Set text color to white */
            font-size: 16px; /* Adjust font size as needed */
            background-color: #25d366;
            border: none;
            height: 150px;
            width: 150px;
            border-radius: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: 2s upload ease-in infinite;
            cursor: pointer;
        }

        button {
            margin: 4vh;
            color: white;
            display: inline-block;
            padding: 8px 12px;
            cursor: pointer;
            background-color: #007bff;
            border-radius: 4px;
            border: none;
        }

        @keyframes upload {
            0% { box-shadow: 0 0 1px 1px #25d366; }
            50% { box-shadow: 0 0 50px 10px #25d366; }
            100% { box-shadow: 0 0 1px 1px #25d366; }
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form id="uploadForm" enctype="multipart/form-data">
        <label for="file-upload" class="video" id="progress">Choose File</label>
        <input id="file-upload" type="file" style="display: none;" onchange="showUploadButton()">
        <br><br><br>
        
        <button type="button" id="upload-btn" style="display: none;" onclick="uploadFile()">Upload</button>
    </form>

    <script>
        let pro = document.getElementById('progress');

        function showUploadButton() {
            document.getElementById('upload-btn').style.display = 'inline-block';
        }

        function uploadFile() {
            const fileInput = document.getElementById('file-upload');
            const file = fileInput.files[0];
            if (!file) return alert("Please choose a file to upload.");

            const formData = new FormData();
            formData.append('video', file);

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload_s.php', true);

            xhr.upload.onprogress = function(event) {
                if (event.lengthComputable) {
                    const percentComplete = Math.round((event.loaded / event.total) * 100);
                    pro.innerHTML = percentComplete + '%'; // Display percentage in the green circle
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Redirect to status_upload.php upon successful upload
                    window.location.href = 'status_upload.php';
                } else {
                    alert('Upload failed.');
                }
            };

            xhr.send(formData);
        }
    </script>
</body>
</html>
