	var selectedStudy = 0;
	var alertColor = "Red";
	var okColor = "White";
		
	function switchMenu(obj) 
	{
		var el = document.getElementById(obj);
		if ( el.style.display != "none" ) 
		{
			el.style.display = 'none';
		}
		else 
		{
			el.style.display = '';
		}
	}
	
	function selectStudy(obj) 
	{
		var num = obj.options[obj.selectedIndex].value;
		
		switch(num)
		{
			case "1":
					selectedStudy = 1;
					document.getElementById("single").style.display = "block";
					document.getElementById("dyad").style.display = "none";
					document.getElementById("triad").style.display = "none";
					document.getElementById("alertStudy").style.display = "none";			
					break;
			case "2":
					selectedStudy = 2;
					document.getElementById("single").style.display = "none";
					document.getElementById("dyad").style.display = "block";
					document.getElementById("triad").style.display = "none";
					document.getElementById("alertStudy").style.display = "none";			
					break;
					
			case "3":
					selectedStudy = 3;
					document.getElementById("single").style.display = "none";
					document.getElementById("dyad").style.display = "none";
					document.getElementById("triad").style.display = "block";
					document.getElementById("alertStudy").style.display = "none";			
					break;
					
			default:
					document.getElementById("single").style.display = "none";
					document.getElementById("dyad").style.display = "none";
					document.getElementById("triad").style.display = "none";
					document.getElementById("alertStudy").style.display = "none";				
					selectedStudy = 0;
					break;
		
		}
	}
	
	function validateForm(form)
	{
		var isValid = 1;
		
		if (selectedStudy == 0)
		{
			document.getElementById("alertStudy").style.display = "block";
			isValid = 0;
		}
		else
		{
			document.getElementById("alertStudy").style.display = "none";
			if (selectedStudy == 3)
			{		
				form.action = "signupTriad.php";
				isValid &= validateField(form.TfirstName1);
				isValid &= validateField(form.TlastName1);
				isValid &= validateEmail(form.Temail1,form.TreEmail1);
				isValid &= isRadioSelected(form.Tenglish1, "Tenglish1");
				isValid &= isRadioSelected(form.Tsex1, "Tsex1");
				isValid &= validateField(form.TfirstName2);
				isValid &= validateField(form.TlastName2);
				isValid &= validateEmail(form.Temail2,form.TreEmail2);
				isValid &= isRadioSelected(form.Tenglish2, "Tenglish2");
				isValid &= isRadioSelected(form.Tsex2, "Tsex2");
				isValid &= validateField(form.TfirstName3);
				isValid &= validateField(form.TlastName3);
				isValid &= validateEmail(form.Temail3,form.TreEmail3);
				isValid &= isRadioSelected(form.Tenglish3, "Tenglish3");
				isValid &= isRadioSelected(form.Tsex3, "Tsex3");
				isValid &= validateField(form.TpastCollab);		
				isValid &= notEqualEmails(form.Temail1,form.Temail2,form.Temail3,"TduplicateEmail");
				//isValid &= isCheckboxSelected(form.viewInstructionsCheckCollab, "viewInstructionsCheckCollab");
			}
			else			
			if (selectedStudy == 2)
			{		
				form.action = "signupDyad.php";
				isValid &= validateField(form.DfirstName1);
				isValid &= validateField(form.DlastName1);
				isValid &= validateEmail(form.Demail1,form.DreEmail1);
				isValid &= isRadioSelected(form.Denglish1, "Denglish1");
				isValid &= isRadioSelected(form.Dsex1, "Dsex1");
				isValid &= validateField(form.DfirstName2);
				isValid &= validateField(form.DlastName2);
				isValid &= validateEmail(form.Demail2,form.DreEmail2);
				isValid &= isRadioSelected(form.Denglish2, "Denglish2");
				isValid &= isRadioSelected(form.Dsex2, "Dsex2");
				isValid &= validateField(form.DpastCollab);
				isValid &= notEqualEmails(form.Demail1,form.Demail2,"","DduplicateEmail");
				//isValid &= isCheckboxSelected(form.viewInstructionsCheckCollab, "viewInstructionsCheckCollab");
			}
			else
				if (selectedStudy == 1)
				{
					form.action = "signupSingle.php";
					isValid &= validateField(form.firstName);
					isValid &= validateField(form.lastName);
					isValid &= validateEmail(form.email,form.reEmail);
					isValid &= isRadioSelected(form.english, "english");
					isValid &= isRadioSelected(form.sex, "sex");
					//isValid &= isCheckboxSelected(form.viewInstructionsCheckSingle, "viewInstructionsCheckSingle");
				}
				
					
		}
		isValid &= isTimeSlotSelected(form.slot);	
		
		if (isValid==1)
		{
			document.getElementById("alertForm").style.display = "none";
			return true;
		}
		else
		{
			document.getElementById("alertForm").style.display = "block";
			return false;
		}
	}
	
	function notEqualEmails(obj1, obj2, obj3, id)
	{
		if (selectedStudy==3)
		{
			if ((obj1.value==obj2.value)||(obj1.value==obj3.value)||(obj2.value==obj3.value))
			{
				document.getElementById(id).style.display = "block";
				return false;
			}
			else
			{
				document.getElementById(id).style.display = "none";
				return true;
			}
		}
		else
		{
			if (obj1.value==obj2.value)
			{
				document.getElementById(id).style.display = "block";
				return false;
			}
			else
			{
				document.getElementById(id).style.display = "none";
				return true;
			}		
		}
	
	}

	function isCheckboxSelected(checkbox, obj) 
	{
		if (checkbox.checked)
		{
			document.getElementById(obj).style.backgroundColor = okColor;
			return true;
		}

		document.getElementById(obj).style.backgroundColor = alertColor;

		return false;
	}
	
	function validateField(field)
	{	
		if (field.value == "") 
		{
			changeColor(field,alertColor);
			return false;
		}
		else
		{
			changeColor(field,okColor);
			return true;
		}
	}
	
	function isRadioSelected(radioButtons, obj) 
	{
		for (i=radioButtons.length-1; i > -1; i--) 
			if (radioButtons[i].checked) 
			{
				document.getElementById(obj).style.backgroundColor = okColor;
				return true;
			}

		document.getElementById(obj).style.backgroundColor = alertColor;

		return false;
	}
	
	function validateEmail(field1, field2)
	{
		if (field1.value != field2.value) 
		{
			changeColor(field1,alertColor);
			changeColor(field2,alertColor);
			return false;
		}
		else
			if (!isValidadEmail(field1.value))
			{
				changeColor(field1,alertColor);
				changeColor(field2,alertColor);
				return false;
			}
			else
			{
				changeColor(field1,okColor);
				changeColor(field2,okColor);
				return true;
			}
	}
	
	function changeColor(field,color) 
	{
		field.style.background = color; 
	}

	function isValidadEmail(email) 
	{ 
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	
	function isTimeSlotSelected(radioButtons) 
	{
		if (radioButtons.checked) 
		{
			document.getElementById("alertSlot").style.display = "none";
			return true;
		}
		
		for (i=0; i < radioButtons.length; i++) 
		{
			if (radioButtons[i].checked) 
			{
				document.getElementById("alertSlot").style.display = "none";
				return true;
			}

		}

		document.getElementById("alertSlot").style.display = "block";
		
		return false;
	}

	function viewDetailsTriad(check)
	{
		if (check.checked)
			document.getElementById("triadStudyDetails").style.display = "block";
		else
			document.getElementById("triadStudyDetails").style.display = "none";
	}
	
	function viewDetailsDyad(check)
	{
		if (check.checked)
			document.getElementById("dyadStudyDetails").style.display = "block";
		else
			document.getElementById("dyadStudyDetails").style.display = "none";
	}

	function viewDetailsSingle(check)
	{
		if (check.checked)
			document.getElementById("singleStudyDetails").style.display = "block";
		else
			document.getElementById("singleStudyDetails").style.display = "none";
	}