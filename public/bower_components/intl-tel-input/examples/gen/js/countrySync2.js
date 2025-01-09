// Get the country data from the plugin
var countryData2 = window.intlTelInputGlobals.getCountryData(),
    input2 = document.querySelector("#phone2"),
    addressDropdown2 = document.querySelector("#address-country2");

// Initialize the intlTelInput plugin for input2
var iti2 = window.intlTelInput(input2, {
  utilsScript: "../../build/js/utils.js?1638200991544" // for formatting/placeholders etc.
});

// Populate the country dropdown
for (var i = 0; i < countryData2.length; i++) {
  var country2 = countryData2[i]; // Fixed to countryData2
  var optionNode = document.createElement("option");
  optionNode.value = country2.iso2;
  var textNode = document.createTextNode(country2.name);
  optionNode.appendChild(textNode);
  addressDropdown2.appendChild(optionNode); // Append to addressDropdown2
}

// Set initial value of the country dropdown to match the phone input's selected country
addressDropdown2.value = iti2.getSelectedCountryData().iso2;

// Listen to the telephone input for country change events and update the dropdown
input2.addEventListener('countrychange', function(e) {
  addressDropdown2.value = iti2.getSelectedCountryData().iso2;
});

// Listen to the address dropdown for changes and update the telephone input
addressDropdown2.addEventListener('change', function() {
  iti2.setCountry(this.value);
});
