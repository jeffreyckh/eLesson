
　　
　　function CheckForm(oForm)
　　{
　　　　var els = oForm.elements;
        var password  = els["password"];
		var password2 = els["password2"];
		var email     = els["email"];
		var email2    = els["email2"];
　　　　
　　　　for(var i=0;i<els.length;i++)
　　　　{
　　　　　　
　　　　　　if(els[i].check)
　　　　　　{
　　　　　　　　var sReg = els[i].check;
　　　　　　　　var sVal = GetValue(els[i]);
　　　　　　　　var reg = new RegExp(sReg,"i");
　　　　　　　　if(!reg.test(sVal))
　　　　　　　　{　
　　　　　　　　　　alert(els[i].warning);
　　　　　　　　　　GoBack(els[i])  
　　　　　　　　　　return false;
　　　　　　　　}
　　　　　　}
　　　　}
       //Expand
        if(password && password2){
		   if(password.value !== password2.value){
		      alert("2nd password is different with 1st");
			  GoBack(password2);
			  return false;
		   }
		}
        
        if(email && email2){
		   if(email.value !==email2.value){
		      alert("2nd email is different with 1st");
			  GoBack(email2);
			  return false;
		   }
		}

　　}

　
　　function GetValue(el)
　　{
　　　
　　　　var sType = el.type;
　　　　switch(sType)
　　　　{
　　　　　　case "text":
　　　　　　case "hidden":
　　　　　　case "password":
　　　　　　case "file":
　　　　　　case "textarea": return el.value;
　　　　　　case "checkbox":
　　　　　　case "radio": return GetValueChoose(el);
　　　　　　case "select-one":
　　　　　　case "select-multiple": return GetValueSel(el);
　　　　}
　　　　
　　　　function GetValueChoose(el)
　　　　{
　　　　　　var sValue = "";
　　　　　　
　　　　
　　　　var tmpels = document.getElementsByName(el.name);
　　　　　　for(var i=0;i<tmpels.length;i++)
　　　　　　{
　　　　　　　　if(tmpels[i].checked)
　　　　　　　　{
　　　　　　　　　　sValue += "0";
　　　　　　　　}
　　　　　　}
　　　　　　return sValue;
　　　　}
　　　　
　　　　function GetValueSel(el)
　　　　{
　　　　　　var sValue = "";
　　　　　　for(var i=0;i<el.options.length;i++)
　　　　　　{
　　　　　　　　
　　　　　　　　if(el.options[i].selected && el.options[i].value!="")
　　　　　　　　{
　　　　　　　　　　sValue += "0";
　　　　　　　　}
　　　　　　}
　　　　　　return sValue;
　　　　}
　　}

　　
　　function GoBack(el)
　　{
　　　　var sType = el.type;
　　　　switch(sType)
　　　　{
　　　　　　case "text":
　　　　　　case "hidden":
　　　　　　case "password":
　　　　　　case "file":
　　　　　　case "textarea": el.focus();var rng = el.createTextRange(); rng.collapse(false); rng.select();
　　　　　　case "checkbox":
　　　　　　case "radio": var els = document.getElementsByName(el.name);els[0].focus();
　　　　　　case "select-one":
　　　　　　case "select-multiple":el.focus();
　　　　}
　　}
   
	function ckEle(el){
	          
　　　　　　  if(el.check){
　　　　　　　　 var sReg = el.check;
　　　　　　　　 var sVal = GetValue(el);
　　　　　　　　 var reg = new RegExp(sReg,"i");
　　　　　　　　 if(!reg.test(sVal)){
　　　　　　　　　　alert(el.warning);
　　　　　　　　　　GoBack(el)  
　　　　　　　　　　return false;
　　　　　　　　 }
　　　　　　  }
		      
	}
 