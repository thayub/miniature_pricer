<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <title>Regent Markets</title>
        
        <script type="text/javascript">
            function submit(){
                                var formData={
                                currentPrice:$('#current').val(),
                                time:$('#time').val()
                                };
                        
                            $.ajax ({
                                url: 'service.php', 
                                type: 'POST',
                                dataType:"text",
                                data: formData,
                                success: function(response){
                                    $('#outputdiv').show();
                                    $('#answer').html(response);
                                }
                             });
            }
        </script>    
    </head>
    
    <body>
    
        
    Current Spot Price : <input type="text" name="current" id="current"><br>
    Time in year (days): <input type="text" name="time" id="time"><br>
    
    <input type="submit" value="Get the value future contract" id="submit" onclick ="submit()"/>
    
    <div id="outputdiv" name="outputdiv" style="display: none">
        <textarea id="answer" name="answer" cols="50" rows="10" style="padding:5px;">   
        </textarea>
    </div>
   
    </body>
</html>
