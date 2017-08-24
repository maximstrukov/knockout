<!DOCTYPE html>
<html>
<head>
<title>Knockout Application</title>
<script type='text/javascript' src="jquery-3.2.1.min.js"></script>
<script type='text/javascript' src='knockout-3.4.2.js'></script>
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

</body>
</html>