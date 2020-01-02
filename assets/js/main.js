var form_data = [];
var script = document.createElement('script');
//script.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
script.src = 'http://code.jquery.com/ui/1.12.1/jquery-ui.min.js';
script.src = 'http://code.jquery.com/jquery-3.4.1.min.js'
script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

function writetolocalstoragefrompersonal() {
    if (typeof (Storage) != "undefined") {

        var fist_name = document.getElementById("firstName").value
        var last_name = document.getElementById("lastName").value
        var telephone = document.getElementById("telephone").value

        var personal_info_json = {"firstName": fist_name, "lastName": last_name, "telephone": telephone}
//        window.form_data['personal_info'] = personal_info_json;
        console.log(JSON.stringify(personal_info_json))
        localStorage.setItem("personal_info",  JSON.stringify(personal_info_json));
        window.location = "/wunderfleet-registration/view/address_info.html";
    }
}

function readfromlocalstoragetopersonal() {
    var personal_info = JSON.parse(localStorage.getItem("personal_info"))
    if (personal_info) {
        document.getElementById("firstName").value = personal_info.firstName
        document.getElementById("lastName").value = personal_info.lastName
        document.getElementById("telephone").value = personal_info.telephone
    }


}

function writetolocalstoragefromaddress() {
    if (typeof (Storage) != "undefined") {

        var address_line = document.getElementById("addressLine").value
        var house_no = document.getElementById("houseNo").value
        var zip_code = document.getElementById("zipCode").value
        var city = document.getElementById("city").value

        var address_info_json = {"addressLine": address_line, "houseNo": house_no, "zipCode": zip_code, "city": city}
//        window.form_data['address_info'] = address_info_json;
        console.log(JSON.stringify(address_info_json))
        localStorage.setItem("address_info",  JSON.stringify(address_info_json));
        window.location = "/wunderfleet-registration/view/payment_info.html";
    }
}

function readfromlocalstoragetoaddress() {
    var address_info = JSON.parse(localStorage.getItem("address_info"))
    if (address_info) {
        document.getElementById("addressLine").value = address_info.addressLine
        document.getElementById("houseNo").value = address_info.houseNo
        document.getElementById("zipCode").value = address_info.zipCode
        document.getElementById("city").value = address_info.city
    }
}

function writetolocalstoragefrompayment() {
    if (typeof (Storage) != "undefined") {

        var owner_name = document.getElementById("ownerName").value
        var iban_no = document.getElementById("ibanNo").value

        var payment_info_json = {"ownerName": owner_name, "ibanNo": iban_no}
        localStorage.setItem("payment_info",  JSON.stringify(payment_info_json));

        form_data['personal_info'] = JSON.parse(localStorage.getItem("personal_info"))
        form_data['address_info'] = JSON.parse(localStorage.getItem("address_info"))
        form_data['payment_info'] = JSON.parse(localStorage.getItem("payment_info"))

        // make a post request to backend using ajax call
        $.ajax({
            url: "/wunderfleet-registration/controller/UserController.php",
            type: "POST",
            data: {personal_info: form_data['personal_info'], address_info: form_data['address_info'], payment_info: form_data['payment_info']},
            success: function(data, textStatus, jqXHR) {
                //calling external api on success
                makeApiCall(form_data['payment_info'], JSON.parse(data).user_id);
             },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error occurred!');
            }
        });
    }
}

function readfromlocalstoragetopayment() {
    var payment_info = JSON.parse(localStorage.getItem("payment_info"))
    if (payment_info) {
        document.getElementById("ownerName").value = payment_info.ownerName
        document.getElementById("ibanNo").value = payment_info.ibanNo
    }
}

function makeApiCall(account_details, user_id) {
    //making external api call using ajax
    $.ajax({
        url: "https://37f32cl571.execute-api.eu-central-1.amazonaws.com/default/wunderfleet-recruiting-backend-dev-save-payment-data",
        type: "POST",
        data: {customerid: user_id, iban: account_details['ibanNo'], owner: account_details['ownerName']},
        success: function(data, textStatus, jqXHR) {
            console.log(data);
            
            //calling external api on success
            // makeApiCall(form_data['payment_info'], JSON.parse(data).user_id);
         },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error occurred!');
        }
    });
}