$(document).ready(function(){

	// This is a simple *viewmodel* - JavaScript that defines the data and behavior of your UI
	function AppViewModel() {
		
		this.firstName = ko.observable();
		this.lastName = ko.observable("Bertington");
		this.fullName = ko.computed(function() {
			return this.firstName() + " " + this.lastName();    
		}, this);
		
		this.capitalizeLastName = function() {
			var currentVal = this.lastName();        // Read the current value
			this.lastName(currentVal.toUpperCase()); // Write back a modified value
		};

		var self = this;
		
		// Non-editable catalog data - would come from the server
		self.availableMeals = ko.observableArray([
			{ mealName: "Standard (sandwich)", price: 0 },
			{ mealName: "Premium (lobster)", price: 34.95 },
			{ mealName: "Ultimate (whole zebra)", price: 290 }
		]);

		// Editable data
		self.seats = ko.observableArray([
			new SeatReservation("Steve", self.availableMeals()[0]),
			new SeatReservation("Bert", self.availableMeals()[0])
		]);
		
		self.addSeat = function() {
			self.availableMeals.push({mealName: "Big Mac", price: 900});
			self.seats.push(new SeatReservation("Max", self.availableMeals()[self.availableMeals().length-1]));
		}
		
		self.removeSeat = function(seat) {
			self.seats.remove(seat);
		}
		
		self.totalSurcharge = ko.computed(function() {
		   var total = 0;
		   for (var i = 0; i < self.seats().length; i++)
			   total += self.seats()[i].meal().price;
		   return total;
		});
		
		/*************************/
		/*Single page Application*/
		/*************************/
		// Data
		self.folders = ['Inbox', 'Archive', 'Sent', 'Spam'];
		self.chosenFolderId = ko.observable();
		self.chosenFolderData = ko.observable();
		self.chosenMailData = ko.observable();
		
		// Behaviours
		/*self.goToFolder = function(folder) {
			self.chosenFolderId(folder); 
			$.get('/getmail/folder/'+folder, { }, self.chosenFolderData);
			//$.get('mail/'+folder, {}, function( response ) {
				//self.chosenFolderData( JSON.parse(response) );
			//});
			self.chosenMailData(null); // Stop showing a mail
		}*/
		self.goToFolder = function(folder) { location.hash = folder };
		
		/*self.goToMail = function(mail) {
			self.chosenFolderId(mail.folder);
			self.chosenFolderData(null); // Stop showing a folder
			$.get("/getmail/mail/"+mail.id, { }, self.chosenMailData);
		};*/
		self.goToMail = function(mail) { location.hash = mail.folder + '/' + mail.id };

		// Client-side routes using Scam framework
		Sammy(function() {
			this.get('#:folder', function() {
				self.chosenFolderId(this.params.folder);
				self.chosenMailData(null);
				$.get('/getmail/folder/'+this.params.folder, { }, self.chosenFolderData);
			});

			this.get('#:folder/:mailId', function() {
				self.chosenFolderId(this.params.folder);
				self.chosenFolderData(null);
				$.get("/getmail/mail/"+this.params.mailId, { }, self.chosenMailData);
			});
			
			this.get('', function() { this.app.runRoute('get', '#Inbox') });
		}).run();
		
		// Show inbox by default
		//self.goToFolder('Inbox');
		
		
	}

	
	// Class to represent a row in the seat reservations grid
	function SeatReservation(name, initialMeal) {
		var self = this;
		self.name = name;
		self.meal = ko.observable(initialMeal);
		
		self.formattedPrice = ko.computed(function() {
			var price = self.meal().price;
			return price ? "$" + price.toFixed(2) : "None";        
		});
		
	}

	// Activates knockout.js
	ko.applyBindings(new AppViewModel());
	
	
});