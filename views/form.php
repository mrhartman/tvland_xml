<?php
include "models/Constants.php";
include "utils/FormControls.php";
$formControls = new FormControls;
?>
<form action="controllers/CompController.php" name="dupeForm" id="dupe-form" method="POST">
    <fieldset class="name">
        <legend>Name of Template Comp in After Effects Project</legend>
        <!--
        <label for="template-name">Template Name:</label>
        -->
        <input type="text" name="templateName" id="template-name" placeholder="Enter template name" />
    </fieldset>
    <fieldset class="name">
        <legend>Desired Base Name for Duplicated Comps</legend>
        <!--
        <label for="dupe-name">Dupe Name:</label>
        -->
        <input type="text" name="dupeName" id="dupe-name" placeholder="Enter dupe name" />
    </fieldset>
    <fieldset id="fs-tune-ins">
        <legend class="clearfix">
            <div>Choose Tune Ins</div>
            <div>Specify if Tune In Requires Time Info</div>
        </legend>
        <?php echo $formControls->createCheckboxes(TDAY, true); ?>
    </fieldset>
    <fieldset id="fs-tune-in-times">
        <legend>Choose Tune In Time/Times</legend>
        <?php echo $formControls->createCheckboxes(TTIME, false); ?>
    </fieldset>
    <fieldset id="fs-tune-in-modifiers">
        <legend>Choose Tune In Modifier</legend>
        <?php echo $formControls->createCheckboxes(TMODIFIER, false); ?>
    </fieldset>
    <fieldset>
        <legend>Are There Channel Numbers?</legend>
        <label for="channel-number-yes"><input name="channelNumber" id="channel-number-yes" value="yes" type="radio">Yes</label>
        <label for="channel-number-no"><input name="channelNumber" id="channel-number-no" value="no" type="radio" checked="checked">No</label>
    </fieldset>
    <fieldset id="fs-channel-numbers" class="name">
        <legend>Enter Channel Numbers Needed Separated by Commas</legend>
        <!--
        <label for="channel-numbers">Channel Numbers:</label>
        -->
        <textarea id="channel-numbers" name="channelNumbers" placeholder="Enter channel numbers"></textarea>
    </fieldset>
    <button type="subimt" value="submit">Submit</button>
    <button type="reset" value="reset">Reset</button>
</form>

