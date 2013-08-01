//Gravity form star rating
	
		//function for changing selected rating background based on selection of radio button
		function tmm_star_rating() {
			//remove all background star related classes each time and radio button is clicked
			$('.review-selected').removeClass('per20 per40 per60 per80 per100');
			
			//check which radio button is checked and apply class to show correct number of selected stars	
			switch ( $('#input_2_4 input:checked').attr('id') ) {
				case 'choice_4_0': 
					$('.review-selected').addClass('per20');
				break;
				
				case 'choice_4_1': 
					$('.review-selected').addClass('per40');
				break;
				
				case 'choice_4_2': 
					$('.review-selected').addClass('per60');
				break;
				
				case 'choice_4_3': 
					$('.review-selected').addClass('per80');
				break;
				
				case 'choice_4_4': 
					$('.review-selected').addClass('per100');
				break;
			}
		}
		
		$(document).ready(function(){
			//add the markup for showing the star background image
			$('#input_2_4').append('<span class="review-selected"></span>');
			
			//Run the function on page load so the correct number of stars are show when the form is reloaded, say when the form is submitted but all required fields are not filled
			tmm_star_rating();
			
			//Run the function anytime a radio button is selected
			$('#input_2_4 input[type="radio"]').on('click', function() {
				tmm_star_rating();
			});
		});