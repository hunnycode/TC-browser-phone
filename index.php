<?php
include 'Services/Twilio/Capability.php';

$accountSid = 'your twilio account SID';
$authToken  = 'your twilio Auth Token';

$capability = new Services_Twilio_Capability($accountSid, $authToken);
$capability->allowClientOutgoing('your twilio APP SID');
$capability->allowClientIncoming("your twilio client name");
$token = $capability->generateToken();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Twilio Client Browser Phone</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript" ></script>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="//static.twilio.com/libs/twiliojs/1.1/twilio.min.js"></script>

	<script type="text/javascript">
	 
		Twilio.Device.setup("<?php echo $token; ?>");

		Twilio.Device.ready(function (device) {
			$("#log").text("架電待機");
		});
	 
		Twilio.Device.error(function (error) {
			$("#log").text("Error: " + error.message);
		});
	 
		Twilio.Device.connect(function (conn) {
			$("#log").text("架電成功");
		});
	 
		Twilio.Device.disconnect(function (conn) {
			$("#log").text("架電終了");
		});
	 
		Twilio.Device.incoming(function (conn) {

	        if (confirm('Accept incoming call from ' + conn.parameters.From + '?')){
	            connection=conn;
	            conn.accept();
	        }
		});
	 
		function call() {
			// get the phone number to connect the call to
			params = {"PhoneNumber": $("#client_to_number").val()};
			Twilio.Device.connect(params);
		}
	 
		function hangup() {
			Twilio.Device.disconnectAll();
		}
	</script>

</head>
<body>
	<table align="center">
		<tr>
			<td>
			    <h1>Twilio Browser Phone</h1>
			    <form>
			    	<table class="table">
			    		<tr>
			    			<td>
					            <input class="input-xlarge" type="text" id="client_to_number" name="client_to_number" placeholder="発信先電話番号を入力してください。">
					            <br/>
					            <button class="btn btn-large btn-primary" type="button" id="client_callBtn" name="client_callBtn" onclick="call();">発信</button>
					            <button class="btn btn-large btn-primary" type="button" id="client_hangBtn" name="client_hangBtn" onclick="hangup();">切断</button>
								<div id="log">Loading pigeons...</div>
			            	</td>
			            </tr>
			        </table>
			    </form>
			</td>
		</tr>
	</table>
</body>
</html>