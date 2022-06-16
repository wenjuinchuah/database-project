<!-- Header -->
<header class="w3-container w3-padding-16">
    <h5 class="w3-left"><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
    <a class="w3-btn w3-text-white w3-green w3-round w3-right"
        href="./donation_appointment.php?empID=<?php echo $empID ?>"><i class="fa fa-plus"></i><b> New
            Appointment</b></a>
</header>

<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
        <div class="w3-container w3-round-large w3-red w3-padding-16">
            <div class="w3-left"><i class="fa fa-user w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3><?php echo $donorSum ?></h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Donor</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-round-large w3-blue w3-padding-16">
            <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3>99</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Views</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-round-large w3-teal w3-padding-16">
            <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3>23</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Shares</h4>
        </div>
    </div>
    <div class="w3-quarter">
        <div class="w3-container w3-round-large w3-orange w3-text-white w3-padding-16">
            <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
            <div class="w3-right">
                <h3>50</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Users</h4>
        </div>
    </div>
</div>