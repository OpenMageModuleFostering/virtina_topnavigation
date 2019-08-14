/**
 * Virtina
 * @package    Virtina_Topnavigation
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
var selectorVisible=false;

getProductChooser = function (url,selected) { 

    if(selectorVisible){
        return;
    }
    selectorVisible=true;
	var myArray = selected.split(",");

    new Ajax.Request(
        url, {
            method: "post",
            parameters : {"selected[]":myArray},            
            onSuccess: function (b) {
                var a = $("product_chooser");
                a.update(b.responseText);
                a.scrollTo()
            }
        });              
};

var VarienRulesForm = new Class.create();
VarienRulesForm.prototype = {
    initialize: function ( a) { 
        this.newChildUrl = a;
        this.shownElement = null;  
        this.updateElement = $("product_ids");   
        this.chooserSelectedItems = $H({});
		this.initParam('');
    },
    initParam: function (b) {	
        b.rulesObject = this;
        var d = Element.down(b, ".label");
        if (d) {
            Event.observe(d, "click", this.showParamInputField.bind(this, b));
        }
        var f = Element.down(b, ".element");
        if (f) {
            var e = f.down(".rule-chooser-trigger");
            if (e) {
                Event.observe(e, "click", this.toggleChooser.bind(this, b));
            }
            var c = f.down(".rule-param-apply");
            if (c) {
                Event.observe(c, "click", this.hideParamInputField.bind(this, b));
            } else {
                f = f.down();
                if (!f.multiple) {
                    Event.observe(f, "change", this.hideParamInputField.bind(this, b));
                }
                Event.observe(f, "blur", this.hideParamInputField.bind(this, b));
            }
        }
        var a = Element.down(b, ".rule-param-remove");
        if (a) {
            Event.observe(a, "click", this.removeRuleEntry.bind(this, b));
        }
    },

    chooserGridRowInit: function (a, b) {		
			
        if (!a.reloadParams) {
			var selected1 = $("product_ids").value;
			var myArray1 = selected1.split(",");
			
            a.reloadParams = {
                "selected[]": myArray1 
            }
        }
    },
    chooserGridRowClick: function (b, d) {	
       
        
        var f = Event.findElement(d, "tr");
        var a = Event.element(d).tagName == "INPUT";
        if (f) {
            var e = Element.select(f, "input");
            if (e[0]) {
                var c = a ? e[0].checked : !e[0].checked;
                b.setCheckboxChecked(e[0], c)
            }
        }
        
    },
    chooserGridCheckboxCheck: function (b, a, c) { 
		var ids;
        if (c) {   							// if checked
            if (!a.up("th")) { 
				if($("product_ids").value && $("product_ids").value != 'undefined') 
					ids =  $("product_ids").value + ',' +a.value; 
				else
					ids = a.value; 
                this.chooserSelectedItems.set(a.value, 1)
            }
        } else { 							// if unchecked
			ids = $("product_ids").value ; 
			var myArray = ids.split(",");  	// explode
			var index = myArray.indexOf(a.value);
			if (index > -1) {
				myArray.splice(index, 1);	// removing existing ids
			}
			ids = myArray.join(',');		// implode
            this.chooserSelectedItems.unset(a.value)
        }
             
        b.reloadParams = {
            "selected[]":this.chooserSelectedItems.keys() 
        };
        
        $("product_ids").value = ids;                  
    }
};


var rule_conditions_fieldset = new VarienRulesForm('');
