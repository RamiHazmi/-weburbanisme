function generateRandomID() {
    const randomID = Math.floor(100000 + Math.random() * 900000);  
    document.getElementById("id_borne").value = randomID;
}
