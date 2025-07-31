<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Open AI Testing</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <style>
            body, html {
            // height: 100%;
            }
            .centered-form {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }
            .form-container {
                width: 100%;
                //max-width: 400px;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 10px;
                background-color: #f9f9f9;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body>
        <div class="container centered-form">
            <div class="form-container mt-5">
                <h1 class="text-center">Data Extraction</h1>
                <!-- Bootstrap 5 JS and dependencies (Popper.js and Bootstrap 5 JS) -->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
                <?php
                    $url = 'https://api.openai.com/v1/chat/completions';

                    $vars['model'] = 'gpt-4';
                    $vars['messages'] = array(0 => array('role'=>'system','content'=>'You are an expert summarizer. Please extract the lab results and categorize it into a table format from input text.'),
                        1 => array('role'=>'user','content'=>file_get_contents($file_path))
                                                );
                    $vars['temperature'] = 0.7;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($vars)); // Post Fields
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $headers = [
                        'Content-Type: application/json',
                        'Authorization: Bearer sk-proj-dBnpOJx7vE9txYqWo06gT3BlbkFJbHBKNZH9AWxHgZgnbTCs'
                    ];

                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $server_output = curl_exec($ch);

                    curl_close($ch);
                print "<pre>";
                     print_r( $server_output );
                     //exit;
                    $result = json_decode($server_output,TRUE);
                    
                    
                    if(!empty($result['choices'][0]['message']['content'])){
                        $content = $result['choices'][0]['message']['content'];
                        DB::table('fc_files')->where('id',$fileid)->update([
                            'ai_generated' => '1',  // Assuming you have the file ID
                            'summarized_data' => $content,
                        ]);
                        print $content;
                        print "</pre>";
                        exit;
                    }
                ?>
            </div>
        </div>
    </body>
</html>
