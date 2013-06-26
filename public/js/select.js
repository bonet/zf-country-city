$(function(){
	console.log(countryCityAreaJson);
	var world = $.parseJSON(countryCityAreaJson);
	var country_id = 0;
	var city_id = 0;
	
	$("#country-select").on("change", function(event){
		
		country_id = $(this).val();
		var cities = world[country_id]['cities'];
		
		//populate City Select
		var select_city = $("<select id='city-select' name='city' /> ");
		$("<option />", {value: "", text: "- Select City -"}).appendTo(select_city);
		for(var key in cities) {
			$("<option />", {value: key, text: cities[key]['name']}).appendTo(select_city);
		}
		
		//remove previous (if existing) City Select + Area Select + Submit Button
		$("#city-select").remove();
		$("#area-select").remove();
		$("#area-submit").remove();
		city_id = 0;
		$area_id = 0;
		
		//append City Select to the Form
		$("#world-form").append(select_city);
	});
	
	$("#world-form").on("change", "#city-select", function(event){
		city_id = $(this).val();
		var areas = world[country_id]['cities'][city_id]['areas'];
		//console.log("country ID "+ country_id);
		//console.log("city ID "+ city_id);
		//console.log(areas);
		
		//populate Area Select
		var select_area = $("<select id='area-select' name='area' /> ");
		$("<option />", {value: "", text: "- Select Area -"}).appendTo(select_area);
		for(var key in areas) {
			$("<option />", {value: key, text: areas[key]['name']}).appendTo(select_area);
		}
		
		//remove previous (if existing) City Select + Submit Button
		$("#area-select").remove();
		$("#area-submit").remove();
		
		//append Area Select to the Form
		$("#world-form").append(select_area);
	});
	
	$("#world-form").on("change", "#area-select", function(event){
		
		var form_submit=$("<input type='submit' name='submit' id='area-submit' value='Submit' style='margin: -10px 0 0 10px;' />");
		console.log(form_submit);
		//remove previous (if existing) Submit Button
		$("#area-submit").remove();
		
		//append Submit Button to the Form
		$("#world-form").append(form_submit);
	});
});
