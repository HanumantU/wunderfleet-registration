var script = document.createElement('script');
script.src = 'https://code.jquery.com/jquery-3.4.1.min.js';
script.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(script);

function writetolocalstoragefrompersonal() {
    if (typeof (Storage) != "undefined") {

        var fist_name = document.getElementById("firstName").value
        var last_name = document.getElementById("lastName").value
        var telephone = document.getElementById("telephone").value

        var personal_info_json = {"firstName": fist_name, "lastName": last_name, "telephone": telephone}
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

        console.log("Inside js function...");

        var payment_info_json = {"ownerName": owner_name, "ibanNo": iban_no}
        console.log(JSON.stringify(payment_info_json))
        localStorage.setItem("payment_info",  JSON.stringify(payment_info_json));
        window.location = "/wunderfleet-registration/view/payment_info.html";


        // make a post request to backend using ajax call
        // $.ajax({
        //     url: "/wunderfleet-registration/controller/UserController.php",
        //     type: "POST",
        //     data: payment_info_json,
        //     success: function(data, textStatus, jqXHR) {
        //         alert('Success!');
        //     },
        //     error: function(jqXHR, textStatus, errorThrown) {
        //         alert('Error occurred!');
        //     }
        //
        // });

    }
}

function readfromlocalstoragetopayment() {
    var payment_info = JSON.parse(localStorage.getItem("payment_info"))
    if (payment_info) {
        document.getElementById("ownerName").value = payment_info.ownerName
        document.getElementById("ibanNo").value = payment_info.ibanNo
    }
}

document.getElementById('btn_to_save').onsubmit = function() {
    console.log("asdasdasdasdsadasd");
    return false;
};