<?php
/*
 //This is an attempt at creating the
 //SRS-2 assessment form
 
 //Much of this file is copied and modified from:
 * @package   OpenEMR
 * @author    Brady Miller <brady.g.miller@gmail.com>
 * @link      http://www.open-emr.org
 */


include_once("../../globals.php");
include_once("$srcdir/api.inc");

/** CHANGE THIS - name of the database table associated with this form **/
$table_name = "form_asq_02mo";

/** CHANGE THIS name to the name of your form **/
$form_name = "ASQ-3 2 Month Questionnaire";

/** CHANGE THIS to match the folder you created for this form **/
$form_folder = "asq_02mo";

formHeader("Form: ".$form_name);
$returnurl = 'encounter_top.php';

/* load the saved record */
$record = formFetch($table_name, $_GET["id"]);

/* remove the time-of-day from the date fields */
if ($record['form_date'] != "") {
    $dateparts = explode(" ", $record['form_date']);
    $record['form_date'] = $dateparts[0];
}
?>

<html><head>
<?php html_header_show();?>

<!-- supporting javascript code -->
<script type="text/javascript" src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-min-3-1-1/index.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['webroot'] ?>/library/textformat.js?v=<?php echo $v_js_includes; ?>"></script>
<script type="text/javascript" src="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker-2-5-4/build/jquery.datetimepicker.full.min.js"></script>

<!-- page styles -->
<link rel="stylesheet" href="<?php echo $css_header;?>" type="text/css">
<link rel="stylesheet" href="../../forms/<?php echo $form_folder; ?>/style.css?v=<?php echo $v_js_includes; ?>" type="text/css">
<link rel="stylesheet" href="<?php echo $GLOBALS['assets_static_relative']; ?>/jquery-datetimepicker-2-5-4/build/jquery.datetimepicker.min.css">

<script language="JavaScript">
// this line is to assist the calendar text boxes
var mypcc = '<?php echo $GLOBALS['phone_country_code'] ?>';

function PrintForm() {
    newwin = window.open("<?php echo "http://".$_SERVER['SERVER_NAME'].$rootdir."/forms/".$form_folder."/print.php?id=".$_GET["id"]; ?>","mywin");
}
</script>

</head>

<body class="body_top">

<?php echo date("F d, Y", time()); ?>

<form method=post action="<?php echo $rootdir;?>/forms/<?php echo $form_folder; ?>/save.php?mode=update&id=<?php echo $_GET["id"];?>" name="my_form">
<span class="title"><?php xl($form_name, 'e'); ?></span><br>

<!-- Save/Cancel links -->
<input type="button" class="save" value="<?php xl('Save Changes', 'e'); ?>"> &nbsp;
<input type="button" class="dontsave" value="<?php xl('Don\'t Save Changes', 'e'); ?>"> &nbsp;
<input type="button" class="printform" value="<?php xl('Print', 'e'); ?>"> &nbsp;

<!-- container for the main body of the form -->
<div id="form_container">
    <div id="preliminaryInfo">
      Was age adjusted for prematurity when selecting questionnaire?
      <input type="radio" name="ageAdjustment" value="y" /> Yes. &nbsp;
      <input type="radio" name="ageAdjustment" value="n" /> No.
    </div>

    <div id="scores">
      <h4>Score Totals</h4>
      <table id="total_scores" class="display" style="width:100%">
          <thead>
              <tr>
                  <th>Area</th>
                  <th align="left">Cutoff</th>
                  <th align="left">Total Score</th>
              </tr>
          </thead>
          <tbody>
            <tr>
              <td>Communication</td>
              <td><?php echo $communCutoff ?></td>
              <td align="center"><input type="number" name="communicationScore" min="0" max="60" step="5" value="<?php echo stripslashes($record['communicationScore']) ?>"></td>
            </tr>
            <tr>
              <td>Gross Motor</td>
              <td><?php echo $gMotorCutoff ?></td>
              <td align="center"><input type="number" name="grossMotorScore" min="0" max="60" step="5" value="<?php echo stripslashes($record['grossMotorScore']) ?>"></td>
            </tr>
            <tr>
              <td>Fine Motor</td>
              <td><?php echo $fMotorCutoff ?></td>
              <td align="center"><input type="number" name="fineMotorScore" min="0" max="60" step="5" value="<?php echo stripslashes($record['fineMotorScore']) ?>"></td>
            </tr>
            <tr>
              <td>Problem Solving</td>
              <td><?php echo $pSolveCutoff ?></td>
              <td align="center"><input type="number" name="problemSolvingScore" min="0" max="60" step="5" value="<?php echo stripslashes($record['problemSolvingScore']) ?>"></td>
            </tr>
            <tr>
              <td>Personal-Social</td>
              <td><?php echo $perSocCutoff ?></td>
              <td align="center"><input type="number" name="personalSocialScore" min="0" max="60" step="5" value="<?php echo stripslashes($record['personalSocialScore']) ?>"></td>
            </tr>
          </tbody>
        </table>
    </div>

    <div id="text_responses">
      <h4>Overall Responses</h4>
      1. Requires followup? <input type="checkbox" name="response1"> &nbsp;
      Comments: <textarea name="comments1" cols="30" rows="1"><?php echo stripslashes($record['comments1']) ?></textarea>
      <br><br>
      2. Requires followup? <input type="checkbox" name="response2"> &nbsp;
      Comments: <textarea name="comments2" cols="30" rows="1"><?php echo stripslashes($record['comments2']) ?></textarea>
      <br><br>
      3. Requires followup? <input type="checkbox" name="response3"> &nbsp;
      Comments: <textarea name="comments3" cols="30" rows="1"><?php echo stripslashes($record['comments3']) ?></textarea>
      <br><br>
      4. Requires followup? <input type="checkbox" name="response4"> &nbsp;
      Comments: <textarea name="comments4" cols="30" rows="1"><?php echo stripslashes($record['comments4']) ?></textarea>
      <br><br>
      5. Requires followup? <input type="checkbox" name="response5"> &nbsp;
      Comments: <textarea name="comments5" cols="30" rows="1"><?php echo stripslashes($record['comments5']) ?></textarea>
      <br><br>
      6. Requires followup? <input type="checkbox" name="response6"> &nbsp;
      Comments: <textarea name="comments6" cols="30" rows="1"><?php echo stripslashes($record['comments6']) ?></textarea>
    </div>

    <div id="followup_action_taken">
      <h4>Follow-up Action Taken</h4>
      <input type="checkbox" name="shouldFollowup"> Provide activities and rescreen in <input type="number" name="followupDelay" min="0" max="4"> months.
      <br>
      <input type="checkbox" name="shareResults"> Share results with primary health care provider
      <br>
      <input type="checkbox" name="referForOptions"> Refer for: <input type="checkbox" name="referForHearing"> hearing, <input type="checkbox" name="referForVision"> vision, <input type="checkbox" name="referForBehavioral"> behavioral screening.
      <br>
      <input type="checkbox" name="referToCareProvider"> Refer to primary health care provider or other community agency (specify reason): <textarea name="reasonForReferral" cols="30" rows="1"></textarea>.
      <br>
      <input type="checkbox" name="referToEarlyIntervention"> Refer to early intervention/early childhood special education.
      <br>
      <input type="checkbox" name="noFurtherAction"> No further action taken at this time.
      <br>
      <input type="checkbox" name="other"> Other (specify): <textarea name="reasonForReferral" cols="30" rows="1"></textarea>.
    </div>

    <div id="extra">
      <h4>Notes</h4>
      <textarea name="notes" id="notes" cols="80" rows="4"><?php echo stripslashes($record['notes']) ?></textarea>
      <br><br>
    </div>

</div> <!-- end form_container -->

<input type="button" class="save" value="<?php xl('Save Changes', 'e'); ?>"> &nbsp;
<input type="button" class="dontsave" value="<?php xl('Don\'t Save Changes', 'e'); ?>"> &nbsp;
<input type="button" class="printform" value="<?php xl('Print', 'e'); ?>"> &nbsp;

</form>

</body>

<script language="javascript">
// jQuery stuff to make the page a little easier to use

$(document).ready(function(){
    $(".save").click(function() { top.restoreSession(); document.my_form.submit(); });
    $(".dontsave").click(function() { parent.closeTab(window.name, false); });
    $(".printform").click(function() { PrintForm(); });

    $('.datepicker').datetimepicker({
        <?php $datetimepicker_timepicker = false; ?>
        <?php $datetimepicker_showseconds = false; ?>
        <?php $datetimepicker_formatInput = false; ?>
        <?php require($GLOBALS['srcdir'] . '/js/xl/jquery-datetimepicker-2-5-4.js.php'); ?>
        <?php // can add any additional javascript settings to datetimepicker here; need to prepend first setting with a comma ?>
    });
});

</script>

</html>
