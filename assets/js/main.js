function writetolocalstorage() {
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

function readfromlocalstorage() {
    var personal_info = JSON.parse(localStorage.getItem("personal_info"))
    document.getElementById("firstName").value = personal_info.firstName
    document.getElementById("lastName").value = personal_info.lastName
    document.getElementById("telephone").value = personal_info.telephone
}