// ##############################
function validate(){
    var elements_to_validate = all("[data-validate]")
    elements_to_validate.forEach(function(element){ element.classList.remove("validate_error") })
    elements_to_validate.forEach( function(element){
      switch(element.getAttribute("data-validate")){
        case "str":
          if( element.value.length < parseInt(element.getAttribute("data-min")) || 
              element.value.length > parseInt(element.getAttribute("data-max")) 
          ){
            element.classList.add("validate_error")
          }
        break;
        case "int":
          if( ! parseInt(element.value)  ||
              parseInt(element.value) < parseInt(element.getAttribute("data-min")) || 
              parseInt(element.value) > parseInt(element.getAttribute("data-max")) 
          ){
            element.classList.add("validate_error")
          }
        break;      
        case "email":
          const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          if( ! re.test(element.value.toLowerCase()) ){
            element.classList.add("validate_error")
          }
          break;
          case "phone":
          const re_phone = /^[1-9]\d{7}$/;
          if( ! re_phone.test(element.value) ){
            element.classList.add("validate_error")
          }
        break;
        case "match":
          if( element.value != one(`[name='${element.getAttribute("data-match-name")}']`).value ){
            element.classList.add("validate_error")
          }
        break;
      }
    })
  
    return one(".validate_error", event.target) ? false : true
  }
  
  // ##############################
  function clear_validate_error(){
    event.target.classList.remove("validate_error")
  }
  
  // ##############################
  function one(q, from=document){ return from.querySelector(q) }
  function all(q, from=document){ return from.querySelectorAll(q) }