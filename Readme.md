# Powermail Ext #

This Extension was developed to add some functionality powermail.


## Features ##

  - Dependencies for Fields of other Fields: Conditional Validation and Display
  - Additional HTML Tag Attributes (maxlength, disabled, readonly) for Input/Select Fields
  - Additional Validators (Date Range, IBAN)
  - Viewhelper for correct Text Answer in Confirmation View for Radiobuttons and Checkboxes

## Installing ##

 - install the Extension using the Extension Manager.
 - Make sure you include the static Typoscript of this Extension in the Template right after powermail
 - Enjoy new Features!

## General ##

The Developers of Powermail developed an Extension 'powermail_cond' which should provide features like conditional Validation (and Display). Although the conditional displaying of fields in frontend worked (a little delayed, because it uses AJAX for the test), the field was still validated server-side after submission. So it was impossible to have a mandatory field which is only mandatory when a other field meets a requirement..
In my opinion - additionally - it was a little effort to create all the rule and condition records. And you don't see if a field has a condition or rule when you are editing the powermail form..

I don't want to cheapen the great 'powermail_cond' Extension, but the above reasons made me finding a simpler solution for the conditional validation. Maybe it is fixed now.

Powermailext requires jQuery Library to be included in the frontend.

Powermailext provides fluid Templates for some partials of powermail, if you want to use this functionality in your own template, make sure you include the following at the top of your fluid template:
```
{namespace pmext=WorldDirect\Powermailext\ViewHelpers}
```

### Dependency ###

The Main Feature of this Extension is the Dependency.
With this Feature it is possible to:
 -  only validate fields (client and server side) if a other field meets a specific requirement.
 -  show / hide fields in the form if a other field meets a specific requirement.

In Backend, you can define your validation condition for a powermail field. After activating the conditional validation, three new fields appear:
  - Field (the field from which the current depends on)
  - Operator (the operator which will be used for comparison)
  - Value (the value which will be compared with the field value of 'Field')
  - Action (the Action(s) which are affected to the dependent field)

![Screenshot from Dependency Section in Backend](Documentation/Images/dependency.jpg "Dependency Section")

#### Javascript Visibility Handling ####

Powermailext toggles the visibility of form fields in the Frontend with Javascript.

There is a View Helper which takes care of correct rendering of dependency information for Javascript called 'ContainerDataAttributes' View Helper. Make sure you use this View Helper at the html container element which holds the input field if you use your own Templates/Partials

Partials/Form/FIELDNAME.html
```
<div id="powermail_fieldwrap... {pmext:Validation.ContainerDataAttributes(field:field)}>
	<label> ... </label>
	<f:form.FIELDNAME ... > 
		...
	</f:form.FIELDNAME>
</div>
```` 

If you want to perform further actions with a field immediately after a visibility change, you can listen for this event in Javascript: (here using jQuery)

```
// event "pmext.visibility.change"

$('input, select').on('pmext.visibility.change', function(event) {
	// do something (access the field using event.target or this)
});

```

which will be triggered on the affected field (the input or select tag)

#### Example ####

For example, you want to display the field 'customer id' only if the user checks the box 'I am already customer', and display different further options when checked a specific radio button.

To achieve the above example, you need the following fields in your form
  * Checkboxes (I am already customer)
  * Input (Customer ID)
  * Radio (Choose Brand)
  * Checkboxes (Audi)
  * Checkboxes (BMW)

This will generate a form like this in the Frontend (unstyled)

![Screenshot from Form in Frontend](Documentation/Images/form.jpg "Form in Frontend")


Add a Label and a value (the use of integer 1 as checkbox value for enabling/disabling checkbox has proven to be..) to the checkbox and activate the conditional validation of the input field.
Select the checkbox in the select box, use 'equal' as operator and insert '1' as value. For the action choose 'toggle visibility and validation'. This will cause the field to change its visibility if the checkbox is checked. Additionally, the field will only be validated if the checkbox is checked. If you want only the one feature or the other, you can easily change it in the backend via setting the action to an other option.

![Screenshot of checkbox trigger field in Backend](Documentation/Images/form_be_triggerfield.jpg "Trigger Field 'I am already Customer'")

![Screenshot of dependent input field in Backend](Documentation/Images/form_be_dependentfield.jpg "Dependent Field 'Customer ID'")

Add the values '1' and '2' to the Radio Buttons 'Choose Brand'.
Also activate the validation condition for both checkboxes fields (Audi and BMW) and configure them like the checkbox above, use '1' as comparison value at Audi Checkboxes and '2' at BMW.
When you check your form in the frontend, you will notice that the 'Customer ID' input and 'Audi'/'BMW' checkboxes are hidden if the specific checkbox/radio is not checked. Check the checkbox to toggle the visibility of the input field. In this Screenshot also the option for the choosing of car models depends on the selection of the brand.

![Screenshot of form with checked checkbox in Frontend](Documentation/Images/form_checked.jpg "Form in Frontend after user action")


### Additional Attributes ###

Sometimes, you need to mark input fields with attributes like "readonly", "disabled" or specify the "maxlength" Attribute. With this Extension installed, the Powermail Record got a new section "Attributes" in the tag "Extended"
Here you can activate the desired Attributes.

![Screenshot from Attributes Section in Backend](Documentation/Images/attributes.jpg "Attributes Section")

There is a View Helper which extends the 'ValidationDataAttribute' View Helper called 'ValidationDataAndAttributes' View Helper. Make sure you use this View Helper instead of the Powermail's View Helper:

Partials/Form/FIELDNAME.html
```
additionalAttributes="{pmext:Validation.ValidationDataAndAttributes(field:field, iteration:index)}
````

### Additional Validators ###

The Extension offers two additional Validators:
   - IBAN
   - Date Range

	This Validator is for the type 'date'. It is possible to validate a date input against a given date range. The date range can be inserted in the 'validation configuration' input. Possible values are strings that can be parsed by PHP's strtotime() function. The validation configuration consists at least of one, but share a maximum of two arguments, seperated by a comma. This two parts represent the limits for the date. If only one argument is given, the validator automatically adds 'now' as the second argument, if the result of strtotime of the given argument is less than the current timestamp. Otherwise the second argument 'now' will be inserted before the given argument. See this examples of date ranges for better understanding:  
let's say the current date is *May, 25th 2015*, then

| validation configuration | resulting validation                                       |
|--------------------------|------------------------------------------------------------|
| -100 years, -18 years    | validates a date between May, 25th 1915 and May, 25th 1997 |
| -3 months, + 3 days      | validates a date between Feb, 25 2015 and May, 28th 2015   |
| -8 months                | validates a date between Aug, 25th 2014 and May, 25th 2015 |
| +12 days                 | a date between May, 25th 2015 and June, 6th 2015           |

![Screenshot from Date Range Validation in Backend](Documentation/Images/daterange_validation.jpg "Date Range Validation")

### Correct Text Answers ###

Powermail does offer the opportunity to add different values and labels to radiobuttons and checkboxes. In confirmation View, you only see the value. Sometimes you specify values like integers ore single characters as a value for a checkbox, because your label includes some special chars or is too long. These values are much better for further processing, but in confirmation view the user sees them instead of the labels. Powermailext provides a View Helper for this. A few lines of code will change the functionality:

Partials/PowermailAll/Web.html
```
<pmext:Misc.CorrectTextAnswer answer="{answer}" />
```
instead of
```
<f:if condition="{vh:Condition.IsArray(val: '{answer.value}')}">
	<f:else>
		<f:format.nl2br>{answer.value}</f:format.nl2br>
	</f:else>
	<f:then>
		<f:for each="{answer.value}" as="subValue" iteration="index">
			<f:if condition="{subValue}">
				{subValue}<f:if condition="{index.isLast}"><f:else>, </f:else></f:if>
			</f:if>
		</f:for>
	</f:then>
</f:if>
```

This View Helper also takes care of array handling and nested Answers.