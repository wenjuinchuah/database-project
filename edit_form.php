<form class='w3-row-padding' action='' method='POST'>
    <input type="hidden" id="editID" name="editID">
    <div class='w3-half w3-padding-16'>
        <label>First Name</label>
        <input class='w3-input' name='donorFN' type='text' required>
    </div>
    <div class='w3-half w3-padding-16'>
        <label>Last Name</label>
        <input class='w3-input' name='donorLN' type='text' required>
    </div>
    <div class='w3-quarter w3-padding-16'>
        <label>Weight</label>
        <input class='w3-input' name='donorWeight' type='text' required>
    </div>
    <div class='w3-quarter w3-padding-16'>
        <label>Age</label>
        <input class='w3-input' name='donorAge' type='text' required>
    </div>
    <div class='w3-quarter w3-padding-16'>
        <label>Sex</label>
        <select class='w3-select' name='donorSex' required>
            <option value='M' selected>Male</option>
            <option value='F'>Female</option>
        </select>
    </div>
    <div class='w3-quarter w3-padding-16'>
        <label>Blood Type</label>
        <select class='w3-select' name='donorbloodtype' required>
            <option value='A+' selected>A+</option>
            <option value='A-'>A-</option>
            <option value='B+'>B+</option>
            <option value='B-'>B-</option>
            <option value='AB+'>AB+</option>
            <option value='AB-'>AB-</option>
            <option value='O+'>O+</option>
            <option value='O-'>O-</option>
        </select>
    </div>
    <div class='w3-row-padding w3-padding-16'>
        <label>Home Address</label>
        <input class='w3-input' name='donorAddress' type='text' required>
    </div>
    <div class='w3-twothird w3-padding-16'>
        <label>Identity Card No / Passport No</label>
        <input class='w3-input' name='donorIC' type='text' required>
    </div>
    <div class='w3-third w3-padding-16'>
        <label>Phone No</label>
        <input class='w3-input' name='donorPhone' type='text' required>
    </div>
    <div class='w3-half w3-padding-16'>
        <label>Email</label>
        <input class='w3-input' name='donorEmail' type='text' required>
    </div>
    <div class='w3-half w3-padding-16'>
        <label>Nationality</label>
        <select class='w3-select' name='nationality' required>
            <option value='Malaysian' selected>Malaysian</option>
            <option value='Others'>Others</option>
        </select>
    </div>
    <div class='w3-row-padding'>
        <b><input type='submit' class='w3-btn w3-block w3-round w3-green'
                name='editDonor' value='editDonor'></input></b>
    </div>
    <br>
</form>