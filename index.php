<?php
if (isset($_GET["action"])) {
	switch ($_GET["action"]) {
		case 'getmail':
			$response = array();
			if (isset($_GET["folder"])) {
				$response["id"] = $_GET["folder"];
				$response["mails"][] = array(
					"id" => 11,
					"from" => "monica@mail.com",
					"to" => "max@mail.com",
					"date" => "May 2, 2011",
					"subject" => $_GET["folder"]." test subject",
					"folder" => $_GET["folder"]
				);
			}
			if (isset($_GET["mail"])) {
				$response = array(
					"id" => $_GET["mail"],
					"from" => "monica@mail.com",
					"to" => "max@mail.com",
					"date" => "May 2, 2011",
					"subject" => $_GET["mail"]." test subject",
					"messageContent" => "The Best content ever!<br/>Enjoy it! Say 'Yes!'",
					"folder" => ""
				);
			}
			header('Content-Type: application/json');
			echo json_encode($response);
		break;
		default:
		break;
	}
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Knockout Application</title>
<link href="http://learn.knockoutjs.com/Content/TutorialSpecific/webmail.css" type="text/css" rel="stylesheet"/>
<link href="style.css" type="text/css" rel="stylesheet"/>
<script type='text/javascript' src="jquery-3.2.1.min.js"></script>
<script type='text/javascript' src='knockout-3.4.2.js'></script>
<script type='text/javascript' src='sammy-latest.min.js'></script>
<script type='text/javascript' src='main.js'></script>
</head>
<body>

<h1>Introduction</h1>

<p>First name: <strong data-bind="text: firstName">todo</strong></p>
<p>Last name: <strong data-bind="text: lastName">todo</strong></p>
<p>Full name: <strong data-bind="text: fullName">todo</strong></p>

<p>First name: <input data-bind="value: firstName" /></p>
<p>Last name: <input data-bind="value: lastName" /></p>

<button data-bind="click: capitalizeLastName">Go caps</button>


<h1>Lists and Collections</h1>

<h2>Your seat reservations (<span data-bind="text: seats().length"></span>)</h2>

<table>
    <thead><tr>
        <th>Passenger name</th><th>Meal</th><th>Surcharge</th><th></th>
    </tr></thead>
    <tbody data-bind="foreach: seats">
		<tr>
			<td><input data-bind="value: name" /></td>
			<td><select data-bind="options: $root.availableMeals, value: meal, optionsText: 'mealName'"></select></td>
			<td data-bind="text: formattedPrice" align="center"></td>
			<td><a href="#" data-bind="click: $root.removeSeat">Remove</a></td>
		</tr>
	</tbody>
</table>

<button data-bind="click: addSeat, enable: seats().length < 5">Reserve another seat</button>

<h3 data-bind="visible: totalSurcharge() > 0">
    Total surcharge: $<span data-bind="text: totalSurcharge().toFixed(2)"></span>
</h3>

<h1>Single page Application</h1>

<ul data-bind="foreach: folders" class="folders">
    <li data-bind="text: $data, css: {selected: $data == $root.chosenFolderId()}, click: $root.goToFolder"></li>
</ul>
<!-- Mails grid -->
<table class="mails" data-bind="with: chosenFolderData">
    <thead><tr><th>From</th><th>To</th><th>Subject</th><th>Date</th></tr></thead>
    <tbody data-bind="foreach: mails">
        <tr data-bind="click: $root.goToMail">
            <td data-bind="text: from"></td>
            <td data-bind="text: to"></td>
            <td data-bind="text: subject"></td>
            <td data-bind="text: date"></td>
        </tr>     
    </tbody>
</table>

<!-- Chosen mail -->
<div class="viewMail" data-bind="with: chosenMailData">
    <div class="mailInfo">
        <h1 data-bind="text: subject"></h1>
        <p><label>From</label>: <span data-bind="text: from"></span></p>
        <p><label>To</label>: <span data-bind="text: to"></span></p>
        <p><label>Date</label>: <span data-bind="text: date"></span></p>
    </div>
    <p class="message" data-bind="html: messageContent" />
</div>

</body>
</html>