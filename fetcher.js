import Input from "./input.js";

let firstName = new Input(
  document.querySelector(`[name='firstname']`),
  document.querySelector("form-group.firstname .error")
);
let lastName = new Input(
  document.querySelector(`[name='lastname']`),
  document.querySelector("form-group.lastname .error")
);
let email = new Input(document.querySelector(`[name='email']`), document.querySelector("form-group.email .error"));
let comment = new Input(
  document.querySelector(`[name='comment']`),
  document.querySelector("form-group.comment .error")
);
let submitBtn = document.getElementById("submit");

const _apiKey = "19JOAC4Q";

function init() {
  submitBtn.addEventListener("click", submitEntry);
}

function submitEntry(e) {
  e.preventDefault();
  let data = {
    firstName: firstName.getValue(),
    lastName: lastName.getValue(),
    email: email.getValue(),
    comment: comment.getValue()
  };

  addEntry(data).then((response) => {
    console.log(`response after submit`, response);
  });
}

function createFetch(data) {
  let url = "./api.php";
  return fetch(url, {
    method: "POST",
    credentials: "same-origin",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
  });
}

function addEntry(data) {
  // Add some extra key values to the data object...
  let tData = _.extend(
    {
      k: _apiKey,
      action: "addEntry"
    },
    data
  );

  console.log(`tData: `, tData);

  //  now we want to use fetch to post it to our DB
  return createFetch(tData)
    .then((response) => response.json())
    .then((data) => {
      console.log(`jsonified: `, data);
      
      if(data.entry > 0) {
        showSuccessMsg(); 
      }

      return data;
    })
    .catch((e) => {
      console.log("error", e);
    });
}

function showSuccessMsg() {
  let msg = document.getElementById('success'); 
  let formFields = document.querySelectorAll('.form-control'); 

  msg.classList.add('active'); 
  submitBtn.classList.add('disabled'); 
  submitBtn.setAttribute('disabled', 'true'); 
  submitBtn.removeEventListener("click", submitEntry);
  
  formFields.forEach(field => {
    field.classList.add('disabled'); 
  })
}

window.addEventListener("DOMContentLoaded", init);
