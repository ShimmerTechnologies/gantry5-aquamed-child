jQuery(document).ready(function($){

	let max_fields		= 5;
	let wrapper			= $(".input_sizes");
	let add_button		= $(".add_field_button");

	let count = 1;

	$(add_button).click(function(e){

		e.preventDefault();

		if(count < max_fields){			

			$(wrapper).append(`<br><div class="new_sizes">
				<div><label>Length</label><input type="text" name="add_size_length[]"></div>
				<div><label>Width</label><input type="text" name="add_size_width[]"></div>
				<div><label>Shallow Depth</label><input type="text" name="add_size_shallow[]"></div>
				<div><label>Deep Depth</label><input type="text" name="add_size_deep[]"></div>
				</div><br>`);

			count++;
		}

	});

});
